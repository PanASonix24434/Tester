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
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <h6><i class="fas fa-list"></i> Janaan Senarai Nama Permohonan Baharu:</h6>
                        <a class="btn btn-primary" href="{{ route('subsistence-allowance.generate-name-state.listName') }}">Jana Senarai Nama Negeri</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Jana Nama Negeri</h4>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold text-primary">Senarai Janaan Nama Elaun Sara Hidup Nelayan Darat</p>
                                <div class="table-responsive">
                                <table id="dataTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tarikh Senarai Dijana</th>
                                            <th>Jumlah Senarai</th>
                                            <th>Tahun</th>
                                            <th>Mesyuarat</th>
                                            <th>Status</th>
                                            <th>Pejabat Perikanan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (!$lists->isEmpty())
                                        @foreach($lists as $data)
                                        <tr>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->total_applicants }}</td>
                                            <td>{{ $data->year }}</td>
                                            <td>{{ $data->phase }}</td>
                                            <td>
                                                <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                            <td>{{ $data->entities_id != null ? strtoupper(Helper::getEntityNameById($data->entities_id)) : '' }}</td>
                                            <td>
                                                <a data-target="editButton-{{$data->id}}" class="btn btn-sm btn-info" href="{{ route('subsistence-allowance.generate-name-state.generateListNamePDF',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a>
                                                @if($data->status=='Dicetak')
                                                    <a id="editButton-{{$data->id}}" class="btn btn-sm btn-warning" href="{{ route('subsistence-allowance.generate-name-state.edit', $data->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @elseif ($data->status=='Dihantar')
                                                    <a id="editButton-{{$data->id}}" class="btn btn-sm btn-primary" href="{{ route('subsistence-allowance.generate-name-state.edit', $data->id) }}">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @else
                                                    <a id="editButton-{{$data->id}}" class="btn btn-sm btn-warning disabled" href="{{ route('subsistence-allowance.generate-name-state.edit', $data->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if($data->status=='Dijana' || $data->status=='Dicetak')
                                                    <form action="{{ route('subsistence-allowance.generate-name-state.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">{{ __('app.no_record_found') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
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
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    // Listen for clicks on any button that has a 'data-target-button' attribute
    $('a[data-target]').on('click', function() {
        // Get the value of the 'data-target-button' attribute from the clicked button
        var targetButtonId = $(this).data('target'); 
        // Use the obtained ID to select and remove the 'disabled' class from the target button
        $('#' + targetButtonId).removeClass('disabled');
    });
});
</script>   
@endpush
