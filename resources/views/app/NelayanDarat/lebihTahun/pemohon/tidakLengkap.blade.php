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
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">PERMOHONAN PEMBAHARUAN LESEN LEBIH 1 TAHUN</h3>
                        <small>Kemaskini - Pemohon</small>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>

            <div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"></div>
                           <div class="card-body">
                                <form action="{{ route('lebihTahun.permohonan-07.storeTidakLengkap', $application->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                            
                                    <!-- Officer Feedback (Read-Only) -->
                                    <div class="mb-3">
                                        <label for="officerFeedback" class="form-label">Maklum Balas Pegawai</label>
                                        <textarea class="form-control" id="officerFeedback" rows="5"
                                            readonly>{{ $applicationLogs->remarks ?? 'Tiada maklum balas diberikan.' }}</textarea>
                                    </div>
                            
                                    <!-- User Statement -->
                                    <div class="mb-3">
                                        <label for="userStatement" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="userStatement" name="user_statement" rows="5" required></textarea>
                                    </div>
                            
                                    <!-- Document Upload Table -->
                                    <div class="mb-3">
                                        <label class="form-label">Muat Naik Dokumen</label>
                                        <table class="table table-bordered" id="documentTable">
                                            <thead>
                                                <tr>
                                                    <th>Fail</th>
                                                    <th>Deskripsi</th>
                                                    <th class="text-center">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="file" name="document_file[]" class="form-control" required></td>
                                                    <td><input type="text" name="document_description[]" class="form-control"
                                                            placeholder="Masukkan deskripsi dokumen" required></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm removeRow"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary mt-2 col-md-1" id="addRow"> + Tambah</button>
                                    </div>
                            
                                    <br>
                            
                                    <div class="card-headerpl-0">
                                        <h4>Dokumen Di Muat Naik</h4>
                                    </div>
                                    <hr>
                            
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Fail</th>
                                                <th>Keterangan</th>
                                                <th>Tarikh Muat Naik</th>
                            
                                                <th class="col-md-2">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($uploadedFiles->count())
                                            @foreach ($uploadedFiles as $file)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ basename($file->name) }}</td>
                                                <td>{{ $file->description}}</td>
                                                <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                            
                                                    <a class="btn btn-primary  col-md"
                                                        href="{{ route('lebihTahun.permohonan-07.viewFile', $file->id) }}" target="_blank">
                                                        <i class="fa fa-eye pr-2"></i> Lihat
                                                    </a>
                            
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="4">Tiada dokumen
                                                    dimuat naik.</td>
                                            </tr>
                                            @endif
                                            <tr></tr>
                                        </tbody>
                                    </table>
                            
                                    <br>
                            
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success col-md-1 mr-4">Hantar</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
                    // Convert all prefilled input and textarea values to uppercase
                    $("input[type=text], textarea").each(function() {
                        const currentVal = $(this).val();
                        if (currentVal && typeof currentVal === "string") {
                            $(this).val(currentVal.toUpperCase());
                        }
                    });
    
                    // Dynamic input conversion as the user types
                    $(document).on('input', "input[type=text], textarea", function() {
                        $(this).val(function(_, val) {
                            return val.toUpperCase();
                        });
                    });
                });
    
                // Display success message from Laravel session
                var msgSuccess = '{{ Session::get('success') }}';
                var existSuccess = '{{ Session::has('success') }}';
                if (existSuccess) {
                    alert(msgSuccess);
                }
    
                // Display error message from Laravel session
                var msgError = '{{ Session::get('error') }}';
                var existError = '{{ Session::has('error') }}';
                if (existError) {
                    alert(msgError);
                }
    </script>

    <script>
        // Add a new row for uploading documents
            $(document).on('click', '#addRow', function() {
                var newRow = '<tr>' +
                    '<td><input type="file" name="document_file[]" class="form-control" required></td>' +
                    '<td><input type="text" name="document_description[]" class="form-control" placeholder="Masukkan deskripsi dokumen" required></td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>';
                $('#documentTable tbody').append(newRow);
            });

            // Remove row functionality
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });
    </script>
    @endpush