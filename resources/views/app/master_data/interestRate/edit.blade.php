@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">KEMASKINI BAYARAN PERKHIDMATAN</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.rates.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-rates-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-rates-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.rates.update', $rate->id) }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="rates">Bayaran Perkhidmatan (%) : </label>
                                    <input id="rates" name="rates" class="form-control" type="number" onchange="setTwoNumberDecimal" min="0" max="10" step="0.25" value="{{ $rate->interest_rate_value }}" disabled/>    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status : </label>
                                    <select class="form-control select2" id="status" name="status" required autocomplete="off">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @if ($rate->is_active == true || $rate->is_active == '1')
                                            <option value="1" selected>AKTIF</option>
                                            <option value="0">TIDAK AKTIF</option>
                                        @else
                                            <option value="1">AKTIF</option>
                                            <option value="0" selected>TIDAK AKTIF</option>
                                        @endif
                                        
                                    </select>   
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
			
            function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
}
	   });

    </script>
@endpush