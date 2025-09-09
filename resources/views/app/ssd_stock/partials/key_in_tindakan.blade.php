<!-- Key In Tindakan Tab Content -->
<div class="row">
    <div class="col-12">
        <h5>Pengesahan Penghantaran</h5>
        
        <!-- Delivery Confirmation Form -->
        <div class="card">
            <div class="card-body">
                <form id="pengesahanForm">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-3">Stok SSD bagi permohonan ini telah dihantar:</p>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pengesahan_penghantaran" id="disahkan" value="disahkan" checked>
                                    <label class="form-check-label" for="disahkan">
                                        Disahkan
                                    </label>
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
    $('input[name="pengesahan_penghantaran"]').change(function() {
        var status = $(this).val();
        console.log('Delivery confirmation changed to:', status);
        
        // You can add logic here to handle status changes
        if (status === 'disahkan') {
            // Handle confirmed status
            console.log('Delivery is confirmed');
        }
    });
    
    // Handle form submission
    $('#pengesahanForm').on('submit', function(e) {
        e.preventDefault();
        
        var status = $('input[name="pengesahan_penghantaran"]:checked').val();
        
        if (!status) {
            alert('Sila pilih status pengesahan!');
            return;
        }
        
        if (confirm('Adakah anda pasti mahu menghantar pengesahan ini?')) {
            // Add submission logic here
            console.log('Submitting confirmation:', {status});
            alert('Pengesahan telah dihantar!');
        }
    });
    
    // Handle save button
    $('.btn-success').click(function() {
        var status = $('input[name="pengesahan_penghantaran"]:checked').val();
        
        if (!status) {
            alert('Sila pilih status pengesahan!');
            return;
        }
        
        // Add save logic here
        console.log('Saving confirmation:', {status});
        alert('Pengesahan telah disimpan!');
    });
    
    // Handle submit button
    $('.btn-primary').click(function() {
        $('#pengesahanForm').submit();
    });
});
</script>
