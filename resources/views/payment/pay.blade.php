@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:80px">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <a href="{{ route('bookings.show', $booking->code) }}" class="btn btn-light w-100 fw-bold mb-4">
                    <i class="fa fa-arrow-left me-2"></i>
                </a>

                @php
                $ribbonClass = '';
                switch ($payment->status) {
                    case 'unpaid':
                        $ribbonClass = 'ribbon-warning';
                        break;

                    case 'paid':
                        $ribbonClass = 'ribbon-success';
                        break;

                    default:
                        $ribbonClass = 'ribbon-info';
                }
            @endphp

            @if ($payment->method === 'qris')
                <div class="card ribbon-box right card-animate">
                    <div class="card-body">
                        <div class="ribbon {{ $ribbonClass }} ribbon-shape">
                            <span>{{ strtoupper($payment->status) }}</span>
                        </div>

                        <h2 class="text-center">QRIS</h2>
                        <center>
                            <span>Rp.{{ number_format($payment->amount) }}</span> <br>
                            <span>Berlaku sampai: {{ \Carbon\Carbon::createFromTimestamp($payment->expired_time)->format('d F Y H:i:s') }}</span>

                        </center>

                        <div class="d-flex justify-content-center">
                            <div class="col-8 mx-auto">
                                <img src="{{ $payment->qr_url }}" class="img-fluid">
                            </div>
                        </div>

                        <p class="text-center">Jika sudah melakukan scan dan pembayaran, refresh untuk melihat status transaksi</p>

                        <div class="d-flex justify-content-center mb-4">
                            <a href="{{ url()->current() }}" class="btn btn-dark w-100 fw-bold">Refresh</a>
                        </div>


                        <div class="d-flex justify-content-center mb-4">
                            <a href="{{ $payment->checkout_url }}" target="_blank" class="btn btn-dark w-100 fw-bold">Check</a>
                        </div>


                    </div>
                </div>

                <hr>
            @endif

                   <div class="card ">
                        <div class="card-body">
                            <h5>Jumlah Pembayaran : <i>Rp.</i>{{ number_format($payment->amount) }}</h5>
                            <p>Silakan transfer ke salah satu rekening dibawah, jika sudah melakukan transfer harap konfirmasi ke Admin.</p>
                        </div>
                    </div>

                    <a href="#bankTransfer" class="btn btn-light w-100 fw-bold mb-4">
                        Bank Transfer
                    </a>
                    <div id="bankTransfer">

                        @if($banks->isEmpty())
                        <p class="text-center">Bank belum ditambahkan</p>
                    @else
                        @foreach ($banks as $bank)
                            <div class="card mb-3 card-animate">
                                <div class="row g-0">
                                    <div class="col-4 bg-gray p-2">
                                        <img class="img-fluid" src="{{ asset('storage/banks/'. $bank->image)}}" alt="{{ $bank->name }}" class="img-fluid">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 >{{ $bank->name }} </h5>
                                            <label for="bank{{ $bank->id}}">{{ $bank->holder }}</label>
                                            <input class="form-control" type="text" disabled value="{{ $bank->account}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    </div>

                   @if ($payment->status === 'paid')
                        <div class="alert alert-success mt-3">
                          Pembayaran Sudah Selesai.
                        </div>
                    @endif


            </div>
        </div>
    </div>
@endsection
