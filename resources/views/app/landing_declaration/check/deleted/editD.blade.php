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
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" ria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
                    <form method="POST" action="{{ route('landingdeclaration.application.updateD',$app->id) }}">
                        @csrf
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">D. Maklumat Pendaratan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm table-responsive">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>12. Nama Spesies Ikan</th>
                                                            <th>13. Berat (KG)</th>
                                                            <th>14. Harga (RM/KG)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Isnin</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies1" name="txtSpecies1" value="{{ $landingInfo1!=null ? $landingInfo1->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg1" name="txtKg1" value="{{ $landingInfo1!=null ? $landingInfo1->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice1" name="txtPrice1" value="{{ $landingInfo1!=null ? $landingInfo1->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Selasa</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies2" name="txtSpecies2" value="{{ $landingInfo2!=null ? $landingInfo2->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg2" name="txtKg2" value="{{ $landingInfo2!=null ? $landingInfo2->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice2" name="txtPrice2" value="{{ $landingInfo2!=null ? $landingInfo2->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rabu</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies3" name="txtSpecies3" value="{{ $landingInfo3!=null ? $landingInfo3->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg3" name="txtKg3" value="{{ $landingInfo3!=null ? $landingInfo3->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice3" name="txtPrice3" value="{{ $landingInfo3!=null ? $landingInfo3->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Khamis</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies4" name="txtSpecies4" value="{{ $landingInfo4!=null ? $landingInfo4->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg4" name="txtKg4" value="{{ $landingInfo4!=null ? $landingInfo4->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice4" name="txtPrice4" value="{{ $landingInfo4!=null ? $landingInfo4->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumaat</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies5" name="txtSpecies5" value="{{ $landingInfo5!=null ? $landingInfo5->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg5" name="txtKg5" value="{{ $landingInfo5!=null ? $landingInfo5->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice5" name="txtPrice5" value="{{ $landingInfo5!=null ? $landingInfo5->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sabtu</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies6" name="txtSpecies6" value="{{ $landingInfo6!=null ? $landingInfo6->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg6" name="txtKg6" value="{{ $landingInfo6!=null ? $landingInfo6->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice6" name="txtPrice6" value="{{ $landingInfo6!=null ? $landingInfo6->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ahad</td>
                                                            <td>
                                                                <input type="text" id="txtSpecies7" name="txtSpecies7" value="{{ $landingInfo7!=null ? $landingInfo7->species_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtKg7" name="txtKg7" value="{{ $landingInfo7!=null ? $landingInfo7->kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" id="txtPrice7" name="txtPrice7" value="{{ $landingInfo7!=null ? $landingInfo7->price_per_kg : '' }}" class="form-control" min="0" step="0.01" required />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('landingdeclaration.application.editC',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengisytiharan Pendaratan?</span>').text())">
                                                        <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                                    </button>
                                                </div>
                                            </div>
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
