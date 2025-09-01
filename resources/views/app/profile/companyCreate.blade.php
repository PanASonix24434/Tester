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
              <h1 class="m-0">{{ __('app.company_profile') }}</h1>
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
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Profil Syarikat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-alp-tab" data-toggle="pill" href="#custom-tabs-one-alp" role="tab" aria-controls="custom-tabs-one-alp" aria-selected="false">Maklumat ALP</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-account-tab" data-toggle="pill" href="#custom-tabs-one-account" role="tab" aria-controls="custom-tabs-one-account" aria-selected="false">Maklumat Penyata Akaun</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-asset-tab" data-toggle="pill" href="#custom-tabs-one-asset" role="tab" aria-controls="custom-tabs-one-asset" aria-selected="false">Maklumat Aset</a>
                      </li>
                    </ul>
                </div>
          
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                            <form method="POST" action="{{ route('profile.profileCompanyStore') }}">
                            @csrf
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-12 col-sm-6">
                                    
                                    <div class="form-group">
                                        <label for="txtCompanyName">{{ __('app.company_name') }} : </label>
                                        <input type="text" class="form-control" name="txtCompanyName" id="txtCompanyName" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtCompanyRegNo">{{ __('app.company_reg_no') }} : </label>
                                        <input type="text" class="form-control" name="txtCompanyRegNo" id="txtCompanyRegNo" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtCompanyRegDate">{{ __('app.company_reg_date') }} : </label>
                                        <input type="date" class="form-control" name="txtCompanyRegDate" id="txtCompanyRegDate" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtLhdnAccountNo">{{ __('app.lhdn_account_no') }} : </label>
                                        <input type="text" class="form-control" name="txtLhdnAccountNo" id="txtLhdnAccountNo" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPhoneNo">No. Telefon : </label>
                                        <input type="text" class="form-control" name="txtPhoneNo" id="txtPhoneNo" value="" required>
                                    </div>
                                    <br/>
                                    <div class="form-group" style="margin-top:15px;">
                                        <label for="txtFaxNo">No. Faks : </label>
                                        <input type="text" class="form-control" name="txtFaxNo" id="txtFaxNo" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtEmail">{{ __('app.email') }} : </label>
                                        <input type="email" class="form-control" name="txtEmail" id="txtEmail" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtSecretary">{{ __('app.company_secretary') }} : </label>
                                        <input type="text" class="form-control" name="txtSecretary" id="txtSecretary" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtOwnership">{{ __('app.ownership') }} : </label>
                                        <input type="text" class="form-control" name="txtOwnership" id="txtOwnership" value="">
                                    </div>
                        
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label for="bumiputera" style="margin-right: 55px;">{{ __('app.bumiputera') }} : <span style="color: red;">*</span></label>
                                        <div style="display: inline-block; padding-left: 50px;">
                                            
                                            <input class="form-check-input" type="radio" name="bumiputera" id="radio-yes" value="1" style="margin-right: 5px;">
                                            <label for="radio-yes" style="margin-right: 30px;">{{ __('app.yes') }}</label>
        
                                            <input class="form-check-input" type="radio" name="bumiputera" id="radio-no" value="2" style="margin-right: 5px;">
                                            <label for="radio-no">{{ __('app.no') }}</label>
    
                                        </div>
                                    </div>                                    
                                </div>
                        
                                <!-- Second Column -->
                                <div class="col-12 col-sm-6">
                                    
                                    <!-- Alamat Semasa -->
                                    <div class="form-group">
                                        <label for="alamat">Alamat Semasa : </label>
                                        <input type="text" class="form-control" name="txtCurrentAddress1" id="txtCurrentAddress1" value="" required>
                                        <input type="text" class="form-control" name="txtCurrentAddress2" id="txtCurrentAddress2" value="">
                                        <input type="text" class="form-control" name="txtCurrentAddress3" id="txtCurrentAddress3" value="">
                                    </div><br/>                        
                                    <div class="form-group" style="margin-top:-8px;">
                                        <label for="txtCurrentPostcode">Poskod : </label>
                                        <input type="number" class="form-control" name="txtCurrentPostcode" id="txtCurrentPostcode" value="" required min="1" max="99999">
                                    </div>                        
                                    <div class="form-group">
                                        <label for="txtCurrentCity">Bandar : </label>
                                        <input type="text" class="form-control" name="txtCurrentCity" id="txtCurrentCity" value="" required>
                                    </div>                        
                                    <div class="form-group">
                                        <label for="selCurrentState">Negeri : </label>
                                        <select id="selCurrentState" class="form-control select2" name="selCurrentState" required>
                                            
                                            <option value="">{{ __('app.please_select')}}</option>
                                            @foreach($states as $st)       
                                                <option value="{{$st->id}}">{{ (App::getLocale() == 'en') ? strtoupper($st->name) : strtoupper($st->name_ms) }}</option>       
                                            @endforeach
        
                                        </select>
                                    </div>

                                    <!-- Alamat Surat Menyurat -->
                                    <div class="form-group">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="chkAddress">
                                          <label class="form-check-label" style="color:red;"><b>Alamat Surat Menyurat Sama Seperti Alamat Semasa ?</b></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamatSurat">Alamat Surat Menyurat : </label>                 
                                        <input type="text" class="form-control" name="txtLetterAddress1" id="txtLetterAddress1" value="" required>
                                        <input type="text" class="form-control" name="txtLetterAddress2" id="txtLetterAddress2" value="">
                                        <input type="text" class="form-control" name="txtLetterAddress3" id="txtLetterAddress3" value="">
                                    </div>
                                                            
                                    <div class="form-group" style="margin-top:30px;">
                                        <label for="txtLetterPostcode">Poskod : </label>
                                        <input type="number" class="form-control" name="txtLetterPostcode" id="txtLetterPostcode" value="" required min="1" max="99999">
                                    </div>                        
                                    <div class="form-group">
                                        <label for="txtLetterCity">Bandar : </label>
                                        <input type="text" class="form-control" name="txtLetterCity" id="txtLetterCity" value="" required>
                                    </div>                        
                                    <div class="form-group">
                                        <label for="selLetterState">Negeri : </label>
                                        <select id="selLetterState" class="form-control select2" name="selLetterState" required>
                                            
                                            <option value="">{{ __('app.please_select')}}</option>
                                            @foreach($states as $st)       
                                                <option value="{{$st->id}}">{{ (App::getLocale() == 'en') ? strtoupper($st->name) : strtoupper($st->name_ms) }}</option>       
                                            @endforeach
        
                                        </select>
                                    </div>                   
                                </div>

                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label for="txtModalAllow">{{ __('app.modal_allow') }} : </label>
                                        <input type="number" class="form-control" name="txtModalAllow" id="txtModalAllow"  step='0.01' value='0.00'>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label for="txtModalPaid">{{ __('app.modal_paid') }} : </label>
                                        <input type="number" class="form-control" name="txtModalPaid" id="txtModalPaid"  step='0.01' value='0.00'>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCompanyBusiness">{{ __('app.company_business') }} : </label>
                                        <input type="text" class="form-control" name="txtCompanyBusiness" id="txtCompanyBusiness" value="">
                                    </div> 
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCompanyExpFish">{{ __('app.company_exp_fish') }} : </label>
                                        <textarea class="form-control" name="txtCompanyExpFish" id="txtCompanyExpFish" rows="7"></textarea>
                                    </div> 
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCompanyExpOther">{{ __('app.company_exp_other') }} : </label>
                                        <textarea class="form-control" name="txtCompanyExpOther" id="txtCompanyExpOther" rows="7"></textarea>
                                    </div> 
                                </div>

                            </div>
                            
                            <!-- End of row -->
                            <div class="form-group">
                                <div class="profile-info w-100" style="margin-bottom: -30px;">
                                    <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                                        <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                                            <div style="display: flex; gap: 10px;">
                                                <a href="{{ route('profile.user') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
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
    <script type="text/javascript">
		
        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    </script>
@endpush