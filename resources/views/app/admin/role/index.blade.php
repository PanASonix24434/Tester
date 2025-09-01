@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

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
                        <h3 class="mb-0">Senarai Peranan</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('administration.roles.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
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
                                <form method="GET" action="{{ route('administration.roles.index') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="name" class="form-label">Nama Peranan : </label>
                                            <input type="text" id="name" name="name" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label class="form-label" for="selectOne">Pejabat Bertugas : </label>
                                            <select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="150%">
                                                <option value="">-- Papar Semua --</option>
                                                @foreach($entities as $entity)
                                                    @if ($filterEntity == $entity->id)
                                                    <option value="{{$entity->id}}" selected>{{$entity->entity_name}}</option>
                                                    @else
                                                    <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <br/>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                        <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                    </div>
                                </div>
                                </form>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$roles->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama Peranan</b></th>
                                                <th><b>Peringkat</b></th>
                                                <th><b>Pejabat Bertugas</b></th>
                                                <th><b>Bil. Kuota</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('administration.roles.edit', $role->id) }}">
                                                        {{ $role->name }}
                                                    </a>
                                                </td>
                                                @if ($role->entity_level == 1)
                                                    <td>IBU PEJABAT (HQ)</td>
                                                @elseif($role->entity_level == 2)
                                                    <td>NEGERI</td>
                                                @elseif($role->entity_level == 3)
                                                    <td>WILAYAH</td>
                                                @elseif($role->entity_level == 4)
                                                    <td>DAERAH</td>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if ($role->entity_name)
                                                <td>{{ strtoupper($role->entity_name) }}</td>
                                                @else
                                                <td>{{ $role->entity_name }}</td>
                                                @endif
                                                

                                                @if(!$role->quota)
                                                    <td>TIADA KUOTA</td>
                                                @else
                                                    <td>{{ $role->quota }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Peranan</th>
                                                <th>Peringkat</th>
                                                <th>Bil. Kuota</th>
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
                                                    {!! $roles->appends(Request::except('page'))->render() !!}
                                                </div>
                                            </div>
                                            @if (!$roles->isEmpty())
                                                <div class="col-md-4">
                                                    <span class="float-md-right">
                                                        {{ __('app.table_info', [ 'first' => $roles->firstItem(), 'last' => $roles->lastItem(), 'total' => $roles->total() ]) }}
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
