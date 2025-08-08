{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */
--}}

@php use App\Models\User; @endphp
@php use App\Models\Setting; @endphp

<h1 class="fs-3 mb-4 text-muted">
    {{__('menu')}}
</h1>

<ul id="settings-nav" class="nav flex-column fw-bold fs-5 sidebar-width">
    @can('viewAny', Setting::class)
        <li class="nav-item mb-3">
            <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('settings') }}">
                <i class="bi bi-gear fs-4 text-muted"></i>
                {{__('general')}}
            </a>
        </li>
    @endcan

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('links') }}">
            <i class="bi bi-link-45deg fs-4 text-muted"></i>
            {{__('links')}}
        </a>
    </li>

    <li class="nav-item mb-3">
        <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('tags') }}">
            <i class="bi bi-tags fs-4 text-muted"></i>
            {{__('tags')}}
        </a>
    </li>

    @can('viewAny', User::class)
        <li class="nav-item mb-3">
            <a class="nav-link px-0 py-2 d-flex align-items-center gap-3 text-primary" href="{{ route('users') }}">
                <i class="bi bi-people fs-4 text-muted"></i>
                {{__('users')}}
            </a>
        </li>
    @endcan
</ul>
