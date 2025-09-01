
<div class="tab-pane fade" id="pematuhan" role="tabpanel">
    <div class="col mb-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $tab['pematuhan']['description'] }}</h4>
            </div>
            
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table mb-0 text-nowrap table-centered">
                        <thead>
                            <tr>
                                <td class="text-bold table-light">Bil.</td>
                                <td class="text-bold table-light">Tarikh Pemeriksaan LPI</td>
                                <td class="text-bold table-light">Sebab Pemeriksaan</td>
                                <td class="text-bold table-light">Status Aktif</td>
                                <td class="text-bold table-light">Tindakan</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pematuhan as $index => $patuh)

                                <tr>
                                    <td class="text-start">{{ (int)$index + 1 }}</td>
                                    <td class="text-start">
                                        {{ isset($patuh->tarikh_pemeriksaan_lpi) && $patuh->tarikh_pemeriksaan_lpi
                                            ? \Carbon\Carbon::parse($patuh->tarikh_pemeriksaan_lpi)->format('d-m-Y') 
                                            : 'Tiada' }}
                                    </td>
                                    

                                    <td>{{ $patuh->sebab_pemeriksaan ?? 'Tiada' }}</td>

                                    <!-- <td>
                                        <span class="badge {{ $patuh->status_pematuhan ? 'bg-success' : 'bg-danger' }}">
                                            {{ $patuh->status_pematuhan ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td> -->

                                    @php
                                        if ( $patuh->status_pematuhan === 'Aktif') {
                                            $badgeClass = 'badge-success-soft text-dark-success';
                                            $statusText = 'Aktif';
                                        } elseif ($patuh->status_pematuhan === 'Tidak Aktif') {
                                            $badgeClass = 'badge-warning-soft text-dark-warning';
                                            $statusText = 'Tidak Aktif';
                                        } else {
                                            $badgeClass = 'badge-danger-soft text-dark-danger';
                                            $statusText = 'Batal';
                                        }
                                    @endphp

                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>
                                   
                                    
                                    <td class="text-center">
                                        @if(isset($patuh->id))
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#patuhModal" 
                                                    data-vessel-id="{{ $vessel->id }}" 
                                                    data-kulit-id="{{ $patuh->id }}">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        @else
                                            Tiada
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-10">
                    <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                        Kembali
                        <i class="icon-xxs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="patuhModal" tabindex="-1" aria-labelledby="patuhModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kulitModalLabel">Maklumat Penuh Pematuhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Memuatkan...
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#patuhModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var vesselId = button.data('vessel-id'); // Get vessel id from button
        var patuhId = button.data('patuh-id');   // Get kulit id from button
        var modal = $(this);

        // Show loading animation
        modal.find('#modalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuatkan...</div>');

        // Load content via AJAX
        $.ajax({
            url: "/profile/vessel/" + vesselId + "/tab/patuh/" + patuhId, // Pass parameters directly
            type: "GET",
            success: function(response) {
                modal.find('#modalContent').html(response);
            },
            error: function() {
                modal.find('#modalContent').html('<div class="text-center text-danger">Gagal memuatkan data.</div>');
            }
        });
    });
});
</script>

