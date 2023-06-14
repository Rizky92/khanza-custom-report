<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Keuangan\Rekening;
use App\Support\Traits\Livewire\DeferredLoading;
use App\Support\Traits\Livewire\ExcelExportable;
use App\Support\Traits\Livewire\Filterable;
use App\Support\Traits\Livewire\FlashComponent;
use App\Support\Traits\Livewire\LiveTable;
use App\Support\Traits\Livewire\MenuTracker;
use App\View\Components\BaseLayout;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\View\View;
use Livewire\Component;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class LabaRugiRekeningPerPeriode extends Component
{
    use FlashComponent, Filterable, ExcelExportable, LiveTable, MenuTracker, DeferredLoading;

    /** @var string */
    public $tglAwal;

    /** @var string */
    public $tglAkhir;

    protected function queryString(): array
    {
        return [
            'tglAwal'  => ['except' => now()->startOfMonth()->format('Y-m-d'), 'as' => 'tgl_awal'],
            'tglAkhir' => ['except' => now()->endOfMonth()->format('Y-m-d'), 'as' => 'tgl_akhir'],
        ];
    }

    public function mount(): void
    {
        $this->defaultValues();
    }

    public function getLabaRugiPerRekeningProperty(): Collection
    {
        if ($this->isDeferred) {
            return collect(['D' => [], 'K' => []]);
        }

        $semuaRekening = Rekening::semuaRekening()->get();

        $debetKredit = Rekening::query()
            ->hitungDebetKreditPerPeriode($this->tglAwal, $this->tglAkhir)
            ->get();

        return $semuaRekening
            ->merge($debetKredit)
            ->map(function (Rekening $rekening): Fluent {
                $total = 0;

                $debet = $rekening->debet ?? 0;
                $kredit = $rekening->kredit ?? 0;

                if ($rekening->balance === 'K') {
                    $total = $kredit - $debet;
                }

                if ($rekening->balance === 'D') {
                    $total = $debet - $kredit;
                }

                return new Fluent(array_merge(
                    $rekening->only('kd_rek', 'nm_rek', 'balance'),
                    [
                        'debet' => floatval($debet),
                        'kredit' => floatval($kredit),
                        'total' => floatval($total),
                    ],
                ));
            })
            ->mapToGroups(fn ($item): array => [$item->balance => $item]);
    }

    public function getTotalLabaRugiPerRekeningProperty(): array
    {
        $pendapatan = collect($this->labaRugiPerRekening->get('K'));

        $bebanDanBiaya = collect($this->labaRugiPerRekening->get('D'));

        $totalDebetPendapatan = $pendapatan->sum('debet');
        $totalKreditPendapatan = $pendapatan->sum('kredit');
        $totalPendapatan = $totalKreditPendapatan - $totalDebetPendapatan;

        $totalDebetBeban = $bebanDanBiaya->sum('debet');
        $totalKreditBeban = $bebanDanBiaya->sum('kredit');
        $totalBebanDanBiaya = $totalDebetBeban - $totalKreditBeban;

        $labaRugi = $totalPendapatan - $totalBebanDanBiaya;

        return compact(
            'totalPendapatan',
            'totalDebetPendapatan',
            'totalKreditPendapatan',
            'totalBebanDanBiaya',
            'totalDebetBeban',
            'totalKreditBeban',
            'labaRugi'
        );
    }

    public function render(): View
    {
        return view('livewire.keuangan.laba-rugi-rekening-per-periode')
            ->layout(BaseLayout::class, ['title' => 'Laporan Laba Rugi']);
    }

    protected function defaultValues(): void
    {
        $this->cari = '';
        $this->perpage = 25;
        $this->sortColumns = [];
        $this->tglAwal = now()->startOfMonth()->format('Y-m-d');
        $this->tglAkhir = now()->endOfMonth()->format('Y-m-d');
    }

    protected function mapDataForExcelExport(): Collection
    {
        $pendapatanRowHeader = $this->insertExcelRow('', 'PENDAPATAN');
        $bebanRowHeader = $this->insertExcelRow('', 'BEBAN & BIAYA');
        $empty = $this->insertExcelRow();

        $pendapatan = $this->labaRugiPerRekening->get('K');
        $beban = $this->labaRugiPerRekening->get('D');

        $total = $this->totalLabaRugiPerRekening;

        $totalPendapatanRow = $this->insertExcelRow('', 'TOTAL', '', $total['totalDebetPendapatan'], $total['totalKreditPendapatan'], $total['totalPendapatan']);
        $totalBebanRow = $this->insertExcelRow('', 'TOTAL', '', $total['totalDebetBeban'], $total['totalKreditBeban'], $total['totalBebanDanBiaya']);

        $pendapatanBersih = $this->insertExcelRow('', 'PENDAPATAN BERSIH', '', $total['totalPendapatan'], $total['totalBebanDanBiaya'], $total['labaRugi']);

        return collect([$pendapatanRowHeader])
            ->merge($pendapatan)
            ->merge([$totalPendapatanRow, $empty])
            ->merge([$bebanRowHeader])
            ->merge($beban)
            ->merge([$totalBebanRow, $empty])
            ->merge([$pendapatanBersih]);
    }

    private function insertExcelRow(string $kd_rek = '', string $nm_rek = '', string $balance = '', string $debet = '', string $kredit = '', string $total = ''): Fluent
    {
        return new Fluent(func_get_named_args($this, 'insertExcelRow', func_get_args()));
    }

    protected function dataPerSheet(): array
    {
        return [
            $this->mapDataForExcelExport(),
        ];
    }

    protected function columnHeaders(): array
    {
        return [
            'Kode Akun',
            'Nama Akun',
            'Jenis',
            'Debet',
            'Kredit',
            'Total',
        ];
    }

    protected function pageHeaders(): array
    {
        $periodeAwal = carbon($this->tglAwal);
        $periodeAkhir = carbon($this->tglAkhir);

        $periode = 'Periode ' . $periodeAwal->translatedFormat('d F Y') . ' s.d. ' . $periodeAkhir->translatedFormat('d F Y');

        if ($periodeAwal->isSameDay($periodeAkhir)) {
            $periode = $periodeAwal->translatedFormat('d F Y');
        }

        return [
            'RS Samarinda Medika Citra',
            'Laporan Laba Rugi Keuangan',
            now()->translatedFormat('d F Y'),
            $periode,
        ];
    }
}
