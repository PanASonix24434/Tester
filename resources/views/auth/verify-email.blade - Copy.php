@extends('layouts.app')
@include('layouts.page_title', ['page_title' => __('module.verify_email_address')])

@section('content')
    @include('layouts.alert')
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            <button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
            {{ __('auth.verification_link_sent') }}
        </div>
    @endif
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@yield('page_title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ __('auth.check_email_verification_link') }}<br /><br />
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('auth.resent_verification_email') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
