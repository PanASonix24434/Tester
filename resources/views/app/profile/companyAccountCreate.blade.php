@extends('layouts.app')
@include('layouts.page_title', ['page_title' => __('module.profile')])

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/MagnificPopup/magnific-popup.css') }}">
    <style type="text/css">
        .processing {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .top-left {
            position: absolute;
            top: -14px;
            left: -3px;
        }
        .top-right {
            position: absolute;
            top: -14px;
            right: -3px;
        }
    </style>
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header" style="margin-top:-20px;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Tambah Maklumat Penyata Akaun</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row">
        
        <div class="col-lg-12">
            
            <div class="card card-primary" style="outline: 2px solid lightgray;">

                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-home-tab" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Profil Syarikat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-alp-tab" href="{{ route('profile.profileCompanyAlpList', $company_profile_id) }}" role="tab" aria-controls="custom-tabs-one-alp" aria-selected="false">Maklumat ALP</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-account-tab" data-toggle="pill" href="#" role="tab" aria-controls="custom-tabs-one-account" aria-selected="true">Maklumat Penyata Akaun</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-asset-tab" href="{{ route('profile.profileCompanyAssetList', $company_profile_id) }}" role="tab" aria-controls="custom-tabs-one-asset" aria-selected="false">Maklumat Aset</a>
                      </li>
                    </ul>
                </div>
          
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-account" role="tabpanel" aria-labelledby="custom-tabs-one-account-tab">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('profile.profileCompanyAccountStore') }}">
                            @csrf
                            <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
	                        <input type="hidden" id="hide_appid" name="hide_appid" value="{{ $company_profile_id }}">
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="selAccountYear">Tahun Penyata Akaun : </label>
                                        <select id="selAccountYear" name="selAccountYear" class="form-control select2" required>                                                          
                                            <option value="2024">2024</option>
                                            <option value="2024">2023</option>
                                            <option value="2022">2022</option>        
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtTitle">Penerangan : </label>
                                        <input type="text" class="form-control" name="txtTitle" id="txtTitle" value="" required>
                                    </div>
                                </div>

                                <!-- Second Column -->
                                <div class="col-12 col-sm-6">                                    
                                    <!--<div class="form-group">
                                        <label for='path'>Fail Penyata Akaun : </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="path" name="path" required>
                                            <label class="custom-file-label" for="path"></label>													
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="path">Fail Penyata Akaun : <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc" required>
                                            <label class="custom-file-label" for="fileDoc">Choose file</label>
                                          </div>
                                        </div>
                                      </div>
                                    <!--<div class="form-group">
                                        <label for="path">Fail Penyata Akaun : <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file" style="margin-top:33px;">
                                                <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc" required>
                                                <label class="custom-file-label" for="fileDoc">Choose file</label>
                                            </div>							  
                                        </div>
                                    </div>-->
                                </div>
                    
                            </div>
                            
                            <!-- End of row -->
                            <div class="form-group">
                                <div class="profile-info w-100" style="margin-bottom: -30px;">
                                    <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                        <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                            <div style="display: flex; gap: 10px;">
                                                <a href="{{ route('profile.profileCompanyAccountList', $company_profile_id) }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                                                <button type="submit" class="btn btn-primary" onclick="return confirm($('<span>{{ __('auth.update_profile') }}</span>').text())">
                                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                                </button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>         
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('plugins/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
		
        bsCustomFileInput.init(); 

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    </script>
@endpush