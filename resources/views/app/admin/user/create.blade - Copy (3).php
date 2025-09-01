@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/jstree/dist/themes/default/style.min.css') }}">
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
                        <h3 class="mb-0">Tambah Pengguna</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('administration.users.index') }}">Pengguna</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
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
                        <form id="form-user-create" method="POST" action="{{ route('administration.users.store') }}">
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
                                            <input type="text" id="name" name="name" class="form-control" style="text-transform: uppercase" required />
                                        </div>
                                        @error('name')
                                            <span id="name_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <!-- Mobile No -->
                                        <div class="mb-3">
                                            <label for="txtMobileNo" class="form-label">No. Telefon Bimbit : <span style="color:red;">*</span></label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                <input type="number" class="form-control" id="txtMobileNo" name="txtMobileNo"
                                                aria-describedby="inputGroupPrepend" required>
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Emel : <span style="color:red;">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control" required />
                                        </div>
                                        @error('email')
                                            <span id="email_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <!-- ICNo -->
                                        <div class="mb-3">
                                            <label for="identification_card_number" class="form-label">No. Kad Pengenalan : <span style="color:red;">*</span></label>
                                            <input type="number" id="identification_card_number" name="identification_card_number" class="form-control" required/>
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
                                                <input type="number" class="form-control" id="txtOfficePhoneNo" name="txtOfficePhoneNo"
                                                aria-describedby="inputGroupPrepend">
                                            </div>
                                        </div>
                                        <!-- Tarikh Lapor Diri -->
                                        <div class="mb-3">
                                            <label for="txtStartDate" class="form-label">Tarikh Lapor Diri : <span style="color:red;">*</span></label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" class="form-control" required />
                                        </div>
                                        @error('reg_date')
                                            <span id="reg_date" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Entity -->
								<div class="mb-3">
                                    <label class="form-label" for="selectOne">Pejabat Bertugas : <span style="color:red;">*</span></label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @foreach($entities as $entity)
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                        @endforeach	
                                    </select>
								</div>

                                <!-- Password & Confirmation -->
                                <!--<div class="row">
                                    <div class="col-6">

                                        <div class="mb-3" style="margin-top:10px;">
                                            <label for="password" class="form-label">Kata Laluan : 
                                                <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                                title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                </i> <span style="color:red;">*</span>
                                            </label>
                                        </div>
                                        <div class="input-group mt-3" >
                                            <input style="margin-top:-10px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="">
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

                                        <div class="mb-3" style="margin-top:10px;">
                                            <label for="password-confirm" class="form-label">Pengesahan Kata Laluan : 
                                                <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                                title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                </i> <span style="color:red;">*</span>
                                            </label>
                                        </div>
                                        <div class="input-group mt-3" >
                                            <input style="margin-top:-10px;" id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password" placeholder="">
                                            <div class="input-group-append" style="margin-top:-10px;">                           
                                                <div class="input-group-text">
                                                    <i  class="far fa-eye" id="togglePasswordConfirm" style="cursor: pointer;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password_confirmation')
                                            <span id="password_confirm_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>-->

                              </div>
                              <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
                                
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input id="{{ $role->id }}" name="roles_id[]" value="{{ $role->id }}" class="form-check-input" type="checkbox">
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
                            <!--<a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-user-create').submit();"><i class="fas fa-save"></i> Simpan</a>-->
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
    <script type="text/javascript">

        /*$(document).ready(function () {  
            $('#identification_card_number').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)){    
                    return false;
                } 
            }          
        });*/ 

        /*$(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });*/

        //Password
        /*const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

        //Confirm Password
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirm = document.querySelector('#password-confirm');

        togglePasswordConfirm.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });*/

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

    </script>
@endpush
