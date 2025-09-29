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
                                                <a class="nav-link disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Pembatalan Kru</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembatalanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.updateB',$id) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12 table-responsive">
                                                            <div class="form-group">
                                                            <label class="col-form-label">Senarai Kru:</label>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="col-sm-12 table-responsive">
                                                            <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                <th>Bil</th>
                                                                <th>Nama Kru</th>
                                                                <th>Warganegara</th>
                                                                <!-- <th>Tarikh Lahir</th>
                                                                <th>Jantina</th> -->
                                                                <th>Nombor Pasport</th>
                                                                <th>Jawatan</th>
                                                                <th>Tarikh Tamat PLKS</th>
                                                                <th>Ingin Dibatalkan</th>
                                                                <th>Sebab Pembatalan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="listKru">
                                                                @php
                                                                    $count = 0;
                                                                @endphp
                                                                @foreach ($foreignCrews as $foreignCrew)
                                                                    <tr>
                                                                        <td>{{++$count}}</td>
                                                                        <td>{{$foreignCrew->name}}</td>
                                                                        <td>{{$foreignCrew->source_country_id != null ? Helper::getCodeMasterNameById($foreignCrew->source_country_id) : ''}}</td>
                                                                        <!-- <td>{{$foreignCrew->birth_date->format('d/m/Y')}}</td>
                                                                        <td>{{$foreignCrew->gender_id != null ? Helper::getCodeMasterNameById($foreignCrew->gender_id) : ''}}</td> -->
                                                                        <td>{{$foreignCrew->passport_number}}</td>
                                                                        <td>{{$foreignCrew->foreign_kru_position_id != null ? Helper::getCodeMasterNameById($foreignCrew->foreign_kru_position_id) : ''}}</td>
                                                                        <td>{{optional($foreignCrew->plks_end_date)->format('d/m/Y')}}</td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" name="selKrus[]" class="custom-control-input" id="{{'kru'.$count}}" value="{{$foreignCrew->id}}"  {{$selectedCrews->contains('passport_number', $foreignCrew->passport_number) ? 'checked' : ''}} >
                                                                                <label class="custom-control-label" for="{{'kru'.$count}}"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            @if ($selectedCrews->contains('passport_number', $foreignCrew->passport_number))
                                                                                    <input type="text" name="reasons[]" class="form-control" placeholder="Sebab Pembatalan" value="{{ $selectedCrews->where('passport_number',$foreignCrew->passport_number)->first()->revocation_reason }}" required/>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.edit',$id) }}" class="btn btn-sm" style="background-color: #282c34; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 8px 16px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"><i class="fas fa-arrow-left" style="color: #fff;"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-weight: bold; box-shadow: 0 2px 8px rgba(0,123,255,0.3);" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                                <i class="fas fa-save" style="color: #fff;"></i> Simpan
                                                            </button>
                                                            <a href="{{ route('pembatalanpenggunaankrubukanwarganegara.permohonan.editE',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
