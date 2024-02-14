@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Payments</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2">
                                <a class="btn btn-danger fw-bold add-btn" href="{{ route('admin.payments.index') }}"><i
                                        class="ri-refresh align-bottom me-1"></i> Refresh </a>
                                <button type="button" class="btn btn-primary fw-bold add-btn" data-bs-toggle="modal"
                                    data-bs-target="#createPaymentModal">
                                    <i class="ri-add-fill align-bottom me-1"></i> Create Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET" action="{{ route('admin.payments.index') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-xxl-4 col-sm-4">
                                <input type="text" class="form-control bg-light border-light" id="demo-datepicker"
                                    data-provider="flatpickr" name="date_range" data-date-format="Y-m-d"
                                    data-range-date="true" placeholder="Select date range">
                            </div>
                            <div class="col-xxl-4 col-sm-4">
                                <div class="input-light">
                                    <select name="payment_status" class="form-control" data-choices id="payment_status">
                                        <option value="all" selected>all</option>
                                        <option value="unpaid">unpaid</option>
                                        <option value="paid">paid</option>
                                        <option value="failed">failed</option>
                                        <option value="expired">expired</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-sm-4">
                                <button type="submit" class="btn btn-primary w-100"> <i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                            <thead class="table-success">
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Customer</th>
                                    <th>Jumlah</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Package</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="list form-check-all">
                                @foreach ($payments as $payment)
                                    @php
                                        $totalPayments = $payment->booking->payments->sum('amount');
                                    @endphp

                                    <tr>
                                        <td class="fw-bold">{{ $payment->booking->code }}</td>
                                        <td class="fw-semibold">{{ $payment->user->name }}</td>
                                        <td><i>Rp.</i>{{ number_format($payment->amount) }}</td>
                                        <td><span class="badge bg-primary text-uppercase">{{ $payment->method }}</span></td>
                                        <td>
                                            <button
                                                class="btn btn-sm fw-bold
                                            @if ($payment->status == 'unpaid') btn-light
                                            @elseif($payment->status == 'paid') btn-success
                                            @elseif($payment->status == 'failed') btn-warning
                                            @elseif($payment->status == 'expired') btn-secondary @endif
                                            change-status">
                                                {{ $payment->status }}
                                            </button>
                                        </td>
                                        <td>{{ $payment->booking->package->name }}</td>
                                        <td>{{ $payment->created_at }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.payments.edit', $payment->id)}}" class="btn btn-warning btn-sm edit-payment-btn" data-payment_id="{{ $payment->id }}">
                                                Edit
                                            </a>


                                            <!-- Tombol Delete -->
                                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class=" mt-2">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.payments.modals.create')
@endsection
