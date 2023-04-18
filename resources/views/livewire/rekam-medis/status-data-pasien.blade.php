<div wire:init="loadProperties">
    <x-flash />

    <x-card use-default-filter use-loading loading-target="loadProperties">
        <x-slot name="body">
            <x-table :sortColumns="$sortColumns" style="width: 150rem" sortable zebra hover sticky nowrap>
                <x-slot name="columns">
                    <x-table.th style="width: 25ch" name="no_rawat" title="No. Rawat" />
                    <x-table.th style="width: 20ch" name="tgl_registrasi" title="Tgl. Registrasi" />
                    <x-table.th style="width: 15ch" name="stts" title="Status" />
                    <x-table.th style="width: 35ch" name="nm_dokter" title="Dokter" />
                    <x-table.th style="width: 10ch" name="no_rkm_medis" title="No. RM" />
                    <x-table.th name="nm_pasien" title="Pasien" />
                    <x-table.th style="width: 30ch" name="nm_poli" title="Poliklinik" />
                    <x-table.th style="width: 30ch" name="status_lanjut" title="Jenis Perawatan" />
                    <x-table.th style="width: 32ch" name="soapie_ralan" title="S.O.A.P.I.E. Ralan" />
                    <x-table.th style="width: 32ch" name="soapie_ranap" title="S.O.A.P.I.E. Ranap" />
                    <x-table.th style="width: 32ch" name="resume_ralan" title="Resume Ralan" />
                    <x-table.th style="width: 32ch" name="resume_ranap" title="Resume Ranap" />
                    <x-table.th style="width: 32ch" name="triase_igd" title="Triase IGD" />
                    <x-table.th style="width: 32ch" name="askep_igd" title="Askep IGD" />
                    <x-table.th style="width: 32ch" name="icd_10" title="ICD 10" />
                    <x-table.th style="width: 32ch" name="icd_9" title="ICD 9" />
                </x-slot>
                <x-slot name="body">
                    @forelse ($this->dataStatusRekamMedisPasien as $item)
                        <x-table.tr>
                            <x-table.td>{{ $item->no_rawat }}</x-table.td>
                            <x-table.td>{{ $item->tgl_registrasi }}</x-table.td>
                            <x-table.td>{{ $item->stts }}</x-table.td>
                            <x-table.td>{{ $item->nm_dokter }}</x-table.td>
                            <x-table.td>{{ $item->no_rkm_medis }}</x-table.td>
                            <x-table.td>{{ $item->nm_pasien }}</x-table.td>
                            <x-table.td>{{ $item->nm_poli }}</x-table.td>
                            <x-table.td>{{ $item->status_lanjut }}</x-table.td>
                            <x-table.td>{{ (bool) $item->soapie_ralan ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->soapie_ranap ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->resume_ralan ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->resume_ranap ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->triase_igd ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->askep_igd ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->icd_10 ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                            <x-table.td>{{ (bool) $item->icd_9 ? 'Ada' : 'Tidak Ada' }}</x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr-empty colspan="16" />
                    @endforelse
                </x-slot>
            </x-table>
        </x-slot>
        <x-slot name="footer">
            <x-paginator :data="$this->dataStatusRekamMedisPasien" />
        </x-slot>
    </x-card>
</div>
