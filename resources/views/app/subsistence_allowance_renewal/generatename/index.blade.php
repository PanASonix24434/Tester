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
                        <h3 class="mb-0">Janaan Nama Pembaharuan ESH</h3>
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
                    <!-- Jana Senarai Nama Permohonan Baharu -->
                    
                    <div class="card p-3">
                        <h6><i class="fas fa-list"></i> Janaan Senarai Nama Permohonan Pembaharuan:</h6>
                     <!-- <form action="{{ route('subsistence-allowance-renewal.store') }}" method="POST">
                    @csrf
                        <label class="mt-2">Kuota Penerima Elaun:</label>
                        <input type="number" name="quota" class="form-control" required placeholder="Masukkan kuota"> 
                        <button type="submit" class="btn btn-primary mt-2">Jana Senarai Nama</button> 
                    </form> -->

                    <a class="btn btn-primary mt-2" href="{{ route('subsistence-allowance-renewal.listNameRenewal') }}">Jana Senarai Nama</a>
                    </div>
                    
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Elaun Sara Sara Hidup</h4>
                            </div>

                                <div class="card-body">
                                
                                    <!-- Elaun Sara Hidup -->
                                        <p class="fw-bold text-primary">Senarai Janaan Nama Mesyuarat Elaun Sara Hidup Nelayan Darat</p>

                                        <!-- Jadual Data -->
                                        <table id="dataTable" class="table table-striped">
                                        @if (!$lists->isEmpty())
                                            <thead>
                                                <tr>
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Senarai</th>
                                                    <th>Status</th>
                                                    <th>Pejabat Perikanan</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lists as $data)
                                                <tr>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->total_applicants }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                            {{ $data->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $data->entities_id != null ? strtoupper(Helper::getEntityNameById($data->entities_id)) : '' }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="{{ route('subsistence-allowance-renewal.generate.pdf',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a>
                                                        <a class="btn btn-sm btn-warning" href="{{ route('subsistence-allowance-renewal.edit', $data->id) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        @if($data->status=='Dijana' || $data->status=='Dicetak')
                                                            <form action="{{ route('subsistence-allowance-renewal.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    
                                                  
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            @else
                                            <thead>
                                                <tr>                                             
                                                    <th>Tarikh Senarai Dijana</th>
                                                    <th>Jumlah Senarai</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="4">{{ __('app.no_record_found') }}</td>
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
