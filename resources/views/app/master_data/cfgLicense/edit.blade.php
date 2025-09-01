@extends('layouts.app')

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Kemaskini Konfigurasi Lesen</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('master-data.licenses.index') }}">Data Utama</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Data Utama</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10">
                        <form id="form-duration-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.licenses.update', $license->id) }}" autocomplete="off">
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">

                                <!-- Parameter Lesen -->
								<div class="mb-3">
									<label for="txtParameter" class="form-label">Parameter Lesen : </label>
									<input type="text" id="txtParameter" name="txtParameter" class="form-control" value="{{ $license->license_parameter }}" readonly />
								</div>

                                <!-- Penerangan -->
								<div class="mb-3">
									<label for="txtDesc" class="form-label">Penerangan : </label>
									<input type="text" id="txtDesc" name="txtDesc" class="form-control" value="{{ $license->desc }}" readonly />
								</div>

                                <!-- Tempoh Lesen -->
								<div class="mb-3">
									<label for="txtDuration" class="form-label">Tempoh Keaktifan Lesen (Tahun) : </label>
									<input type="number" min="0" max="100" step="1" id="txtDuration" name="txtDuration" class="form-control" value="{{ $license->license_duration }}" readonly />
								</div>

                                <!-- Amaun Lesen -->
								<div class="mb-3">
									<label for="txtAmount" class="form-label">Amaun Lesen (RM) : </label>
									<input type="number" min="0" max="10000" step="10" id="txtAmount" name="txtAmount" class="form-control" value="{{ $license->license_amount }}" readonly />
								</div>

                                <!-- Tarikh Kuat Kuasa -->
                                <div class="mb-3">
                                    <label for="txtStartDate" class="form-label">Tarikh Kuat Kuasa : <span style="color:red;">*</span></label>
                                    <input type="date" id="txtStartDate" name="txtStartDate" class="form-control" value="{{ $license->start_date }}" readonly />
                                </div>

                                <!-- Status Aktif -->
                                <div class="mb-3">
                                    <label for="active" class="form-check-label">
                                        <b>Status : <span style="color:red;">*</span></b>
                                    </label>
                                    <select class="form-control select2" id="status" name="status" required autocomplete="off">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @if ($license->is_active == true || $license->is_active == '1')
                                            <option value="1" selected>AKTIF</option>
                                            <option value="0">TIDAK AKTIF</option>
                                        @else
                                            <option value="1">AKTIF</option>
                                            <option value="0" selected>TIDAK AKTIF</option>
                                        @endif                                        
                                    </select>                                 
                                </div>

                          </div>
                        </div>

                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('master-data.licenses.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <!--<a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-duration-add').submit();"><i class="fas fa-save"></i> Simpan</a>-->
                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Data Utama ?</span>').text())">
                                <i class="fas fa-save"></i> Simpan
                            </button><br/>
                        </div><br/>

                        </form>

                        

                      </div>
                    </div>
                </div>
                
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

    $(document).ready(function(){
			
        function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
	});

</script>
@endpush
