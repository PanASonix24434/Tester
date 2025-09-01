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
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-8">
                        <h3 class="mb-0">Senarai Permohonan Elaun Sara Diri Nelayan (HQ)</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            
            <div>
                <!-- <form method="POST" enctype="multipart/form-data" action="#">
                    @csrf -->
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Elaun Sara Hidup</h4>
                            </div>

                                <div class="card-body">
                                
                                    <!-- Elaun Sara Hidup -->
                                        <p class="fw-bold text-primary">Senarai Janaan Nama Mesyuarat Elaun Sara Hidup Nelayan Darat (HQ)</p>

                                        <!-- Jadual Data -->
                                        <table id="dataTable" class="table table-striped">
                                        @if (!$lists->isEmpty())
                                            <thead>
                                                <tr>
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Senarai</th>
                                                    <th>Pejabat</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lists as $data)
                                                <tr>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->total_applicants }}</td>
                                                    <td>{{ $data->entities_id != null ? strtoupper(Helper::getEntityNameById($data->entities_id)) : '' }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                            {{ $data->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('subsistence-allowance.generate.hq.pdf',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a>
                                                        <a class="btn btn-sm btn-warning" href="{{ route('subsistence-allowance.edithq', $data->id) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <!-- <form action="{{ route('subsistence-allowance.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                        </form> -->
                                                    </td>
                                                    
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            @else
                                            <thead>
                                                <tr>                                             
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Senarai</th>
                                                    <th>Pejabat</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="5">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                        </table>
                                   
                                       
                                    
                                   

                                    

                                   
                                   

                                     
                                    
                                   
                                </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                            <div class="table-responsive">
                                {!! $lists->appends(\Request::except('page'))->render() !!}
                            </div>
                        </div>
                        @if (!$lists->isEmpty())
                            <div class="col-md-4">
                                <span class="float-md-right">
                                    {{ __('app.table_info', [ 'first' => $lists->firstItem(), 'last' => $lists->lastItem(), 'total' => $lists->total() ]) }}
                                </span>
                            </div>
                        @endif
                </div>
                </div>

                
                

            <!-- </form> -->
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

       

</script>   
@endpush
