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
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                {{--
                                <form method="GET" id="search-form" action="{{ route('subsistence-allowance.list-application.index') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 align-items-center">
                                            <div class="mb-6">
                                                <label for="txtNoFail" class="form-label">No Rujukan : </label>
                                                <input type="text" id="txtNoFail" name="txtNoFail" value="{{ $filterNoFail }}" class="form-control" />
                                            </div>
                                            <div class="mb-6">
                                                <label for="txtName" class="form-label" for="selectOne">Nama : </label>
                                                <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 align-items-center">
                                            <div class="mb-6">
                                                <label for="txtNoKP" class="form-label" for="selectOne">No KP: </label>
                                                <input type="text" id="txtNoKP" name="txtNoKP" value="{{ $filterNoKP }}" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <br/>
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                            <a class="btn btn-secondary btn-sm" onclick="resetForm()"><i class="fas fa-eraser"></i> Reset</a>
                                        </div>
                                    </div>
                                </form>
                                --}}
                            </div>
                            <div class="card-body" style="padding: 0%;">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Tarikh Permohonan</b></th>
                                                <th><b>No Rujukan</b></th>
                                                <th><b>Nama</b></th>
                                                <th><b>No KP</b></th>
                                                <th><b>Pejabat Perikanan Daerah</b></th>
                                                <th><b>Status</b></th>
                                                <th style="width: 0%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$subApplication->isEmpty())
                                                @foreach ($subApplication as $a)
                                                    <tr>
                                                        <td>{{ $a->created_at }}</td>
                                                        <td>{{ $a->registration_no }}</td>
                                                        <td>{{ strtoupper($a->fullname) }}</td>
                                                        <td>{{ $a->icno }}</td>
                                                        <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                        <td>{{ strtoupper($a->sub_application_status) }}</td>
                                                        <td>
                                                            <a href="{{ route('subsistence-allowance.list-application.show' , $a->id ) }}" class="btn btn-primary btn-sm audit-view" ><i class="fa fa-search"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="7">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $subApplication->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$subApplication->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $subApplication->firstItem(), 'last' => $subApplication->lastItem(), 'total' => $subApplication->total() ]) }}
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
<script type="text/javascript">

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    function resetForm() {
        // Reset all input fields
        document.querySelector('input[name="txtName"]').value = '';
        document.querySelector('input[name="txtNoFail"]').value = '';
        document.querySelector('input[name="txtNoKP"]').value = '';

        // Submit the form to retrieve all list data
        document.getElementById('search-form').submit();
    }
    
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush
