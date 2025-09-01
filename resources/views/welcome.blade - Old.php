@extends('auth.app')

@section('content')
{{-- <div class="row pt-5">
    <div class="col-md-12">
        <div class="card"> --}}
            <div class="card-body login-card-body">
                <p class="login-box-msg"><b>{{ strtoupper(__('auth.login')) }}</b></p>
                
                @if (session('status'))
                    <div class="alert alert-info" role="alert">
                        <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                        {{ session('status') }}
                    </div>
                @endif
                @error('username')
                    <div id="alert" class="alert alert-danger alert-dismissable" role="alert">
                        <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                        <i class="fas fa-ban"></i> {{ $message }}
                    </div>
                @enderror
                @error('password')
                    <div id="alert" class="alert alert-danger alert-dismissable" role="alert">
                        <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                        <i class="fas fa-ban"></i> {{ $message }}
                    </div>
                @enderror

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username"{{ $errors->has('username') ? '' : ' autofocus' }} placeholder="{{ __('auth.ic_number') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mt-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('auth.password') }}">
                        
                        <div class="input-group-append">                           
                            <div class="input-group-text">
                                <!--<span class="fas fa-lock"></span>-->
                                <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
            			<div class="col-7">
            				<div class="icheck-primary">
            				    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            				    <label class="form-check-label" for="remember">{{ __('auth.remember_me') }}</label>
            				</div>
            			</div>
            			<div class="col-5">
            				<input type="submit" value="{{ __('auth.login') }}" class="btn btn-primary btn-block" />
            			</div>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <p class="mt-3 mb-1">
                            <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                        </p>
                    @endif
                    <p class="mt-1">
                        <a href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    </p>
                </form>
            </div>
        {{-- </div>
    </div>
</div> --}}
@endsection
@push('scripts')
    <script type="text/javascript">

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

    </script>
@endpush