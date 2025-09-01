@extends('layouts.app')

@push('styles')
@endpush

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
                        <h3 class="mb-0">Kemaskini Data Utama</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('master-data.index', $slug) }}">Data Utama</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Kemaskini Data Utama</li>
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
                        <form id="form-master-data-update" method="POST" action="{{ route('master-data.update', ['slug' => $slug, 'id' => $code_master->id]) }}">
                            @method('PUT')
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">

                                <!-- Name -->
								<div class="mb-3">
									<label for="name" class="form-label">Nama Data Utama : <span style="color:red;">*</span></label>
									<input type="text" id="name" name="name" value="{{ $code_master->name_ms }}" class="form-control" required="" />
								</div>

                                <!-- Status Aktif -->
                                <div class="mb-3">
                                    <label for="active" class="form-check-label">
                                        <b>Aktif : <span style="color:red;">*</span></b>
                                    </label>
                                    <input style="margin-left:20px;" id="active" name="active" value="true"{{ $code_master->is_active ? ' checked' : '' }} class="form-check-input" type="checkbox">                                   
                                </div>

                          </div>
                        </div>
                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('master-data.index', $slug) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <!--<a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-master-data-update').submit();"><i class="fas fa-save"></i> Simpan</a>-->
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

    //Display success message
    var msgSuccess = '{{Session::get('cm_success')}}';
    var existSuccess = '{{Session::has('cm_success')}}';
    if(existSuccess){
        alert(msgSuccess);
    }

    //Display failed message
    var msgFailed = '{{Session::get('cm_failed')}}';
    var existFailed = '{{Session::has('cm_failed')}}';
    if(existFailed){
        alert(msgFailed);
    }

</script>
@endpush
