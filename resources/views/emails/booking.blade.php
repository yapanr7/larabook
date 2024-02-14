    <x-mail::message>

        Halo, {{ auth()->user()->name }} <br>

        Anda telah melakukan dengan detail sebagai berikut:

        - Booking Kode : {{ $booking->code }}
        - Paket: {{ $booking->package->name }}
        - Tanggal: {{ $booking->date }}
        - Waktu: {{ $booking->time }}


        Terima kasih telah melakukan pemesanan dengan kami!
        {{ $setting->app_name }}

        Visit url : {{ $url }}


    </x-mail::message>
