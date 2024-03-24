<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('balanza') }}'>
        <i class='nav-icon la la-cube'></i> Balanzas
    </a>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" data-toggle="collapse">
        <i class="la la-question-circle nav-icon"></i>Ayuda
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="la la-star nav-icon"></i>Uso del sistema
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('finanz.ayuda.importar-excel') }}">
                <i class="la la-star nav-icon"></i>Importar Excel
            </a>
        </li>
    </ul>
</li>
