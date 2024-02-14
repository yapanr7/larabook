@extends('layouts.admin')

@section('content')
    <div class="mb-3">


        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>

    </div>
    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Booking Details</h4>

                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th scope="row">Booking Code</th>
                                <td>{{ $booking->code }}</td>
                            </tr>
                            <tr>
                                <th scope="row">User</th>
                                <td>{{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Package</th>
                                <td>{{ $booking->package->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date</th>
                                <td>{{ $booking->date }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Time</th>
                                <td>{{ $booking->time }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Booking Status</th>
                                <td>{{ $booking->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Created At</th>
                                <td>{{ $booking->created_at }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Updated At</th>
                                <td>{{ $booking->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

        <div class="col-md-4">
            @forelse ($booking->payments->sortByDesc('created_at') as $payment)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">
                        {{ strtoupper($payment->method) }}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td>Rp.{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->status }}</td>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <p>No payments for this booking.</p>
        @endforelse

        </div>
    </div>
@endsection
