@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Permohonan Rayuan Pindaan Syarat (PP-KPV-07)</h2>
    <form method="POST" action="{{ route('appeals.store') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Hantar Permohonan</button>
    </form>
</div>
@endsection 