@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Add Dealer</h3>
                    <div class="card-tools">
                        
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-dealer-add" method="POST" action="{{ route('master-data.dealer.store') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">
                        <div class="form-group row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Dealer Name : </label>
                                    <input type="text" class="form-control" id="txtDealerName" name="txtDealerName" value="{{ old('txtDealerName') }}" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Dealer Code : </label>
                                    <input type="text" class="form-control" id="txtDealerCode" name="txtDealerCode" value="{{ old('txtDealerCode') }}" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Phone No. : </label>
                                    <input type="text" class="form-control" id="txtPhoneNo" name="txtPhoneNo" value="{{ old('txtPhoneNo') }}" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Fax No. : </label>
                                    <input type="text" class="form-control" id="txtFaxNo" name="txtFaxNo" value="{{ old('txtFaxNo') }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Contact Person : </label>
                                    <input type="text" class="form-control" id="txtContactPerson" name="txtContactPerson" value="{{ old('txtContactPerson') }}" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Email : </label>
                                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="{{ old('txtEmail') }}" required autocomplete="off">
                                </div>	
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Address : </label>
                                    <input type="text" id="txtAddress1" name="txtAddress1" value="{{ old('txtAddress1') }}" class="form-control" required autocomplete="off">
                                    <input type="text" id="txtAddress2" name="txtAddress2" value="{{ old('txtAddress2') }}" class="form-control" autocomplete="off">
                                    <input type="text" id="txtAddress3" name="txtAddress3" value="{{ old('txtAddress3') }}" class="form-control" autocomplete="off">
                                </div>
                                <br/>
                                <div class="form-group">
                                    <label class="col-form-label">Postcode : </label>
                                    <input type="number" id="txtPostcode" name="txtPostcode" value="" maxlength="5" minlength="5" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">City : </label>
                                    <input type="text" id="txtCity" name="txtCity" value="" class="form-control" required>
                                </div>
                                <div class="form-group">	
                                    <label class="col-form-label">State : </label>
                                    <select class="form-control select2" id="selState" name="selState" required autocomplete="off">
                                        <option value="">{{ __('app.please_select')}}</option>
                                        @foreach($states as $st)
                                            <option value="{{$st->id}}">{{ (App::getLocale() == 'en') ? $st->name : $st->name_ms }}</option>
                                        @endforeach	
                                    </select>
                                </div>    	
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <a href="{{ route('master-data.dealer.index') }}" class="btn btn-default btn-sm"><i class="fas fa-times"></i><span class="hidden-xs"> {{ __('app.back') }}</span></a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="event.preventDefault(); document.getElementById('form-dealer-add').submit();"><i class="fas fa-save"></i><span class="hidden-xs"> {{ __('app.save') }}</span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection