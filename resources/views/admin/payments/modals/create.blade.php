<!-- resources/views/admin/payments/modals/create.blade.php -->
<div class="modal fade" id="createPaymentModal" tabindex="-1" role="dialog" aria-labelledby="createPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPaymentModalLabel">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="booking_id" class="form-label">Booking</label>
                        <select class="form-control" data-choices id="booking_id" name="booking_id" required>
                            <option value="" disabled selected>Select Booking</option>
                            @foreach ($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->code }} : {{ $booking->user->name }} : {{ $booking->package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="method" class="form-label">Method</label>
                        <select class="form-control" id="method" name="method">
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_payment" class="form-label">Status</label>
                        <select class="form-control" id="status_payment" name="status">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
