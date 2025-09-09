<!-- Semakan Tindakan Tab Content -->
<div class="row">
    <div class="col-12">
        <h5>Keputusan Permohonan</h5>
        
        <!-- Decision Form -->
        <div class="card">
            <div class="card-body">
                <form id="keputusanForm">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Keputusan bagi permohonan ini adalah :</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="keputusan_status" id="diluluskan" value="diluluskan" checked>
                                        <label class="form-check-label" for="diluluskan">
                                            Diluluskan
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="keputusan_status" id="tidak_diluluskan" value="tidak_diluluskan">
                                        <label class="form-check-label" for="tidak_diluluskan">
                                            Tidak Diluluskan
                                        </label>
                                    </div>
                                </div>
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
    $('input[name="keputusan_status"]').change(function() {
        var status = $(this).val();
        console.log('Decision status changed to:', status);
        
        // You can add logic here to handle status changes
        if (status === 'diluluskan') {
            // Handle approved status
            console.log('Application is approved');
        } else if (status === 'tidak_diluluskan') {
            // Handle not approved status
            console.log('Application is not approved');
        }
    });
    
    // Handle form submission
    $('#keputusanForm').on('submit', function(e) {
        e.preventDefault();
        
        var status = $('input[name="keputusan_status"]:checked').val();
        
        if (!status) {
            alert('Sila pilih keputusan permohonan!');
            return;
        }
        
        if (confirm('Adakah anda pasti mahu menghantar keputusan ini?')) {
            // Add submission logic here
            console.log('Submitting decision:', {status});
            alert('Keputusan telah dihantar!');
        }
    });
    
    // Handle save button
    $('.btn-success').click(function() {
        var status = $('input[name="keputusan_status"]:checked').val();
        
        if (!status) {
            alert('Sila pilih keputusan permohonan!');
            return;
        }
        
        // Add save logic here
        console.log('Saving decision:', {status});
        alert('Keputusan telah disimpan!');
    });
    
    // Handle submit button
    $('.btn-primary').click(function() {
        $('#keputusanForm').submit();
    });
});
</script>
