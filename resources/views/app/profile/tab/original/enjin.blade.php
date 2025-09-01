<div class="tab-pane fade" id="enjin" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tab['lesen']['description'] }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th class="pe-0"></th>
                            <th class="ps-0">Bil.</th>
                            <th>Jenis Enjin</th>
                            <th>Bahan Api</th>
                            <th>Jenama</th>
                            <th>Kuasa Kuda</th>
                            <th>No. Enjin</th>
                            <th>Model</th>
                            <th>Turbo</th>
                            <th>Tarikh PEV</th>
                            <th>Kategori Enjin</th>
                            <th>Status Enjin</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enjin as $enjin_item)
                            <tr>
                                <td class="pe-0"></td>
                                <td class="ps-0">{{ $loop->iteration }}</td>
                                <td>
                                    @if($enjin_item->jenis_enjin == 1)
                                        Sangkut
                                    @elseif($enjin_item->jenis_enjin == 2)
                                        Dalam
                                    @else
                                        Tiada
                                    @endif
                                </td>
                                <td>{{ $enjin_item->bahan_api ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->jenama ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->kuasa_kuda ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->no_enjin ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->model ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->turbo ?? 'Tiada' }}</td>
                                <td>{{ isset($enjin_item->tarikh_enjin_dilesenkan) ? 
                                    \Carbon\Carbon::parse($enjin_item->tarikh_enjin_dilesenkan)->format('d-m-Y') : 'Tiada' }}</td>
                                <td>{{ $enjin_item->kategori_enjin ?? 'Tiada' }}</td>
                                <td>{{ $enjin_item->status_enjin ?? 'Tiada' }}</td>
                                <td class="text-center">
                                    @if(isset($enjin_item->id))
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#enjinModal" 
                                                data-vessel-id="{{ $vessel->id }}" 
                                                data-enjin-id="{{ $enjin_item->id }}">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    @else
                                        Tiada
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tiada maklumat tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center mt-2">
            <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                Kembali <i class="icon-xxs"></i>
            </a>
        </div>
    </div>
</div>  

<!-- Modal for Enjin Details -->
<div class="modal fade" id="enjinModal" tabindex="-1" aria-labelledby="enjinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enjinModalLabel">Maklumat Penuh Enjin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="enjinModalContent">
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
    $('#enjinModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var vesselId = button.data('vessel-id'); // Get vessel ID from button
        var enjinId = button.data('enjin-id');   // Get engine ID from button
        var modal = $(this);

        // Show loading animation
        modal.find('#enjinModalContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuatkan...</div>');

        // Load content via AJAX
        $.ajax({
            url: "/profile/vessel/" + vesselId + "/tab/enjin/" + enjinId, // Pass parameters directly
            type: "GET",
            success: function(response) {
                modal.find('#enjinModalContent').html(response);
            },
            error: function() {
                modal.find('#enjinModalContent').html('<div class="text-center text-danger">Gagal memuatkan data.</div>');
            }
        });
    });
});
</script>