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
                        <h3 class="mb-0">Senarai Lucut Hak Penerimaan Elaun Sara Hidup Nelayan Darat</h3>
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
                                <h4 class="mb-0" style="color:white;">Senarai Nama Permohonan Lucut Hak</h4>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table" style="margin-bottom: 20px;">
                                        @if (!$confiscation->isEmpty())
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th  style="padding: 10px;">Tindakan</th>
                                                    <th  style="padding: 10px;">No Fail</th>
                                                    <th  style="padding: 10px;">Nama Pemohon</th>
                                                    <th  style="padding: 10px;">No KP</th>
                                                    <th  style="padding: 10px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($confiscation as $a)
                                                    <tr class="text-center">
                                                        <td style="padding: 10px;">
                                                            @if($a->status == 'Permohonan Lucut Hak Diluluskan')
                                                                <a></a>
                                                            @else
                                                                <a href="{{ route('confiscation.name-list.edit', $a->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td style="padding: 10px;">{{ $a->registration_no }}</td>
                                                        <td style="padding: 10px;">{{ $a->fullname }}</td>
                                                        <td style="padding: 10px;">{{ $a->icno }}</td>
                                                        <td style="padding: 10px;">{{ $a->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="padding: 10px;">Tindakan</th>
                                                    <th style="padding: 10px;">No Fail</th>
                                                    <th style="padding: 10px;">Nama Pemohon</th>
                                                    <th style="padding: 10px;">No KP</th>
                                                    <th style="padding: 10px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-center" style="padding: 20px;">
                                                        {{ __('app.no_record_found') }}
                                                    </td>
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
        
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

</script>   
@endpush
