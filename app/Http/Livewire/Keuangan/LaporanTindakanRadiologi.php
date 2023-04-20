<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Radiologi\HasilPeriksaRadiologi;
use App\Support\Traits\Livewire\DeferredLoading;
use App\Support\Traits\Livewire\ExcelExportable;
use App\Support\Traits\Livewire\Filterable;
use App\Support\Traits\Livewire\FlashComponent;
use App\Support\Traits\Livewire\LiveTable;
use App\Support\Traits\Livewire\MenuTracker;
use App\View\Components\BaseLayout;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LaporanTindakanRadiologi extends Component
{
    use FlashComponent, Filterable, ExcelExportable, LiveTable, MenuTracker, DeferredLoading;

    public $tglAwal;

    public $tglAkhir;

    protected function queryString()
    {
        return [
            'tglAwal' => ['except' => now()->startOfMonth()->format('Y-m-d'), 'as' => 'tgl_awal'],
            'tglAkhir' => ['except' => now()->endOfMonth()->format('Y-m-d'), 'as' => 'tgl_akhir'],
        ];
    }

    public function mount()
    {
        $this->defaultValues();
    }

    public function getDataLaporanTindakanRadiologiProperty()
    {
        return HasilPeriksaRadiologi::query()
            ->laporanTindakanRadiologi($this->tglAwal, $this->tglAkhir)
            ->search($this->cari, [
                'periksa_radiologi.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'penjab.png_jawab',
                'petugas.nama',
                'periksa_radiologi.dokter_perujuk',
                'jns_perawatan_radiologi.kd_jenis_prw',
                'jns_perawatan_radiologi.nm_perawatan',
                'reg_periksa.status_bayar',
                'periksa_radiologi.status',
                'periksa_radiologi.kd_dokter',
                'dokter.nm_dokter',
                'hasil_radiologi.hasil',
            ])
            ->sortWithColumns($this->sortColumns, [
                'no_rawat'          => 'periksa_radiologi.no_rawat',
                'no_rkm_medis'      => 'reg_periksa.no_rkm_medis',
                'nm_pasien'         => 'pasien.nm_pasien',
                'png_jawab'         => 'penjab.png_jawab',
                'nama_petugas'      => 'petugas.nama',
                'tgl_periksa'       => 'periksa_radiologi.tgl_periksa',
                'jam'               => 'periksa_radiologi.jam',
                'dokter_perujuk'    => 'periksa_radiologi.dokter_perujuk',
                'kd_jenis_prw'      => 'jns_perawatan_radiologi.kd_jenis_prw',
                'nm_perawatan'      => 'jns_perawatan_radiologi.nm_perawatan',
                'biaya'             => 'periksa_radiologi.biaya',
                'status_bayar'      => 'reg_periksa.status_bayar',
                'status'            => 'periksa_radiologi.status',
                'kd_dokter'         => 'periksa_radiologi.kd_dokter',
                'nm_dokter'         => 'dokter.nm_dokter',
                'hasil_pemeriksaan' => DB::raw('LEFT(hasil_radiologi.hasil, 200)'),
            ], [
                'periksa_radiologi.tgl_periksa' => 'asc',
                'periksa_radiologi.jam' => 'asc',
            ])
            ->paginate($this->perpage);
    }

    public function render()
    {
        return view('livewire.keuangan.laporan-tindakan-radiologi')
            ->layout(BaseLayout::class, ['title' => 'Laporan Jumlah Tindakan Radiologi']);
    }

    protected function defaultValues()
    {
        $this->tglAwal = now()->startOfMonth()->format('Y-m-d');
        $this->tglAkhir = now()->endOfMonth()->format('Y-m-d');
    }

    protected function dataPerSheet(): array
    {
        return [
            HasilPeriksaRadiologi::query()
                ->laporanTindakanRadiologi($this->tglAwal, $this->tglAkhir)
                ->get(),
        ];
    }

    protected function columnHeaders(): array
    {
        return [
            "No. Rawat",
            "No. RM",
            "Pasien",
            "Jenis Bayar",
            "Petugas",
            "Tgl. Periksa",
            "Jam",
            "Perujuk",
            "Kode Tindakan",
            "Nama Tindakan",
            "Biaya (Rp)",
            "Status Bayar",
            "Jenis Perawatan",
            "Kode Dokter",
            "Nama Dokter Pemeriksa",
            "Hasil Pemeriksaan",
        ];
    }

    protected function pageHeaders(): array
    {
        return [
            'RS Samarinda Medika Citra',
            'Laporan Jumlah Tindakan Radiologi',
            now()->translatedFormat('d F Y'),
            'Periode ' . carbon($this->tglAwal)->format('d F Y') . ' s.d. ' . carbon($this->tglAkhir)->format('d F Y'),
        ];
    }
}
