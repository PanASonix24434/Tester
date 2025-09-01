@extends('layouts.app')

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Pengguna</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('administration.users.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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

                                <form id="export-users-excel" method="GET" action="{{ route('administration.users.export.excel') }}" class="hidden">
                                    <input type="text" class="form-control" name="q" value="">
                                </form>
                                <form id="export-users-pdf" method="GET" action="{{ route('administration.users.export.pdf') }}" target="_blank" class="hidden">
                                    <input type="text" class="form-control" name="q" value="">
                                </form>

                                <!-- Form -->
                                <form method="GET" action="{{ route('administration.users.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label">Nama Penuh : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label class="form-label" for="selRole">Peranan : </label>
                                            <select class="form-select select2" id="selRole" name="selRole" autocomplete="off" height="150%">
                                                <option value="">-- Papar Semua --</option>
                                                @foreach($roles as $r)
                                                    @if ($filterSelRole == $r->id)
                                                    <option value="{{ $r->id }}" selected>{{ strtoupper($r->name) }}</option>
                                                    @else
                                                    <option value="{{ $r->id }}">{{ strtoupper($r->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                            </select>
                                        </div>
                                        <div class="mb-6">
                                            <label class="form-label" for="selStatus">Status : </label>
                                            <select class="form-select select2" id="selStatus" name="selStatus"  autocomplete="off" height="150%">
                                                <option value="">-- Papar Semua --</option>
                                                @if ($filterSelStatus == 1)
                                                    <option value="1" selected>AKTIF</option>
                                                    <option value="0">TIDAK AKTIF</option>
                                                @elseif($filterSelStatus == 0)
                                                    <option value="1">AKTIF</option>
                                                    <option value="0" selected>TIDAK AKTIF</option>
                                                @else
                                                    <option value="1">AKTIF</option>
                                                    <option value="0">TIDAK AKTIF</option>
                                                @endif
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtICNo" class="form-label">No. Kad Pengenalan : </label>
                                            <input type="text" id="txtICNo" name="txtICNo" value="{{ $filterICNo }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label class="form-label" for="selEntity">Pejabat Bertugas : </label>
                                            <select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="150%">
                                                <option value="">-- Papar Semua --</option>
                                                @foreach($entities as $entity)
                                                    @if ($filterSelEntity == $entity->id)
                                                    <option value="{{$entity->id}}" selected>{{$entity->entity_name}}</option>
                                                    @else
                                                    <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>

                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-file-export"></i> Eksport
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('export-users-excel').submit();">Excel</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('export-users-pdf').submit();">PDF</a>
                                        </div>

                                    </div>
                                </div>
                                </form><br/>
                            </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table text-nowrap mb-0 table-centered table-hover">
                        @if (!$users->isEmpty())
                            <thead class="table-light">
                                <tr>
                                    <th><b>Nama Penuh</b></th>
                                    <th><b>No. Kad Pengenalan</b></th>
                                    <th><b>Emel</b></th>
                                    <th><b>Peranan</b></th>
                                    <th><b>Pejabat Bertugas</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('administration.users.edit', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <i class="{{ !empty($user->email_verified_at) ? 'fas fa-check-circle text-info' : 'fas fa-exclamation-triangle text-danger' }}" title="{{ !empty($user->email_verified_at) ? __('app.email_verified') : __('app.email_not_verified') }}"></i>
                                        {{ $user->email }}
                                    </td>
                                    <td>{{ $user->roles->sortBy('name')->pluck('name')->implode(', ') }}</td>
                                    <td>{{ strtoupper(Helper::getEntityNameById($user->entity_id)) }}</td>
                                    <td>
                                        @if ($user->is_active && !empty($user->email_verified_at))
                                            <span class="badge badge-pill badge-info">{{ __('app.active') }}</span>
                                        @else
                                            <span class="badge badge-pill badge-dark">{{ __('app.inactive') }}</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        @else
                            <thead class="table-light">
                                <tr>
                                    <th><b>Nama Penuh</b></th>
                                    <th><b>No. Kad Pengenalan</b></th>
                                    <th><b>Emel</b></th>
                                    <th><b>Peranan</b></th>
                                    <th><b>Pejabat Bertugas</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody><tr><td>{{ __('app.no_record_found') }}</td></tr></tbody>
                        @endif
                        </table>
                    </div>
                  </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $users->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$users->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $users->firstItem(), 'last' => $users->lastItem(), 'total' => $users->total() ]) }}
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

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
        alert(msg);
        }

</script>   
@endpush
