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

<ul id="settings-nav" class="nav flex-column fw-bold fs-5">
    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2" href="{{ route('settings') }}">
            <i class="bi bi-gear me-2"></i>
            {{__('general')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2" href="{{ route('links') }}">
            <i class="bi bi-link-45deg me-2"></i>
            {{__('links')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2" href="{{ route('tags') }}">
            <i class="bi bi-tags me-2"></i>
            {{__('tags')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2" href="{{ route('users') }}">
            <i class="bi bi-people me-2"></i>
            {{__('users')}}
        </a>
    </li>
</ul>
