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
                            <h3 class="mb-0">Senarai Pengurus Vesel</h3>
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
                                                    <th>Nama Pengurus Vesel</th>
                                                    <th>No. Kad Pengenalan</th>
                                                    <th>No. Telefon</th>
                                                    <th>No. Pendaftaran Vesel Yang Diuruskan</th>
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
                ajax: "{{ route('profile_verification.vesselmanager.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'ref', name: 'ref'},
                    {data: 'phone', name: 'phone'},
                    {data: 'vessels_with_zones', name: 'vessels_with_zones'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
