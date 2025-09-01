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
                                <li class="breadcrumb-item"><a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.index') }}">Kebenaran Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.edit',$id)}}">Senarai Vesel</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editB',$id)}}">Maklumat Am</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editC',$id)}}">Senarai Kru Bukan Warganegara</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editD',$id)}}">Maklumat Dokumen</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" href="{{route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editE',$id)}}">Perakuan</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-4" id="myTabContent">
                                            <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                <form id="form" method="POST" action="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.updateC',$id) }}">
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
                                                                <th>Tarikh Tamat Pasport</th>
                                                                <th>Jawatan</th>
                                                                <th>Status Keberadaan Kru</th>
                                                                <th>Tarikh Tamat PLKS</th>
                                                                <th>Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="listKru">
                                                                @php
                                                                    $count = 0;
                                                                @endphp
                                                                @foreach ($foreignCrews as $foreignKru)
                                                                    <tr>
                                                                        <td>{{++$count}}</td>
                                                                        <td>{{$foreignKru->name}}</td>
                                                                        <td>{{$foreignKru->source_country_id != null ? Helper::getCodeMasterNameById($foreignKru->source_country_id) : ''}}</td>
                                                                        <!-- <td>{{$foreignKru->birth_date->format('d/m/Y')}}</td>
                                                                        <td>{{$foreignKru->gender_id != null ? Helper::getCodeMasterNameById($foreignKru->gender_id) : ''}}</td> -->
                                                                        <td>{{$foreignKru->passport_number}}</td>
                                                                        <td>{{$foreignKru->passport_end_date->format('d/m/Y')}}</td>
                                                                        <td>{{$foreignKru->foreign_kru_position_id != null ? Helper::getCodeMasterNameById($foreignKru->foreign_kru_position_id) : ''}}</td>
                                                                        <td>{{$foreignKru->crew_whereabout}}</td>
                                                                        <td>{{optional($foreignKru->plks_end_date)->format('d/m/Y')}}</td>
                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" name="selKrus[]" class="custom-control-input" id="{{'kru'.$count}}" value="{{$foreignKru->id}}"  {{$selectedCrews->contains('passport_number', $foreignKru->passport_number) ? 'checked' : ''}} >
                                                                                <label class="custom-control-label" for="{{'kru'.$count}}"></label>
                                                                            </div>
                                                                            @if ($selectedCrews->contains('passport_number', $foreignKru->passport_number))
                                                                                <!-- <a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editCAddKru', $foreignKru->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a> -->
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.editB',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                                <i class="fas fa-save"></i> Simpan & Seterusnya
                                                            </button>
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
