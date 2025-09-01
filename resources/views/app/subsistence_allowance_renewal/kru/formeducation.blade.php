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
                        <h3 class="mb-0">Permohonan Pembaharuan ESH Nelayan</h3>
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
                    <a class="nav-link disabled" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="true">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-doc-tab" href="#" role="tab" aria-controls="custom-content-doc" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="false">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance-renewal.storeEducation') }}">
                    @csrf
                <!-- row -->
                <div class="row">
                <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">D. Tahap Pendidikan</h4>
                            </div>

                                <div class="card-body">

                                    <div class="row">
                                       <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">17. Tahap Pendidikan Pemohon</label>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_primary" id="is_primary" {{ !empty($subApplication->is_primary) && $subApplication->is_primary == 1 ? 'checked' : ($subApplication->is_primary === null ? ( $previousApp->is_primary == 1 ? 'checked' : '' ) : '') }}>
                                                    <label class="form-check-label" for="is_primary">Sekolah Rendah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_secondary" id="is_secondary" {{ !empty($subApplication->is_secondary) && $subApplication->is_secondary == 1 ? 'checked' : ($subApplication->is_secondary === null ? ( $previousApp->is_secondary == 1 ? 'checked' : '' ) : '') }}>
                                                    <label class="form-check-label" for="is_secondary">Sekolah Menengah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="is_uni" id="is_uni" {{ !empty($subApplication->is_uni) && $subApplication->is_uni == 1 ? 'checked' : ($subApplication->is_uni === null ? ( $previousApp->is_uni == 1 ? 'checked' : '' ) : '') }}>
                                                    <label class="form-check-label" for="is_uni">Kolej / Universiti</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="education" value="no_school" id="no_school" {{ !empty($subApplication->no_school) && $subApplication->no_school == 1 ? 'checked' : ($subApplication->no_school === null ? ( $previousApp->no_school == 1 ? 'checked' : '' ) : '') }}>
                                                    <label class="form-check-label" for="no_school">Tidak Bersekolah</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                   

                                    
                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistence-allowance-renewal.formdependent' ,  $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Permohonan ?</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save_next') }}
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
