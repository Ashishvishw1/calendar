@extends('welcome') {{-- Adjust this to your layout name if needed --}}

@section('content')
<div>
@if(isset($imagePath))
        <img src="{{ asset('images/generated_calendar.jpg') }}" alt="Generated Calendar">
    @else
        <p>No image available.</p>
    @endif
</div>
@endsection
