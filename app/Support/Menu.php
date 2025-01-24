<?php

namespace App\Support;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

class Menu
{
    /**
     * @param  Authenticatable&\App\Database\Eloquent\Authenticatable  $user
     */
    public static function all($user): Collection
    {
        $develop = config('permission.superadmin_name');

        return collect([
            [
                'name'              => 'Dashboard',
                'url'               => route('admin.dashboard'),
                'icon'              => 'fas fa-home',
                'type'              => 'link',
                'hasAnyPermissions' => true,
            ],
            [
                'name'              => 'Perawatan',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'perawatan.daftar-pasien-ranap.read',
                    'perawatan.laporan-pasien-ranap.read',
                    'perawatan.laporan-transaksi-gantung.read',
                    'perawatan.laporan-hasil-pemeriksaan.read',
                ]),
                'items' => [
                    [
                        'name'              => 'Daftar Pasien Ranap',
                        'url'               => route('admin.perawatan.daftar-pasien-ranap'),
                        'icon'              => 'fas fa-procedures',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.daftar-pasien-ranap.read'),
                    ],
                    [
                        'name'              => 'Laporan Pasien Ranap',
                        'url'               => route('admin.perawatan.laporan-pasien-ranap'),
                        'icon'              => 'fas fa-newspaper',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.laporan-pasien-ranap.read'),
                    ],
                    [
                        'name'              => 'Transaksi Gantung',
                        'url'               => route('admin.perawatan.laporan-transaksi-gantung'),
                        'icon'              => 'fas fa-file-alt',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.laporan-transaksi-gantung.read'),
                    ],
                    [
                        'name'              => 'Laporan Hasil Pemeriksaan',
                        'url'               => route('admin.perawatan.laporan-hasil-pemeriksaan'),
                        'icon'              => 'fas fa-file-alt',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('perawatan.laporan-hasil-pemeriksaan.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Laboratorium',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'lab.hasil-mcu-karyawan.read',
                ]),
                'items' => [
                    [
                        'name'              => 'Hasil MCU Karyawan',
                        'url'               => route('admin.lab.hasil-mcu-karyawan'),
                        'icon'              => 'fas fa-vial',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('lab.hasil-mcu-karyawan.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Keuangan',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'keuangan.rkat-penetapan.read',
                    'keuangan.rkat-pelaporan.read',
                    'keuangan.rkat-pemantauan.read',
                    'keuangan.rkat-kategori.read',
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
                    'keuangan.jurnal-perbaikan-riwayat.read',
                    'keuangan.stok-obat-ruangan.read',
                    'keuangan.laporan-trial-balance.read',
                    'keuangan.posting-jurnal',
                ]),
                'items' => [
                    [
                        'name'              => 'Penetapan RKAT',
                        'url'               => route('admin.keuangan.rkat-penetapan'),
                        'icon'              => 'fas fa-sitemap',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat-penetapan.read'),
                    ],
                    [
                        'name'              => 'Pelaporan RKAT',
                        'url'               => route('admin.keuangan.rkat-pelaporan'),
                        'icon'              => 'fas fa-coins',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat-pelaporan.read'),
                    ],
                    [
                        'name'              => 'Pemantauan RKAT',
                        'url'               => route('admin.keuangan.rkat-pemantauan'),
                        'icon'              => 'fas fa-coins',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat-pemantauan.read'),
                    ],
                    [
                        'name'              => 'Kategori RKAT',
                        'url'               => route('admin.keuangan.rkat-kategori'),
                        'icon'              => 'fas fa-coins',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.rkat-kategori.read'),
                    ],
                    [
                        'name'              => 'Stok Obat Ruangan',
                        'url'               => route('admin.keuangan.stok-obat-ruangan'),
                        'icon'              => 'fas fa-shapes',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.stok-obat-ruangan.read'),
                    ],
                    [
                        'name'              => 'Laporan Tambahan Biaya',
                        'url'               => route('admin.keuangan.laporan-tambahan-biaya'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tambahan-biaya.read'),
                    ],
                    [
                        'name'              => 'Laporan Potongan Biaya',
                        'url'               => route('admin.keuangan.laporan-potongan-biaya'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-potongan-biaya.read'),
                    ],
                    [
                        'name'              => 'Laporan Selesai Billing',
                        'url'               => route('admin.keuangan.laporan-selesai-billing'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-selesai-billing.read'),
                    ],
                    [
                        'name'              => 'Jurnal Supplier PO',
                        'url'               => route('admin.keuangan.jurnal-supplier-po'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-po-supplier.read'),
                    ],
                    [
                        'name'              => 'Jurnal Piutang Lunas',
                        'url'               => route('admin.keuangan.jurnal-piutang-lunas'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-piutang-lunas.read'),
                    ],
                    [
                        'name'              => 'Jurnal Perbaikan',
                        'url'               => route('admin.keuangan.jurnal-perbaikan'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-perbaikan.read'),
                    ],
                    [
                        'name'              => 'Riwayat Jurnal',
                        'url'               => route('admin.keuangan.jurnal-perbaikan-riwayat'),
                        'icon'              => 'fas fa-history',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.jurnal-perbaikan-riwayat.read'),
                    ],
                    [
                        'name'              => 'Buku Besar',
                        'url'               => route('admin.keuangan.buku-besar'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.buku-besar.read'),
                    ],
                    [
                        'name'              => 'Laba Rugi Rekening',
                        'url'               => route('admin.keuangan.laba-rugi-rekening'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laba-rugi-rekening.read'),
                    ],
                    [
                        'name'              => 'Laporan Tindakan Lab',
                        'url'               => route('admin.keuangan.laporan-tindakan-lab'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tindakan-lab.read'),
                    ],
                    [
                        'name'              => 'Laporan Tindakan Rdlg.',
                        'url'               => route('admin.keuangan.laporan-tindakan-radiologi'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-tindakan-radiologi.read'),
                    ],
                    [
                        'name'              => 'Piutang Aging AR',
                        'url'               => route('admin.keuangan.account-receivable'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.account-receivable.read'),
                    ],
                    [
                        'name'              => 'Hutang Aging AP',
                        'url'               => route('admin.keuangan.account-payable'),
                        'icon'              => 'fas fa-file-invoice',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->canAny(['keuangan.account-payable.read-medis', 'keuangan.account-payable.read-nonmedis']),
                    ],
                    [
                        'name'              => 'Laporan Trial Balance',
                        'url'               => route('admin.keuangan.laporan-trial-balance'),
                        'icon'              => 'fas fa-book',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.laporan-trial-balance.read'),
                    ],
                    [
                        'name'              => 'Posting Jurnal',
                        'url'               => route('admin.keuangan.posting-jurnal'),
                        'icon'              => "fas fa-book",
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('keuangan.posting-jurnal.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Farmasi',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'farmasi.stok-darurat.read',
                    'farmasi.pemakaian-stok.read',
                    'farmasi.obat-per-dokter.read',
                    'farmasi.laporan-produksi.read',
                    'farmasi.kunjungan-per-bentuk-obat.read',
                    'farmasi.kunjungan-per-poli.read',
                    'farmasi.perbandingan-po-obat.read',
                    'farmasi.laporan-pembuatan-soap.read',
                    'farmasi.laporan-pemakaian-obat-napza.read',
                    'farmasi.laporan-pemakaian-obat-morphine.read',
                    'farmasi.laporan-pemakaian-obat-tb.read',
                    'farmasi.defecta-depo.read',
                    'farmasi.daftar-riwayat-obat-alkes.read',
                    'farmasi.farmasi.rincian-perbandingan-po.read'
                ]),
                'items' => [
                    [
                        'name'              => 'Rencana Order',
                        'icon'              => 'far fa-newspaper',
                        'url'               => route('admin.farmasi.stok-darurat'),
                        'hasAnyPermissions' => $user->can('farmasi.stok-darurat.read'),
                    ],
                    [
                        'name'              => 'Pemakaian Stok',
                        'icon'              => 'far fa-newspaper',
                        'url'               => route('admin.farmasi.pemakaian-stok'),
                        'hasAnyPermissions' => $user->can('farmasi.pemakaian-stok.read'),
                    ],
                    [
                        'name'              => 'Laporan Produksi',
                        'icon'              => 'fas fa-th-list',
                        'url'               => route('admin.farmasi.laporan-produksi'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-produksi.read'),
                    ],
                    [
                        'name'              => 'Obat Per Dokter',
                        'icon'              => 'fas fa-pills',
                        'url'               => route('admin.farmasi.obat-per-dokter'),
                        'hasAnyPermissions' => $user->can('farmasi.obat-per-dokter.read'),
                    ],
                    [
                        'name'              => 'Kunjungan Bentuk Obat',
                        'icon'              => 'fas fa-pills',
                        'url'               => route('admin.farmasi.kunjungan-per-bentuk-obat'),
                        'hasAnyPermissions' => $user->can('farmasi.kunjungan-per-bentuk-obat.read'),
                    ],
                    [
                        'name'              => 'Kunjungan Poli',
                        'icon'              => 'fas fa-pills',
                        'url'               => route('admin.farmasi.kunjungan-per-poli'),
                        'hasAnyPermissions' => $user->can('farmasi.kunjungan-per-poli.read'),
                    ],
                    [
                        'name'              => 'Perbandingan PO Obat',
                        'icon'              => 'fas fa-balance-scale',
                        'url'               => route('admin.farmasi.perbandingan-po-obat'),
                        'hasAnyPermissions' => $user->can('farmasi.perbandingan-po-obat.read'),
                    ],
                    [
                        'name'              => 'Pembuatan SOAP',
                        'icon'              => 'fas fa-file-invoice',
                        'url'               => route('admin.farmasi.laporan-pembuatan-soap'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-pembuatan-soap.read'),
                    ],
                    [
                        'name'              => 'Pemakaian Obat NAPZA',
                        'icon'              => 'fas fa-file-invoice',
                        'url'               => route('admin.farmasi.laporan-pemakaian-obat-napza'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-pemakaian-obat-napza.read'),
                    ],
                    [
                        'name'              => 'Pemakaian Obat Morfin',
                        'icon'              => 'fas fa-file-invoice',
                        'url'               => route('admin.farmasi.laporan-pemakaian-obat-morphine'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-pemakaian-obat-morphine.read'),
                    ],
                    [
                        'name'              => 'Pemakaian Obat TB',
                        'icon'              => 'fas fa-file-invoice',
                        'url'               => route('admin.farmasi.laporan-pemakaian-obat-tb'),
                        'hasAnyPermissions' => $user->can('farmasi.laporan-pemakaian-obat-tb.read'),
                    ],
                    [
                        'name'              => 'Defecta Depo',
                        'icon'              => 'fas fa-shopping-cart',
                        'url'               => route('admin.farmasi.defecta-depo'),
                        'hasAnyPermissions' => $user->can('farmasi.defecta-depo.read'),
                    ],
                    [
                        'name'              => 'Daftar Riwayat Obat/Alkes',
                        'icon'              => 'fas fa-history',
                        'url'               => route('admin.farmasi.daftar-riwayat-obat-alkes'),
                        'hasAnyPermissions' => $user->can('farmasi.daftar-riwayat-obat-alkes.read'),
                    ],
                    [
                        'name'              => 'Rincian Perbandingan PO',
                        'icon'              => 'fas fa-balance-scale',
                        'url'               => route('admin.farmasi.rincian-perbandingan-po'),
                        'hasAnyPermissions' => $user->can('farmasi.rincian-perbandingan-po.read'),
                    ],
                    [
                        'name'              => 'Rincian Kunjungan Ralan',
                        'icon'              => 'fas fa-balance-scale',
                        'url'               => route('admin.farmasi.rincian-kunjungan-ralan'),
                        'hasAnyPermissions' => $user->can('farmasi.rincian-kunjungan-ralan.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Rekam Medis',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'rekam-medis.laporan-statistik.read',
                    'rekam-medis.laporan-demografi.read',
                    'rekam-medis.status-data-pasien.read',
                ]),
                'items' => [
                    [
                        'name'              => 'Laporan Statistik',
                        'icon'              => 'fas fa-file-alt',
                        'url'               => route('admin.rekam-medis.laporan-statistik'),
                        'hasAnyPermissions' => $user->can('rekam-medis.laporan-statistik.read'),
                    ],
                    [
                        'name'              => 'Demografi Pasien',
                        'icon'              => 'fas fa-globe-asia',
                        'url'               => route('admin.rekam-medis.laporan-demografi'),
                        'hasAnyPermissions' => $user->can('rekam-medis.laporan-demografi.read'),
                    ],
                    [
                        'name'              => 'Status Data Pasien',
                        'icon'              => 'fas fa-file-alt',
                        'url'               => route('admin.rekam-medis.status-data-pasien'),
                        'hasAnyPermissions' => $user->can('rekam-medis.status-data-pasien.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Logistik',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'logistik.input-minmax-stok.read',
                    'logistik.stok-darurat.read',
                ]),
                'items' => [
                    [
                        'name'              => 'Input Minmax Stok',
                        'icon'              => 'fas fa-pencil-alt',
                        'url'               => route('admin.logistik.input-minmax-stok'),
                        'hasAnyPermissions' => $user->can('logistik.input-minmax-stok.read'),
                    ],
                    [
                        'name'              => 'Stok Darurat',
                        'icon'              => 'far fa-newspaper',
                        'url'               => route('admin.logistik.stok-darurat'),
                        'hasAnyPermissions' => $user->can('logistik.stok-darurat.read'),
                    ],
                ],
            ],
            [
                'name'              => 'Aplikasi',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny(['aplikasi.bidang-unit.read']) || $user->hasRole($develop),
                'items'             => [
                    [
                        'name'              => 'Bidang Unit',
                        'url'               => route('admin.aplikasi.bidang-unit'),
                        'icon'              => 'fas fa-hospital',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('aplikasi.bidang-unit.read'),
                    ],
                    [
                        'name'              => 'Pengaturan',
                        'url'               => route('admin.aplikasi.pengaturan'),
                        'icon'              => 'fas fa-sliders-h',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                ],
            ],
            [
                'name'              => 'Hak Akses',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->hasRole($develop),
                'items'             => [
                    [
                        'name'              => 'SIMRS Khanza',
                        'url'               => route('admin.hak-akses.khanza'),
                        'icon'              => 'fas fa-key',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                    [
                        'name'              => 'SMC Internal App',
                        'url'               => route('admin.hak-akses.siap'),
                        'icon'              => 'fas fa-circle',
                        'type'              => 'dropdown',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                ],
            ],
            [
                'name'              => 'Antrean',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->canAny([
                    'antrean.manajemen-pintu.read',
                ]),
                'items'             => [
                    [
                        'name'              => 'Manajemen Pintu',
                        'url'               => route('admin.antrean.manajemen-pintu'),
                        'icon'              => 'fas fa-door-open',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->can('antrean.manajemen-pintu.read'),
                    ]
                ],
            ],
            [
                'name'              => 'Informasi',
                'icon'              => 'far fa-circle',
                'type'              => 'dropdown',
                'hasAnyPermissions' => $user->hasRole($develop),
                'items'             => [
                    [
                        'name'              => 'Informasi Kamar',
                        'url'               => route('admin.informasi.informasi-kamar'),
                        'icon'              => 'fas fa-info',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                    [
                        'name'              => 'Jadwal Dokter',
                        'url'               => route('admin.informasi.jadwal-dokter'),
                        'icon'              => 'fas fa-calendar',
                        'type'              => 'link',
                        'hasAnyPermissions' => $user->hasRole($develop),
                    ],
                ],
            ],
            [
                'name'              => 'Manajemen User',
                'url'               => route('admin.manajemen-user'),
                'icon'              => 'fas fa-users',
                'type'              => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
            [
                'name'              => 'Log Viewer',
                'url'               => route('admin.log-viewer'),
                'icon'              => 'fas fa-scroll',
                'type'              => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
            [
                'name'              => 'Route List',
                'url'               => route('admin.route-list'),
                'icon'              => 'fas fa-list-ul',
                'type'              => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
            [
                'name'              => 'Job Cleaner',
                'url'               => route('admin.job-cleaner'),
                'icon'              => 'fas fa-broom',
                'type'              => 'link',
                'hasAnyPermissions' => $user->hasRole($develop),
            ],
        ]);
    }
}
