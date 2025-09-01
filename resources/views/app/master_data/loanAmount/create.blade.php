@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">TAMBAH HAD PINJAMAN MAKSIMUM</h3>
                    <div class="card-tools">
                        <a href="{{ route('master-data.amount.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-amount-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-amount-add" method="POST" enctype="multipart/form-data" action="{{ route('master-data.amount.store') }}" autocomplete="off">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Had Pinjaman Maksimum (RM) : </label>
                                <input id="amount" name="amount" class="form-control" type="number" onchange="setTwoNumberDecimal" min="0" max="100000" step="10000.00" value="0.00" required/>    
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