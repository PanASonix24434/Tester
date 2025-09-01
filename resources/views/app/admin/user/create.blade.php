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
                                        <div class="mb-3">
                                            <span id="txtMobileNo_desc" class="text-danger" role="alert">
                                                <strong>Contoh : 126557349</strong>
                                            </span>
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
                                        <!--<div class="mb-3">
                                            <label for="identification_card_number" class="form-label">No. Kad Pengenalan : <span style="color:red;">*</span></label>
                                            <input type="number" id="identification_card_number" name="identification_card_number" class="form-control" maxlength="12" minlength="12" required/>
                                        </div>-->
                                        <div class="mb-3">
                                            <label for="username" class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : <span style="color:red;">*</span></label>
                                            <input type="number" id="username" class="form-control" name="username" required="" maxlength="12" minlength="12" />
                                        </div>
                                        @error('username')
                                            <span id="username_error" class="text-danger" role="alert">
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
                                        <div class="mb-3" style="margin-top:45px;">
                                            <label for="txtStartDate" class="form-label">Tarikh Lapor Diri : <span style="color:red;">*</span></label>
                                            <input type="date" id="txtStartDate" name="txtStartDate" class="form-control" required />
                                        </div>
                                        @error('txtStartDate')
                                            <span id="txtStartDate_error" class="text-danger" role="alert">
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

                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                    <a href="{{ route('administration.users.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Pengguna ?</span>').text())">
                                        <i class="fas fa-save"></i> Simpan
                                    </button><br/>
                                </div><br/>

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
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function () {  

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

    </script>
@endpush
