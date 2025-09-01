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
                <div class="col-md-9">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Kemaskini Pekeliling</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('administration.pekeliling.index') }}">Pekeliling</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Kemaskini Pekeliling</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('administration.pekeliling.update', $id) }}">
                            @csrf

                            <div class="card-body row">
                                <div class="col-lg-6">
                                    <!-- Nama Pekeliling -->
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Bilangan Pekeliling : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtName" name="txtName" value="{{ $pekeliling[0]->nama }}" class="form-control" required />
                                    </div>
                                    <!-- Tajuk Pekeliling -->
                                    <div class="mb-3">
                                        <label for="txtTitle" class="form-label">Tajuk Pekeliling : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtTitle" name="txtTitle" value="{{ $pekeliling[0]->tajuk }}" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtDate" class="form-label">Tarikh Pekeliling : <span style="color:red;">*</span></label>
                                        <input type="date" id="txtDate" name="txtDate" value="{{ $pekeliling[0]->tarikh }}" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtRefNo" class="form-label">No Rujukan Surat Pekeliling : <span style="color:red;">*</span></label>
                                        <input type="text1" id="txtRefNo" name="txtRefNo" value="{{ $pekeliling[0]->no_rujukan }}" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Lampiran : <small>Maksimum Saiz : 5MB </small><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc">
                                            <label class="custom-file-label" for="fileDoc">Choose file</label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('administration.pekeliling.downloadDoc', $pekeliling[0]->id) }}">{{ $pekeliling[0]->file_name }}</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <!-- Penerangan -->
                                    <div class="form-group">
                                        <label for="txtDesc">Kandungan Pekeliling : <span style="color:red;">*</span></label>
                                        <textarea name="txtDesc" id="txtDesc" class="form-control" rows="16" placeholder="" required>{{ $pekeliling[0]->kandungan }}</textarea>
                                    </div>
                                </div>
    
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('administration.pekeliling.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pekeliling ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
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
