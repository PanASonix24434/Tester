@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">
                        <a href="{{ route('administration.users.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-user-create').submit();"><i class="fas fa-save"></i><span class="hidden-xs">  {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="detail-tab" data-toggle="pill" href="#detail-tab-content" role="tab" aria-controls="detail-tab-content" aria-selected="true">{{ __('app.detail') }}</a>
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
                                        <div class="form-group row">
                                            <label for="name" class="col-md-3 col-form-label control-label">{{ __('app.name') }}</label>
                                            <div class="col-md-7">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required{{ $errors->has('name') ? '' : ' autofocus' }} autocomplete="off">
                                                @error('name')
                                                    <span id="name_error" class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-md-3 col-form-label control-label">{{ __('app.email') }}</label>
                                            <div class="col-md-7">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="off">
                                                @error('email')
                                                    <span id="email_error" class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="identification_card_number" class="col-md-3 col-form-label control-label">{{ __('app.ic_number') }}</label>
                                            <div class="col-md-7">
                                                <input id="identification_card_number" type="text" class="form-control @error('identification_card_number') is-invalid @enderror" name="identification_card_number" value="{{ old('identification_card_number') }}" required autocomplete="off">
                                                @error('identification_card_number')
                                                    <span id="identification_card_number_error" class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-md-3 col-form-label control-label">{{ __('auth.password') }}
                                                <div class="tooltip-container" style="position: relative; display: inline-block;">
                                                    <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                                     title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                     <i class="fas fa-info-circle"></i>
                                                    </span>
                                                </div>
                                            </label>
                                            <div class="col-md-7">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                                @error('password')
                                                    <span id="password_error" class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-3 col-form-label control-label">{{ __('auth.confirm_password') }}
                                                <div class="tooltip-container" style="position: relative; display: inline-block;">
                                                    <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                                     title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                                     <i class="fas fa-info-circle"></i>
                                                    </span>
                                                </div>
                                            </label>
                                            <div class="col-md-7">
                                                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                                                @error('password_confirmation')
                                                    <span id="password_confirm_error" class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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
    </script>   
@endpush