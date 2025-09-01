@extends('layouts.app')

@push('styles')
    <style type="text/css">
      textarea { text-transform: uppercase; }
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
                    <div class="mb-5">
                        <h3 class="mb-0">Lihat Kelulusan Hebahan</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('hebahan.hebahanapprovelist.index') }}">Kelulusan Hebahan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Lihat Kelulusan Hebahan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10 row">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('hebahan.hebahanapprovelist.store') }}">
                            @csrf
                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <!-- Tajuk Pekeliling -->
                                    <div class="mb-3">
                                        <label for="txtTitle" class="form-label">Tajuk Hebahan : </label>
                                        <input type="text" id="txtTitle" name="txtTitle" value="{{ $hebahan[0]->tajuk }}" class="form-control" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtDate" class="form-label">Tarikh Hebahan : </label>
                                        <input type="date" id="txtDate" name="txtDate" value="{{ $hebahan[0]->tarikh }}" class="form-control" readonly />
                                    </div>
                                    <!-- Role -->
                                    <div class="mb-3">
                                        <label for="txtRoles" class="form-label">Kumpulan Sasaran : </label>
                                        <input type="text" id="txtRoles" name="txtRoles" value="{{ $hebahan[0]->name }}" class="form-control" readonly />
                                    </div>

                                    <!-- Entity -->
                                    <div class="mb-3">
                                        <label for="txtEntity" class="form-label">Kumpulan Sasaran : </label>
                                        <input type="text" id="txtEntity" name="txtEntity" value="{{ $hebahan[0]->entity_name }}" class="form-control" readonly />
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <!-- Penerangan -->
                                    <div class="form-group">
                                        <label for="txtDesc">Kandungan Hebahan : </label>
                                        <textarea name="txtDesc" id="txtDesc" class="form-control" rows="11" placeholder="" readonly>{{ $hebahan[0]->kandungan }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('hebahan.hebahanapprovelist.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>

                                <a href="{{ route('hebahan.hebahanapprovelist.editApprove', $id) }}" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Lulus</a>

                                <a href="{{ route('hebahan.hebahanapprovelist.editReject', $id) }}" class="btn btn-danger btn-sm"><i class="fas fa-ban"></i> Tolak</a>

                                <!--<button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Hebahan ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                </button><br/>-->
                            </div>
                            <br/>
                        </form>
                      </div>
                    </div>
                </div>
                
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript"> 

    bsCustomFileInput.init();

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

</script>
@endpush
