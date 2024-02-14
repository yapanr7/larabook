@extends('layouts.app')

@section('content')
    <div class="container " style="margin-top:80px">
        <div class="row justify-content-center">

            <div class="col-md-8">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">

                        <h5>Informasi Booking</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                        </div>
                        <div class="table-responsive">

                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Package</strong></td>
                                    <td>{{ $booking->package->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Package</strong></td>
                                    <td>{{ number_format($booking->package->price) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah bayar</strong></td>
                                    <td>{{ number_format($booking->booking_amount) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tipe Pembayaran</b></td>
                                    <td>{{ $booking->payment_type}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal yang di Pesan</strong></td>
                                    <td>{{ $booking->date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Waktu</strong></td>
                                    <td>{{ $booking->time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat </strong></td>
                                    <td>{{ $booking->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">

                        <h5>Pembayaran</h5>
                    </div>
                    <div class="card-body">

                        <table class="table table-sm">
                            <tr>
                                <td><strong>Status Pembayaran</strong></td>
                                <td><span class="badge bg-primary">{{ $booking->payment_status }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($booking->payment_method === 'qris')
                    <div class="card">
                        <div class="card-body">

                            <h2 class="text-center">QRIS</h2>

                            <center>
                                <span class="badge badge-light">{{ strtoupper($status) }}</span>
                                <br>
                                <span>Rp.{{ number_format($amount) }}</span> <br>
                                <span>Berlaku sampai : {{ $expired_time }}</span>
                            </center>

                            <div class="d-flex justify-content-center">
                                <div class="col-3">
                                    <img src="{{ $qr_url }}" class="img-fluid">
                                </div>
                            </div>

                            <p class="text-center">Jika sudah melakukan scan dan pembayaran refresh untuk melihat status
                                transaksi</p>
                            <div class="d-flex justify-content-center mb-4">
                                <a class="btn btn-dark"
                                    href="{{ route('bookings.payment', $booking->reference) }}">Refresh</a>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($booking->payment_status === 'paid')
                    <div class="alert alert-success">
                        Pembayaran Berhasil!, Terima kasih telah booking!
                    </div>
                @else
                    <div class="alert alert-dark">
                        Pembayaran belum dilakukan. silahkan pilih proses pembayaran.
                    </div>
                    <div class="card">
                        <div class="card-header">

                            <h5>Proses Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            @if (!$booking->qr_url)
                                <form
                                    action="{{ route('booking.process_payment_qris', ['reference' => $booking->reference]) }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="qris">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold mb-2"><i
                                            class="fa fa-qrcode me-2"></i>QRIS</button>
                                </form>
                            @endif
                            <button class="btn btn-primary fw-bold w-100"><i class="fa fa-wallet me-2"></i>Transfer Bank</button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-12 col-md-2">
                <div class="card">
                    <div class="card-body">

                        <img class="img-fluid rounded " src="{{ asset('storage/' . $booking->package->image) }}"
                            alt="{{ $booking->package->name }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
