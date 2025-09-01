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
                        <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row ustify-content-center">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Pengisytiharan Pendaratan Perikanan Darat </h4>
                            </div>
                            <div class="card-body" style="display:flex;  flex-direction: column; align-items:center;">
                                
                                <br/>
                      
                                <div class="table-responsive table-card">
                                    <table class="table table-striped">

                                        @if (!$app->isEmpty())
                                            <thead class="table-light">
                                                <tr> 
                                                    <th style="width:1%;"></th> 
                                                    <th>Tarikh Permohonan </th>
                                                    <th>Nama Pemohon</th>
                                                    <th>No. Kad Pengenalan</th>
                                                    <th>Tarikh Disahkan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($app as $a)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('landingdeclaration.check.show', $a->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $a->created_at }}</td>
                                                        <td>{{ $a->name }}</td>
                                                        <td>{{ $a->username }}</td>
                                                        <td>{{ $a->confirmed_at }}</td>
                                                        <td>{{ $a->landing_status_id != null ? Helper::getCodeMasterNameById($a->landing_status_id) : '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:1%;"></th> 
                                                    <th>Tarikh Permohonan </th>
                                                    <th>{{__('app.applicant_name')}}</th>
                                                    <th>{{__('app.icno')}}</th>
                                                    <th>Tarikh Disahkan</th>
                                                    <th>@sortablelink('status', __('app.status'))</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="6">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                  
                                       
                                    
                                    </table>
                                </div>
                            </div>     

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            {!! $app->appends(Request::except('page'))->render() !!}
                        </div>
                    </div>
                    @if (!$app->isEmpty())
                        <div class="col-md-4">
                            <span class="float-md-right">
                                {{ __('app.table_info', [ 'first' => $app->firstItem(), 'last' => $app->lastItem(), 'total' => $app->total() ]) }}
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
