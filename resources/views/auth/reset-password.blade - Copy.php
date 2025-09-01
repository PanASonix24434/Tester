@extends('auth.app')
@section('page_title', __('auth.reset_password'))

@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">{{ __('auth.reset_password') }}</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="input-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autocomplete="email" placeholder="{{ __('auth.email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
        <span id="email_error" class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="input-group mt-3">
                <input id="icno" type="text" class="form-control @error('icno') is-invalid @enderror" name="icno" value="{{ old('icno', $request->icno) }}" required autocomplete="icno" placeholder="{{ __('auth.ic_number_passport') }}">
                <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
                </div>
            </div>
            @error('icno')
            <span id="icno_error" class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


        <div class="input-group mt-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('auth.password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
        <span id="password_error" class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="input-group mt-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('auth.confirm_password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('auth.reset_password') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#email').focus(function () {
            $('#email_error').addClass('hidden');
        });
        $('#password').focus(function () {
            $('#password_error').addClass('hidden');
        });
        $('#icno').focus(function () {
            $('#icno_error').addClass('hidden');
        });
    });
</script>
@endpush

