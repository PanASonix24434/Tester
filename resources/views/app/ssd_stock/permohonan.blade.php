@extends('layouts.app')

@section('title', 'Permohonan Stok SSD')
@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white">
                                <i class="fas fa-boxes"></i>
                                Pengurusan Stok SSD
                            </h3>
                        </div>
                    </div>

                    <form id="permohonanForm" method="POST" action="{{ route('ssd-stock.store') }}">
                        @csrf
                        
                        <!-- Maklumat Permohonan Stok SSD -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h4 class="card-title mb-0">Maklumat Permohonan Stok SSD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tarikh_permohonan">Tarikh Permohonan Stok SSD:</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="tarikh_permohonan" name="tarikh_permohonan" value="{{ date('Y-m-d') }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="button" class="btn btn-info">
                                                    <i class="fas fa-info-circle"></i> Maklumat Permohonan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Senarai Permohonan Stok SSD -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">Senarai Permohonan Stok SSD</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">Bil</th>
                                            <th width="40%">Lesen</th>
                                            <th width="25%">Kuantiti Semasa</th>
                                            <th width="25%">Kuantiti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Geran</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Lesen Sampan</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Lesen Tradisi Zon A</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Lesen Unjam</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Lesen Komersil (Zon B, C & C2)</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Lesen Tuna (Zon C3)</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Lesen Bantuan - MPPI / Angkut</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Lesen Khas (PK2B, Siput Retak Seribu, Pukat Suluh Bilis)</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Lesen Vesel SKL (Angkut, Kerja, Penumpang)</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>Lesen Perikanan Darat</td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" readonly style="background-color: #f8f9fa;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="Auto" name="kuantiti[]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-primary" onclick="submitForm()">
                                    <i class="fas fa-arrow-right"></i> Hantar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Set current date
    $('#tarikh_permohonan').val('{{ date("Y-m-d") }}');
    
    // Handle quantity input changes
    $('input[name="kuantiti[]"]').on('input', function() {
        // Add any validation or auto-calculation logic here
        console.log('Quantity changed:', $(this).val());
    });
});

// Function to submit form for final submission
function submitForm() {
    if (confirm('Adakah anda pasti mahu menghantar permohonan ini?')) {
        // Change form action to submit route
        $('#permohonanForm').attr('action', '{{ route("ssd-stock.submit") }}');
        $('#permohonanForm').submit();
    }
}

// Handle form submission
$('#permohonanForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validate form
    var isValid = true;
    $('input[name="kuantiti[]"]').each(function() {
        if ($(this).val() === '' || $(this).val() === 'Auto') {
            $(this).addClass('is-invalid');
            isValid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    if (!isValid) {
        alert('Sila isi semua kuantiti yang diperlukan.');
        return;
    }
    
    // Submit form
    this.submit();
});
</script>
@endpush
