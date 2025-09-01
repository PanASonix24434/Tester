@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">
                        <a href="{{ route('administration.users.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-user-create').submit();"><i class="fas fa-save"></i><span class="hidden-xs">  {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="detail-tab" data-toggle="pill" href="#detail-tab-content" role="tab" aria-controls="detail-tab-content" aria-selected="true">Pengguna</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="roles-tab" data-toggle="pill" href="#roles-tab-content" role="tab" aria-controls="roles-tab-content" aria-selected="false">{{ __('app.roles') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form id="form-user-create" method="POST" action="{{ route('administration.users.store') }}">
                                @csrf
                                <div class="tab-content" id="custom-tabContent">
                                    <div class="tab-pane fade show active" id="detail-tab-content" role="tabpanel" aria-labelledby="detail-tab">
                                        
                                        <div class="row">
                                            <!-- First Column -->
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="txtName">Nama Penuh : </label>
                                                    <input type="text" class="form-control" name="txtName" id="txtName" value="" required>
                                                </div>
                                                <div class="form-group" style="margin-top:30px;">
                                                    <label for="txtICNo">No. Kad Pengenalan : </label>
                                                    <input type="text" class="form-control" name="txtICNo" id="txtICNo" value="" required>
                                                </div>
                                                <div class="form-group" style="margin-top:32px;">
                                                    <label for="txtEmail">Emel : </label>
                                                    <input type="email" class="form-control" name="txtEmail" id="txtEmail" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtStartDate">Tarikh Lapor Diri : </label>
                                                    <input type="date" class="form-control" name="txtStartDate" id="txtStartDate" value="" required>
                                                </div>
                                            </div>
            
                                            <!-- Second Column -->
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="selEntity">Entiti : </label>
                                                    <select id="selEntity" name="selEntity" class="form-control select2" required>                                                          
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach($entities as $entity)
                                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                                        @endforeach        
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="col-form-label control-label">{{ __('auth.password') }} : 
                                                        <div class="tooltip-container" style="position: relative; display: inline-block;">
                                                            <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                                             title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                             <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </div>
                                                    </label>
                                                    <!--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>-->
                                                    <div class="input-group">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                    @error('password')
                                                        <span id="password_error" class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password-confirm" class="col-form-label control-label">{{ __('auth.confirm_password') }} : 
                                                        <div class="tooltip-container" style="position: relative; display: inline-block;">
                                                            <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                                             title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                             <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </div>
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="far fa-eye" id="togglePasswordConfirm" style="cursor: pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                    
                                            </div>
                                
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="roles-tab-content" role="tabpanel" aria-labelledby="roles-tab">
                                        @foreach ($roles as $role)
                                            <div class="custom-control custom-checkbox">
                                                <input id="{{ $role->id }}" type="checkbox" class="custom-control-input" name="roles_id[]" value="{{ $role->id }}">
                                                <label for="{{ $role->id }}" class="custom-control-label">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
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
    <script type="text/javascript">
        $(document).ready(function () {  
            $('#identification_card_number').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });    
        });

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

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
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirm = document.querySelector('#password-confirm');

        togglePasswordConfirm.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

    </script>   
@endpush