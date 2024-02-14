@extends('layouts.app')

@section('content')

    <div class="container " style="margin-top:80px">
        {{-- <x-breadcrumb image="{{ asset('storage/' . $booking->package->image) }}" title="{{ $booking->code }}"
            description="{{ $booking->package->name }}" /> --}}

        <div class="row justify-content-center">

            <div class="col-md-6 mx-auto">
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
                @php
                    $bookingRibbonClass = '';

                    switch ($booking->status) {
                        case 'pending':
                            $bookingRibbonClass = 'ribbon-warning';
                            break;

                        case 'booked':
                            $bookingRibbonClass = 'ribbon-success';
                            break;

                        case 'cancel':
                            $bookingRibbonClass = 'ribbon-danger';
                            break;

                        default:
                            $bookingRibbonClass = 'ribbon-info';
                    }
                @endphp


                <img class="img-fluid rounded " src="{{ asset('storage/' . $booking->package->image) }}"
                    alt="{{ $booking->package->name }}">
                <div class="card ribbon-box right card-animate">
                    <div class="ribbon {{ $bookingRibbonClass }} ribbon-shape">
                        <span>{{ strtoupper($booking->status) }}</span>
                    </div>
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
                                    <td><strong>Minimal Booking</strong></td>
                                    <td>{{ number_format($booking->package->minimal_booking_price) }}</td>
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




            </div>

            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>History Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($booking->payments->isNotEmpty())
                                    @foreach ($booking->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->method }}</td>
                                            <td>{{ number_format($payment->amount) }}</td>
                                            <td>{{ $payment->status }}</td>
                                            <td>{{ $payment->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Belum Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($booking->download)
                    <a href="{{ $booking->download }}" class="btn btn-warning btn-secondary w-100 mt-3 download-booking">
                        <i class="fa fa-download me-2"></i>Download
                    </a>
                @else

                <a href="{{ route('payment.index', $booking->code) }}" class="btn btn-master btn-primary w-100 mt-3"><i
                    class="fa fa-arrow-right me-2"></i>Lanjutkan Booking</a>

                    <a href="#" class="btn btn-master btn-danger w-100 mt-3 cancel-booking"
                        data-booking-code="{{ $booking->code }}">
                        <i class="fa fa-times me-2"></i>Batalkan Booking
                    </a>
                @endif


            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil semua tombol dengan kelas cancel-booking
                var cancelBookingButtons = document.querySelectorAll('.cancel-booking');

                // Loop melalui setiap tombol
                cancelBookingButtons.forEach(function(button) {
                    // Tambahkan event listener untuk setiap tombol
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        // Ambil kode booking dari atribut data-booking-code
                        var bookingCode = button.getAttribute('data-booking-code');

                        // Tampilkan SweetAlert untuk konfirmasi
                        Swal.fire({
                            title: 'Konfirmasi Pembatalan Booking',
                            text: 'Apakah Anda yakin ingin membatalkan booking ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Batalkan!'
                        }).then((result) => {
                            // Jika pengguna mengklik tombol Ya
                            if (result.isConfirmed) {
                                // Redirect ke route pembatalan booking
                                window.location.href = '/booking/' + bookingCode + '/cancel';
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
