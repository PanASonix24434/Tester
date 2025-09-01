@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Appeal Details</h1>

        <div>
            <strong>ID:</strong> {{ $appeal->id }}<br>
            <strong>Status:</strong> {{ $appeal->status }}<br>  
            <strong>Applicant ID:</strong> {{ $appeal->applicant_id }}<br>
        </div>

        <a href="{{ route('appeals.edit', $appeal->id) }}" class="btn btn-primary">Edit</a>
    </div>
@endsection
