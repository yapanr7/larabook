@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:80px">
        <div class="row justify-content-center">

            <div class="col-md-6 mx-auto">

                <a href="{{ route('bookings.show', $booking->code) }}" class="btn btn-light w-100 fw-bold mb-4">
                    <i class="fa fa-arrow-left me-2"></i>Booking Info
                </a>

                <form id="paymentForm" action="{{ route('payment.process', $booking->code) }}" method="POST"
                  >
                    @csrf

                    <h5 class="text-center fw-bold mb-3">Pilih Tipe Pembayaran</h5>

                    <div class="row g-4 mb-3">

                        <div class="col-lg-6">
                            <div class="form-check card-radio">
                                <input id="partial" name="payment_type" value="partial" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="partial">
                                    <span class="fs-14 mb-1 text-wrap d-block">Pembayaran Uang Muka</span>
                                    <span
                                        class="fw-bold text-wrap d-block"><i>Rp.</i>{{ number_format($booking->package->minimal_booking_price) }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-check card-radio">
                                <input id="full" name="payment_type" value="full" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="full">
                                    <span class="fs-14 mb-1 text-wrap d-block">Pembayaran Penuh</span>
                                    <span
                                        class="fw-bold text-wrap d-block"><i>Rp.</i>{{ number_format($remainingPayment) }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-center fw-bold mb-3">Pilih Metode Pembayaran</h5>

                    <div class="row g-4 mb-3">

                        <div class="col-lg-6">
                            <div class="form-check card-radio">
                                <input id="qris" name="payment_method" value="qris" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="qris">
                                    <span class="fs-14 mb-1 text-wrap d-block">QRIS</span>
                                    <span class="fw-bold text-wrap d-block">Pembayaran Otomatis</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-check card-radio">
                                <input id="bank" name="payment_method" value="bank" type="radio" class="form-check-input"
                                    required>
                                <label class="form-check-label" for="bank">
                                    <span class="fs-14 mb-1 text-wrap d-block">Transfer Bank</span>
                                    <span class="fw-bold text-wrap d-block">Pembayaran Manual Cek</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    Harga :
                                    {{ formatRupiah($booking->package->price) }}
                                    <hr>
                                    Pembayaran berhasil :
                                    {{ formatRupiah($totalPaidAmount )}}
                                    <hr>
                                    Sisa Pembayaran :
                                    {{ formatRupiah($remainingPayment) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-label right w-100 fw-bold mb-5">
                        <i class="fa fa-arrow-right label-icon align-middle fs-16 ms-2"></i> Proses Pembayaran
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection
