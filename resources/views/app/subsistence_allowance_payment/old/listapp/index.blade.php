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
                        <h3 class="mb-0">Senarai Permohonan Elaun Sara Hidup</h3>
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
                                <form method="GET" id="search-form" action="{{ route('subsistence-allowance.formlistApp') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtNoAccount" class="form-label">No Akaun : </label>
                                            <input type="text" id="txtNoAccount" name="txtNoAccount" value="{{ $filterNoAccount }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label" for="selectOne">Nama : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtNoFail" class="form-label">No Fail : </label>
                                            <input type="text" id="txtNoFail" name="txtNoFail" value="{{ $filterNoFail }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="txtNoKP" class="form-label" for="selectOne">No KP: </label>
                                            <input type="text" id="txtNoKP" name="txtNoKP" value="{{ $filterNoKP }}" class="form-control" />
                                        </div>                             
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <br/>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()"> Reset</button>
                                        <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">

                                        @if (!$subApplication->isEmpty())
                                            <thead class="table-light">
                                                <tr> 
                                                    <th><b>Tindakan</b></th>
                                                    <th><b>Tarikh Permohonan</b></th>
                                                    <th><b>No Fail</b></th>
                                                    <th><b>Jenis Permohonan</b></th>
                                                    <th><b>Nama</b></th>
                                                    <th><b>No KP</b></th>
                                                    <th><b>Tarikh Diluluskan</b></th>
                                                    <th><b>Tarikh Luput</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subApplication as $a)
                                                    <tr>
                                                    <td>    
                                                        <a href="{{ route('subsistence-allowance.details' , $a->id ) }}" class="btn btn-primary btn-sm audit-view" ><i class="fa fa-edit"></i></a>
                                                    </td>
                                                        <td>{{ $a->created_at }}</td>
                                                        <td>{{ $a->registration_no }}</td>
                                                        @if($a->type_registration == 'Baru')
                                                            <td><span class="badge bg-success">Baru</span></td>
                                                        @elseif($a->type_registration == 'Rayuan')
                                                            <td><span class="badge bg-warning text-dark">Rayuan</span></td>
                                                        @else
                                                            <td>{{ $a->type_registration }}</td>
                                                        @endif
                                                        <td>{{ strtoupper($a->fullname) }}</td>
                                                        <td>{{ $a->icno }}</td>
                                                        <td>{{ $a->application_approved_date ? Carbon\Carbon::parse($a->application_approved_date)->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $a->application_expired_date ? Carbon\Carbon::parse($a->application_expired_date)->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ strtoupper($a->sub_application_status) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead class="table-light">
                                                <tr>                                             
                                                    <th><b>Tindakan</b></th>
                                                    <th><b>Tarikh Permohonan</b></th>
                                                    <th><b>Jenis Permohonan</b></th>
                                                    <th><b>No Fail</b></th>
                                                    <th><b>Nama</b></th>
                                                    <th><b>No KP</b></th>
                                                    <th><b>Tarikh Diluluskan</b></th>
                                                    <th><b>Tarikh Luput</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="8">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                  
                                       
                                    
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
                document.querySelector('input[name="txtNoAccount"]').value = '';
                document.querySelector('input[name="txtName"]').value = '';
                document.querySelector('input[name="txtNoFail"]').value = '';
                document.querySelector('input[name="txtNoKP"]').value = '';

                

                // Submit the form to retrieve all list data
                document.getElementById('search-form').submit();
            }

</script>   
@endpush
