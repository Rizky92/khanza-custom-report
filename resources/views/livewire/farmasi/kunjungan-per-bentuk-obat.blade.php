<div>
    <x-flash />

    <x-card>
        <x-slot name="header">
            <x-card.row-col>
                <x-filter.range-date />
                <x-filter.label class="ml-auto pr-3">Jenis Perawatan</x-filter.label>
                <div class="input-group input-group-sm" style="width: max-content">
                    <x-filter.select model="jenisPerawatan" placeholder="--Jenis Perawatan--" :options="[
                        '-' => 'Semua',
                        'ralan' => 'Rawat Jalan',
                        'ranap' => 'Rawat Inap',
                    ]" />
                </div>
                <x-filter.button-export-excel class="ml-2" />
            </x-card.row-col>
            <x-card.row-col class="mt-2">
                <x-filter.select-perpage />
                <x-filter.button-reset-filters class="ml-auto" />
                <x-filter.search />
            </x-card.row-col>
        </x-slot>
        <x-slot name="body">
            <x-navtabs :livewire="true">
                <x-slot name="tabs">
                    <x-navtabs.tab id="obat-regular" title="Obat Regular" selected />
                    <x-navtabs.tab id="obat-racikan" title="Obat Racikan" />
                </x-slot>
                <x-slot name="contents">
                    <x-navtabs.content id="obat-regular" title="Obat Regular" selected class="table-responsive">
                        <x-table class="mb-0" sortable :sortColumns="$sortColumns">
                            <x-slot name="columns">
                                <x-table.th name="no_resep" title="No. Resep" />
                                <x-table.th name="nm_dokter" title="Dokter Peresep" />
                                <x-table.th name="tgl_perawatan" title="Tgl. Validasi" />
                                <x-table.th name="jam" title="Jam" />
                                <x-table.th name="nm_pasien" title="Pasien" />
                                <x-table.th name="status_lanjut" title="Jenis Perawatan" />
                                <x-table.th name="total" title="Total Pembelian" />
                            </x-slot>
                            <x-slot name="body">
                                @foreach ($this->kunjunganResepObatRegularPasien as $resep)
                                    <x-table.tr>
                                        <x-table.td>{{ $resep->no_resep }}</x-table.td>
                                        <x-table.td>{{ $resep->nm_dokter }}</x-table.td>
                                        <x-table.td>{{ $resep->tgl_perawatan }}</x-table.td>
                                        <x-table.td>{{ $resep->jam }}</x-table.td>
                                        <x-table.td>{{ $resep->nm_pasien }}</x-table.td>
                                        <x-table.td>{{ $resep->status_lanjut }}</x-table.td>
                                        <x-table.td>{{ rp($resep->total) }}</x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                        <x-paginator class="px-4 py-3 bg-light" :data="$this->kunjunganResepObatRegularPasien" />
                    </x-navtabs.content>
                    <x-navtabs.content id="obat-racikan" title="Obat Racikan" class="table-responsive">
                        <x-table class="mb-0" sortable :sortColumns="$sortColumns">
                            <x-slot name="columns">
                                <x-table.th name="no_resep" title="No. Resep" />
                                <x-table.th name="nm_dokter" title="Dokter Peresep" />
                                <x-table.th name="tgl_perawatan" title="Tgl. Validasi" />
                                <x-table.th name="jam" title="Jam" />
                                <x-table.th name="nm_pasien" title="Pasien" />
                                <x-table.th name="status_lanjut" title="Jenis Perawatan" />
                                <x-table.th name="total" title="Total Pembelian" />
                            </x-slot>
                            <x-slot name="body">
                                @foreach ($this->kunjunganResepObatRacikanPasien as $resep)
                                    <x-table.tr>
                                        <x-table.td>{{ $resep->no_resep }}</x-table.td>
                                        <x-table.td>{{ $resep->nm_dokter }}</x-table.td>
                                        <x-table.td>{{ $resep->tgl_perawatan }}</x-table.td>
                                        <x-table.td>{{ $resep->jam }}</x-table.td>
                                        <x-table.td>{{ $resep->nm_pasien }}</x-table.td>
                                        <x-table.td>{{ $resep->status_lanjut }}</x-table.td>
                                        <x-table.td>{{ rp($resep->total) }}</x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                        <x-paginator class="px-4 py-3 bg-light" :data="$this->kunjunganResepObatRacikanPasien" />
                    </x-navtabs.content>
                </x-slot>
            </x-navtabs>
        </x-slot>
    </x-card>
</div>
