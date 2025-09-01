@extends('layouts.app')
@include('layouts.page_title')
@push('styles')
	<link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<style type="text/css">
		.card-title a {
			font-weight: bold;
		}
	</style>
@endpush
@section('content')

	<div class="row">
        <div class="col-md-12">
		  <form id="form-application-category" method="POST" action="#" autocomplete="off">
		  <input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
			<input type="hidden" id="hide_tc" name="hide_tc" value="">	
			<input type="hidden" id="urlLB" name="urlLB" value="">	
           	<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title bold">Kategori Permohonan</h3>
				</div>
				<div class="card-body">
					<div class="row"> 
						<!--<div class="col-sm-12"> 
							<div class="form-group">	
								<label class="col-form-label">Kategori Permohonan : </label>
								<select class="form-control" id="selAppCategory" name="category_application" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									<option value="Pensijilan MyGAP/FQC/MyGMP/MyHOB">Pensijilan MyGAP/FQC/MyGMP/MyHOB</option>
									<option value="Makmal">Makmal</option>										
								</select>
							</div>								
						</div>-->
						<div class="col-sm-6">										
							<div class="form-group">
								<label class="col-form-label">
									Kategori Permohonan :  <span style="color: red;">*</span>
								</label>
								<div class="card">
									<div class="card-body">													
										<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
											<input id="is_cert" type="checkbox" class="custom-control-input" name="is_cert" value="true" >
											<label for="is_cert" class="custom-control-label">Pensijilan MyGAP/FQC/MyGMP/MyHOB</label>
										</div>
										<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
											<input id="is_lab" type="checkbox" class="custom-control-input" name="is_lab" value="true" >
											<label for="is_lab" class="custom-control-label">Makmal</label>
										</div>													
									</div>
								</div>
							</div>																						
						</div>
						<div class="col-sm-6"> 
							<div class="form-group">	
								<label class="col-form-label">{{ __('app.category_staff')}} : </label>
								<select class="form-control" id="selAppStaff" name="category_staff" required autocomplete="off">
									<option value="">{{ __('app.please_select')}}</option>
									<option value="{{ __('app.staff')}}">{{ __('app.staff')}}</option>
									<option value="{{ __('app.nonstaff')}}">{{ __('app.nonstaff')}}</option>										
								</select>
							</div>								
						</div>
					</div>	
					<div class="row">
									<div class="col-12 text-center">
									<a href="{{ route('auditor.list.index') }}" class="btn btn-default">
											<i class="fas fa-times"></i> {{ __('app.cancel') }}
										</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>	
				</div>
			</div>
	     </form>
		</div>
	</div>
		
	<div class="row">
        <div class="col-md-12">			
			<div id="accordion">
				<div id="form-a" class="card card-info" style="display: show">
					<div class="card-header" id="idBG">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								A. Latarbelakang
							</a>
						</h3>
					</div>
					<div id="collapseOne" class="collapse" aria-labelledby="idBG" data-parent="#accordion">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3 col-12">
									<form id="form-profile-picture-upload" method="POST" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
										@csrf
										<div class="form-group">
											<div class="col-xxl-8 offset-xxl-4 col-12 text-center">
												@if (empty(Auth::user()->profile_picture))
													<img class="profile-user-img img-fluid" src="{{ asset('/images/avatar.png') }}" />
												@else
													<a href="{{ asset('/storage/profile-picture/.original/'.Auth::user()->profile_picture) }}" class="profile-picture">
														<img class="profile-user-img img-fluid" src="{{ asset('/storage/profile-picture/'.Auth::user()->profile_picture) }}" />
													</a>
													<div id="profile-picture-btn-rotate" class="top-left">
														<a href="javascript:void(0);" onclick="event.preventDefault(); processAvatar(); document.getElementById('form-profile-picture-rotate').submit();">
															<span class="fa-stack">
																<i class="fas fa-circle fa-stack-2x"></i>
																<i class="fas fa-redo fa-stack-1x fa-inverse"></i>
															</span>
														</a>
													</div>
													<div id="profile-picture-btn-delete" class="top-right">
														<a href="javascript:void(0);" class="text-danger" onclick="if (confirm($('<span>{{ __('auth.are_you_sure_to_delete_profile_picture') }}</span>').text())) document.getElementById('form-profile-picture-delete').submit();">
															<span class="fa-stack">
																<i class="fas fa-circle fa-stack-2x"></i>
																<i class="fas fa-times fa-stack-1x fa-inverse"></i>
															</span>
														</a>
													</div>
												@endif
												<div id="process-img" class="processing hidden">
													<h3>
														<span class="badge badge-light badge-outline">
															<i class="fas fa-spinner fa-spin bigger-120"></i> 
															{{ __('app.processing') }}...
														</span>
													</h3>
												</div>
											</div>
										</div>
										<div id="profile-picture-input" class="form-group row">
											<div class="col-xxl-8 offset-xxl-4 col-12">
												<div class="custom-file">
													<input id="profile-picture" type="file" class="custom-file-input" name="profile-picture">
													<label for="profile-picture" class="custom-file-label">{{ empty(Auth::user()->profile_picture) ? __('app.upload_photo') : __('app.upload_new_photo') }}</label>
												</div>
												@error('profile-picture')
													<span class="text-danger" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>
									</form>
									<form id="form-profile-picture-rotate" class="hidden" method="POST" action="{{ route('profile.picture.rotate') }}">
										@csrf
									</form>
									@if (strcmp(Auth::user()->profile_picture, 'avatar.png') !== 0)
										<form id="form-profile-picture-delete" class="hidden" method="POST" action="{{ route('profile.picture.delete') }}">
											@method('DELETE')
											@csrf
										</form>
									@endif
								</div>
								<div class="col-sm-5">	
									<div class="form-group">
										<label class="col-form-label">Nama Penuh :</label>
										<input type="text" class="form-control" id="txtOwnerName" value="{{ Auth::user()->name }}" readonly>
									</div>
									<div class="form-group">
										<label class="col-form-label">No Kad Pengenalan :</label>
										<input type="text" class="form-control" id="txtICNo" name="txtICNo" value="{{ Auth::user()->username }}" readonly>
									</div>
									<div class="form-group">
										<label class="col-form-label">Emel :</label>
										<input type="email" class="form-control" id="txtEmail" value="{{ Auth::user()->email }}" readonly>
									</div>
								</div>
	
								<div class="col-sm-4">
									<div class="form-group">
									<form id="form-application-create-one" method="POST" action="#" autocomplete="off">
									<input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
									<input type="hidden" id="hide_tc" name="hide_tc" value="">	
										<label class="col-form-label">Gelaran : <span style="color: red;">*</span></label>
										<select class="form-control" id="selGelaran" name="title" required autocomplete="off">
											<option value="">{{ __('app.please_select')}}</option>
											<option value="{{ __('app.Mr')}}">{{ __('app.Mr')}}</option>
											<option value="{{ __('app.Mrs')}}">{{ __('app.Mrs')}}</option>
											<option value="{{ __('app.Ms')}}">{{ __('app.Ms')}}</option>
											<option value="{{ __('app.Dato')}}">{{ __('app.Dato')}}</option>
											<option value="{{ __('app.Dr.')}}">{{ __('app.Dr.')}}</option> 
										</select>
									</div>
									<div class="form-group">
										<label class="col-form-label">Tarikh Lahir : <span style="color: red;">*</span></label>
										<input type="date" class="form-control" id="txtBirthday" name="date_birthday" value="" required autocomplete="off">
									</div>
									<div class="form-group">
										<label class="col-form-label">Jantina : <span style="color: red;">*</span></label>
										<select class="form-control" id="selJantina" name="gender" required autocomplete="off">
															<option value="">{{ __('app.please_select')}}</option>
															<option value="Lelaki">Lelaki</option>
															<option value="Perempuan">Perempuan</option>		
										</select>
									</div>								
								</div>										
							</div>									
								<div class="row">					
									<div class="col-sm-6">										
										<div class="form-group">
											<label  class="col-form-label">
												Alamat Tetap : <span style="color: red;">*</span>												
											</label>
											<input type="text" class="form-control" id="txtAdress1" name="address1" value="{{ old('txtAdress1') }}" required autocomplete="off">										
											<input type="text" class="form-control" id="txtAdress2" name="address2" value="{{ old('txtAdress2') }}" autocomplete="off">										
											<input type="text" class="form-control" id="txtAdress3" name="address3" value="{{ old('txtAdress3') }}" autocomplete="off">										
										</div>
										<div class="form-group">	
											<label class="col-form-label">
												Poskod : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtPostcode" name="postcode" value="{{ old('txtPostcode') }}" maxlength="5" required autocomplete="off">										
										</div>
										<div class="form-group">	
											<label class="col-form-label">
												Bandar : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtCity" name="city" value="{{ old('txtCity') }}" required autocomplete="off">										
										</div>
									</div>									
									<div class="col-sm-6">											
										<div class="form-group">
											<label class="col-form-label">
												Negara : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selCountry" name="country_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($countries as $c)
													<option value="{{$c->id}}">{{$c->name}}</option>
												@endforeach											
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Negeri : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selState" name="state_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Daerah : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selDistrict" name="district_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												No Telefon Bimbit :
												<span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtHponeNo" name="mobile_phone_no" value="{{ old('txtHponeNo') }}" required autocomplete="off">										
										</div>											
									</div>
								</div>							
								<div class="row">
									<div class="col-12 text-center">
									<a href="{{ route('auditor.list.index') }}" class="btn btn-default">
											<i class="fas fa-times"></i> {{ __('app.cancel') }}
										</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>							
							</form> <!-- End form -->  
						</div>
					</div>
				</div>
				<div id="form-b" class="card card-info" style="display: show">
					<div class="card-header" id="idJD">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								B. Butiran Pekerjaan Semasa
							</a>
						</h3>
					</div>
					<div id="collapseTwo" name="collapseJD" class="collapse" aria-labelledby="idJD" data-parent="#accordion">
						<div class="card-body">
							<form id="form-job-details-create" method="POST" action="#" autocomplete="off">
								<input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
								<input type="hidden" id="hide_tc" name="hide_tc" value="">	
								<input type="hidden" id="url" name="url" value="">											
								<div class="row">					
									<div class="col-sm-6">										
										<div class="form-group">
											<label  class="col-form-label">
												Nama Pejabat : <span style="color: red;">*</span>												
											</label>
											<input type="text" class="form-control" id="txtofficeName" name="office_name" value="" required autocomplete="off">										
										</div>										
										<div class="form-group">
											<label  class="col-form-label">
												Alamat Pejabat : <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtAddress1" name="office_address1" value="" required autocomplete="off" placeholder="Alamat 1">										
											<input type="text" class="form-control" id="txtAddress2" name="office_address2" value=""  autocomplete="off" placeholder="Alamat 2">										
											<input type="text" class="form-control" id="txtAddress3" name="office_address3" value=""  autocomplete="off" placeholder="Alamat 3">										
										</div>																					
										<div class="form-group">	
											<label class="col-form-label">
												Poskod : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtOfficePostcode" name="office_postcode" value="{{ old('txtPostcode') }}" maxlength="5" required autocomplete="off">										
										</div>										
									</div>									
									<div class="col-sm-6">
										<div class="form-group">	
											<label class="col-form-label">
												Bandar : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtCity" name="office_city" value="{{ old('txtCity') }}" required autocomplete="off">										
										</div>											
										<div class="form-group">
											<label class="col-form-label">
												Negara : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selOfficeCountry" name="office_country_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($countries as $c)
												<option value="{{$c->id}}">{{$c->name}}</option>
												@endforeach											
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Negeri : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selOfficeState" name="office_state_id" required  autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Daerah : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selOfficeDistrict" name="office_district_id" required  autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>											
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label  class="col-form-label">
												Telefon (Pejabat) : <span style="color: red;">*</span>													
											</label>
											<input type="text" class="form-control" id="txtOfficeHponeNo" name="office_phone_no" value="{{ old('txtHponeNo') }}" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Fax (Pejabat) : 													
											</label>
											<input type="text" class="form-control" id="txtOfficeFaxNo" name="office_fax_no" value="{{ old('txtHponeNo') }}" maxlength="20" autocomplete="off">										
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label  class="col-form-label">
												Jawatan : <span style="color: red;">*</span>													
											</label>
											<input type="text" class="form-control" id="txtPosition" name="position" value="{{ old('txtHponeNo') }}" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Tarikh Mula Berkhidmat : <span style="color: red;">*</span>													
											</label>
											<input type="date" class="form-control" id="txtdateService" name="start_date_service" value="{{ old('txtdateService') }}" maxlength="20" required autocomplete="off">										
										</div>
									</div>
								</div>							
								<div class="row">
									<div class="col-12 text-center">
									<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapseOne">
											<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
									</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>							
							</form>
						</div>
					</div>
				</div>
				<div id="form-c" name="emergency_contact_heir" class="card card-info" style="display: show">
					<div class="card-header" id="idECH">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								C. Waris Untuk Dihubungi Semasa Kecemasan
							</a>
						</h3>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="idECH" data-parent="#accordion">
						<div class="card-body">
							<form id="form-emergency_contact_heir-create" method="POST" action="#" autocomplete="off">
								<input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
								<input type="hidden" id="hide_tc" name="hide_tc" value="">	
								<input type="hidden" id="url2" name="url2" value="">												
								<div class="row">					
									<div class="col-sm-6">										
										<div class="form-group">
											<label  class="col-form-label">
												Nama : <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtWarisName" name="w_name" value="" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Telefon Bimbit : <span style="color: red;">*</span>												
											</label>
											<input type="text" class="form-control" id="txtWarisHponeNo" name="w_mobile_phone_no" value="{{ old('txtHponeNo') }}" maxlength="20" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Telefon (Rumah) : 												
											</label>
											<input type="text" class="form-control" id="txtWarisHomeNo" name="w_home_phone_no" value="{{ old('txtHponeNo') }}" maxlength="20" autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Telefon (Pejabat) : 													
											</label>
											<input type="text" class="form-control" id="txtWarisOfficeNo" name="w_office_phone_no" value="{{ old('txtHponeNo') }}" maxlength="20" autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Fax (Pejabat) : 												
											</label>
											<input type="text" class="form-control" id="txtWarisFaxNo" name="w_office_fax_no" value="{{ old('txtHponeNo') }}" maxlength="20" autocomplete="off">										
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Hubungan :
												<span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selType" name="w_relationship" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												<option value="Bapa">Bapa</option>
												<option value="Ibu">Ibu</option>
												<option value="Suami">Suami</option>
												<option value="Isteri">Isteri</option>
											</select>
										</div>													
																				
									</div>									
									<div class="col-sm-6">
										<div class="form-group">
											<label  class="col-form-label">
												Alamat Pejabat : <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtAddress1" name="w_office_address1" value="" required autocomplete="off" placeholder="Alamat 1">										
											<input type="text" class="form-control" id="txtAddress2" name="w_office_address2" value=""  autocomplete="off" placeholder="Alamat 2">										
											<input type="text" class="form-control" id="txtAddress3" name="w_office_address3" value=""  autocomplete="off" placeholder="Alamat 3">										
										</div>																					
										<div class="form-group">	
											<label class="col-form-label">
												Poskod : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtWarisPostcode" name="w_office_postcode" value="{{ old('txtPostcode') }}" maxlength="5" required autocomplete="off">										
										</div>
										<div class="form-group">	
											<label class="col-form-label">
												Bandar : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtCity" name="w_office_city" value="{{ old('txtCity') }}" required autocomplete="off">										
										</div>											
										<div class="form-group">
											<label class="col-form-label">
												Negara : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selWarisCountry" name="w_office_country_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($countries as $c)
													<option value="{{$c->id}}">{{$c->name}}</option>
												@endforeach											
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Negeri : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selWarisState" name="w_office_state_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Daerah : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selWarisDistrict" name="w_office_district_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>											
									</div>									
								</div>							
								<div class="row">
									<div class="col-12 text-center">
									<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapseThree">
											<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
	                        </a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>							
							</form>
						</div>
					</div>
				</div>
				<div id="form-d" name="academic_course" class="card card-info" style="display: show">
					<div class="card-header" id="idAC">
						<h3 class="card-title">
							<a class="collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
								D. Kelayakan Akademik & Kursus/Latihan Berkaitan Audit Yang Pernah Dihadiri
							</a>
						</h3>
					</div>
					<div id="collapseFour" class="collapse" aria-labelledby="idAC" data-parent="#accordion">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div>
										<a href="#" data-toggle="modal" data-target="#modalAddAcademic" class="btn btn-primary float-right">TAMBAH KELAYAKAN AKADEMIK</a>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-form-label">Senarai Kelayakan Akademik :</label>
									</div>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th>Kelayakan</th>
												<th>Institusi</th>
												<th>Pengkhususan</th>	  
												<th>Tahun</th>	  
												<th style="text-align:center">Tindakan</th> 
											</tr>
										</thead>
										<tbody id="listAcademic">
										</tbody>
									</table>
								</div>
							</div>								
							<div class="row">
								<div class="col-sm-12">
									<div>
										<a href="#" data-toggle="modal" data-target="#modalAddCourse" class="btn btn-primary float-right">TAMBAH KURSUS</a>
									</div>
									<div class="form-group row">
										<label class="col-sm-12 col-form-label">Senarai Kursus/Latihan :</label>
									</div>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th>Nama Kursus</th>
												<th>Penganjur</th>
												<th>Tahun</th>	  
												<th>Dokumen</th>	
												<th style="text-align:center">Tindakan</th>  
											</tr>
										</thead>
										<tbody id="listCourse">
										</tbody>
									</table>
								</div>
							</div>																								
							<div class="row">
								<div class="col-12 text-center">
									<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapse">
										<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
									</a>
									<a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#collapseFive">
										{{ __('app.next') }} <i class="fas fa-chevron-right"></i>
									</a>
								</div>							
							</div>	
						</div>
						<!--<div class="modal fade" id="modalAddAcademic" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">								
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="addModalLabel">Tambah Kelayakan Akademik</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>									
									<form id="form-modal-add-academic" method="POST" action="#" autocomplete="off" enctype="multipart/form-data">
										<input type="hidden" id="aid_mpc" name="aid_mpc" value="">
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Kelayakan : <span style="color: red;">*</span>
														</label>
														<select class="form-control" id="selQualification" name="qualification" required autocomplete="off">
															<option value="">{{ __('app.please_select')}}</option>
															<option value="Diploma">Diploma</option>
															<option value="Ijazah">Ijazah</option>
															<option value="Master">Master</option>
															<option value="PhD">PhD</option>
															<option value="Lain-lain">Lain-Lain</option>
														</select>																		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Tahun : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtYear" name="yearly" maxlength="4"  required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Institusi : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtInstitute" name="institution" required>		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Pengkhususan : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtSpecialization" name="specialization" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Muatnaik Dokumen <i>(Optional/Tidak Wajib)</i> :
														</label>
														
															<div class="custom-file">
																<input type="file" class="custom-file-input" id="fileDocCourse" name="fileDocCourse" >
																<label class="custom-file-label" for="fileDocCourse">{{ __('app.choose_file') }}</label>
															</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-secondary " data-dismiss="modal">Tutup</button>
											<button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
										</div>
									</form>							
								</div>								
							</div>
						</div>-->
						<div class="modal fade" id="modalAddAcademic" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">								
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="addModalLabel">Tambah Kelayakan Akademik</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>									
									<form id="form-modal-add-academic" method="POST" action="#" autocomplete="off" enctype="multipart/form-data">
										<input type="hidden" id="aid_mpc" name="aid_mpc" value="">
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Kelayakan : <span style="color: red;">*</span>
														</label>
														<select class="form-control" id="selQualification" name="qualification" required autocomplete="off">
															<option value="">{{ __('app.please_select')}}</option>
															<option value="Diploma">Diploma</option>
															<option value="Ijazah">Ijazah</option>
															<option value="Master">Master</option>
															<option value="PhD">PhD</option>
															<option value="Lain-lain">Lain-Lain</option>
														</select>																		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Tahun : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtYear" name="yearly" maxlength="4"  required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Institusi : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtInstitute" name="institution" required>		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Pengkhususan : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtSpecialization" name="specialization" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Muatnaik Dokumen <i>(optional/tidak Wajib)</i> :
														</label>
														
															<div class="custom-file">
																<input type="file" class="custom-file-input" id="fileDocCourse" name="fileDocCourse" >
																<label class="custom-file-label" for="fileDocCourse">{{ __('app.choose_file') }}</label>
															</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
										</div>
									</form>							
								</div>								
							</div>
						</div>
						<div class="modal fade" id="modalAddCourse" tabindex="-1" role="dialog" aria-labelledby="addModalLabel2" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">								
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="addModalLabel2">Tambah Kursus/Latihan</h3>
										<button id="closeModal2" type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>									
									<form id="form-modal-add-course" method="POST" action="#" autocomplete="off">
										<input type="hidden" id="aid_mpc1" name="aid_mpc1" value="">
										<div class="modal-body">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Nama Kursus : <span style="color: red;">*</span>
														</label>
														<select class="form-control" id="selCourse" name="selCourse" required autocomplete="off">
															<option value="">{{ __('app.please_select')}}</option>
															<option value="Kursus Pre-Requisite HACCP">Kursus Pre-Requisite HACCP</option>
															<option value="Kursus Perlaksanaan HACCP">Kursus Perlaksanaan HACCP</option>
															<option value="Kursus Verikfikasi & Audit">Kursus Verikfikasi & Audit</option>
															<option value="Kursus HACCPLead Auditor">Kursus HACCPLead Auditor</option>
															<option value="Kursus Kecekapan Bio Tahap(I)">Kursus Kecekapan Bio Tahap(I)</option>	
															<option value="Kursus Kecekapan Bio Tahap(II)">Kursus Kecekapan Bio Tahap(II)</option>	
															<option value="Kursus Kecekapan Bio Tahap(III)">Kursus Kecekapan Bio Tahap(III)</option>
															<option value="ISO/EIC 17025:2017 INTRODUCTION">ISO/EIC 17025:2017 INTRODUCTION</option>	
															<option value="ISO/EIC 17025:2017 INTERNAL AUDITING">ISO/EIC 17025:2017 INTERNAL AUDITING</option>		
															<option value="(SIRIM CERTIFIED) LEAD AUDITOR / ASSESSOR ISO/IEC 17025:2017 LAB QUALITY MANAGEMENT SYSTEM">(SIRIM CERTIFIED) LEAD AUDITOR / ASSESSOR ISO/IEC 17025:2017 LAB QUALITY MANAGEMENT SYSTEM</option>											
														</select>																		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Tahun : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="selYearCourse" name="selYearCourse" maxlength ="4" required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
															Penganjur : <span style="color: red;">*</span>
														</label>
														<input type="text" class="form-control" id="txtOrganizer" name="txtOrganizer" required>		
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">
														 Muatnaik Dokumen <i>(optional/tidak Wajib)</i> :
														</label>
														<div class="input-group">
															<div class="custom-file">
																<input type="file" class="custom-file-input" id="fileDocCourse2" name="fileDocCourse2">
																<label class="custom-file-label" for="fileDocCourse2">Choose file</label>
															</div>							  
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-secondary " data-dismiss="modal">Tutup</button>
											<button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
										</div>
									</form>							
								</div>								
							</div>							
						</div>
					</div>
				</div>
				<div id="form-e" name="fisheries_sector_experience" class="card card-info" style="display: show">
					<div class="card-header" id="idFSE">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
								E. Pengalaman Di Dalam Sektor Perikanan
							</a>
						</h3>
					</div>
					<div id="collapseFive" class="collapse" aria-labelledby="idFSE" data-parent="#accordion">
						<div class="card-body">
							<form id="form-fse-create" method="POST" action="#" autocomplete="off" enctype="multipart/form-data">	
								<input type="hidden" id="hide_si" name="hide_si" value="">	

								<div class="row">
									<div class="col-sm-12">										
										<div class="form-group">
											<label class="card-title">
												Pengalaman di dalam bidang yang bersesuaian. 
												Anda boleh menanda lebih daripada satu senarai industri di bawah termasuk yang tidak disenaraikan.
												Pemilihan tersebut perlulah bersesuaian dengan pekerjaan dan pengalaman termasuk permohonan ini.												
											</label>
										</div>
									</div>
									<div class="col-sm-12">										
										<div class="form-group">
											<label class="col-form-label">
												Senarai Industri <span style="color: red;">*</span>
											</label>
											<div class="card">
												<div class="card-body">													
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="tp" type="checkbox" class="custom-control-input" name="is_perikanan_tangkapan" value="true" >
														<label for="tp" class="custom-control-label">Perikanan Tangkapan</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="sk" type="checkbox" class="custom-control-input" name="is_sains_kelautan" value="true" >
														<label for="sk" class="custom-control-label">Sains Kelautan</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="sm" type="checkbox" class="custom-control-input" name="is_sains_makanan" value="true" >
														<label for="sm" class="custom-control-label">Sains Makanan</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="ak" type="checkbox" class="custom-control-input" name="is_akuakultur" value="true" >
														<label for="ak" class="custom-control-label">Akuakultur</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="tm" type="checkbox" class="custom-control-input" name="is_teknologi_makanan" value="true" >
														<label for="tm" class="custom-control-label">Teknologi Makanan</label>
													</div>												
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="sp" type="checkbox" class="custom-control-input" name="is_sains_pertanian" value="true" >
														<label for="sp" class="custom-control-label">Sains Pertanian</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="v" type="checkbox" class="custom-control-input" name="is_virologi" value="true" >
														<label for="v" class="custom-control-label">Virologi</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="m" type="checkbox" class="custom-control-input" name="is_mikrobiologi" value="true" >
														<label for="m" class="custom-control-label">Mikrobiologi</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="p" type="checkbox" class="custom-control-input" name="is_parasitologi" value="true">
														<label for="p" class="custom-control-label">Parasitologi</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="k" type="checkbox" class="custom-control-input" name="is_kimia" value="true" >
														<label for="k" class="custom-control-label">Kimia</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="kt" type="checkbox" class="custom-control-input" name="is_plankton_kualiti_air" value="true">
														<label for="kt" class="custom-control-label">Plankton dan Kualiti Air</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="pm" type="checkbox" class="custom-control-input" name="is_pengurusan_makmal" value="true" >
														<label for="pm" class="custom-control-label">Pengurusan Makmal</label>
													</div>
													<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="ll" type="checkbox" class="custom-control-input" name="is_lain_lain" value="true" >
														<label for="ll" class="custom-control-label">Lain-lain</label>
													</div>													
												</div>
											</div>
										</div>																						
									</div>
									<div class="col-sm-6">	
										<div class="form-group">
											<input type="text" class="form-control" id="txtOthersIndustry" name="othersIndustry" value="" placeholder="Lain-lain"  autocomplete="off">								
										</div>									
									</div>									
								</div>							
								<div class="row">
									<div class="col-12 text-center">
									<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapseFour">
											<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
									</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>							
							</form>
						</div>
					</div>
				</div>
				<div id="form-f" name="supporters" class="card card-info" style="display: show">
					<div class="card-header" id="idS">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
								F. Penyokong
							</a>
						</h3>
					</div>
					<div id="collapseSix" class="collapse" aria-labelledby="idS" data-parent="#accordion">
						<div class="card-body">
							<form id="form-s-create" method="POST" action="#" autocomplete="off">
								<input type="hidden" id="hide_aid" name="hide_aid" value="{{ Helper::uuid() }}">		
                        <input type="hidden" id="aid_mpc2" name="aid_mpc2" value="">
								<div class="row">									
									<div class="col-sm-12">
										<div class="form-group">
											<label class="card-title">
												Penyokong :</br>
												Namakan dua (2) orang penyokong yang boleh membuktikan kelayakan, pengetahuan dan pengalaman anda 
												yang diperlukan oleh seorang Juruaudit Biosekuriti Perikanan.
											</label>
										</div>
									</div>								
									<div class="col-sm-6">
										<div class="card-header">
											<label class="card-title">Penyokong Pertama</label>
										</div>															
										<div class="form-group">
											<label  class="col-form-label">
												Nama Penuh : <span style="color: red;">*</span>											
											</label>
											<select class="form-control" id="selFN1" name="sFirst_name" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($users as $a)
                                        <option value="{{$a->name}}">{{ strtoupper($a->name) }}   </option>
                                    @endforeach  
											</select>										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Jawatan	: <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtP1" name="sFirst_position" value="" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Hubungan Dengan Pemohon	: <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtAR1" name="sFirst_relationship" value="PEGAWAI PENILAI 1" readonly>										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Tempoh Dibawah Seliaan : <span style="color: red;">*</span>											
											</label>
											<select class="form-control" id="txtAP1" name="sFirst_period_known" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												<option value="BAWAH 1 TAHUN">BAWAH 1 TAHUN</option>
												<option value="1 HINGGA 3 TAHUN">1 HINGGA 3 TAHUN</option>
												<option value="3 TAHUN KEATAS">3 TAHUN KEATAS</option>												
											</select>										
										</div>										
										<div class="form-group">
											<label  class="col-form-label">
												Alamat Pejabat	: <span style="color: red;">*</span>										
											</label>
											<input type="text" class="form-control" id="txtOA11" name="sFirst_address1" value="" required autocomplete="off" placeholder="Alamat 1">										
											<input type="text" class="form-control" id="txtOA21" name="sFirst_address2" value=""  autocomplete="off" placeholder="Alamat 2">										
											<input type="text" class="form-control" id="txtOA31" name="sFirst_address3" value=""  autocomplete="off" placeholder="Alamat 3">										
										</div>																					
										<div class="form-group">	
											<label class="col-form-label">
												Poskod : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtPenyokongSatuPostcode" name="sFirst_postcode" value="{{ old('txtPostcode') }}" maxlength="5" required autocomplete="off">										
										</div>
										<div class="form-group">	
											<label class="col-form-label">
												Bandar : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtC1" name="sFirst_city" value="{{ old('txtCity') }}" required autocomplete="off">										
										</div>											
										<div class="form-group">
											<label class="col-form-label">
												Negara : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selC1" name="sFirst_country_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($countries as $c)
													<option value="{{$c->id}}">{{$c->name}}</option>
												@endforeach											
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Negeri : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selS1" name="sFirst_state_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Daerah : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selD1" name="sFirst_district_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
																			
									</div>
									<div class="col-sm-6">
										<div class="card-header">
											<label class="card-title">Penyokong Kedua</label>
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Nama Penuh	: <span style="color: red;">*</span>											
											</label>
											<select class="form-control" id="selFN2" name="sSecond_name" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($users as $a)
                                        <option value="{{$a->name}}">{{ strtoupper($a->name) }}   </option>
                                    @endforeach  
											</select>										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Jawatan	: <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtP2" name="sSecond_position" value="" required autocomplete="off">										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Hubungan Dengan Pemohon	: <span style="color: red;">*</span>											
											</label>
											<input type="text" class="form-control" id="txtAR2" name="sSecond_relationship" value="PEGAWAI PENILAI 2" readonly>										
										</div>
										<div class="form-group">
											<label  class="col-form-label">
												Tempoh Dibawah Seliaan : <span style="color: red;">*</span>											
											</label>
											<select class="form-control" id="txtAP2" name="sSecond_period_known" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												<option value="BAWAH 1 TAHUN">BAWAH 1 TAHUN</option>
												<option value="1 HINGGA 3 TAHUN">1 HINGGA 3 TAHUN</option>
												<option value="3 TAHUN KEATAS">3 TAHUN KEATAS</option>												
											</select>										
										</div>										
										<div class="form-group">
											<label  class="col-form-label">
												Alamat Pejabat : <span style="color: red;">*</span>										
											</label>
											<input type="text" class="form-control" id="txtOA12" name="sSecond_address1" value="" required autocomplete="off" placeholder="Alamat 1">										
											<input type="text" class="form-control" id="txtOA22" name="sSecond_address2" value=""  autocomplete="off" placeholder="Alamat 2">										
											<input type="text" class="form-control" id="txtOA32" name="sSecond_address3" value=""  autocomplete="off" placeholder="Alamat 3">										
										</div>																					
										<div class="form-group">	
											<label class="col-form-label">
												Poskod : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtPenyokongDuaPostcode" name="sSecond_postcode" value="{{ old('txtP2') }}" maxlength="5" required autocomplete="off">										
										</div>
										<div class="form-group">	
											<label class="col-form-label">
												Bandar : <span style="color: red;">*</span>
											</label>
											<input type="text" class="form-control" id="txtC2" name="sSecond_city" value="{{ old('txtC2') }}" required autocomplete="off">										
										</div>											
										<div class="form-group">
											<label class="col-form-label">
												Negara : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selC2" name="sSecond_country_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
												@foreach($countries as $c)
													<option value="{{$c->id}}">{{$c->name}}</option>
												@endforeach											
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Negeri : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selS2" name="sSecond_state_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>
										<div class="form-group">
											<label class="col-form-label">
												Daerah : <span style="color: red;">*</span>
											</label>
											<select class="form-control" id="selD2" name="sSecond_district_id" required autocomplete="off">
												<option value="">{{ __('app.please_select')}}</option>
											</select>
										</div>									
									</div>	
								</div>							
								<hr>							
								<div class="row">
									<div class="col-12 text-center">
										<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapseFive">
												<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
										</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.save_next') }}
										</button>
									</div>							
								</div>							
							</form>
						</div>
					</div>
				</div>
				<div id="form-g" name="declaration_applicant" class="card card-info" style="display: show">
					<div class="card-header" id="idDA">
						<h3 class="card-title">
							<a href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
								G. Perakuan Oleh Pemohon
							</a>
						</h3>
					</div>
					<div id="collapseSeven" class="collapse" aria-labelledby="idDA" data-parent="#accordion">
						<div class="card-body">
							<form id="form-da-create" method="POST" action="#" autocomplete="off">
								<input type="hidden" id="url-Perakuan" name="url-Perakuan" value="">		

								<div class="row">									
									<div class="col-sm-12">
										<div class="form-group">
											<label class="card-title" class="custom-control-label">
											<div class="custom-control custom-checkbox @desktop custom-control-inline @enddesktop">
														<input id="agree" type="checkbox" class="custom-control-input" name="agree" value="Yes" required>
														<label for="agree" class="custom-control-label"> Saya memohon untuk didaftarkan sebagai seorang juruaudit di bawah program Biosekuriti 
												Perikanan dan dengan ini berjanji untuk mematuhi perkara berikut :</label>
											</div>
										</div>									
									</div>									
									<div class="col-sm-12">									
										<div class="form-group">											
											<div class="card">
												<div class="card-body">													
													<label class="col-form-label">												
													1. Kod etika sebagai seorang juruaudit.</br>
													2. Terma dan syarat untuk juruaudit.</br>
													3. Untuk menjalani latihan dan melaksanakan audit sebagaimana diminta.</br>
													4. Semua maklumat yang disediakan di dalam permohonan ini adalah betul daripada pihak saya.</br>
													5. Setiap keadaan tambahan yang mungkin dikenakan oleh pihak Jabatan sekiranya perlu.</br>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label  class="col-form-label">
												Nombor Kad Pengenalan 												
											</label>
											<input type="text" class="form-control" id="txtICV" name="txtICV" value="{{ Auth::user()->username }}" readonly>										
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label  class="col-form-label">
												Tarikh 												
											</label>
											<input type="text" class="form-control" id="txtDA" name="txtDA" value="<?= date("d/m/Y") ?>" maxlength="20" readonly>										
										</div>
									</div>							
								</div>							
								<hr>							
								<div class="row">
									<div class="col-12 text-center">
										<a href="#" class="btn btn-default" data-toggle="collapse" data-target="#collapseSix">
											<i class="fas fa-chevron-left"></i> {{ __('app.back') }}
	                        			</a>
										<button id="save_giid" type="submit" class="btn btn-primary">
											<i class="fas fa-save"></i> {{ __('app.submit') }}
										</button>
									</div>							
								</div>							
							</form>
						</div>
					</div>
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
			$(document).on('change', '#selCountry', function(){
				var country = $('#selCountry option:selected').val();
				var state = $('#selState');
				state.empty();
				state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(country){
					$.get("{{ url('app/state') }}/"+country, function(data){
						$.each(data, function(key,value){
							state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
				else{
					state.val(null).trigger('change');
				}
			});
			$(document).on('change', '#selState', function(){
				var state = $('#selState option:selected').val();
				var district = $('#selDistrict');
				district.empty();
				district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(state){
					$.get("{{ url('app/district') }}/"+state, function(data){
						$.each(data, function(key,value){
							district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
		});


				// office
			$(document).ready(function(){
			$(document).on('change', '#selOfficeCountry', function(){
				var comp_country = $('#selOfficeCountry option:selected').val();
				var comp_state = $('#selOfficeState');
				comp_state.empty();
				comp_state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_country){
					$.get("{{ url('app/state') }}/"+comp_country, function(data){
						$.each(data, function(key,value){
							comp_state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	   	});

		$(document).ready(function(){
			$(document).on('change', '#selOfficeState', function(){
				var comp_state = $('#selOfficeState option:selected').val();
				var comp_district = $('#selOfficeDistrict');
				comp_district.empty();
				comp_district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_state){
					$.get("{{ url('app/district') }}/"+comp_state, function(data){
						$.each(data, function(key,value){
							comp_district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	    });

		 
		// waris
		$(document).ready(function(){
			$(document).on('change', '#selWarisCountry', function(){
				var comp_country = $('#selWarisCountry option:selected').val();
				var comp_state = $('#selWarisState');
				comp_state.empty();
				comp_state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_country){
					$.get("{{ url('app/state') }}/"+comp_country, function(data){
						$.each(data, function(key,value){
							comp_state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	   	});

		$(document).ready(function(){
			$(document).on('change', '#selWarisState', function(){
				var comp_state = $('#selWarisState option:selected').val();
				var comp_district = $('#selWarisDistrict');
				comp_district.empty();
				comp_district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_state){
					$.get("{{ url('app/district') }}/"+comp_state, function(data){
						$.each(data, function(key,value){
							comp_district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	    });


		 // penyokong1
		 $(document).ready(function(){
			$(document).on('change', '#selC1', function(){
				var comp_country = $('#selC1 option:selected').val();
				var comp_state = $('#selS1');
				comp_state.empty();
				comp_state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_country){
					$.get("{{ url('app/state') }}/"+comp_country, function(data){
						$.each(data, function(key,value){
							comp_state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	   	});

		$(document).ready(function(){
			$(document).on('change', '#selS1', function(){
				var comp_state = $('#selS1 option:selected').val();
				var comp_district = $('#selD1');
				comp_district.empty();
				comp_district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_state){
					$.get("{{ url('app/district') }}/"+comp_state, function(data){
						$.each(data, function(key,value){
							comp_district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	    });


		 // penyokong2
		 $(document).ready(function(){
			$(document).on('change', '#selC2', function(){
				var comp_country = $('#selC2 option:selected').val();
				var comp_state = $('#selS2');
				comp_state.empty();
				comp_state.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_country){
					$.get("{{ url('app/state') }}/"+comp_country, function(data){
						$.each(data, function(key,value){
							comp_state.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	   	});

		$(document).ready(function(){
			$(document).on('change', '#selS2', function(){
				var comp_state = $('#selS2 option:selected').val();
				var comp_district = $('#selD2');
				comp_district.empty();
				comp_district.append("<option value=''>{{ __('app.please_select')}}</option>");
				
				if(comp_state){
					$.get("{{ url('app/district') }}/"+comp_state, function(data){
						$.each(data, function(key,value){
							comp_district.append("<option value='"+value.id+"'>"+value.name+"</option>");
						});
					});
				}
			});
	    });


      // Show based on selected category (jenis kategori)
		



	$(document).ready(function(){


      //submitCategory
		$('#form-application-category').on('submit', function(e) {
				e.preventDefault();		
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storeCategory') }}",
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");			
								$('#collapseOne').collapse('show');	
								$('#urlLB').val(msg.urlLB);	
								$('#aid_mpc').val(msg.apid);	
								$('#aid_mpc1').val(msg.apid2);	
								$('#aid_mpc2').val(msg.apid3);
								$('#hide_si').val(msg.apid4);														
								$("#selAppCategory").attr('disabled','disabled');							
								$('#save_giid').hide();							
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});
			//submit
			$('#form-application-create-one').on('submit', function(e) {
				e.preventDefault();
				var urlLB = $('#urlLB').val();		
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "PUT",
						url: urlLB,
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");			
								$('#collapseTwo').collapse('show');								
								$('#url').val(msg.url);							
								$('#save_giid').hide();							
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});

			$('#form-job-details-create').on('submit', function(e) {
				e.preventDefault();
				var url = $('#url').val();
				var htc = $('#hide_tc').val();
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "PUT",
						url: url,
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");			
								$('#collapseThree').collapse('show');								
								$('#url2').val(msg.url2);																					
								$('#save_giid').hide();	
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});

			$('#form-emergency_contact_heir-create').on('submit', function(e) {
				e.preventDefault();
				var url2 = $('#url2').val();
				//var htc = $('#hide_tc').val();
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "PUT",
						url: url2,
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");			
								$('#collapseFour').collapse('show');																													
								$('#save_giid').hide();	
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});

			/*$('#form-modal-add-academic').on('submit', function(e) {
				e.preventDefault();
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storeModalAcademic') }}",
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(data) {
							if(data.success == true) {
								alert("{{ __('app.record_saved') }}");


								$("#listAcademic").append('<tr id="acid_'+ data.AuditAcademic.id +'"><td>' + data.AuditAcademic.qualification + 
								'</td><td>' + data.AuditAcademic.institution + 
								'</td><td>' + data.AuditAcademic.specialization + 
								'</td><td>' + data.AuditAcademic.yearly +
								'</td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="deleteAcademic(this);" data-id="'+ data.urlKJA +'"><i class="fas fa-trash"></i></a>' +
								'</td></tr>');

									$('#modalAddAcademic').modal('hide');	
									$('#modalAddAcademic').on('hidden.bs.modal', function () {
										$(this).find('form').trigger('reset');				
									})
									$('#closeModals').on('click', function () {													
										$("#tableModal tbody tr").remove(); 
									});

							} else {
								alert("{{ __('app.record_not_updated') }}");
							}	
						},
						error: function (data) {
							console.log(data);
						}						
					});
				}
			});*/

			$('#form-modal-add-academic').on('submit', function(e) {
				e.preventDefault();
				var formData = new FormData(this);
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storeModalAcademic') }}",
						data: formData,
						enctype: 'multipart/form-data',
						dataType: 'JSON',
						cache: false,
						contentType: false,
						processData: false,
						success: function(data) {
							if(data.success == true) {
								alert("{{ __('app.record_saved') }}");

								if(data.AuditAcademic.fileDocCourse === undefined) {

									$("#listAcademic").append('<tr id="acid_"><td>' + data.AuditAcademic.qualification + 
								'</td><td>' + data.AuditAcademic.institution + 
								'</td><td>' + data.AuditAcademic.specialization + 
								'</td><td>' + data.AuditAcademic.yearly +
								'</td><td>' + "Tiada Dokumen" +
								'</td><td style="text-align:center"> <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="deleteAcademic(this);" data-id="'+ data.urlKJA +'"><i class="fas fa-trash"></i></a> ' +
								'</td></tr>');

								}
								else {
									$("#listAcademic").append('<tr id="acid_"><td>' + data.AuditAcademic.qualification + 
								'</td><td>' + data.AuditAcademic.institution + 
								'</td><td>' + data.AuditAcademic.specialization + 
								'</td><td>' + data.AuditAcademic.yearly +
								'</td><td>' + data.AuditAcademic.fileDocCourse +
								'</td><td style="text-align:center"> <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="deleteAcademic(this);" data-id="'+ data.urlKJA +'"><i class="fas fa-trash"></i></a> ' +
								'</td></tr>');

								}



									$('#modalAddAcademic').modal('hide');	
									$('#modalAddAcademic').on('hidden.bs.modal', function () {
										$(this).find('form').trigger('reset');				
									})
									$('#closeModals').on('click', function () {													
										$("#tableModal tbody tr").remove(); 
									});
																						
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (data) {
							console.log(data);
						}
					});
				}
			});

			$('#form-modal-add-course').on('submit', function(e) {
				e.preventDefault();
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storeModalCourse') }}",
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(data) {
							if(data.success == true) {
								alert("{{ __('app.record_saved') }}");


								$("#listCourse").append('<tr id="cid_'+ data.AuditCourse.id +'"><td>' + data.AuditCourse.name_course + 
								'</td><td>' + data.AuditCourse.year_course + 
								'</td><td>' + data.AuditCourse.organizer_course + 
								'</td><td>' + data.AuditCourse.fileDocCourse2 +
								'</td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="deleteCourse(this);" data-id="'+ data.urlKJAC +'"><i class="fas fa-trash"></i></a>' +
								'</td></tr>');

									$('#modalAddCourse').modal('hide');	
									$('#modalAddCourse').on('hidden.bs.modal', function () {
										$(this).find('form').trigger('reset');				
									})
									$('#closeModals').on('click', function () {													
										$("#tableModal tbody tr").remove(); 
									});

							} else {
								alert("{{ __('app.record_not_updated') }}");
							}	
						},
						error: function (data) {
							console.log(data);
						}						
					});
				}
			});

			$('#form-fse-create').on('submit', function(e) {
				e.preventDefault();		
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storeIndustry') }}",
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");			
								$('#collapseSix').collapse('show');								
								//$('#url').val(msg.url);	
								//$('#aid_mpc').val(msg.apid);								
								//$("#selAppCategory").attr('disabled','disabled');							
								$('#save_giid').hide();							
							} else {
								alert("{{ __('app.record_not_saved') }}");
								
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});
         //Penyokong
			$('#form-s-create').on('submit', function(e) {
				e.preventDefault();		
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "POST",
						url: "{{ route('auditor.list.storePenyokong') }}",
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(msg) {
							if(msg.success == true) {
								alert("{{ __('app.record_saved') }}");		

								$('#collapseSeven').collapse('show');		
								$('#url-Perakuan').val(msg.urlPAuditor);																	
								$('#save_giid').hide();							
							} else {
								alert("{{ __('app.record_not_saved') }}");
							}
						},
						error: function (msg) {
							console.log(msg);
						}
					});
				}
			});

         //Perakuan
			$('#form-da-create').on('submit', function(e) {
				e.preventDefault();
				var urlPerakuan = $('#url-Perakuan').val();
				if($(this).valid()) {
					$.ajax({
						headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
						method: "PUT",
						url: urlPerakuan,
						data: $(this).serialize(),
						dataType: 'JSON',
						cache: false,
						success: function(data) {
							if(data.success == true) {
								alert("{{ __('app.record_submitted') }}");							
								window.location.href = data.urlI;							
							} else {
								alert("{{ __('app.record_not_submitted') }}");
							}
						},
						error: function (data) {
							console.log(data);
						}
					});
				}
			});


	}); // end of document


	$(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

		// allow number
		$(document).ready(function () {  
            $('#txtHponeNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });
			$('#txtFaxNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });
			$('#txtPostcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#txtOfficePostcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#txtOfficeHponeNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });

				$('#txtOfficeFaxNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });

				$('#txtWarisPostcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#txtWarisHponeNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });
				$('#txtWarisHomeNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });
				$('#txtWarisOfficeNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });

				$('#txtWarisFaxNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
            });

				$('#txtYear').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#selYearCourse').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#txtPenyokongSatuPostcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

			$('#txtPenyokongDuaPostcode').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                    return false;                        
         });

		});

		 // deleteAcademic
		 /*function deleteAcademic(element) {
			var urlid = $(element).data('id');			
			if(confirm('Anda pasti mahu memadam data ini ?')) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
					url: urlid,
					type: 'DELETE',
					data: $(this).serialize(),
					dataType: 'JSON',
					cache: false,					
					success: function(r) {					
						if(r.success == true) {
							alert("{{ __('app.record_deleted') }}");
							$('#acid_'+ r.p.id).remove(); 
						} else {
							alert("Record could not deleted");
						}   						
					},
					error: function() {
						console.log(r.p);
					}
				});
			}
		}*/	

		// deleteAcademic
		function deleteAcademic(element) {
			var urlid = $(element).data('id');			
			if(confirm('Anda pasti mahu memadam data ini ?')) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
					url: urlid,
					type: 'DELETE',
					data: $(this).serialize(),
					dataType: 'JSON',
					cache: false,					
					success: function(r) {					
						if(r.success == true) {
							alert("{{ __('app.record_deleted') }}");
							$('#acid_').remove(); 
						} else {
							alert("Record could not deleted");
						}   						
					},
					error: function() {
						console.log(r.p);
					}
				});
			}
		}

		// deleteCourse
		/*function deleteCourse(element) {
			var urlid = $(element).data('id');			
			if(confirm('Anda pasti mahu memadam data ini ?')) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
					url: urlid,
					type: 'DELETE',
					data: $(this).serialize(),
					dataType: 'JSON',
					cache: false,					
					success: function(r) {					
						if(r.success == true) {
							alert("{{ __('app.record_deleted') }}");
							$('#cid_'+ r.p.id).remove(); 
						} else {
							alert("Record could not deleted");
						}   						
					},
					error: function() {
						console.log(r.p);
					}
				});
			}
		}*/	

		// deleteCourse
		function deleteCourse(element) {
			var urlid = $(element).data('id');			
			if(confirm('Anda pasti mahu memadam data ini ?')) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
					url: urlid,
					type: 'DELETE',
					data: $(this).serialize(),
					dataType: 'JSON',
					cache: false,					
					success: function(r) {					
						if(r.success == true) {
							alert("{{ __('app.record_deleted') }}");
							$('#cid_').remove(); 
						} else {
							alert("Record could not deleted");
						}   						
					},
					error: function() {
						console.log(r.p);
					}
				});
			}
		}

		
    </script>
@endpush