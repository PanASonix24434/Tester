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
            <div class="card mb-10 row">
              <!--  <div class="card-header bg-primary"> -->
                <div>
                    <!-- Page header -->
                    <div class="mb-5">
                        <br />
                      <label style="font:#007bff;">Senarai Tindakan</label>
                    </div>
                </div>
            <br />
            <div>
            <div class="form-container">
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-body">
                            <form method="GET" action="{{ route('appointment.approval.indexapprove') }}">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$apptApprove->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Bahagian</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Tarikh Lapor Diri</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($apptApprove as $a)
                                            <tr>                          
                                                <td>{{ $a->name }}</td>
                                                <td>{{ $a->icno }}</td>
                                                <td>{{ $a->department }}</td>
                                                <td>{{ $a->role }}</td>
                                                <td>{{ $a->report_date }}</td>
                                                <td><a href="{{ route('appointment.approval.editApprove',$a->id) }}"><i class="fas fa-search"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Bahagian</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Tarikh Lapor Diri</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
                                    </form>
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
    <script src="{{ asset('plugins/jstree/dist/jstree.min.js') }}"></script>
    <script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        $(function () {
            $('#jstree').jstree({
                'checkbox': {
                    keep_selected_style: false,
                    three_state: false,
                    cascade: ''
                },
                plugins: ['checkbox']
            }).on("changed.jstree", function (e, data) {
                if (!data.node) {
                    return;
                }
                var childrenNodes;
                if (data.node.state.selected) {
                    selectNodeAndAllParents($(this).jstree('get_parent', data.node));
                    childrenNodes = $.makeArray($(this).jstree('get_children_dom', data.node));
                    $(this).jstree('select_node', childrenNodes);
                } else {
                    childrenNodes = $.makeArray($tree.jstree('get_children_dom', data.node));
                    $(this).jstree('deselect_node', childrenNodes);
                }
            }).on('ready.jstree', function() { 
                $(this).jstree('open_all');
            });
        });

        function selectNodeAndAllParents(node) {
            var tree = $('#jstree');
            tree.jstree('select_node', node, true);
            var parent = tree.jstree('get_parent', node);
            if (parent) {
                selectNodeAndAllParents(parent);
            }
        };

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }    

    </script>
@endpush
