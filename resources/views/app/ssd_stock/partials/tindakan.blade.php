<!-- Tindakan Tab Content -->
<div class="row">
    <div class="col-12">
        <h5>Sokongan Permohonan</h5>
        
        <!-- Support Form -->
        <div class="card">
            <div class="card-body">
                <form id="sokonganForm">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Maklumat dan Dokumen Permohonan :</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sokongan_status" id="disokong" value="disokong" checked>
                                        <label class="form-check-label" for="disokong">
                                            Disokong
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sokongan_status" id="tidak_disokong" value="tidak_disokong">
                                        <label class="form-check-label" for="tidak_disokong">
                                            Tidak Disokong
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="ulasan" class="form-label">Ulasan :</label>
                                <textarea class="form-control" id="ulasan" name="ulasan" rows="6" placeholder="Masukkan ulasan anda..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle radio button changes
    $('input[name="sokongan_status"]').change(function() {
        var status = $(this).val();
        console.log('Support status changed to:', status);
        
        // You can add logic here to handle status changes
        if (status === 'disokong') {
            // Handle supported status
            console.log('Application is supported');
        } else if (status === 'tidak_disokong') {
            // Handle not supported status
            console.log('Application is not supported');
        }
    });
    
    // Handle form submission
    $('#sokonganForm').on('submit', function(e) {
        e.preventDefault();
        
        var status = $('input[name="sokongan_status"]:checked').val();
        var ulasan = $('#ulasan').val();
        
        if (!status) {
            alert('Sila pilih status sokongan!');
            return;
        }
        
        if (confirm('Adakah anda pasti mahu menghantar sokongan ini?')) {
            // Add submission logic here
            console.log('Submitting support:', {status, ulasan});
            alert('Sokongan telah dihantar!');
        }
    });
    
    // Handle save button
    $('.btn-success').click(function() {
        var status = $('input[name="sokongan_status"]:checked').val();
        var ulasan = $('#ulasan').val();
        
        if (!status) {
            alert('Sila pilih status sokongan!');
            return;
        }
        
        // Add save logic here
        console.log('Saving support:', {status, ulasan});
        alert('Sokongan telah disimpan!');
    });
    
    // Handle submit button
    $('.btn-primary').click(function() {
        $('#sokonganForm').submit();
    });
});
</script>
