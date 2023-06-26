<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;
use Illuminate\View\View;

class BaseLayout extends Component
{
    public ?Collection $sidebarMenu;

    public ?string $title;

    public ?string $current;

    public ?string $nama;

    public ?string $nik;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = 'Dashboard')
    {
        /** @var \App\Models\Aplikasi\User $user */
        $user = Auth::user();

        $develop = config('permission.superadmin_name');

        $this->title = $title;
        $this->current = URL::current();
        $this->nama = $user->nama;
        $this->nik = $user->nik;

        $this->sidebarMenu = collect([
            [
                'name' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'icon' => "fas fa-home",
                'type' => 'link',
                'hasAnyPermissions' => true,
            ],
            [
                'name' => 'Perawatan',
                'icon' => 'far fa-circle',
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'perawatan.daftar-pasien-ranap.read',
                    'perawatan.laporan-pasien-ranap.read',
                ]),
                'items' => [
                    [
                        'name' => 'Daftar Pasien Ranap',
                        'url' => route('admin.perawatan.daftar-pasien-ranap'),
                        'icon' => "fas fa-procedures",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.daftar-pasien-ranap.read'),
                    ],
                    [
                        'name' => 'Laporan Pasien Ranap',
                        'url' => route('admin.perawatan.laporan-pasien-ranap'),
                        'icon' => "fas fa-newspaper",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.laporan-pasien-ranap.read'),
                    ],
                ]
            ],
            [
                'name' => 'Keuangan',
                'icon' => "far fa-circle",
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'keuangan.rkat.penetapan-rkat.read',
                    'keuangan.rkat.pelaporan-rkat.read',
                    'keuangan.rkat.pemantauan-rkat.read',
                    'keuangan.rkat.kategori-rkat.read',
                    'keuangan.account-payable.read-medis',
                    'keuangan.account-payable.read-nonmedis',
                    'keuangan.account-receivable.read',
                    'keuangan.buku-besar.read',
                    'keuangan.jurnal-perbaikan.read',
                    'keuangan.jurnal-piutang-lunas.read',
                    'keuangan.jurnal-po-supplier.read',
                    'keuangan.laba-rugi-rekening.read',
                    'keuangan.laporan-potongan-biaya.read',
                    'keuangan.laporan-selesai-billing.read',
                    'keuangan.laporan-tambahan-biaya.read',
                    'keuangan.laporan-tindakan-lab.read',
                    'keuangan.laporan-tindakan-radiologi.read',
                    'keuangan.rekap-piutang-aging.read',
                    'keuangan.rekap-piutang-pasien.read',
                    'keuangan.riwayat-jurnal-perbaikan.read',
                    'keuangan.stok-obat-ruangan.read',
                ]),
                'items' => [
                    [
                        'name' => 'Penetapan RKAT',
                        'url' => route('admin.keuangan.penetapan-rkat'),
                        'icon' => "fas fa-sitemap",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat.penetapan-rkat.read'),
                    ],
                    [
                        'name' => 'Pelaporan RKAT',
                        'url' => route('admin.keuangan.pelaporan-rkat'),
                        'icon' => "fas fa-coins",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat.pelaporan-rkat.read'),
                    ],
                    [
                        'name' => 'Pemantauan RKAT',
                        'url' => route('admin.keuangan.pemantauan-rkat'),
                        'icon' => "fas fa-coins",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat.pemantauan-rkat.read'),
                    ],
                    [
                        'name' => 'Kategori RKAT',
                        'url' => route('admin.keuangan.kategori-rkat'),
                        'icon' => "fas fa-coins",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat.kategori-rkat.read'),
                    ],
                    [
                        'name' => 'Stok Obat Ruangan',
                        'url' => route('admin.keuangan.stok-obat-ruangan'),
                        'icon' => "fas fa-shapes",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.stok-obat-ruangan.read'),
                    ],
                    [
                        'name' => 'Rekap Piutang Pasien',
                        'url' => route('admin.keuangan.rekap-piutang-pasien'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rekap-piutang-pasien.read'),
                    ],
                    [
                        'name' => 'Laporan Tambahan Biaya',
                        'url' => route('admin.keuangan.laporan-tambahan-biaya'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tambahan-biaya.read'),
                    ],
                    [
                        'name' => 'Laporan Potongan Biaya',
                        'url' => route('admin.keuangan.laporan-potongan-biaya'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-potongan-biaya.read'),
                    ],
                    [
                        'name' => 'Laporan Selesai Billing',
                        'url' => route('admin.keuangan.laporan-selesai-billing'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-selesai-billing.read'),
                    ],
                    [
                        'name' => 'Jurnal Supplier PO',
                        'url' => route('admin.keuangan.jurnal-supplier-po'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-po-supplier.read'),
                    ],
                    [
                        'name' => 'Jurnal Piutang Lunas',
                        'url' => route('admin.keuangan.jurnal-piutang-lunas'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-piutang-lunas.read'),
                    ],
                    [
                        'name' => 'Jurnal Perbaikan',
                        'url' => route('admin.keuangan.jurnal-perbaikan'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-perbaikan.read'),
                    ],
                    // [
                    //     'name' => 'Riwayat Jurnal Perbaikan',
                    //     'url' => route('admin.keuangan.riwayat-jurnal-perbaikan'),
                    //     'icon' => "fas fa-history",
                    //     'type' => 'link',
                    //     'hasAnyPermissions' => $user->can('keuangan.riwayat-jurnal-perbaikan.read'),
                    // ],
                    [
                        'name' => 'Buku Besar',
                        'url' => route('admin.keuangan.buku-besar'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.buku-besar.read'),
                    ],
                    [
                        'name' => 'Laba Rugi Rekening',
                        'url' => route('admin.keuangan.laba-rugi-rekening'),
                        'icon' => "fas fa-book",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laba-rugi-rekening.read'),
                    ],
                    [
                        'name' => 'Laporan Tindakan Lab',
                        'url' => route('admin.keuangan.laporan-tindakan-lab'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tindakan-lab.read'),
                    ],
                    [
                        'name' => 'Laporan Tindakan Rdlg.',
                        'url' => route('admin.keuangan.laporan-tindakan-radiologi'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tindakan-radiologi.read'),
                    ],
                    [
                        'name' => 'Piutang Aging AR',
                        'url' => route('admin.keuangan.account-receivable'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.account-receivable.read'),
                    ],
                    [
                        'name' => 'Hutang Aging AP',
                        'url' => route('admin.keuangan.account-payable'),
                        'icon' => "fas fa-file-invoice",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->canAny(['keuangan.account-payable.read-medis', 'keuangan.account-payable.read-nonmedis']),
                    ],
                ],
            ],
            [
                'name' => 'Farmasi',
                'icon' => "far fa-circle",
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'farmasi.stok-darurat.read',
                    'farmasi.obat-per-dokter.read',
                    'farmasi.laporan-produksi.read',
                    'farmasi.kunjungan-per-bentuk-obat.read',
                    'farmasi.kunjungan-per-poli.read',
                    'farmasi.perbandingan-po-obat.read',
                ]),
                'items' => [
                    [
                        'name' => 'Stok Darurat',
                        'icon' => 'far fa-newspaper',
                        'url' => route('admin.farmasi.stok-darurat'),
                        'hasAnyPermissions' => $user->can('farmasi.stok-darurat.read'),
                    ],
                    [
                        'name' => 'Laporan Produksi',
                        'icon' => 'fas fa-th-list',
                        'url' => route('admin.farmasi.laporan-produksi'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-produksi.read'),
                    ],
                    [
                        'name' => 'Obat Per Dokter',
                        'icon' => 'fas fa-pills',
                        'url' => route('admin.farmasi.obat-per-dokter'),
                        'hasAnyPermissions' => $user->can('farmasi.obat-per-dokter.read'),
                    ],
                    [
                        'name' => 'Kunjungan Bentuk Obat',
                        'icon' => 'fas fa-pills',
                        'url' => route('admin.farmasi.kunjungan-per-bentuk-obat'),
                        'hasAnyPermissions' => $user->can('farmasi.kunjungan-per-bentuk-obat.read'),
                    ],
                    [
                        'name' => 'Kunjungan Poli',
                        'icon' => 'fas fa-pills',
                        'url' => route('admin.farmasi.kunjungan-per-poli'),
                        'hasAnyPermissions' => $user->can('farmasi.kunjungan-per-poli.read'),
                    ],
                    [
                        'name' => 'Perbandingan PO Obat',
                        'icon' => 'fas fa-balance-scale',
                        'url' => route('admin.farmasi.perbandingan-po-obat'),
                        'hasAnyPermissions' => $user->can('farmasi.perbandingan-po-obat.read'),
                    ],
                ],
            ],
            [
                'name' => 'Rekam Medis',
                'icon' => "far fa-circle",
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'rekam-medis.laporan-statistik.read',
                    'rekam-medis.laporan-demografi.read',
                    'rekam-medis.status-data-pasien.read',
                ]),
                'items' => [
                    [
                        'name' => 'Laporan Statistik',
                        'icon' => 'fas fa-file-alt',
                        'url' => route('admin.rekam-medis.laporan-statistik'),
                        'hasAnyPermissions' => $user->can('rekam-medis.laporan-statistik.read'),
                    ],
                    [
                        'name' => 'Demografi Pasien',
                        'icon' => 'fas fa-globe-asia',
                        'url' => route('admin.rekam-medis.laporan-demografi'),
                        'hasAnyPermissions' => $user->can('rekam-medis.laporan-demografi.read'),
                    ],
                    [
                        'name' => 'Status Data Pasien',
                        'icon' => 'fas fa-file-alt',
                        'url' => route('admin.rekam-medis.status-data-pasien'),
                        'hasAnyPermissions' => $user->can('rekam-medis.status-data-pasien.read'),
                    ],
                ],
            ],
            [
                'name' => 'Logistik',
                'icon' => "far fa-circle",
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'logistik.input-minmax-stok.read',
                    'logistik.stok-darurat.read',
                ]),
                'items' => [
                    [
                        'name' => 'Input Minmax Stok',
                        'icon' => 'fas fa-pencil-alt',
                        'url' => route('admin.logistik.input-minmax-stok'),
                        'hasAnyPermissions' => $user->can('logistik.input-minmax-stok.read'),
                    ],
                    [
                        'name' => 'Stok Darurat',
                        'icon' => 'far fa-newspaper',
                        'url' => route('admin.logistik.stok-darurat'),
                        'hasAnyPermissions' => $user->can('logistik.stok-darurat.read'),
                    ],
                ],
            ],
            [
                'name' => 'Aplikasi',
                'icon' => 'far fa-circle',
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->hasRole($develop),
                'items' => [
                    [
                        'name' => 'Bidang Unit',
                        'url' => route('admin.aplikasi.bidang-unit'),
                        'icon' => "fas fa-hospital",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                ],
            ],
            [
                'name' => 'Hak Akses',
                'icon' => "far fa-circle",
                'type' => 'dropdown',
                'hasAnyPermissions' => $user->hasRole($develop),
                'items' => [
                    [
                        'name' => 'SIMRS Khanza',
                        'url' => route('admin.hak-akses.khanza'),
                        'icon' => "fas fa-key",
                        'type' => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                    [
                        'name' => 'SMC Internal App',
                        'url' => route('admin.hak-akses.siap'),
                        'icon' => 'fas fa-key',
                        'type' => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                ],
            ],
            [
                'name' => 'Manajemen User',
                'url' => route('admin.manajemen-user'),
                'icon' => "fas fa-users",
                'type' => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
            [
                'name' => 'Log Viewer',
                'url' => route('admin.log-viewer'),
                'icon' => "fas fa-scroll",
                'type' => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
            [
                'name' => 'Route List',
                'url' => route('admin.route-list'),
                'icon' => "fas fa-list-ul",
                'type' => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.admin');
    }
}
