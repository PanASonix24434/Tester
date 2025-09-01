@extends('layouts.app')

@section('content')
    @include('layouts.loader')
    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Caches</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-all"><i class="fas fa-sync"></i> {{ __('app.clear_all') }}</a>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">

                                <form id="cache-clear-all" method="POST" action="{{ route('administration.caches.clear.all') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear" method="POST" action="{{ route('administration.caches.clear') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear-config" method="POST" action="{{ route('administration.caches.clear.config') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear-event" method="POST" action="{{ route('administration.caches.clear.event') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear-bootstrap" method="POST" action="{{ route('administration.caches.clear.bootstrap') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear-route" method="POST" action="{{ route('administration.caches.clear.route') }}">
                                    @csrf
                                </form>
                                <form id="cache-clear-view" method="POST" action="{{ route('administration.caches.clear.view') }}">
                                    @csrf
                                </form>
                                <br/>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">

                                        <tbody>
                                            <tr>
                                                <td>
                                                    Cache
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cache Config
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-config">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cache Event
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-event">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cache Bootstrap
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-bootstrap">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cache Route
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-route">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cache View
                                                    <span class="float-right">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="submit(this);" data-id="cache-clear-view">{{ __('app.clear') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        function submit(element) {
            var form_id = element.getAttribute('data-id');
            document.getElementById('loading-div').classList.remove('hidden');
            document.getElementById(form_id).submit();
        }
    </script>
@endpush
