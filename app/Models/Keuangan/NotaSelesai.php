<?php

namespace App\Models\Keuangan;

use App\Support\Eloquent\Concerns\Searchable;
use App\Support\Eloquent\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use App\Support\Eloquent\Model;
use Illuminate\Database\Query\Builder as DatabaseBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotaSelesai extends Model
{
    use Searchable, Sortable;

    protected $connection = 'mysql_smc';

    protected $table = 'nota_selesai';

    public $timestamps = false;

    protected $fillable = [
        'no_rawat',
        'tgl_penyelesaian',
        'bentuk_bayar',
        'user_id',
    ];

    public function scopeBillingYangDiselesaikan(Builder $query, string $tglAwal = '', string $tglAkhir = ''): Builder
    {
        if (empty($tglAwal)) {
            $tglAwal = now()->format('Y-m-d');
        }

        if (empty($tglAkhir)) {
            $tglAkhir = now()->addDay()->format('Y-m-d');
        }

        $sik = DB::connection('mysql_sik')->getDatabaseName();

        $sqlSelect = [
            "nota_selesai.id",
            "nota_selesai.no_rawat",
            "pasien.no_rkm_medis",
            "nota_pasien.no_nota",
            "nota_selesai.status_pasien",
            "nota_selesai.bentuk_bayar",
            "penjab.png_jawab",
            "nota_selesai.tgl_penyelesaian",
            'nm_pasien'    => DB::raw("trim(pasien.nm_pasien) nm_pasien"),
            'ruangan'      => DB::raw("ifnull(concat(kamar.kd_kamar, ' ', bangsal.nm_bangsal), '-') ruangan"),
            'besar_bayar'  => DB::raw("coalesce(nota_pasien.besar_bayar, piutang_pasien.totalpiutang) besar_bayar"),
            'nama_pegawai' => DB::raw("concat(nota_selesai.user_id, ' ', pegawai.nama) nama_pegawai"),
        ];

        $sqlSelectCasts = [
            'besar_bayar' => 'float',
        ];

        $notaPasien = <<<SQL
            (select
                    nota_jalan.no_rawat,
                    nota_jalan.no_nota,
                    timestamp(nota_jalan.tanggal, nota_jalan.jam) waktu,
                    detail_nota_jalan.nama_bayar,
                    sum(detail_nota_jalan.besar_bayar) besar_bayar
                from {$sik}.nota_jalan nota_jalan
                join {$sik}.detail_nota_jalan detail_nota_jalan on nota_jalan.no_rawat = detail_nota_jalan.no_rawat
                group by 
                    nota_jalan.no_rawat,
                    nota_jalan.no_nota,
                    timestamp(nota_jalan.tanggal, nota_jalan.jam),
                    detail_nota_jalan.nama_bayar
                union all
                select
                    nota_inap.no_rawat,
                    nota_inap.no_nota,
                    timestamp(nota_inap.tanggal, nota_inap.jam) waktu,
                    detail_nota_inap.nama_bayar,
                    (sum(detail_nota_inap.besar_bayar) + nota_inap.uang_muka) besar_bayar
                from {$sik}.nota_inap nota_inap
                join {$sik}.detail_nota_inap detail_nota_inap on nota_inap.no_rawat = detail_nota_inap.no_rawat
                group by
                    nota_inap.no_rawat,
                    nota_inap.no_nota,
                    timestamp(nota_inap.tanggal, nota_inap.jam),
                    detail_nota_inap.nama_bayar
            ) nota_pasien
        SQL;

        return $query
            ->select($sqlSelect)
            ->leftJoin(DB::raw($sik . '.reg_periksa reg_periksa'), 'nota_selesai.no_rawat', '=', 'reg_periksa.no_rawat')
            ->leftJoin(DB::raw($sik . '.kamar_inap kamar_inap'), 'nota_selesai.no_rawat', '=', 'kamar_inap.no_rawat')
            ->leftJoin(DB::raw($sik . '.piutang_pasien piutang_pasien'), 'nota_selesai.no_rawat', '=', 'piutang_pasien.no_rawat')
            ->leftJoin(DB::raw($notaPasien), 'nota_selesai.no_rawat', '=', 'nota_pasien.no_rawat')
            ->leftJoin(DB::raw($sik . '.penjab penjab'), 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->leftJoin(DB::raw($sik . '.kamar kamar'), 'kamar_inap.kd_kamar', '=', 'kamar.kd_kamar')
            ->leftJoin(DB::raw($sik . '.bangsal bangsal'), 'kamar.kd_bangsal', '=', 'bangsal.kd_bangsal')
            ->leftJoin(DB::raw($sik . '.pasien pasien'), 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->leftJoin(DB::raw($sik . '.pegawai'), 'nota_selesai.user_id', '=', 'pegawai.nik')
            ->whereBetween(DB::raw("date(nota_selesai.tgl_penyelesaian)"), [$tglAwal, $tglAkhir])
            ->groupByRaw(<<<SQL
                nota_selesai.no_rawat,
                nota_selesai.status_pasien,
                nota_selesai.bentuk_bayar,
                nota_selesai.tgl_penyelesaian
            SQL)
            ->withCasts($sqlSelectCasts);
    }

    public static function refreshModel(): void
    {
        $latest = static::latest('tgl_penyelesaian')->value('tgl_penyelesaian');

        DB::connection('mysql_sik')
            ->table('jurnal')
            ->when(
                !is_null($latest),
                fn (DatabaseBuilder $query): DatabaseBuilder => $query->whereRaw("timestamp(tgl_jurnal, jam_jurnal) > ?", $latest),
                fn (DatabaseBuilder $query): DatabaseBuilder => $query->where('tgl_jurnal', '>=', '2022-10-31')
            )
            ->where(fn (DatabaseBuilder $query): DatabaseBuilder => $query
                ->where('keterangan', 'like', '%PEMBAYARAN PASIEN RAWAT JALAN% %DIPOSTING OLEH%')
                ->orWhere('keterangan', 'like', '%PEMBAYARAN PASIEN RAWAT INAP% %DIPOSTING OLEH%')
                ->orWhere('keterangan', 'like', '%PIUTANG PASIEN RAWAT JALAN% %DIPOSTING OLEH%')
                ->orWhere('keterangan', 'like', '%PIUTANG PASIEN RAWAT INAP% %DIPOSTING OLEH%'))
            ->orderBy('no_jurnal')
            ->chunk(500, function (Collection $chunk) {
                $data = $chunk->map(function (object $value, int $key) {
                    $ket = Str::of($value->keterangan);

                    $bentukBayar = $ket->before('PASIEN')->words(1, '')->trim();
                    $statusPasien = $ket->after('PASIEN')->words(2, '')->trim();

                    $noRawat = $ket->matchAll('/\d+/')->take(4)->join('/');
                    $petugas = $ket->matchAll('/\d+/')->last();

                    return [
                        'no_rawat'         => $noRawat,
                        'tgl_penyelesaian' => "{$value->tgl_jurnal} {$value->jam_jurnal}",
                        'bentuk_bayar'     => $bentukBayar,
                        'status_pasien'    => $statusPasien,
                        'user_id'          => $petugas,
                    ];
                });

                static::insert($data->all());
            });
    }
}
