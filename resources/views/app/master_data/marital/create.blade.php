@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">Add Marital Status</h3>
                    <div class="card-tools">
                        
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-marital-add" method="POST" action="{{ route('master-data.marital.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-form-label">Marital Status: </label>
                                    <input type="text" class="form-control" id="txtMarital" name="txtMarital" required autocomplete="off">
                                </div>	
                                @error('marital')
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <a href="{{ route('master-data.marital.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-marital-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection