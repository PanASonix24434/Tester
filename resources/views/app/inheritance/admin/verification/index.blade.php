@extends('layouts.app_new')

@push('styles')
    @include('inc.datatables_css')
@endpush

@section('content')
    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Senarai Pentadbir Harta / Pewaris</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="table-data" class="table table-centered mt-0 dataTable no-footer dtr-inline collapsed" style="width: 100%;" role="grid">
                                            <thead class="table-light">
                                                <tr role="row">
                                                    <th style="width:1%;">Bil</th>
                                                    <th>Nama</th>
                                                    <th>No. Kad Pengenalan</th>
                                                    <th>No. Telefon</th>
                                                    <th>Alamat Emel</th>
                                                    {{-- <th>Nama Pemilik Vesel</th> --}}
                                                    <th>Status Pengguna</th>
                                                    <th class="dt-body-nowrap">Vesel Yang Terlibat</th>
                                                    <th>Status</th>
                                                    <th class="dt-body-nowrap">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('inc.datatables_js')
    @include('inc.sweetalert')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table-data').DataTable({
                serverSide: true,
                order: [],
                ajax: "{{ route('profile_verification.inheritance.admin.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'icno', name: 'icno'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'status_pengguna', name: 'status_pengguna'},
                    {data: 'no_vesel', name: 'no_vesel'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
