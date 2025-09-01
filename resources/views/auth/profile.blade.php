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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools text-sm">
                        <a href="{{ route('profile.password.change') }}">{{ __('module.change_password') }} &nbsp;<i class="nav-icon fas fa-external-link-alt"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-3 col-12">
                            <form id="form-profile-picture-upload" method="POST" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-xxl-8 offset-xxl-4 col-12 text-center">
                                        @if (empty(Auth::user()->profile_picture))
                                            <img class="profile-user-img img-fluid" src="{{ asset('/images/avatar.png') }}" />
                                        @else
                                            <a href="{{ asset('/storage/profile-picture/.original/'.Auth::user()->profile_picture) }}" class="profile-picture">
                                                <img class="profile-user-img img-fluid" src="{{ asset('/storage/profile-picture/'.Auth::user()->profile_picture) }}" />
                                            </a>
                                            <div id="profile-picture-btn-rotate" class="top-left">
                                                <a href="javascript:void(0);" onclick="event.preventDefault(); processAvatar(); document.getElementById('form-profile-picture-rotate').submit();">
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x"></i>
                                                        <i class="fas fa-redo fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="profile-picture-btn-delete" class="top-right">
                                                <a href="javascript:void(0);" class="text-danger" onclick="if (confirm($('<span>{{ __('auth.are_you_sure_to_delete_profile_picture') }}</span>').text())) document.getElementById('form-profile-picture-delete').submit();">
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x"></i>
                                                        <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        @endif
                                        <div id="process-img" class="processing hidden">
                                            <h3>
                                                <span class="badge badge-light badge-outline">
                                                    <i class="fas fa-spinner fa-spin bigger-120"></i> 
                                                    {{ __('app.processing') }}...
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div id="profile-picture-input" class="form-group row">
                                    <div class="col-xxl-8 offset-xxl-4 col-12">
                                        <div class="custom-file">
                                            <input id="profile-picture" type="file" class="custom-file-input" name="profile-picture">
                                            <label for="profile-picture" class="custom-file-label">{{ empty(Auth::user()->profile_picture) ? __('app.upload_photo') : __('app.upload_new_photo') }}</label>
                                        </div>
                                        @error('profile-picture')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                            <form id="form-profile-picture-rotate" class="hidden" method="POST" action="{{ route('profile.picture.rotate') }}">
                                @csrf
                            </form>
                            @if (strcmp(Auth::user()->profile_picture, 'avatar.png') !== 0)
                                <form id="form-profile-picture-delete" class="hidden" method="POST" action="{{ route('profile.picture.delete') }}">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endif
                        </div>
                        <div class="col-xxl-8 col-md-9 col-12">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label control-label">{{ __('app.name') }}</label>
                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" {{ Auth::user()->is_admin ? 'readonly' : 'required' }} autocomplete="off">
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label control-label">{{ __('app.email') }}</label>
                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="off">
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="identification_card_number" class="col-md-4 col-form-label control-label">{{ __('app.ic_number') }}</label>
                                    <div class="col-md-8">
                                        <input id="identification_card_number" type="text" class="form-control @error('identification_card_number') is-invalid @enderror" name="identification_card_number" value="{{ Auth::user()->username }}" {{ Auth::user()->is_admin ? 'readonly' : 'required' }} autocomplete="off">
                                        @error('identification_card_number')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm($('<span>{{ __('auth.update_profile') }}</span>').text())">
                                            <i class="fas fa-save"></i> {{ __('app.update') }}
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
    <script src="{{ asset('plugins/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $('.profile-picture').magnificPopup({
                type: 'image',
                mainClass: 'mfp-with-zoom', // this class is for CSS animation below
        
                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it
        
                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function
        
                    // The "opener" function should return the element from which popup will be zoomed in
                    // and to which popup will be scaled down
                    // By defailt it looks for an image tag:
                    opener: function(openerElement) {
                        // openerElement is the element on which popup was initialized, in this case its <a> tag
                        // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }
            });
        });

        document.getElementById("profile-picture").onchange = function () {
            document.getElementById("form-profile-picture-upload").submit();
            $("#process-img").removeClass('hidden');
            $("#profile-picture-input").addClass('hidden');
            $("#profile-picture-btn-rotate").addClass('hidden');
            $("#profile-picture-btn-delete").addClass('hidden');
        };

        function processAvatar() {
            $("#process-img").removeClass('hidden');
            $("#profile-picture-input").addClass('hidden');
            $("#profile-picture-btn-rotate").addClass('hidden');
            $("#profile-picture-btn-delete").addClass('hidden');
        }
		
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