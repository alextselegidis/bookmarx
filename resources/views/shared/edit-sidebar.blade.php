{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://github.com/alextselegidis/bookmarx
 * ---------------------------------------------------------------------------- */
--}}
@php
    $items = $items ?? [];
    $activeRoute = request()->route()->getName();
    $activeItem = collect($items)->first(fn($item) => $item['route'] === $activeRoute) ?? $items[0] ?? null;
@endphp
<!-- Mobile Dropdown -->
<div class="d-lg-none mb-3">
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            @if($activeItem)
                @if(isset($activeItem['icon']))
                    <span>
                        <i class="bi bi-{{ $activeItem['icon'] }} me-2"></i>
                        {{ $activeItem['label'] }}
                    </span>
                @else
                    <span>{{ $activeItem['label'] }}</span>
                @endif
            @else
                <span>{{ __('menu') }}</span>
            @endif
        </button>
        <ul class="dropdown-menu w-100">
            @foreach($items as $item)
                <li>
                    <a class="dropdown-item {{ $activeRoute === $item['route'] ? 'active' : '' }}"
                       href="{{ route($item['route'], $item['params'] ?? []) }}">
                        @if(isset($item['icon']))
                            <i class="bi bi-{{ $item['icon'] }} me-2"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- Desktop Sidebar -->
<div class="d-none d-lg-block">
    <ul class="nav flex-column">
        @foreach($items as $item)
            <li class="nav-item">
                <a class="nav-link px-0 py-2 d-flex align-items-center {{ $activeRoute === $item['route'] ? 'text-primary fw-medium' : 'text-body' }}"
                   href="{{ route($item['route'], $item['params'] ?? []) }}">
                    @if(isset($item['icon']))
                        <i class="bi bi-{{ $item['icon'] }} me-3 text-muted"></i>
                    @endif
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
