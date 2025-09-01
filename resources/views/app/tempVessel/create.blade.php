@extends('layouts.app')

@push('styles')
    <style type="text/css">
      textarea { text-transform: uppercase; }
    </style>
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
                        <h3 class="mb-0">Tambah Vesel</h3>
                    </div>
                </div>
            </div>
            <div>
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <!-- Card -->
                      <div class="card mb-10 row">
                        <form method="POST" action="{{ route('tempvessel.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label class="form-label" for="selOwner">Pemilik : <span style="color:red;">*</span></label>
                                            <select class="form-select select2" id="selOwner" name="selOwner" autocomplete="off" height="100%" width="100%" required>
                                                <option value="">{{ __('app.please_select')}}</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}} ({{$user->username}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label class="form-label" for="selZon">Zon : <span style="color:red;">*</span></label>
                                            <select class="form-select select2" id="selZon" name="selZon" autocomplete="off" height="100%" width="100%" required>
                                                <option value="">{{ __('app.please_select')}}</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="C2">C2</option>
                                                <option value="C3">C3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label for="vesselNumber" class="form-label">No. Vesel : <span style="color:red;">*</span></label>
                                            <input type="text" id="vesselNumber" class="form-control" name="vesselNumber" value="" required/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label for="grt" class="form-label">GRT : <span style="color:red;">*</span></label>
                                            <input type="number" id="grt" class="form-control" name="grt" value="" step="any" required/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label class="form-label" for="selEquipment">Peralatan Utama : <span style="color:red;">*</span></label>
                                            <select class="form-select select2" id="selEquipment" name="selEquipment" autocomplete="off" height="100%" width="100%" required>
                                                <option value="">{{ __('app.please_select')}}</option>
                                                @foreach($equipments as $equipment)
                                                    <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label class="form-label" for="selEntity">Pejabat Pangkalan : <span style="color:red;">*</span></label>
                                            <select class="form-select select2" id="selEntity" name="selEntity" autocomplete="off" height="100%" width="100%" required>
                                                <option value="">{{ __('app.please_select')}}</option>
                                                @foreach($entities as $entity)
                                                    <option value="{{$entity->id}}">{{$entity->entity_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-6">
                                            <label class="form-label" for="dateEnd">Tarikh Tamat Lesen : <span style="color:red;">*</span></label>
                                            <input type="date" id="dateEnd" class="form-control" name="dateEnd" value="" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                <a href="{{ route('tempvessel.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Data ?</span>').text())">
                                    <i class="fas fa-save"></i> {{ __('app.save') }}
                                </button><br/>
                            </div>
                            <br/>
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
<script type="text/javascript"> 


    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }

</script>
@endpush
