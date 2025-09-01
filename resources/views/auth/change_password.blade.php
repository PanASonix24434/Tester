@extends('layouts.app')
@include('layouts.page_title', ['page_title' => __('module.change_password')])

@section('content')
    @include('layouts.alert')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <div class="col-xxl-8 offset-xxl-4 col-12 text-center">
                                    <img class="profile-user-img img-fluid" src="{{ asset('/images/lock.png') }}" style="width: 200px;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-md-9 col-12">
                            <form method="POST" action="{{ route('profile.password.change.post') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="current_password" class="col-md-4 col-form-label control-label">{{ __('auth.current_password') }}</label>
                                    <div class="col-md-8">
                                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                        @error('current_password')
                                            <span id="current_password_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="new_password" class="col-md-4 col-form-label control-label">{{ __('auth.new_password') }}
                                        
                                    <div class="tooltip-container" style="position: relative; display: inline-block;">
                                    <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                            title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    </div>
                                    
                                    </label>
                                    <div class="col-md-8">
                                        <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                                        @error('new_password')
                                            <span id="new_password_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label control-label">{{ __('auth.confirm_new_password') }}
                                        
                                    <div class="tooltip-container" style="position: relative; display: inline-block;">
                                    <span class="info-icon" style="color: #3498db; cursor: pointer; font-size: 20px;" 
                                            title="Kata Laluan: Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    </div>

                                    </label>
                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" required>
                                        @error('new_password_confirmation')
                                            <span id="new_password_confirm_error" class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-lock"></i> {{ __('auth.change_password') }}
                                        </button>
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
            $('#current_password').focus(function () {
                $('#current_password_error').addClass('hidden');
            });
            $('#new_password').focus(function () {
                $('#new_password_error').addClass('hidden');
            });
            $('#password-confirm').focus(function () {
                $('#password_confirm_error').addClass('hidden');
            });
        });
    </script>
@endpush