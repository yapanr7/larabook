<x-mail::message>
    <h1>Lupa password</h1>
    Apakah Anda ingin melakukan reset password anda?

    Jika bukan anda, jangan berikan kepada siapapun atau hiraukan pesan ini.
    Thanks, {{ $setting->app_name }}

    <x-mail::button :url="route('reset.password.get', $token)">
        Reset Password
    </x-mail::button>

</x-mail::message>
