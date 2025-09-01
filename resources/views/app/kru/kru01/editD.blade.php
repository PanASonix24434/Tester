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
                                <li class="breadcrumb-item"><a href="{{ route('kadpendaftarannelayan.permohonan.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-7">
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header mb-0 bg-primary">
                                <span style="color: white;"><b>Dokumen Diperlukan</b></span>
                            </div>
                            <div class="card-body">
                                <div>1) Gambar Ukuran Passport</div>
                                <div>2) Salinan Kad Pengenalan</div>
                                <div>3) Penyata KWSP</div>
                                <div>4) <a href="{{ route('kruhelper.downloadPKN') }}" download><i class="fas fa-download"></i> Pemeriksaan Kesihatan Nelayan (PKN.01.2024)</a></div>
                            </div>
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
                                                    <a class="nav-link disabled" id="application-tab"
                                                    aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link disabled" id="address-tab"
                                                    aria-controls="address" aria-selected="false">Alamat Kru</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link disabled" id="contact-tab"
                                                    aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                                    aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link disabled" id="acknowledgement-tab"
                                                    aria-controls="acknowledgement" aria-selected="false">Perakuan</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content p-4" id="myTabContent">
                                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                                    <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('kadpendaftarannelayan.permohonan.updateDAddDoc',$id) }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Gambar Ukuran Pasport <span style="color: red;">*</span></label>
                                                                    <div class="input-group">
                                                                        @if ( $docPic != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $docPic->id) }}" target="_blank">{{$docPic->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $docPic->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="kruPic" name="kruPic" accept=".jpg, .jpeg, .png" required>
                                                                                <label class="custom-file-label" for="kruPic">Pilih Fail</label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @error('kruPic')
                                                                    <span id="selPosition_error" class="text-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Salinan Kad Pengenalan <span style="color: red;">*</span></label>
                                                                    <div>
                                                                        @if ( $docIc != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $docIc->id) }}" target="_blank">{{$docIc->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $docIc->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="kadPengenalanDoc" name="kadPengenalanDoc" required>
                                                                                <label class="custom-file-label" for="kadPengenalanDoc">Pilih Fail</label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Pemeriksaan Kesihatan Nelayan (PKN.01.2024) <span style="color: red;">*</span></label>
                                                                    <a href="{{ route('kruhelper.downloadPKN') }}" download><i class="fas fa-download"></i> Pemeriksaan Kesihatan Nelayan (PKN.01.2024).pdf</a>
                                                                    <div>
                                                                        @if ( $docPKN != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $docPKN->id) }}" target="_blank">{{$docPKN->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $docPKN->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="kesihatanNelayan" name="kesihatanNelayan" required>
                                                                                <label class="custom-file-label" for="kesihatanNelayan">Pilih Fail</label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Penyata KWSP <span style="color: red;">*</span></label>
                                                                    <div>
                                                                        @if ( $docKWSP != null)
                                                                            <a href="{{ route('kruhelper.previewKruDoc', $docKWSP->id) }}" target="_blank">{{$docKWSP->file_name}}</a>&nbsp;
                                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                                onclick="event.preventDefault(); if (confirm('Hapus Dokumen?')) {
                                                                                        document.getElementById('delete-link-form-{{ $docKWSP->id }}').submit();
                                                                                    }">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="kwsp" name="kwsp" required>
                                                                                <label class="custom-file-label" for="kwsp">Pilih Fail</label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="extraDoc">Dokumen Tambahan : <small>Maksimum Saiz : 5MB </small></label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="extraDoc" name="extraDoc">
                                                                            <label class="custom-file-label" for="extraDoc">Pilih Fail</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="description">Keterangan bagi Dokumen Tambahan</label>
                                                                    <input type="text" name="description" class="form-control" id="description" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="row">
                                                        <div class="col-sm-12 table-responsive">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Senarai Dokumen Tambahan:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:1%;">Bil</th>
                                                                        <th>Tarikh Dicipta</th>
                                                                        <th>Dokumen</th>
                                                                        <th>Tindakan Oleh</th>
                                                                        <th>Hapus</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="listDoc">
                                                                    @if (!$docExtra->isEmpty())
                                                                        @php
                                                                            $count = 0;
                                                                        @endphp
                                                                        @foreach ($docExtra as $doc)
                                                                            <tr>
                                                                                <td>{{++$count}}</td>
                                                                                <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                                <td><a href="{{ route('kruhelper.previewKruDoc', $doc->id) }}" target="_blank">{{$doc->description}}</a></td>
                                                                                <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                                                <td style="text-align: center; vertical-align: middle;">
                                                                                    <form method="post" action="{{ route('kruhelper.deleteKruDoc',$doc->id) }}"> 
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" onclick="return confirm($('<span>Hapus Dokumen?</span>').text())" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="5" style="text-align: center;">-Tiada Dokumen Tambahan-</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                            <a href="{{ route('kadpendaftarannelayan.permohonan.editC',$id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                            <button id="submitButton" type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-save"></i> Simpan & Seterusnya
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @if ( $docIc != null)
                                    <form id="delete-link-form-{{ $docIc->id }}" 
                                        action="{{route('kruhelper.deleteKruDoc',$docIc->id)}}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                                @if ( $docPic != null)
                                    <form id="delete-link-form-{{ $docPic->id }}" 
                                        action="{{route('kruhelper.deleteKruDoc',$docPic->id)}}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                                @if ( $docPKN != null)
                                    <form id="delete-link-form-{{ $docPKN->id }}" 
                                        action="{{route('kruhelper.deleteKruDoc',$docPKN->id)}}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                                @if ( $docKWSP != null)
                                    <form id="delete-link-form-{{ $docKWSP->id }}" 
                                        action="{{route('kruhelper.deleteKruDoc',$docKWSP->id)}}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();

            $('#submitButton').on('click', function() {
				// e.preventDefault();
                if (confirm('Simpan Dokumen?')) {
                    if ($('#form').valid()) { 
                        $('#form').submit();
                    }
                }
            });
            
			$('#form').validate({
                rules: {
                    kruPic: {
                        required: true,
                    },
                    kadPengenalanDoc: {
                        required: true,
                    },
                    kesihatanNelayan: {
                        required: true,
                    },
                    kwsp: {
                        required: true,
                    }
                },
                messages: {
                    kruPic: {
                        required: "Medan ini diperlukan.",
                    },
                    kadPengenalanDoc: {
                        required: "Medan ini diperlukan.",
                    },
                    kesihatanNelayan: {
                        required: "Medan ini diperlukan.",
                    },
                    kwsp: {
                        required: "Medan ini diperlukan.",
                    }
                },
				errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('text-danger');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
			});
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }
    </script>
@endpush
