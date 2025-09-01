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
                        <h3 class="mb-0">Tambah Hebahan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('hebahan.hebahanlist.index') }}">Hebahan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Hebahan</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('hebahan.hebahanlist.store') }}">
                            @csrf
                            <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}">

                            <div class="card-body row">
                                <div class="col-lg-6">

                                    <!-- Tajuk Pekeliling -->
                                    <div class="mb-3">
                                        <label for="txtTitle" class="form-label">Tajuk Hebahan : <span style="color:red;">*</span></label>
                                        <input type="text" id="txtTitle" name="txtTitle" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtDate" class="form-label">Tarikh Hebahan : <span style="color:red;">*</span></label>
                                        <input type="date" id="txtDate" name="txtDate" class="form-control" required />
                                    </div>
                                    <!-- Role -->
                                    <div class="mb-3">
                                        <label class="form-label" for="selRoles">Kumpulan Sasaran : <span style="color:red;">*</span></label>
                                        <select class="form-select select2" id="selRoles" name="selRoles" autocomplete="off" height="100%" required>
                                            <option value="">{{ __('app.please_select')}}</option>
                                            @foreach($roles as $roles)
                                                <option value="{{$roles->id}}">{{$roles->name}}</option>
                                            @endforeach	
                                        </select>
                                    </div>
                                    <!-- Entity -->
                                    <div class="mb-3">
                                        <label class="form-label" for="selEntity">Kawasan Sasaran : <span style="color:red;">*</span></label>
                                        <select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%" required>
                                            <option value="">{{ __('app.please_select')}}</option>
                                            @foreach($entities as $entity)
                                                <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                            @endforeach	
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <!-- Penerangan -->
                                    <div class="form-group">
                                        <label for="txtDesc">Kandungan Hebahan : <span style="color:red;">*</span></label>
                                        <textarea name="txtDesc" id="txtDesc" class="form-control" rows="11" placeholder="" required></textarea>
                                    </div>
                                </div>
    
                                
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('hebahan.hebahanlist.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Hebahan ?</span>').text())">
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
