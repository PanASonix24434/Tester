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
                        <h3 class="mb-0">Kemaskini Peranan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('administration.roles.index') }}">Peranan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Kemaskini Peranan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10">
                        <form id="form-role-update" method="POST" action="{{ route('administration.roles.update', $role->id) }}" onclick="return getSelectedPermissions()">
                            @method('PUT')
                            @csrf

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
                                
                                <!-- RoleName -->
								<div class="mb-3">
									<label for="name" class="form-label">Nama Peranan : <span style="color:red;">*</span></label>
									<input type="text" id="name" name="name" class="form-control" value="{{ $role->name }}" required="" />
								</div>

                                <!-- Dalaman / Luaran -->
								<div class="mb-3">
                                    <label class="form-label" for="selRoleType">Jenis Peranan : <span style="color:red;">*</span></label>
									<select class="form-select" id="selRoleType" name="selRoleType" autocomplete="off" height="100%" required>
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @if ($role->name == 'PELESEN' || $role->name == 'PENGUSAHA SKL' || $role->name == 'AMANAH RAYA')
                                        <option value="1" >DALAMAN</option>
                                        <option value="2" selected>LUARAN</option>
                                        @else
                                        <option value="1" selected>DALAMAN</option>
                                        <option value="2">LUARAN</option>
                                        @endif
                                        
                                    </select>
								</div>

                                 <!-- Quota -->
								<div class="mb-3">
									<label id="lblQuota" for="txtQuota" class="form-label">Bil. Kuota : </label>
									<input type="number" id="txtQuota" name="txtQuota" value="{{ $role->quota }}" class="form-control" required/>
								</div>

                                <!-- Entity -->
								<div class="mb-3">
                                    <label id="lblSelEntity" class="form-label" for="selectOne">Pejabat Bertugas : </label>
									<select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" required height="100%">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @foreach($entities as $entity)
                                            @if ($role->entity_id == $entity->id)
                                            <option value="{{$entity->id}}" selected>{{$entity->entity_name}}</option>
                                            @else
                                            <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                            @endif
                                        @endforeach	
                                    </select>
								</div>

                              </div>
                              <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
                                <div id="permissions-tree" style="display:none;">
                                    @include('app.admin.role.permission_tree')
                                    <input id="permissions" type="hidden" name="permissions" value="">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        </form>

                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('administration.roles.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-role-update').submit();"><i class="fas fa-save"></i> Simpan</a>
                        </div><br/>

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

        var prms_roletype = $('#selRoleType option:selected').val();
                
                if(prms_roletype == 1){
                    document.getElementById("txtQuota").required = true;
                    document.getElementById('lblQuota').innerHTML = 'Bil. Kuota :  <span style="color: red;">*</span>';

                    document.getElementById("selEntity").required = true;
                    document.getElementById('lblSelEntity').innerHTML = 'Pejabat Bertugas :  <span style="color: red;">*</span>';
                }
                else{
                    document.getElementById("txtQuota").required = false;
                    document.getElementById('lblQuota').innerHTML = 'Bil. Kuota :  ';

                    document.getElementById("selEntity").required = false;
                    document.getElementById('lblSelEntity').innerHTML = 'Pejabat Bertugas :  ';
                }

        $(function () {
            $('#permissions-tree').delay(500).fadeIn();
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
                } // else {
                //    childrenNodes = $.makeArray($tree.jstree('get_children_dom', data.node));
                //    $(this).jstree('deselect_node', childrenNodes);
                //}
            }).on('ready.jstree', function() { 
                $(this).jstree('open_all');
                @foreach (Module::getAll(true) as $permission)
                    @if ($role->hasModule($permission->id))
                        $(this).jstree('select_node', '{{ $permission->id }}');
                    @endif
                @endforeach
                @foreach (Module::getAll(true) as $permission)
                    @if (!$role->hasModule($permission->id))
                        $(this).jstree('deselect_node', '{{ $permission->id }}');
                    @endif
                @endforeach
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


        $(document).ready(function(){

            //Nama Peranan
            $('#name').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if ( String.fromCharCode(charCode).match(/[a-zA-Z() ]/g) ){

                }
                else{
                    return false; 
                }    
                                        
            }); 

            //Role Type
            $(document).on('change', '#selRoleType', function(){
                var prms_roletype = $('#selRoleType option:selected').val();
                
                if(prms_roletype == 1){
                    document.getElementById("txtQuota").required = true;
                    document.getElementById('lblQuota').innerHTML = 'Bil. Kuota :  <span style="color: red;">*</span>';

                    document.getElementById("selEntity").required = true;
                    document.getElementById('lblSelEntity').innerHTML = 'Pejabat Bertugas :  <span style="color: red;">*</span>';
                }
                else{
                    document.getElementById("txtQuota").required = false;
                    document.getElementById('lblQuota').innerHTML = 'Bil. Kuota :  ';

                    document.getElementById("selEntity").required = false;
                    document.getElementById('lblSelEntity').innerHTML = 'Pejabat Bertugas :  ';
                }
            });

        });

    </script>
@endpush
