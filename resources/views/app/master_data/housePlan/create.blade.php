@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">@yield('page_title')</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.aduns.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-parliament-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-parliament-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.plans.store') }}" autocomplete="off">
                        @csrf
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title">Nama Pelan</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror    
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for='path'>
                                    Dokumen Pelan Perumahan :
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="path" name="path">
                                        <label class="custom-file-label" for="path"></label>													
                                        </div>
                                </div>
                            </div> 
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
	<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
    bsCustomFileInput.init(); 

        $(document).ready(function(){
			$(document).on('change', '#state', function(){
				var prms_state = $('#state option:selected').val();
				var prms_parliament = $('#parliament');
				prms_parliament.empty();
				prms_parliament.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(prms_state){
					$.get("{{ url('app/parliament') }}/"+prms_state, function(data){
						$.each(data, function(key,value){
							prms_parliament.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	   });

    </script>
@endpush