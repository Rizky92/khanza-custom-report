<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Keuangan\Jurnal\Jurnal;
use App\Support\Traits\Livewire\DeferredLoading;
use App\Support\Traits\Livewire\ExcelExportable;
use App\Support\Traits\Livewire\Filterable;
use App\Support\Traits\Livewire\FlashComponent;
use App\Support\Traits\Livewire\LiveTable;
use App\Support\Traits\Livewire\MenuTracker;
use App\View\Components\BaseLayout;
use Livewire\Component;

class PerbaikanTanggalJurnal extends Component
{
    use FlashComponent, Filterable, ExcelExportable, LiveTable, MenuTracker, DeferredLoading;

    public $periodeAwal;

    public $periodeAkhir;

    protected function queryString()
    {
        return [
            'periodeAwal' => ['except' => now()->format('Y-m-d'), 'as' => 'tgl_awal'],
            'periodeAkhir' => ['except' => now()->format('Y-m-d'), 'as' => 'tgl_akhir'],
        ];
    }

    public function mount()
    {
        $this->defaultValues();
    }

    public function getJurnalProperty()
    {
        return Jurnal::jurnalUmum($this->periodeAwal, $this->periodeAkhir)
            ->search($this->cari, [
                'jurnal.no_jurnal',
                'jurnal.no_bukti',
                'detailjurnal.kd_rek',
                'rekening.nm_rek',
                'jurnal.keterangan',
            ])
            ->paginate($this->perpage);
    }

    public function render()
    {
        return view('livewire.keuangan.perbaikan-tanggal-jurnal')
            ->layout(BaseLayout::class, ['title' => 'Perbaikan Tanggal Jurnal Transaksi Keuangan']);
    }

    protected function defaultValues()
    {
        $this->periodeAwal = now()->format('Y-m-d');
        $this->periodeAkhir = now()->format('Y-m-d');
    }

    protected function dataPerSheet(): array
    {
        return [
            //
        ];
    }

    protected function columnHeaders(): array
    {
        return [
            //
        ];
    }

    protected function pageHeaders(): array
    {
        return [
            //
        ];
    }
}
