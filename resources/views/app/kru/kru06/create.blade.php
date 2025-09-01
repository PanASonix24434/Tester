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
                              <li class="breadcrumb-item"><a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.index') }}">Kelulusan Penggunaan Kru Bukan Warganegara Untuk Bekerja Di Atas Vesel Penangkapan Ikan Tempatan</a></li>
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
                                        aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
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
                                        <form id="form" method="POST" action="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.store') }}">
                                            @csrf
                                            <div class="row">
                                                <!-- <div id="lengkap" class="row"> -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="selLetter">Surat Kebenaran: <span style="color:red;">*</span></label>
                                                            <select class="form-select select2" id="selLetter" name="selLetter" autocomplete="off" height="100%" width="100%" required>
                                                                <option value="">{{ __('app.please_select')}}</option>
                                                                @foreach ( $permissionLetters as $letter )
                                                                    <option value="{{$letter->id}}" >{{ optional(App\Models\Vessel::find($letter->vessel_id))->no_pendaftaran}} ({{ $letter->reference_number }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('selLetter')
                                                            <span id="selLetter_error" class="text-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    {{--
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="txtDate" class="form-label">Tarikh Tamat Tempoh PLKS : <span style="color:red;">*</span></label>
                                                            <input type="date" id="txtDate" name="txtDate" value="" class="form-control" min="{{ now()->toDateString() }}" required />
                                                        </div>
                                                    </div>
                                                    --}}
                                                <!-- </div> -->
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('kelulusanpenggunaankrubukanwarganegara.permohonan.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Permohonan?</span>').text())">
                                                        <i class="fas fa-save"></i> Simpan
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
            // $('#lengkap').addClass('hidden');
            // $('#selApprovalType').on('change', function() {
                
            //     if ($(this).val()=='C, C2 & Jerut Bilis (Langkawi, Kedah dan Pulau Pangkor, Perak)') {
            //         $('#lengkap').removeClass('hidden');
            //     }else if ( $(this).val()=='C3'){
            //         $('#lengkap').addClass('hidden');
            //     }

            //     $('#vessel').val($('#selKru').find(':selected').data('vessel'));
            // });
            
            // $('input[type=radio][name=applicationStatus]').change(function() {
            //     $('#btnSubmit').prop("disabled",false);
            //     if ($(this).val()=='supported') {
            //         $('#remark').prop("required",false);
            //     }else if ($(this).val()=='notsupported' || $(this).val()=='incomplete'){
            //         $('#remark').prop("required",true);
            //     }
                
            //     if ($(this).val()=='supported' || $(this).val()=='notsupported') {
            //         $('#lengkap').removeClass('hidden');
            //     }else if ( $(this).val()=='incomplete'){
            //         $('#lengkap').addClass('hidden');
            //     }
            // });
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
