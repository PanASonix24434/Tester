@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')
    <div id="app-content">
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-8">
                        <h3 class="mb-0">Permohonan Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0" style="color:white;">Senarai Janaan Nama Elaun Sara Hidup Nelayan Darat</h4>
                        </div>
                        <div class="card-body">
                            <p class="fw-bold text-primary">Senarai Janaan Nama Mesyuarat Elaun Sara Hidup Nelayan Darat (HQ)</p>
                            <table id="dataTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tarikh Senarai Dijana</th>
                                        <th>Jumlah Senarai</th>
                                        <th>Tahun</th>
                                        <th>Mesyuarat</th>
                                        <th>Pejabat</th>
                                        <th>Status</th>
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
                                            <td>{{ $data->entities_id != null ? strtoupper(Helper::getEntityNameById($data->entities_id)) : '' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $data->status == 'Dicetak' ? 'warning' : ($data->status == 'Dihantar' ? 'success' : 'primary') }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="{{ route('subsistence-allowance.generate-name-hq.generateListNameHqPDF',  $data->id) }}"  target="_blank"><i class="fas fa-print"></i></a>
                                                @if ($data->status == 'Selesai')
                                                    <a class="btn btn-sm btn-primary" href="{{ route('subsistence-allowance.generate-name-hq.edit', $data->id) }}">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @elseif($data->status == 'Dihantar')
                                                    <a class="btn btn-sm btn-warning" href="{{ route('subsistence-allowance.generate-name-hq.edit', $data->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
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
</script>   
@endpush
