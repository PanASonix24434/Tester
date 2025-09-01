<div class="tab-pane fade col mb-5 show active" id="am_vessel" role="tabpanel">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $tab['am_vessel']['description'] }}</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table mb-0 text-nowrap table-centered">
                    <tbody>
                        <tr>
                            <td class="text-bold table-light">No. Pendaftaran Vesel</td>
                            <td class="text-start">{{ $am_vessel->no_tetap ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. Geran</td>
                            <td class="text-start">
                                {{ $am_vessel->no_geran ?? 'Tiada' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. Patil Kekal</td>
                            <td class="text-start">{{ $am_vessel->no_patil_kekal ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Tarikh Daftar</td>
                            <td class="text-start">
                                {{ isset($am_vessel->tarikh_daftar) ? \Carbon\Carbon::parse($am_vessel->tarikh_daftar)->format('d-m-Y') : 'Tiada' }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="text-bold table-light">Lokasi Pembinaan Vesel</td>
                            <td class="text-start">{{ $am_vessel->tempasal_kapal ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Negara Asal</td>
                            <td class="text-start">{{ $am_vessel->negara ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Pemasangan MTU</td>
                            <td class="text-start">{{ $am_vessel->pemasangan_vtu ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">No. Pendaftaran MTU</td>
                            <td class="text-start
                            ">{{ $am_vessel->no_pendaftaran_mtu ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Hak Milik</td>
                            <td class="text-start">{{ $am_vessel->hak_milik ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Kod RFID/QR</td>
                            <td class="text-start">{{ $am_vessel->kod_rfid ?? 'Ya' }}</td>
                        </tr>
                        {{-- <tr>
                            <td class="text-bold table-light">Kod QR</td>
                            <td class="text-start">{{ $am_vessel->kod_qr ?? 'Tiada' }}</td>
                        </tr> --}}
                        <tr>
                            <td class="text-bold table-light">Pangkalan Utama</td>
                            <td class="text-start">{{ $am_vessel->pangkalan_utama ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold table-light">Pangkalan Tambahan</td>
                            <td class="text-start">{{ $am_vessel->pangkalan_tambahan ?? 'Tiada' }}</td>
                        </tr>
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
