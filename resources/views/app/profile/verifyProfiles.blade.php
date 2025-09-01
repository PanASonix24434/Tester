@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style type="text/css"></style>
<style>
    /* Target the DataTables length dropdown */
    #verificationTable_length {
        margin-left: -1%;
    }

    /* Remove bold styling for 'Papar rekod per halaman' */
    #verificationTable_length label {
        font-weight: normal;
    }

    /* Change 'Cari' to 'Carian' and make it not bold */
    #verificationTable_filter label {
        font-weight: normal;
        display: inline-block;
        margin-right: 8px;
    }

    #verificationTable_filter input {
        font-weight: normal;
        width: 150px; /* Make the search input smaller */
    }

   /* Remove all borders from the table */
#verificationTable {
    width: 100%; /* Ensure the table takes the full width */
    border-collapse: collapse;
    border: none; /* Remove all borders */
}

#verificationTable th, #verificationTable td {
    border-top: 1px solid #ddd; /* Keep horizontal borders on top */
    border-bottom: 1px solid #ddd; /* Keep horizontal borders on bottom */
    border-left: none;  /* Remove vertical left borders */
    border-right: none; /* Remove vertical right borders */
}

#verificationTable td:first-child, #verificationTable th:first-child {
    border-left: none; /* Ensure no left border for the first column */
}

#verificationTable td:last-child, #verificationTable th:last-child {
    border-right: none; /* Ensure no right border for the last column */
}

/* Adjust the width of the table to ensure it fits within the card */
.table-responsive {
    padding-right: 0; /* Remove any padding */
    margin-right: 0; /* Remove any margin */
}
</style>
@endpush

@section('content')
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="">Pengesahan Profil</h3>
                    </div>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        
        
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                            <h6 style="color: white; font-size: 0.9rem;"> SENARAI PENGESAHAN PROFIL (PEMOHON LESEN)</h6>
                        </div>
                        @if (session('status'))
                            <script>
                                window.onload = function() {
                                    alert("{{ session('status') }}");
                                };
                            </script>
                        @endif
                                        <div class="col-12">
                                                        <div class="form-group">
                                            <div id="shareholder-list" class="table-responsive">
                                                <table id="verificationTable" class="table dataTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 2%;">Bil</th>
                                                        <th style="width: 15%;">Jenis Pemohon</th>
                                                        <th>Nama</th>
                                                        <th>No Kad Pengenalan</th>
                                                        <th>Negeri</th>
                                                        <th>Daerah</th>
                                                        <th>Tarikh & Masa Kemaskini</th>
                                                        <th>Status</th>
                                                        <th style="text-align: center;">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($profiles->isNotEmpty())
                                                    @php $i = 1; @endphp
                                                        @foreach($profiles as $profile)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $profile->user->roles->first()->name ?? 'No role' }}</td>
                                                                <td>{{ $profile->name }}</td>
                                                                <td>{{ $profile->icno }}</td>
                                                                <td>{{ strtoupper($profile->negeri?->name_ms ?? '-') }}</td>
                                                                <td>{{ strtoupper($profile->daerah?->name_ms ?? '-') }}</td>
                                                                <td>{{ $profile->updated_at->format('d/m/Y h:i A') }}</td>
                                                                
                                                                <td>
                                                                    @if (is_null($profile->verify_status))
                                                                        <span class="badge bg-warning">Menunggu Pengesahan</span>
                                                                    @elseif ($profile->verify_status == 1)
                                                                        <span class="badge bg-success">Profil Disahkan</span>
                                                                    @elseif ($profile->verify_status == 0)
                                                                        <span class="badge bg-danger">Profil Tidak Disahkan</span>
                                                                    @endif

                                                                </td>
                                                                
                                                                <td class="text-center">
                                                                    <a href="{{ route('profile.showVerification', $profile->id) }}" class="btn btn-link p-0" style="color: #28a745;">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="6" class="text-center">No profiles found to verify.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            </div>
                                                    </div>
                                    </div>

                </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')
<!-- DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#verificationTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [5, 10, 25],
            columnDefs: [
                { targets: 0, orderable: false } // disable sorting on the first column (Bil)
            ],
            rowCallback: function(row, data, index) {
                // Update the Bil column dynamically
                $('td:eq(0)', row).html(index + 1); // The Bil column is the first column (index 0)
            },
            language: {
                search: "Cari:",
                lengthMenu: "Papar _MENU_ rekod per halaman",
                zeroRecords: "Tiada data dijumpai",
                info: "Paparan _PAGE_ dari _PAGES_",
                infoEmpty: "Tiada data tersedia",
                infoFiltered: "(ditapis dari _MAX_ rekod keseluruhan)"
            }
        });
    });
</script>



<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message
        });
    }
</script>
@endpush