@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">TAMBAH BAYARAN PERKHIDMATAN</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.rates.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-rates-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-rates-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.rates.store') }}" autocomplete="off">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Bayaran Perkhidmatan (%) : </label>
                                <input id="rates" name="rates" class="form-control" type="number" onchange="setTwoNumberDecimal" min="0" max="10" step="0.25" value="0.00" required/>    
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