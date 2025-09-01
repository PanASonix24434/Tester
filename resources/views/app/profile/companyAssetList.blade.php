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
    <!-- Content Header (Page header) -->
    <div class="content-header" style="margin-top:-20px;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Maklumat Aset</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row">
        
        <div class="col-lg-12">
            
            <div class="card card-primary" style="outline: 2px solid lightgray;">

                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-home-tab" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Profil Syarikat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-alp-tab" href="{{ route('profile.profileCompanyAlpList', $company_profile_id) }}" role="tab" aria-controls="custom-tabs-one-alp" aria-selected="false">Maklumat ALP</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-account-tab" href="{{ route('profile.profileCompanyAccountList', $company_profile_id) }}" role="tab" aria-controls="custom-tabs-one-account" aria-selected="false">Maklumat Penyata Akaun</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-asset-tab" data-toggle="pill" href="#custom-tabs-one-asset" role="tab" aria-controls="custom-tabs-one-asset" aria-selected="true">Maklumat Aset</a>
                      </li>
                    </ul>
                </div>
          
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-asset" role="tabpanel" aria-labelledby="custom-tabs-one-asset-tab">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">@yield('page_title')</h3>
                                            <div class="card-tools">
                                                <a href="{{ route('profile.profileCompanyAssetCreate', $company_profile_id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped table-sm">
                                                            @if (!$assets->isEmpty())
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:1%;"></th>
                                                                        <th>Nama Aset</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($assets as $a)
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                <a href="{{ route('administration.users.edit', $a->id) }}" class="btn btn-default btn-xs">
                                                                                    <i class="fas fa-search"></i>
                                                                                </a>
                                                                            </td>
                                                                            <td>{{ $a->asset_name }}</td>

                                                                            @if ($a->asset_status == 1)
                                                                                <td>AKTIF</td>
                                                                            @else
                                                                                <td>TIDAK AKTIF</td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            @else
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Aset</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="text-center">
                                                                        <td colspan="2">{{ __('app.no_record_found') }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="table-responsive">
                                                        {!! $assets->appends(\Request::except('page'))->render() !!}
                                                    </div>
                                                </div>
                                                @if (!$assets->isEmpty())
                                                    <div class="col-md-4">
                                                        <span class="float-md-right">
                                                            {{ __('app.table_info', [ 'first' => $assets->firstItem(), 'last' => $assets->lastItem(), 'total' => $assets->total() ]) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
    <script src="{{ asset('plugins/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript">
		
        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    </script>
@endpush