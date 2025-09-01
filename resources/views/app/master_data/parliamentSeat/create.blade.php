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
                        <h3 class="mb-0">Tambah Dewan Undangan Negeri (DUN)</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('master-data.districts.index') }}">Data Utama</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Tambah Data Utama</li>
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
                        <form id="form-parliament-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.aduns.store') }}" autocomplete="off">
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">

                                <!-- Negeri -->
								<div class="mb-3">
									<label for="state" class="form-label">Negeri : <span style="color:red;">*</span></label>
									<select id="state" class="form-control @error('state') is-invalid @enderror select2" name="state" required>
                                        <option value="">{{ __('app.please_select') }}</option>
                                        @foreach ($states as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
								</div>

                                <!-- Parlimen -->
								<div class="mb-3">
									<label for="parliament" class="form-label">Parlimen : <span style="color:red;">*</span></label>
									<select id="parliament" class="form-control @error('parliament') is-invalid @enderror select2" name="parliament" required>
                                        <option value="">{{ __('app.please_select') }}</option>
                                    </select>
								</div>

                                <!-- Kod DUN -->
								<div class="mb-3">
									<label for="code" class="form-label">Kod Dewan Undangan Negeri (DUN) : <span style="color:red;">*</span></label>
									<input type="text" id="code" name="code" class="form-control" required />
								</div>

                                <!-- Nama DUN -->
								<div class="mb-3">
									<label for="name" class="form-label">Nama Dewan Undangan Negeri (DUN) : <span style="color:red;">*</span></label>
									<input type="text" id="name" name="name" class="form-control" required />
								</div>

                          </div>
                        </div>
                        </form>

                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('master-data.aduns.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-parliament-add').submit();"><i class="fas fa-save"></i> Simpan</a>
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
<script type="text/javascript">   

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    $(document).ready(function(){
			$(document).on('change', '#state', function(){
				var prms_state = $('#state option:selected').val();
				var prms_parliament = $('#parliament');
				prms_parliament.empty();
				prms_parliament.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(prms_state){
					$.get("{{ url('master-data/parliaments') }}/"+prms_state, function(data){
						$.each(data, function(key,value){
							prms_parliament.append("<option value='"+value.id+"'>"+value.parliament_code+'-'+value.parliament_name+"</option>");
						});
					});
				}
			});
	});

</script>
@endpush
