<?php

namespace App\Http\Livewire\Logistik;

use App\Models\Logistik\BarangNonMedis;
use App\Support\Traits\Livewire\ExcelExportable;
use App\Support\Traits\Livewire\Filterable;
use App\Support\Traits\Livewire\FlashComponent;
use App\Support\Traits\Livewire\LiveTable;
use App\Support\Traits\Livewire\MenuTracker;
use App\View\Components\BaseLayout;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StokDaruratLogistik extends Component
{
    use WithPagination, FlashComponent, Filterable, ExcelExportable, LiveTable, MenuTracker;
    
    public $tampilkanSaranOrderNol;

    protected function queryString()
    {
        return [
            'tampilkanSaranOrderNol' => ['except' => true],
        ];
    }

    public function mount()
    {
        $this->defaultValues();
    }

    public function getStokDaruratLogistikProperty()
    {   
        return BarangNonMedis::query()
            ->daruratStok($this->tampilkanSaranOrderNol)
            ->search($this->cari, [
                'ipsrsbarang.kode_brng',
                'ipsrsbarang.nama_brng',
                "IFNULL(ipsrssuplier.nama_suplier, '-')",
                'ipsrsjenisbarang.nm_jenis',
                'kodesatuan.satuan',
            ])
            ->sortWithColumns($this->sortColumns, [
                'nama_supplier' => "IFNULL(ipsrssuplier.nama_suplier, '-')",
                'jenis'         => 'ipsrsjenisbarang.nm_jenis',
                'stokmin'       => 'IFNULL(smc.ipsrs_minmax_stok_barang.stok_min, 0)',
                'stokmax'       => 'IFNULL(smc.ipsrs_minmax_stok_barang.stok_max, 0)',
                'saran_order'   => DB::raw("IFNULL(IFNULL(smc.ipsrs_minmax_stok_barang.stok_max, 0) - ipsrsbarang.stok, '0')"),
                'total_harga'   => DB::raw("(ipsrsbarang.harga * (IFNULL(smc.ipsrs_minmax_stok_barang.stok_max, 0) - ipsrsbarang.stok))"),
            ], ['ipsrsbarang.nama_brng' => 'asc'])
            ->paginate($this->perpage);
    }

    public function render()
    {
        return view('livewire.logistik.stok-darurat-logistik')
            ->layout(BaseLayout::class, ['title' => 'Darurat Stok Barang Logistik']);
    }

    protected function defaultValues()
    {
        $this->cari = '';
        $this->perpage = 25;
        $this->tampilkanSaranOrderNol = true;
    }

    protected function dataPerSheet(): array
    {
        return [
            BarangNonMedis::daruratStok($this->tampilkanSaranOrderNol)->get()
        ];
    }

    protected function columnHeaders(): array
    {
        return [
            'Kode',
            'Nama',
            'Satuan',
            'Jenis',
            'Supplier',
            'Min',
            'Max',
            'Saat ini',
            'Saran order',
            'Harga Per Unit (Rp)',
            'Total Harga (Rp)',
        ];
    }

    protected function pageHeaders(): array
    {
        return [
            'RS Samarinda Medika Citra',
            'Darurat Stok Barang Non Medis',
            now()->format('d F Y'),
        ];
    }
}
