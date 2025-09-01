@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">Add Individual Type</h3>
                    <div class="card-tools">
                        
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-individual-add" method="POST" action="{{ route('master-data.individual.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-form-label">Individual Type: </label>
                                    <input type="text" class="form-control" id="txtIndividual" name="txtIndividual" value="{{ old('txtIndividual') }}" required autocomplete="off">
                                </div>	
                                @error('individual')
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <a href="{{ route('master-data.individual.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-individual-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection