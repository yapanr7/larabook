<!-- resources/views/admin/settings/index.blade.php -->

@extends('layouts.admin')

@section('content')

     <div class="col-md-6 mx-auto">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="app_name" class="form-label">Nama Aplikasi</label>
                <input type="text" class="form-control" id="app_name" name="app_name" value="{{ optional($settings)->app_name }}" required>
            </div>

            <div class="mb-3">
                <label for="app_tagline" class="form-label">Tagline</label>
                <input type="text" class="form-control" id="app_tagline" name="app_tagline" value="{{ optional($settings)->app_tagline }}" required>
            </div>

            <div class="mb-3">
                <label for="app_logo" class="form-label">Logo Aplikasi</label>
                <input type="file" class="form-control" id="app_logo" name="app_logo">
                @if(optional($settings)->app_logo)
                    <img src="{{ asset('storage/logo/'.optional($settings)->app_logo) }}" alt="App Logo" class="mt-2 img-thumbnail" style="max-width: 200px">
                @endif
            </div>

            <div class="mb-3">
                <label for="favicon" class="form-label">Favicon</label>
                <input type="file" class="form-control" id="favicon" name="app_favicon">
                @if(optional($settings)->app_favicon)
                    <img src="{{ asset('storage/favicon/'.optional($settings)->app_favicon) }}" alt="Favicon" class="mt-2 img-thumbnail" style="max-width: 200px">
                @endif
            </div>



            <div class="mb-3">
                <label for="app_background" class="form-label">Background</label>
                <input type="file" class="form-control" id="app_background" name="app_background">
                @if(optional($settings)->app_background)
                    <img src="{{ asset('storage/background/'.optional($settings)->app_background) }}" alt="App Logo" class="mt-2 img-thumbnail" style="max-width: 200px">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Pembayaran QRIS</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="enable_qris_payment" id="enable_qris_payment_true" value="1" {{ $settings->enable_qris_payment ? 'checked' : '' }}>
                    <label class="form-check-label" for="enable_qris_payment_true">
                        Aktif
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="enable_qris_payment" id="enable_qris_payment_false" value="0" {{ !$settings->enable_qris_payment ? 'checked' : '' }}>
                    <label class="form-check-label" for="enable_qris_payment_false">
                        Tidak Aktif
                    </label>
                </div>
            </div>


            <div class="mb-3">
                <label for="tripay_merchant_code" class="form-label">Tripay Merchant Code</label>
                <input type="text" class="form-control" id="tripay_merchant_code" name="tripay_merchant_code" value="{{ optional($settings)->tripay_merchant_code }}" required>
            </div>

            <div class="mb-3">
                <label for="tripay_api_key" class="form-label">Tripay API Key</label>
                <input type="text" class="form-control" id="tripay_api_key" name="tripay_api_key" value="{{ optional($settings)->tripay_api_key }}" required>
            </div>

            <div class="mb-3">
                <label for="tripay_private_key" class="form-label">Tripay Private Key</label>
                <input type="text" class="form-control" id="tripay_private_key" name="tripay_private_key" value="{{ optional($settings)->tripay_private_key }}" required>
            </div>

            <div class="mb-3">
                <label for="tripay_transaction_url" class="form-label">Tripay Transaction URL</label>
                <input type="url" class="form-control" id="tripay_transaction_url" name="tripay_transaction_url" value="{{ optional($settings)->tripay_transaction_url }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
            </div>
        </div>

     </div>
@endsection
