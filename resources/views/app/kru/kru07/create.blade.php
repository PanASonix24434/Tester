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
                              <li class="breadcrumb-item"><a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.index') }}">Pembaharuan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                        <a class="nav-link active" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                        aria-controls="application" aria-selected="true">Senarai Vesel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" aria-selected="false">Maklumat Am</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" aria-selected="false">Senarai Kru Bukan Warganegara</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" aria-selected="false">Maklumat Dokumen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" aria-selected="false">Perakuan</a>
                                    </li>
                                </ul>
                                <div class="tab-content p-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                        <form id="form" method="POST" action="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.store') }}">
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
                                                                <th>Zon</th>
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
                                                                        <td>{{$vessel->zon}}</td>
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
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="selVessel">Vesel Pilihan: <span style="color:red;">*</span></label>
                                                        <select class="form-select select2" id="selVessel" name="selVessel" autocomplete="off" height="100%" width="100%" required>
                                                            <option value="">{{ __('app.please_select')}}</option>
                                                            @foreach ( $vessels as $vessel )
                                                                <option value="{{$vessel->id}}" {{-- $vessel->hasForeignQuota() ? '' : 'disabled' --}} {{ App\Models\Kru\ForeignCrew::where('vessel_id',$vessel->id)->exists() ? '' : 'disabled' }}>{{ $vessel->no_pendaftaran }} {{-- $vessel->hasForeignQuota() ? '' : '(TIADA QUOTA)'--}} {{ App\Models\Kru\ForeignCrew::where('vessel_id',$vessel->id)->exists() ? '' : '(Tiada Kru Asing)' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('selVessel')
                                                        <span id="selVessel_error" class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('pembaharuanpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-sm" style="background-color: #282c34; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 8px 16px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"><i class="fas fa-arrow-left" style="color: #fff;"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-weight: bold; box-shadow: 0 2px 8px rgba(0,123,255,0.3);" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                        <i class="fas fa-save" style="color: #fff;"></i> Simpan
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
            $('#selKru').on('change', function() {
                $('#vessel').val($('#selKru').find(':selected').data('vessel'));
            });
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
