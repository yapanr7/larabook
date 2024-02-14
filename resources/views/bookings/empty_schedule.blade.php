{{-- bookings/empty_schedule.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 100px">
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary rounded">
                    <div class="card-body">
                        <div class="justify-content-center text-center fw-bold text-white">
                            @if ($emptySlots->first())
                                {{ $emptySlots->first()['date'] }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- @dd($emptySlots) --}}
                            @foreach ($emptySlots as $emptySlot)
                                <div class="col-4 col-md-4 col-lg-2 mb-3">
                                    <div
                                        class="card {{ $emptySlot['isAvailable'] ? 'bg-primary' : 'bg-dark' }} rounded text-white">
                                        <div class="card-body">

                                            <h5 class="card-title text-white fw-bold">
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $emptySlot['time'])->format('H:i') }}
                                            </h5>
                                            <p class="card-text">
                                                {{ $emptySlot['isAvailable'] ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Display pagination links --}}
                        {{ $emptySlots->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
