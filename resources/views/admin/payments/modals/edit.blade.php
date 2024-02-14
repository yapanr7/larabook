<!-- resources/views/admin/payments/modals/edit.blade.php -->
<div class="modal fade" id="editPaymentModal{{ $payment->id }}" role="dialog"
    aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Edit Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.payments.update', ['payment' => $payment->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Add your form fields for editing payment details here -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{ $payment->amount }}"
                            required>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
