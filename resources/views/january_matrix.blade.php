@extends('welcome') 

@section('content')
<div>
    <form action="{{ url('/insert_calendar') }}" method="POST">
        @csrf
        <label for="year">Year:</label>
        <input type="number" name="year" required>
        
        <input type="number" name="month" min="0" max="12" required>
        <label for="startOfWeek">Start of Week:</label>
        <div class="w-48">
    <select name="start_of_week" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
        <option value="Mon" class="py-1">Monday</option>
        <option value="Sat" class="py-1">Saturday</option>
        <option value="Sun" class="py-1">Sunday</option>
    </select>
</div>

        <button type="submit">Generate Calendar</button>
    </form>
</div>
@endsection
