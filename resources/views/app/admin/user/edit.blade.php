@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/MagnificPopup/magnific-popup.css') }}">
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
                        <h3 class="mb-0">Kemaskini Pengguna</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('administration.users.index') }}">Pengguna</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Kemaskini Pengguna</li>
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
                        <form id="form-user-update" method="POST" action="{{ route('administration.users.update', $user) }}">
                            @method('PUT')
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">
                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="user-tab" data-bs-toggle="tab" href="#user" role="tab"
                                  aria-controls="user" aria-selected="true">Pengguna</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="access-tab" data-bs-toggle="tab" href="#access" role="tab"
                                  aria-controls="access" aria-selected="false">Peranan</a>
                              </li>
                            </ul>
                            <div class="tab-content p-4" id="myTabContent">
                              <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
                                
                                <div class="row">
                                    <div class="col-6">
                                        <!-- User FullName -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Penuh : <span style="color:red;">*</span></label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required />
                                        </div>
                                        <!-- Mobile No -->
                                        <div class="mb-3">
                                            <label for="txtMobileNo" class="form-label">No. Telefon Bimbit : <span style="color:red;">*</span></label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtMobileNo" name="txtMobileNo" value="{{ str_replace('+60', '', $user->contact_number) }}"
                                                aria-describedby="inputGroupPrepend" required>
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Emel : <span style="color:red;">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- ICNo -->
                                        <!--<div class="mb-3">
                                            <label for="identification_card_number" class="form-label">No. Kad Pengenalan : <span style="color:red;">*</span></label>
                                            <input type="number" id="identification_card_number" name="identification_card_number" value="{{ $user->username }}" class="form-control" required/>
                                        </div>-->
                                        <div class="mb-3">
                                            <label for="username" class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
                                            <input type="number" id="username" class="form-control" name="identification_card_number" value="{{ $user->username }}" required="" maxlength="12" minlength="12" />
                                        </div>
                                        @error('identification_card_number')
                                            <span id="identification_card_number_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <!-- Office Phone No -->
                                        <div class="mb-3">
                                            <label for="txtOfficePhoneNo" class="form-label">No. Telefon Pejabat : </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtOfficePhoneNo" name="txtOfficePhoneNo" value="{{ $user->contact_number }}"
                                                aria-describedby="inputGroupPrepend">
                                            </div>
                                        </div>
                                        <!-- Tarikh Lapor Diri -->
                                        <div class="mb-3">
                                            <label for="txtStartDate" class="form-label">Tarikh Lapor Diri : <span style="color:red;">*</span></label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" class="form-control" value="{{ $user->start_date }}" required />
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Entity -->
								<div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : </label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @foreach($entities as $entity)
                                            @if (isset($user->entity) && $user->entity->id == $entity->id)
                                            <option value="{{$entity->id}}" selected>{{$entity->entity_name}}</option>
                                            @else
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                            @endif
                                            
                                        @endforeach	
                                    </select>
								</div>

                                <!-- Password & Confirmation -->
                                <div class="row">
                                    <div class="col-6">
                                        <!-- Password -->
                                        <div class="mb-3" style="margin-top:10px;">
                                            <label for="password" class="form-label">Kata Laluan : 
                                                <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                                title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                </i>
                                            </label>
                                        </div>
                                        <div class="input-group mt-3" >
                                            <input style="margin-top:-10px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="">
                                            <div class="input-group-append" style="margin-top:-10px;">                           
                                                <div class="input-group-text">
                                                    <i  class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password')
                                        <span id="password_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <!-- Password Confirmation -->
                                        <div class="mb-3" style="margin-top:10px;">
                                            <label for="password" class="form-label">Pengesahan Kata Laluan : 
                                                <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                                title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                </i>
                                            </label>
                                        </div>
                                        <div class="input-group mt-3" >
                                            <input style="margin-top:-10px;" id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="current-password" placeholder="">
                                            <div class="input-group-append" style="margin-top:-10px;">                           
                                                <div class="input-group-text">
                                                    <i  class="far fa-eye" id="togglePassword1" style="cursor: pointer;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password_confirmation')
                                        <span id="password_confirmation_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <div class="form-group row">
                                            <label for="verified" class="col-md-4 col-form-label control-label"><span class="hidden-sm hidden-xs">Verifikasi Emel</span> : </label>
                                            <div class="col-md-8">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="verified" type="checkbox" class="custom-control-input" name="verified" value="true"{{ !empty($user->email_verified_at) ? ' checked' : '' }}{{ $user->is_admin ? ' disabled' : '' }}>
                                                    <label for="verified" class="custom-control-label"><span class="hidden-lg hidden-md">{{ __('app.verified') }}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="active" class="col-md-4 col-form-label control-label"><span class="hidden-sm hidden-xs">Status Keaktifan</span> : </label>
                                            <div class="col-md-8">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="active" type="checkbox" class="custom-control-input" name="active" value="true"{{ $user->is_active ? ' checked' : '' }}{{ $user->is_admin ? ' disabled' : '' }}>
                                                    <label for="active" class="custom-control-label"><span class="hidden-lg hidden-md">{{ __('app.active') }}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                              </div>
                              <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">

                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="{{ $role->id }}" name="roles_id[]" value="{{ $role->id }}" {{ $user->hasRole($role->name) ? ' checked' : '' }} >
                                        <label for="{{ $role->id }}" class="form-check-label">
                                        <b>{{ $role->name }}</b>
                                        </label>
                                    </div>
                                @endforeach

                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('administration.users.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <!--<a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-user-update').submit();"><i class="fas fa-save"></i> Simpan</a>-->
                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Pengguna ?</span>').text())">
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
<script src="{{ asset('plugins/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript">


        $(document).ready(function () {  

            //Nama Penuh
            $('#name').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if ( String.fromCharCode(charCode).match(/[a-zA-Z@' ]/g) ){

                }
                else{
                    return false; 
                }    
                                           
            }); 

            //No Kad Pengenalan - Validation
            $('#username').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 12)    
                    return false;                        
            }); 

            //No Telefon Bimbit - Validation
            $('#txtMobileNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            //No Telefon Pejabat - Validation
            $('#txtOfficePhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

        });

        const inputName = document.getElementById("name");

        inputName.addEventListener("keyup", function(event) {
            event.preventDefault();
            inputName.value = inputName.value.toUpperCase();
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
        alert(msg);
        }

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
        alert(msg2);
        }

        //Password
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

        //Confirm Password
        const togglePassword1 = document.querySelector('#togglePassword1');
        const password_confirmation = document.querySelector('#password_confirmation');

        togglePassword1.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        password_confirmation.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
        });

    </script>
@endpush
