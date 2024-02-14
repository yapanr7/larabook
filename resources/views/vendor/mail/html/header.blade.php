@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ asset('storage/favicon/' . $setting->app_favicon) }}" alt="{{ $setting->app_favicon }}"
                    class="logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
