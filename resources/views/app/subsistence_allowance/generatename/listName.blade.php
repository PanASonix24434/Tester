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
                <div class="col-md-6">
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Nama Permohonan Baru Elaun Sara Hidup Nelayan Darat</h3>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6><i class="fas fa-list"></i> Janaan Senarai Nama Permohonan Baharu:</h6>
                            <form action="{{ route('subsistence-allowance.generate-name-state.storeJana') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="selYear" class="form-label">Tahun <span style="color: red;">*</span></label>
                                            <select class="form-select" id="selYear" name="selYear" required>
                                                <option selected value="">- Sila Pilih-</option>
                                                @foreach ($years as $y)
                                                    <option value="{{$y}}">{{$y}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="selPhase" class="form-label">Mesyuarat <span style="color: red;">*</span></label>
                                            <select class="form-select" id="selPhase" name="selPhase" required>
                                                <option selected value="">- Sila Pilih-</option>
                                                @foreach ($phases as $p)
                                                    <option value="{{$p}}">{{$p}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-md-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan Janaan Senarai Nama Negeri</button>
                                    </div>
                                </div>
                            </form>
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
                                            <th><b>Status</b></th>
                                            <th><b>Pejabat Perikanan Daerah</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$subApplication->isEmpty())
                                            @foreach ($subApplication as $a)
                                                <tr>
                                                    <td>{{ $a->submitted_at }}</td>
                                                    <td>{{ $a->registration_no }}</td>
                                                    <td>{{ strtoupper($a->fullname) }}</td>
                                                    <td>{{ $a->icno }}</td>
                                                    <td>{{ strtoupper($a->sub_application_status) }}</td>
                                                    <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
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
                        <div class="card-footer">
                            <div class="row d-md-flex justify-content-between align-items-center">
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
                            <br />
                            <div class="row">
                                <div class="col-md-12 text-md-center mt-3 mt-md-0">
                                    <a href="{{ route('subsistence-allowance.generate-name-state.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
@endpush
