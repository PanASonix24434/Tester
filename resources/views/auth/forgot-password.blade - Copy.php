@extends('auth.app')
@section('page_title', __('auth.forgot_password'))

@push('styles')
    <style type="text/css">

        /* Tooltip container */
        .tooltip-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
            color: #3498db;
            background-color: #0000;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 12px;
        }

        /* Tooltip text (hidden by default) */
        .tooltip-icon::after {
            content: attr(data-tooltip);
            visibility: hidden;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 8px;
            border-radius: 5px;
            
            /* Position the tooltip */
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Adjust position above icon */
            left: 50%;
            margin-left: -80px; /* Center the tooltip */
            
            /* Tooltip arrow */
            opacity: 0;
            transition: opacity 0.3s;
            width: 160px;
        }

        /* Show tooltip on hover */
        .tooltip-icon:hover::after {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endpush

@section('content')
    {{-- <div class="row pt-5">
        <div class="col-md-4 offset-md-4">
            <div class="card"> --}}
                <div class="card-body login-card-body">
                    <p class="login-box-msg">{{ __('auth.reset_password') }}</p>

                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('auth.email_register') }}">
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

                        
                        <div class="input-group mt-3">
                            <input id="new_email" type="email" class="form-control @error('new_email') is-invalid @enderror" name="new_email" value="{{ old('new_email') }}" placeholder="{{ __('auth.new_email') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('new_email')
                        <span id="email_error" class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <p style="font-size:14px;">Info Emel Baru
                            <span class="tooltip-icon" data-tooltip="Sekiranya ingin kemaskini emel, sila isikan emel baru"><i class="fas fa-info-circle"></i></span>
                        </p>

                        <div class="input-group mt-3">
                            <input id="icno" type="text" class="form-control @error('icno') is-invalid @enderror" name="icno" value="{{ old('icno') }}" required autocomplete="icno" placeholder="{{ __('auth.ic_number_passport') }}">
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

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('auth.send_password_reset_link') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    </p>
                </div>
            {{-- </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#email').focus(function () {
                $('#email_error').addClass('hidden');
            });
        });
    </script>
@endpush
