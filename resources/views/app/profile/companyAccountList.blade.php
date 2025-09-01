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
              <h1 class="m-0">Maklumat Penyata Akaun</h1>
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
                        <a class="nav-link active" id="custom-tabs-one-account-tab" data-toggle="pill" href="#custom-tabs-one-account" role="tab" aria-controls="custom-tabs-one-account" aria-selected="true">Maklumat Penyata Akaun</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-asset-tab" href="{{ route('profile.profileCompanyAssetList', $company_profile_id) }}" role="tab" aria-controls="custom-tabs-one-asset" aria-selected="false">Maklumat Aset</a>
                      </li>
                    </ul>
                </div>
          
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-account" role="tabpanel" aria-labelledby="custom-tabs-one-account-tab">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">@yield('page_title')</h3>
                                            <div class="card-tools">
                                                <a href="{{ route('profile.profileCompanyAccountCreate', $company_profile_id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> {{ __('app.create') }}</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped table-sm">
                                                            @if (!$accs->isEmpty())
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:1%;"></th>
                                                                        <th>Tahun Penyata Akaun</th>
                                                                        <th>Penerangan</th>
                                                                        <th>Fail</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($accs as $a)
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                <button type="button" class="btn btn-danger btn-xs"
                                                                                    data-toggle="modal" 
                                                                                    data-target="#delete-modal" 
                                                                                    data-href="{{ route('profile.profileCompanyAccountDelete', $a->id) }}" 
                                                                                    data-text="{{ __('app.data_will_be_deleted') }}">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                            <td>{{ $a->account_year }}</td>
                                                                            <td>{{ $a->title }}</td>
                                                                            <td>
                                                                                <a href="{{ route('profile.profileCompanyAccountDownload', $a->id) }}">{{ $a->filename }}</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            @else
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tahun Penyata Akaun</th>
                                                                        <th>Penerangan</th>
                                                                        <th>Fail</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="text-center">
                                                                        <td colspan="3">{{ __('app.no_record_found') }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="table-responsive">
                                                        {!! $accs->appends(\Request::except('page'))->render() !!}
                                                    </div>
                                                </div>
                                                @if (!$accs->isEmpty())
                                                    <div class="col-md-4">
                                                        <span class="float-md-right">
                                                            {{ __('app.table_info', [ 'first' => $accs->firstItem(), 'last' => $accs->lastItem(), 'total' => $accs->total() ]) }}
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