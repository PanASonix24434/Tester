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
                        <h3 class="mb-0">Tambah Negeri</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('master-data.states.index') }}">Data Utama</a></li>
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
                        <form id="form-state-add" method="POST" action="{{ route('master-data.states.store') }}" autocomplete="off">
                            @csrf

                        <!-- Tab content -->
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">

                                <!-- Negara -->
								<div class="mb-3">
									<label for="country" class="form-label">Negara : <span style="color:red;">*</span></label>
									<select id="country" class="form-control @error('country') is-invalid @enderror select2" name="country" required>
                                        <option value="">{{ __('app.please_select') }}</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
								</div>

                                <!-- Daerah -->
								<div class="mb-3">
									<label for="name" class="form-label">Negeri : <span style="color:red;">*</span></label>
									<input type="text" id="name" name="name" class="form-control" required="" />
								</div>

                          </div>
                        </div>
                        </form>

                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('master-data.states.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="event.preventDefault(); document.getElementById('form-state-add').submit();"><i class="fas fa-save"></i> Simpan</a>
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

</script>
@endpush
