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
                        <h3 class="mb-0">Senarai Nama Pembaharuan</h3>
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
                            <h6><i class="fas fa-list"></i> Janaan Senarai Nama Permohonan Pembaharuan:</h6>
                            <form action="{{ route('subsistence-allowance-renewal.storeJana') }}" method="POST">
                            @csrf
                                <!-- <label class="mt-2">Kuota Penerima Elaun:</label>
                                <input type="number" name="quota" class="form-control" required placeholder="Masukkan kuota">  -->
                                <button type="submit" class="btn btn-primary mt-2">Jana Senarai Nama</button> 
                            </form>
                            
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">

                                            @if (!$subApplication->isEmpty())
                                            <thead class="table-light">
                                                <tr> 
                                                    <th><b>Tarikh Permohonan</b></th>
                                                    <th><b>No Fail</b></th>
                                                    <th><b>Jenis Permohonan</b></th>
                                                    <th><b>Nama</b></th>
                                                    <th><b>No KP</b></th>
                                                    <th><b>Status</b></th>
                                                    <th><b>Pejabat Perikanan Daerah</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subApplication as $a)
                                                    <tr>
                                                        <td>{{ $a->created_at }}</td>
                                                        <td>{{ $a->registration_no }}</td>
                                                        @if($a->type_registration == 'Renew')
                                                            <td><span class="badge bg-success">Pembaharuan</span></td>
                                                        @elseif($a->type_registration == 'Rayuan Pembaharuan')
                                                            <td><span class="badge bg-warning text-dark">Rayuan</span></td>
                                                        @else
                                                            <td>{{ $a->type_registration }}</td>
                                                        @endif
                                                        <td>{{ strtoupper($a->fullname) }}</td>
                                                        <td>{{ $a->icno }}</td>
                                                        <td>{{ strtoupper($a->sub_application_status) }}</td>
                                                        <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead class="table-light">
                                                <tr>                                             
                                                   
                                                    <th><b>Tarikh Permohonan</b></th>
                                                    <th><b>No Fail</b></th>
                                                    <th><b>Jenis Permohonan</b></th>
                                                    <th><b>Nama</b></th>
                                                    <th><b>No KP</b></th>
                                                    <th><b>Status</b></th>
                                                    <th><b>Pejabat Perikanan Daerah</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="8">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
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

                            <div class="card-body">
                                <div class="row">
                                    <br />
                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                        <a href="{{ route('subsistence-allowance-renewal.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    
                                        
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
