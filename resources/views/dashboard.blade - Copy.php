@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $complaintAssigns }}</h3>

        <p>Jumlah Aduan Dalam Tindakan Saya</p>
      </div>
      <div class="icon">
        <i class="fas fa-sync-alt"></i>
      </div>
      <a href="{{ route('complaint2.complaintlist') }}" class="small-box-footer">Lihat Butiran <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $complaintTotals }}</h3>

          <p>Jumlah Aduan Keseluruhan</p>
        </div>
        <div class="icon">
          <i class="fas fa-ticket-alt"></i>
        </div>
        <a href="{{ route('complaint2.complaintlist') }}" class="small-box-footer">Lihat Butiran <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
</div>
<br/>

@endsection

        