{{-- bookings/schedule.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:400px">

        <h2>Schedule from {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</h2>

        @if ($bookings->isEmpty())
            <p>No bookings available for the selected period.</p>
        @else
            <ul>
                @foreach ($bookings as $booking)
                    <li>
                        Date: {{ $booking->date }}, Time: {{ $booking->time }}, Note: {{ $booking->note ?? '-' }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
