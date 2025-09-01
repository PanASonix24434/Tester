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
                            <h3 class="mb-0">Pembayaran Elaun Sara Hidup Nelayan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Janaan Senarai Nama ESHND Aktif</h4>
                                </div>
                                <div class="card-body" style="padding: 0;">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap table-centered table-hover">
                                            <thead class="table-light">
                                                <tr> 
                                                    <th><b>Nama</b></th>
                                                    <th><b>No Kad Pengenalan</b></th>
                                                    <th><b>Tarikh Tamat ESH</b></th>
                                                    <th><b>Pendaratan ({{$month}}/{{$year}})</b></th>
                                                    <th><b>Pejabat Perikanan Daerah</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!$lists->isEmpty())
                                                    @foreach ($lists as $a)
                                                        @php
                                                            $landing = App\Models\LandingDeclaration\LandingDeclarationMonthly::where('user_id',$a->user_id)->where('year',$year)->where('month',$month)->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $a->fullname }}</td>
                                                            <td>{{ $a->icno }}</td>
                                                            <td>{{ optional($a->application_expired_date)->format('d/m/Y') }}</td>
                                                            <td>
                                                                @if ($landing != null)
                                                                    <span class="badge bg-success">Ada Pendaratan</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tiada Pendaratan</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $a->entity_id != null ? strtoupper(Helper::getEntityNameById($a->entity_id)) : '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="3">{{ __('app.no_record_found') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer d-md-flex justify-content-between align-items-center">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            {!! $lists->appends(Request::except('page'))->render() !!}
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
                                <div class="card-body">
                                    <form action="{{ route('subsistenceallowancepayment.generatenamedistrict.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="entity_id" value="{{$entity_id}}">
                                            <input type="hidden" name="selMonth" value="{{$month}}">
                                            <input type="hidden" name="selYear" value="{{$year}}">

                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('subsistenceallowancepayment.generatenamedistrict.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Simpan Janaan Senarai Nama</button>
                                            </div>
                                        </div>
                                    </form>
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
    
</script>   
@endpush
