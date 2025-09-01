@extends('layouts.app')

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
                        <h3 class="mb-0">Lihat Aduan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('complaint2.complaintlist') }}">Aduan</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Lihat Aduan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
              <!-- card  -->
              <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
                <div class="card h-100">
                  <!-- card header  -->
                  <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                      <h4 class="mb-0" style="color:white;">BUTIRAN ADUAN </h4>
                  </div>
                  <!-- table  -->
                  <div class="card-body">

                    <div class="form-group">
                      <label for="txtComplaintNo">No Aduan : </label>
                      <input type="text" class="form-control" name="txtComplaintNo" id="txtComplaintNo" value="#{{ sprintf('%06d', $complaints->complaint_no) }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="txtComplaintType">Jenis Aduan : </label>
                      <input type="text" class="form-control" name="txtComplaintType" id="txtComplaintType" value="{{ strtoupper($complaints->complaint_type) }}" readonly>
                    </div>
      
                    <div class="form-group">
                      <label for="txtTitle">Tajuk : </label>
                      <input type="text" class="form-control" name="txtTitle" id="txtTitle" value="{{ strtoupper($complaints->title) }}" readonly>
                    </div>
      
                    <div class="form-group">
                      <label for="txtDesc">Butiran Aduan : </label>
                      <textarea name="txtDesc" id="txtDesc" class="form-control" rows="7" readonly>{{ strtoupper($complaints->description) }}</textarea>
                    </div>
      
                    <div class="form-group" style="margin-top:28px;">
                      <label for="">Lampiran : </label>
                      @if (!empty( $complaints->file_path ))
                        <a href="{{ route('complaint2.downloadDoc', $complaints->id) }}">{{ $complaints->file_name }}</a>                       
                      @endif
                    

                    </div>

                  </div>
                </div>
              </div>
              <!-- card  -->
              <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
                  <div class="card h-100">
                      <!-- card header  -->
                      <div class="card-header bg-primary">
                          <h4 class="mb-0" style="color:white;">MAKLUMAT PENGADU </h4>
                      </div>
                      <!-- table  -->
                      <div class="card-body" >
                          
                        <div class="form-group">
                          <label for="txtName">Nama Penuh : </label>
                          <input type="text" class="form-control" name="txtName" id="txtName" value="{{ strtoupper($complaints->name) }}" readonly>
                        </div>        

                        <div class="mb-3">
                          <label for="txtPhoneNo" class="form-label">No. Telefon Bimbit <small>[ Tanpa(-) ]</small> : <span style="color:red;">*</span></label>
                          <input type="text" class="form-control" name="txtPhoneNo" id="txtPhoneNo" value="{{ strtoupper($complaints->phone_no) }}" readonly>
                        </div>
          
                        <div class="form-group">
                          <label for="txtEmel">Emel : </label>
                          <input type="email" class="form-control" name="txtEmel" id="txtEmel" value="{{ $complaints->email }}" readonly>
                        </div><br/>

                        <!--<div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                          <a href="{{ route('welcome') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> Hantar</button>
                        </div><br/><br/>-->

                      </div>
                  </div>
              </div>
          </div>

          <div class="row">
            <!-- card  -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-5 mb-xl-0">
              <div class="card h-100">
                <!-- card header  -->
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h4 class="mb-0" style="color:white;">LOG ADUAN </h4>
                </div>
                <!-- table  -->
                <div class="card-body">

                  <div class="table-responsive table-card">
                    <table class="table text-nowrap mb-0 table-centered table-hover">
                    @if (!$complaintLogs->isEmpty())
                        <thead class="table-light">
                            <tr>
                                <th><b>Catatan</b></th>
                                <th><b>Status</b></th>
                                <th><b>Dikemaskini Oleh</b></th>
                                <th><b>Dikemaskini Pada</b></th>                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaintLogs as $a)
                            <tr>
                                <td>{{ strtoupper($a->remark) }}</td>

                                @if ($a->status == 1)
                                <td>DIHANTAR</td>
                                @elseif ($a->status == 2)
                                <td>DALAM TINDAKAN</td>
                                @elseif($a->status == 3)
                                <td>SELESAI</td>
                                @endif

                                @if ($a->status == 1)
                                  <td>{{ strtoupper($complaints->name) }}</td>
                                @else
                                  @if (!empty($a->updated_by))
                                  <td>{{ strtoupper(App\Models\User::withTrashed()->find($a->updated_by)->name) }}</td>
                                  @else
                                  <td></td>  
                                  @endif
                                @endif

                                <td>{{ $a->updated_at->format('d/m/Y h:i:s A') }}</td>                                
                            </tr>
                            @endforeach
                        </tbody>
                    @else
                        <thead>
                            <tr>
                              <th><b>Catatan</b></th>
                              <th><b>Status</b></th>
                              <th><b>Dikemaskini Oleh</b></th>
                              <th><b>Dikemaskini Pada</b></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">{{ __('app.no_record_found') }}</td>
                            </tr>
                        </tbody>
                    @endif
                    </table>
                  </div>

                </div>
                <div class="card-footer d-md-flex justify-content-between align-items-center">
                  <div class="col-md-8">
                    <div class="table-responsive">
                      {!! $complaintLogs->appends(Request::except('page'))->render() !!}
                    </div>
                  </div>
                  @if (!$complaintLogs->isEmpty())
                    <div class="col-md-4">
                      <span class="float-md-right">
                        {{ __('app.table_info', [ 'first' => $complaintLogs->firstItem(), 'last' => $complaintLogs->lastItem(), 'total' => $complaintLogs->total() ]) }}
                      </span>
                    </div>
                  @endif
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
                          <a href="{{ route('complaint2.complaintlist') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                          @if ($complaints->complaint_status == 1 || $complaints->complaint_status == 2)
                            <a href="{{ route('complaint2.editAssign', $id) }}" class="btn btn-success"><i class="fas fa-save"></i><span class="hidden-xs"> Tugaskan</span></a>
                            <a href="{{ route('complaint2.editSolve', $id) }}" class="btn btn-primary"><i class="fas fa-save"></i><span class="hidden-xs"> Selesai</span></a>
                          @endif
                          
                      </div>
                  </li>
              </ul>
          </div><br/>
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

</script>
@endpush
