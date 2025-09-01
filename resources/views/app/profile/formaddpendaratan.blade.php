@extends('layouts.app')

@push('styles')
    <style type="text/css">
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
                    <div class="mb-8">
                        <h3 class="mb-0">Tambah Pendaratan</h3>
                    </div>
                </div>
                   
            </div>
           
            <div>
                <form method="POST" action="{{ route('profile.storePendaratan') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="vessel_id" name="vessel_id" value="{{ $vessel->id }}">
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Tambah Pendaratan </h4>
                            </div>

                                <div class="card-body">

                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Pelayaran No :</label>
                                        <div class="col-sm-9">
                                        <input type="text" name="pelayaran_no" class="form-control" required>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Bagi Bulan:</label>
                                        <div class="col-sm-9">
                                            <select name="bulan" class="form-control" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Mac</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Julai</option>
                                                <option value="8">Ogos</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Disember</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Jumlah Hari Di Laut:</label>
                                        <div class="col-sm-9">
                                        <input type="number" name="jumlah_hari_di_laut" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label">Tarikh & Masa (Berlepas):</label>
                                        <div class="col-sm-9">
                                        <input type="datetime-local" name="tarikh_berlepas" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label">Tarikh & Masa (Balik/Tiba):</label>
                                        <div class="col-sm-9">
                                        <input type="datetime-local" name="tarikh_tiba" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-sm-3 col-form-label">Purata Masa Sekali Memukat :</label>
                                        <div class="col-sm-9">
                                        <input type="text" name="purata_masa_memukat" class="form-control" required>
                                        </div>
                                    </div>


                                    

                                    <div class="row">

                                        <div class="col-sm-5">
                                            <div class="mb-3">
                                            <label>Dokumen (img/pdf)</label>
                                            <input type="file" name="dokumen" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-10">
                                           <button type="submit" class="btn btn-primary">Simpan</button>
                                       
                                            <a href="javascript:history.back()" class="btn btn-outline-white">
                                                Kembali <i class="icon-xxs"></i>
                                            </a>
                                       
                                    </div>
                                   
                                </div>
                        </div>
                    </div>
                </div>
                

            </form>
            </div>

        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

       bsCustomFileInput.init();

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

        

        
        

</script>   
@endpush
