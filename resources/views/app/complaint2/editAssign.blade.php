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
          <form method="POST" action="{{ route('complaint2.updateAssign', $id) }}">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Tugaskan Aduan</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('complaint2.complaintlist') }}">Aduan</a></li>
                              <li class="breadcrumb-item"><a href="{{ route('complaint2.complaintview', $id) }}">Lihat Aduan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tugaskan Aduan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>


          <div class="row">
            <!-- card  -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
              <div class="card h-100">
                <!-- card header  -->
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h4 class="mb-0" style="color:white;">TUGASKAN ADUAN </h4>
                </div>
                <!-- table  -->
                <div class="card-body">

                  <div class="form-group">
                    <label for="txtComplaintNo">No Aduan : </label>
                    <input type="text" class="form-control" name="txtComplaintNo" id="txtComplaintNo" value="#{{ sprintf('%06d', $complaints->complaint_no) }}" disabled>
                  </div>
      
                  <div class="form-group">
                    <label for="selAssign">Tugaskan Kepada : <span style="color:red;">*</span></label>
                    <select class="form-control select2" id="selAssign" name="selAssign" required autocomplete="off">
                      <option value="">{{ __('app.please_select')}}</option>
                      @foreach($roles as $a)
                          <option value="{{$a->id}}">{{$a->name}}</option>
                      @endforeach											
                  </select>
                  </div>
      
                  <div class="form-group">
                    <label for="txtRemark">Catatan : </label>
                    <textarea name="txtRemark" id="txtRemark" class="form-control" rows="7" placeholder=""></textarea>
                  </div>

                </div>

              </div>
            </div>
        </div>

        <!-- End of row -->
        <div class="form-group card">
          <div class="profile-info w-100" style="margin-bottom: -30px;">
              <ul class="list-group list-group-unbordered mb-3 w-100" style="margin-top: 20px;">
                  <li class="list-group-item w-100 d-flex justify-content-center align-items-center" style="border-bottom: none;">
                      <div style="display: flex; gap: 10px;">
                          
                        <a href="{{ route('complaint2.complaintview', $id) }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <button type="submit" class="btn btn-primary" onclick="return confirm($('<span>Tugaskan Aduan ?</span>').text())">
                          <i class="fas fa-save"></i> Simpan
						            </button>
                          
                      </div>
                  </li>
              </ul>
          </div><br/>
        </div>
      </form>
            
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

</script>
@endpush
