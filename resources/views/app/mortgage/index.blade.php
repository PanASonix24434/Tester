@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h2>Pendaftaran Gadaian</h2>
                    <div class="card-tools">  
						
					</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
							<form method="GET" action="#">
                                <div class="input-group mb-3">
                                
                                    <span class="input-group-append">
                                       
                                    </span>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                   
                                    <thead>
                                            <tr>
                                                
                                                <th>{{__('app.no_file')}} </th>                                              
                                                <th> {{__('app.no_account')}}</th>
                                                <th>{{__('app.name')}}</th>
                                                <th>{{ __('app.icno') }}</th>
                                                <th>{{ __('app.icno_old') }}</th>
                                                <th> {{__('app.status')}}</th>
                                                <th>{{ __('app.date_status') }}</th>
                                                <th>{{ __('app.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>11221</td>
                                            <td>11221</td>
                                            <td>Muhammad bin Salleh</td>
                                            <td>971212054321</td>
                                            <td>TIADA</td>
                                            <td>DRAFT</td>
                                            <td>13-4-2024</td>
                                            <td> 
                                            <a href= "{{ route('mortgage.list.edit') }}"class="btn btn-default btn-s">
                                                <i class="nav-icon fas fa-edit"></i>
                                            </a>
                                            <a href= "{{ route('mortgage.list.export16A') }}"class="btn btn-default btn-s" target="_blank">
                                            <i class="nav-icon fas fa-print"></i>
                                            </a> 
                                            </td>
                                        </tr>
                                          
                                                
                                                    
                                    
                                   
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                              
                            </div>
                        </div>
                       
                            <div class="col-md-4">
                                <span class="float-md-right">
                                  
                                </span>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<!-- Page specific script -->
<script type="text/javascript">
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush