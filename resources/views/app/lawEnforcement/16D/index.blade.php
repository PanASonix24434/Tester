@extends('layouts.app')
@include('layouts.page_title')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">Penguatkuasaan Undang-Undang</h3>
                    <div class="card-tools">
                        {{-- <a href="{{route('law-enforcement.16D.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i><span class="hidden-xs"> Add</span></a> --}}
                    
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped table-sm">
                                    
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>No Fail</th>
                                                <th>No Akaun</th>
                                                <th>Tarikh Tamat Tempoh</th>
                                                <th>Tarikh Bayaran Seterusnya</th>
                                                <th>Bulan Tunggakkan</th>
                                                <th>Jumlah Tunggakkan (RM)</th>
                                                <th>Tarikh Borang 16H</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                                <tr>   
                                                <td>Muhammad</td>
                                                <td>861/KD/2102</td>
                                                <td>2420</td>
                                                <td>31-09-2020</td>
                                                <td>31-09-2004</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>31-12-2024</td>
                                                <td>Tunggakan selesai dibayar</td>
                                                <td>
                                                    
                                                </td>
                                                </tr>
                                            
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection