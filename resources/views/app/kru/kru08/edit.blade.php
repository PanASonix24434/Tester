@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/jstree/dist/themes/default/style.min.css') }}">
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Permohonan</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.index') }}">Pembatalan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <!-- Card -->
                            <div class="card mb-10">
                                <!-- Tab content -->
                                <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                                    <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                                        role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">
                                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Pembatalan Kru</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.update',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12 table-responsive">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Senarai Vesel:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Bil</th>
                                                                        <th>Vesel</th>
                                                                        <th>Bilangan Kuota Kru Maksimum</th>
                                                                        <th>Baki Kuota Kru Boleh Dipohon</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="listDoc">
                                                                    @php
                                                                        $vesselCount = 0;
                                                                    @endphp
                                                                    @if ($vessels != null && !$vessels->isEmpty())
                                                                        @foreach ( $vessels as $vessel )
                                                                            <tr>
                                                                                <td>{{++$vesselCount}}</td>
                                                                                <td>{{$vessel->no_pendaftaran}}</td>
                                                                                <td>{{$vessel->maximumForeignKru()}}</td>
                                                                                <td>{{$vessel->totalForeignKruQuotaLeft()}}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="4">- Tiada Vesel Berkaitan -</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="vessel" class="form-label">Vesel Pilihan: </label>
                                                                <input type="text" class="form-control" value="{{ $app->vessel_id != null ? optional(App\Models\Vessel::withTrashed()->find($app->vessel_id))->no_pendaftaran : ''}}" disabled/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <a href="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.editB',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function () {

        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
