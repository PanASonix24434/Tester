@extends('layouts.app')

@push('styles')
    <style type="text/css">
        .form-container {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping for additional fields */
            gap: 15px; /* Space between fields */
        }
        .form-container input {
            flex: 1; /* Adjust field size to fit */
            padding: 8px;
            font-size: 14px;
            min-width: 150px; /* Minimum width to prevent fields from becoming too small */
        }
        .search-bar {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            width: 100%;
            max-width: 500px; /* Adjust the width as needed */
            background-color: #f9f9f9;
        }

        .search-bar input[type="text"] {
            flex: 1;
            border: none;
            outline: none;
            padding: 8px;
            font-size: 16px;
            background-color: transparent;
        }

        .search-bar button {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
        }

        .search-bar button i {
            font-size: 16px;
            color: #666;
        }
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Maklumat Kakitangan Berdaftar</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-5 text-right">
                        <a href="{{ route('appointment.search.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> <span class="hidden-xs"> Tambah</span></a>
                    </div>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <form method="GET" action="{{ route('appointment.search.index') }}">
                                <div class="col-lg-12 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label">Maklumat Carian : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $txtName }}" class="form-control" />
                                        </div>
                                </div>
                                    <br />
                                    <div class="form-container">
                                        <label class="form-label" for="selectOne">Bahagian : </label>
                                        <select style="width: 200px;" id="selDepartType" name="selDepartType" value= "{{ $filterDepartment }}" autocomplete="off">
                                            <option value="">Pilih Bahagian</option>
                                            @foreach($department as $a)
                                                    @if ($department == $a->selDepartType)
                                                    <option value="{{ $a->name }}" selected>{{ $a->name }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                    @endif                                                    
                                                @endforeach	
                                        </select>
                                        
                                        <label for="selStateType">  Negeri : </label>
                                        <select style="width: 200px;" id="selStateType" name="selStateType" autocomplete="off">
                                            <option value="">Pilih Negeri</option>          
                                                @foreach($state as $a)
                                                    @if ($state == $a->selStateType)
                                                    <option value="{{ $a->selStateType }}" selected>{{ $a->name }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ $a->name }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>

                                        <label for="selDistrictType">  Daerah : </label>
                                        <select style="width: 200px;" id="selDistrictType" name="selDistrictType" autocomplete="off">
                                            <option value="">Pilih Daerah</option>
                                            @foreach($district as $a)
                                                    @if ($district == $a->selDistrictType)
                                                    <option value="{{ $a->name }}" selected>{{ strtoupper($a->name) }}</option>
                                                    @else
                                                    <option value="{{ $a->name }}">{{ strtoupper($a->name) }}</option>
                                                    @endif
                                                    
                                                @endforeach	
                                        </select>
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                         <br>
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                        </div>
                                    </div>
                                    <br />
                                    </form>
                                 <!--   <div class="row">
                                        <div class="mb-5">
                                            <label style="font:#007bff;"> Peranan & Bilangan Kouta</label>
                                            <u>______________________________________________________________________________________________________________________________________________</u>
                                        </div>
                                     </div>

                                     <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$role->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Jawatan</b></th>
                                                <th><b>Bil. Kouta</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($role as $a)
                                                <tr>                                                    
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ $a->quota }}</td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Peranan</b></th>
                                                <th><b>Bil. Kouta</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
                                </div>
                            </div>                
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="mb-5">
                            <label style="font:#007bff;">Senarai Kakitangan Berdaftar</label>
                            <u>_____________________________________________________________________________________________________________________________________________</u>
                        </div>
                   </div>
                    <br/>
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$appt->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama Pegawai</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Bahagian</b></th>
                                                <th><b>Peringkat</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($appt as $a)
                                                <tr>            
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ $a->icno }}</td>
                                                    <td>{{ $a->department }}</td>
                                                    <td>{{ $a->level }}</td>
                                                    <td>{{ $a->role }}</td>
                                                    <td><a href="{{ route('appointment.search.edit3',$a->id) }}"><i class="fas fa-search"></i></a></td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                            <th><b>Nama Pegawai</b></th>
                                            <th><b>No. Kad Pengenalan</b></th>
                                            <th><b>Bahagian</b></th>
                                            <th><b>Peringkat</b></th>
                                            <th><b>Peranan</b></th>
                                            <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
                                </div>
                            </div>                
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="mb-5">
                            <label style="font:#007bff;">Senarai Kakitangan Terdahulu</label>
                            <u>_____________________________________________________________________________________________________________________________________________</u>
                        </div>
                   </div>
                   <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$apptInactive->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                            <th><b>Nama Pegawai</b></th>
                                            <th><b>No. Kad Pengenalan</b></th>
                                            <th><b>Bahagian</b></th>
                                            <th><b>Peringkat</b></th>
                                            <th><b>Peranan</b></th>
                                            <th><b>Tarikh Nyahaktif</b></th>
                                            <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($apptInactive as $a)
                                                <tr>            
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ $a->icno }}</td>
                                                    <td>{{ $a->department }}</td>
                                                    <td>{{ $a->level }}</td>
                                                    <td>{{ $a->role }}</td>
                                                    <td>{{ $a->inactive_date }}</td>
                                                    <td><a href="{{ route('appointment.search.view',$a->id) }}"><i class="fas fa-search"></i></a></td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>Nama Pegawai</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Bahagian</b></th>
                                                <th><b>Peringkat</b></th>
                                                <th><b>Peranan</b></th>
                                                <th><b>Tarikh Nyahaktif</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
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
        
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }

</script>   
@endpush
