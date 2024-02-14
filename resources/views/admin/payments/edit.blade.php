<!-- resources/views/admin/payments/edit.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Payment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payments.update', ['payment' => $payment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tambahkan field formulir untuk pengeditan detail pembayaran di sini -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $payment->amount }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="method" class="form-label">Method</label>
                            <select class="form-control" id="method" name="method">
                                <option value="cash" {{ $payment->method === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank" {{ $payment->method === 'bank' ? 'selected' : '' }}>Bank</option>
                                <option value="qris" {{ $payment->method === 'qris' ? 'selected' : '' }}>QRIS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status_payment" class="form-label">Status</label>
                            <select class="form-control" id="status_payment" name="status">
                                <option value="unpaid" {{ $payment->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="expired" {{ $payment->status === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
