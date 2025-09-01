@extends('layouts.app')

@push('styles')
    <style type="text/css">
       

        #search-form {
            width: 100%; 
            margin-bottom: 40px;
        }

       
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
                        <h3 class="mb-0">Permohonan Lucut Hak Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row ustify-content-center">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Senarai Penerima Elaun Sara Hidup Nelayan Darat</h4>
                            </div>
                            <div class="card-body" style="display:flex;  flex-direction: column; align-items:center;">
                                <form method="GET" id="search-form" action="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span style="color: red;">Sila Masukkan Nama atau Nombor Kad Pengenalan untuk Carian</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtName" class="form-label" for="selectOne">Nama : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterName }}" class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtNoKP" class="form-label" for="selectOne">No KP: </label>
                                            <input type="text" id="txtNoKP" name="txtNoKP" value="{{ $filterNoKP }}" class="form-control" />
                                        </div>  

                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <br/>
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()"> Reset</button>
                                            <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                        </div>
                                    </div>
                                </form>
                      
                                <div class="table-responsive table-card">
                                    <table class="table table-striped">
                                        <thead class="table-light">
                                            <tr> 
                                                <th><b>Tindakan</b></th>
                                                <th><b>No Fail</b></th>
                                                <th><b>Nama Pemohon</b></th>
                                                <th><b>No KP</b></th>
                                                <th><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$confiscation->isEmpty())
                                                @foreach ($confiscation as $a)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('confiscation.update-application.edit', $a->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $a->registration_no }}</td>
                                                        <td>{{ $a->fullname }}</td>
                                                        <td>{{ $a->icno }}</td>
                                                        <td>{{ $a->sub_application_status }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="5">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            {!! $confiscation->appends(Request::except('page'))->render() !!}
                        </div>
                    </div>
                    @if (!$confiscation->isEmpty())
                        <div class="col-md-4">
                            <span class="float-md-right">
                                {{ __('app.table_info', [ 'first' => $confiscation->firstItem(), 'last' => $confiscation->lastItem(), 'total' => $confiscation->total() ]) }}
                            </span>
                        </div>
                    @endif

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
                document.querySelector('input[name="txtNoKP"]').value = '';

                

                // Submit the form to retrieve all list data
                document.getElementById('search-form').submit();
            }

</script>   
@endpush
