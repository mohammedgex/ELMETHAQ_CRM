@php
    $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboard_url = $dashboard_url ? route($dashboard_url) : '';
    } else {
        $dashboard_url = $dashboard_url ? url($dashboard_url) : '';
    }
@endphp

<a href="{{ $dashboard_url }}" class="brand-link {{ config('adminlte.classes_brand') }}">

    <img src="{{ $appLogoImg ?? asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
        alt="{{ $appLogoText ?? config('adminlte.logo_img_alt', 'AdminLTE') }}"
        class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}"
        style="opacity:.8; max-height: 35px;">

    <span class="brand-text font-weight-light">
        {{ $appLogoText ?? config('adminlte.logo', 'AdminLTE') }}
    </span>

</a>
