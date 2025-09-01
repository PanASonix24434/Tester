<div class="tab-pane fade " id="pendaftaran_antarabangsa" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ $tab['pendaftaran_antarabangsa']['description'] }}</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table mb-0 text-nowrap table-centered">
                    <tbody>
                        <tr>
                            <td class="text-bold table-light">Nama Vessel</td>
                            <td class="text-start">{{ $pendaftaran_antarabangsa->nama_vesel ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. Pendaftaran (Jabatan Laut)</td>
                            <td class="text-start">
                            {{ $pendaftaran_antarabangsa->no_pendaftaran_vesel ?? 'Tiada' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. IRCS</td>
                            <td class="text-start">{{ $pendaftaran_antarabangsa->no_ircs ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. RFMO</td>
                            <td class="text-start">
                            {{$pendaftaran_antarabangsa->no_rfmo ?? 'Tiada' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-bold table-light">No. IMO</td>
                            <td class="text-start">
                            {{$pendaftaran_antarabangsa->no_imo ?? 'Tiada' }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="text-bold table-light">Kawasan Penangkapan</td>
                            <td class="text-start">{{ $pendaftaran_antarabangsa->kawasan_penangkapan ?? 'Tiada' }}</td>
                        </tr>

                        <tr>
                            <td class="text-bold table-light">Pangkalan Tambahan</td>
                            <td class="text-start">{{ $am_vessel->pangkalan_tambahan ?? 'Tiada' }}</td>
                        </tr>
                        
                        <tr>
                            <td class="text-bold table-light">Spesis Sasaran</td>
                            <td class="text-start">{{ $pendaftaran_antarabangsa->spesis_sasaran ?? 'Tiada' }}</td>
                        
                        
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-10">
                <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                    Kembali <i class="icon-xxs"></i>
                </a>
            </div>
        </div>
    </div>
</div>
