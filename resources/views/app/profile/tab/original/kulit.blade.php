<!-- filepath: c:\Users\wanmu\OneDrive\Desktop\Project\2025\Laravel\perikanan\elesen20-20250305\resources\views\app\profile\tab\kulit.blade.php -->
<div class="tab-pane fade" id="kulit" role="tabpanel">
    <div class="col mb-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tab['kulit']['description'] }}</h4>
            </div>
            
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table mb-0 text-nowrap table-centered">
                        <thead>
                            <tr>
                                <td class="text-bold table-light">Bil.</td>
                                <td class="text-bold table-light">No. Rujukan Permohonan</td>
                                <td class="text-bold table-light">Tarikh kulit dilesenkan</td>
                                <td class="text-bold table-light">Jenis Kulit</td>
                                <td class="text-bold table-light">Catatan</td>
                                <td class="text-bold table-light">Tindakan</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($kulitList as $index => $kulit)

                                <tr>
                                    <td class="text-start">{{ (int)$index + 1 }}</td>
                                    <td class="text-start">
                                        @if($user->is_admin && isset($kulit->no_rujukan_permohonan))
                                            <a href="{{ route('permohonan.show', $kulit->no_rujukan_permohonan) }}">
                                                {{ $kulit->no_rujukan_permohonan }}
                                            </a>
                                        @elseif(isset($kulit->no_rujukan_permohonan))
                                            {{ $kulit->no_rujukan_permohonan }}
                                        @else
                                            Tiada
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        {{ isset($kulit->tarikh_kulit_dilesenkan) && $kulit->tarikh_kulit_dilesenkan 
                                            ? \Carbon\Carbon::parse($kulit->tarikh_kulit_dilesenkan)->format('d-m-Y') 
                                            : 'Tiada' }}
                                    </td>
                                    <td class="text-start">
                                        {{ $kulit->jenis_kulit ?? 'Tiada' }}
                                    </td>
                                    <td class="text-start">
                                        {{ $kulit->catatan ?? 'Tiada' }}
                                    </td>
                                    <td class="text-center">
                                        @if(isset($kulit->id))
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#kulitModal" 
                                                    data-vessel-id="{{ $vessel->id }}" 
                                                    data-kulit-id="{{ $kulit->id }}">
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
<div class="modal fade" id="kulitModal" tabindex="-1" aria-labelledby="kulitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kulitModalLabel">Maklumat Penuh Kulit</h5>
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
    $('#kulitModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var vesselId = button.data('vessel-id'); // Get vessel id from button
        var kulitId = button.data('kulit-id');   // Get kulit id from button
        var modal = $(this);

        // Show loading animation
        modal.find('#modalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuatkan...</div>');

        // Load content via AJAX
        $.ajax({
            url: "/profile/vessel/" + vesselId + "/tab/kulit/" + kulitId, // Pass parameters directly
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

