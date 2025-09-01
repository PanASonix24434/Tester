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
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Tambah Peranan</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
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
                                <a class="nav-link active" id="role-tab" data-bs-toggle="tab" href="#role" role="tab"
                                  aria-controls="role" aria-selected="true">Nama Peranan</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="access-tab" data-bs-toggle="tab" href="#access" role="tab"
                                  aria-controls="access" aria-selected="false">Akses Peranan</a>
                              </li>
                            </ul>
                            <div class="tab-content p-4" id="myTabContent">
                              <div class="tab-pane fade show active" id="role" role="tabpanel" aria-labelledby="role-tab">
                                <p>Consequat occaecat ullamco amet non eiusmod nostrud dolore irure incididunt est duis
                                  anim
                                  sunt officia. Fugiat velit proident aliquip nisi incididunt nostrud exercitation
                                  proident
                                  est nisi. Irure
                                  magna elit commodo anim ex veniam culpa eiusmod id nostrud sit cupidatat in veniam ad.
                                  Eiusmod consequat eu adipisicing minim anim aliquip cupidatat culpa excepteur quis.
                                  Occaecat sit eu exercitation
                                  irure Lorem incididunt nostrud.</p>
                              </div>
                              <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
                                    @include('app.admin.role.permission_tree')
                                    <input id="permissions" type="hidden" name="permissions" value="">
                              </div>
                            </div>
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

        function getSelectedPermissions() {
            var tree = $('#jstree');
            var permissions = [];
            var selectedPermissions = tree.jstree('get_selected', true);
            for (var i = 0; i < selectedPermissions.length; i++) {
                permissions.push(selectedPermissions[i].id);
            }
            document.getElementById('permissions').value = permissions.join(", ");
        };
    </script>
@endpush
