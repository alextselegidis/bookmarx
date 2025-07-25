{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Open Source Telemetry
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */
--}}

<h2 class="fs-3 mt-1 mb-3 text-muted">
    {{__('settings')}}
</h2>

<ul id="settings-nav" class="nav flex-column fw-bold fs-5 sidebar-width">
    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('settings') }}">
            <i class="bi bi-gear fs-4"></i>
            {{__('general')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('links') }}">
            <i class="bi bi-link-45deg fs-4"></i>
            {{__('links')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('tags') }}">
            <i class="bi bi-tags fs-4"></i>
            {{__('tags')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('users') }}">
            <i class="bi bi-people fs-4"></i>
            {{__('users')}}
        </a>
    </li>
</ul>
