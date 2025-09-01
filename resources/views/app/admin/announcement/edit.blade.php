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
                        <h3 class="mb-0">Kemaskini Pengumuman</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('administration.announcement.index') }}">Pengumuman</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Kemaskini Pengumuman</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('administration.announcement.update', $id) }}">
                            @csrf
                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-6">
                                    <!-- Tajuk -->
                                    <div class="mb-3">
                                        <label for="txtTitle" class="form-label">Tajuk : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtTitle" name="txtTitle" value="{{ $anns[0]->title }}" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="tarikh_mula" class="form-label">Tarikh Mula : <span style="color:red;">*</span></label>
                                        <input type="date" id="tarikh_mula" name="tarikh_mula" value="{{ $anns[0]->start_date }}" class="form-control" required />
                                    </div>
                                    @error('tarikh_mula')
                                        <span id="tarikh_mula_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="tarikh_hingga" class="form-label">Tarikh Hingga : <span style="color:red;">*</span></label>
                                        <input type="date" id="tarikh_hingga" name="tarikh_hingga" value="{{ $anns[0]->end_date }}" class="form-control" required />
                                    </div>
                                    @error('tarikh_hingga')
                                        <span id="tarikh_hingga_error" class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="col-lg-6">
                                    <!-- Penerangan -->
                                    <div class="form-group">
                                        <label for="txtDesc">Penerangan : <span style="color:red;">*</span></label>
                                        <textarea name="txtDesc" id="txtDesc" class="form-control" rows="9" required>{{ $anns[0]->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="">Lampiran : <small>Maksimum Saiz : 5MB </small></label>
                                        <div class="input-group">
                                          <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc">
                                            <label class="custom-file-label" for="fileDoc">Choose file</label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('administration.announcement.downloadDoc', $anns[0]->id) }}">{{ $anns[0]->file_name }}</a>
                                    </div>
                                </div>
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('administration.announcement.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengumuman ?</span>').text())">
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

    $(document).ready(function(){
			
        function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
	});

</script>
@endpush
