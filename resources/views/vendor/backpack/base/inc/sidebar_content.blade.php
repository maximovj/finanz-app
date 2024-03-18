<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('balanza') }}'>
        <i class='nav-icon la la-star'></i> Balanzas
    </a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('informe-financiero') }}'>
        <i class='nav-icon la la-star'></i> Informe financieros
    </a>
</li>
