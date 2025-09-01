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
                  <a class="nav-link" id="custom-content-form-tab" data-toggle="pill" href="#custom-content-form" role="tab" aria-controls="custom-content-form" aria-selected="false">Butiran Pemohon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-work-tab" href="#" role="tab" aria-controls="custom-content-work" aria-selected="false">Butiran Pekerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-depandents-tab" href="#" role="tab" aria-controls="custom-content-dependents" aria-selected="false">Butiran Tanggungan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-education-tab" href="#" role="tab" aria-controls="custom-content-education" aria-selected="false">Tahap Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-doc-tab" href="#" role="tab" aria-controls="custom-content-doc" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-declaration-tab" href="#" role="tab" aria-controls="custom-content-declaration" aria-selected="true">Perakuan</a>
                </li>
            </ul>
            <br />
            <div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance.storeDeclaration') }}">
                    @csrf
                <!-- row -->
                <div class="row">
                <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Perakuan</h4>
                            </div>

                                <div class="card-body">

                                    <div class="row">
                                       <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Perakuan</label>

                                                <p class="mb-3">
                                                    Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. 
                                                    Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
                                                </p>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="confirmation" id="agree" value="1" required {{ isset($subApplication->declaration) && $subApplication->declaration == 1 ? 'checked' : '' }} disabled> 
                                                    <label class="form-check-label" for="agree">Setuju</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="confirmation" id="disagree" value="0" required {{ isset($subApplication->declaration) && $subApplication->declaration == 0 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="disagree">Tidak Setuju</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                   

                                    
                                      <!-- button action -->
                                    <div class="card-body">
                                        <div class="row">
                                            <br />
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistence-allowance-renewal.showformdoc', $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <!-- <button type="submit" class="btn btn-primary btn-sm" name="action" value="save" onclick="return confirm($('<span>Simpan Permohonan ?</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                                </button>
                                                <button type="submit" class="btn btn-success btn-sm" name="action" value="send" onclick="return confirm($('<span>Hantar Permohonan ?</span>').text())">
                                                    <i class="fas fa-arrow-right"></i>  {{ __('app.submit') }}
                                                </button> -->
                                                <!-- <a href="#" class="btn btn-success btn-sm"> <i class="fas fa-arrow-right"></i> {{ __('app.submit') }}</a> -->
                                               
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
