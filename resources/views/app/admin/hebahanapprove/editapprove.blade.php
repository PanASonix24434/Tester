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
                        <h3 class="mb-0">Lulus Hebahan</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('hebahan.hebahanapprovelist.index') }}">Kelulusan Hebahan</a></li>
                              <li class="breadcrumb-item"><a href="{{ route('hebahan.hebahanapprovelist.edit', $id) }}">Lihat Hebahan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Lulus Hebahan</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('hebahan.hebahanapprovelist.updateApprove', $id) }}">
                            @csrf
                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-12">
                                    <!-- Ulasan Gagal -->
                                    <div class="form-group">
                                        <label for="txtApprove">Ulasan Diluluskan : <span style="color:red;">*</span></label>
                                        <textarea name="txtApprove" id="txtApprove" class="form-control" rows="7" placeholder="" required></textarea>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('hebahan.hebahanapprovelist.edit', $id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>

                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Lulus hebahan ?</span>').text())">
                                    <i class="fas fa-save"></i> Lulus
                                </button><br/>
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
