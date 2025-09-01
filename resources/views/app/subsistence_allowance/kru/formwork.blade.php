@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-8">
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link disabled" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="true">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-document" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" action="{{ route('subsistence-allowance.application.storeWork') }}">
                    @csrf
                <!-- row -->
                <div class="row">
                    <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Butiran Pekerjaan </h4>
                            </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Status Nelayan :</label>
                                                <input type="text" class="form-control" id="StatusNelayan" value="{{ $fishermanInfo != null ? ($fishermanInfo->fisherman_type_id != null ? Helper::getCodeMasterNameById($fishermanInfo->fisherman_type_id) : '--Tiada Rekod--') : '-Tiada Rekod-' }}" readonly>
                                                <input type="hidden" name="statusNelayanId" value="{{ $fishermanInfo != null ? ($fishermanInfo->fisherman_type_id != null ? $fishermanInfo->fisherman_type_id : null) : null }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Tahun Mula Menjadi Nelayan:</label>
                                                <input type="number" class="form-control" name="startYear" value="{{ $fishermanInfo ? $fishermanInfo->year_become_fisherman : '-Tiada Rekod-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-form-label">Tempoh Menjadi Nelayan:</label>
                                                <input type="number" class="form-control" name="duration" value="{{ $fishermanInfo ? $fishermanInfo->becoming_fisherman_duration : '-Tiada Rekod-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Bilangan Hari Menangkap Ikan Sebulan:</label>
                                                <input type="number" class="form-control" name="fishDays" value="{{ $fishermanInfo ? $fishermanInfo->working_days_fishing_per_month : '-Tiada Rekod-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="row">
                                       <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Purata Pendapatan Bulanan:</label>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">a. Hasil daripada menangkap ikan</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" class="form-control" name="fishing_income" id="fishing_income" value="{{ $subApplication->tot_incomefish ?? '0' }}" step="0.01" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">b. Hasil daripada pekerjaan lain (*jika ada)</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" class="form-control" name="other_income" id="other_income" value="{{ $subApplication->tot_incomeother ?? '0' }}" step="0.01" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 fw-bold">
                                            <label class="form-label">Jumlah:</label>
                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" class="form-control fw-bold" name="total_income" id="total_income" value="{{ $subApplication->tot_allincome ?? '0' }}" step="0.01" readonly>
                                        </div>
                                    </div>


                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistence-allowance.application.editformdetails',  $subApplication->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan ?</span>').text())">
                                                    <i class="fas fa-save"></i> Simpan & Seterusnya
                                                </button>
                                            </div>
                                        </div>
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

@endsection

@push('scripts')
<script type="text/javascript">

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    function calculateTotal() {
    let fishingIncome = parseFloat(document.getElementById('fishing_income').value) || 0;
    let otherIncome = parseFloat(document.getElementById('other_income').value) || 0;
    document.getElementById('total_income').value = fishingIncome + otherIncome;
    }

    document.getElementById('fishing_income').addEventListener('input', calculateTotal);
    document.getElementById('other_income').addEventListener('input', calculateTotal);

</script>
@endpush
