<div class="p-4">
    <h1 class="text-3xl font-bold mb-4">Dynamic Calendar</h1>

    <form wire:submit.prevent="generateCalendar">
        @csrf
        <label for="starting_day" class="mr-2">Select Starting Day:</label>
       
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Show Calendar</button>
    </form>

 

    <table class="mt-4">
        <tr>
            <th class="px-4 py-2">Sun</th>
            <th class="px-4 py-2">Mon</th>
            <th class="px-4 py-2">Tue</th>
            <th class="px-4 py-2">Wed</th>
            <th class="px-4 py-2">Thu</th>
            <th class="px-4 py-2">Fri</th>
            <th class="px-4 py-2">Sat</th>
        </tr>
        @foreach ($calendarMatrix as $row)
            <tr>
                @foreach ($row as $cell)
                    <td class="px-4 py-2">{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
