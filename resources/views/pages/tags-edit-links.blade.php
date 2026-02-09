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
@extends('layouts.main-layout')
@section('pageTitle')
    {{ $tag->name }}
@endsection
@section('breadcrumbs')
    @include('shared.breadcrumb', ['breadcrumbs' => [
        ['label' => __('tags'), 'url' => route('tags')],
        ['label' => $tag->name]
    ]])
@endsection
@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{ __('create') }}
    </a>
    <form action="{{ route('tags.destroy', $tag->id) }}"
          method="POST"
          onsubmit="return confirm('{{ __('delete_record_prompt') }}')">
        @csrf
        @method('DELETE')
        <button type="submit" class="nav-link">
            <i class="bi bi-trash me-2"></i>
            {{ __('delete') }}
        </button>
    </form>
@endsection
@section('content')
    <div class="d-flex flex-column flex-lg-row gap-4">
        <!-- Sidebar -->
        <div class="flex-shrink-0" style="min-width: 200px;">
            @include('shared.edit-sidebar', ['items' => [
                ['label' => __('details'), 'route' => 'tags.edit', 'params' => ['tag' => $tag->id], 'icon' => 'file-text'],
                ['label' => __('links'), 'route' => 'tags.edit.links', 'params' => ['tag' => $tag->id], 'icon' => 'link-45deg']
            ]])
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <!-- Table -->
                    <div class="table-responsive" style="overflow: visible;">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-0 ps-4 text-white">{{ __('title') }}</th>
                                    <th class="border-0 text-white">{{ __('url') }}</th>
                                    <th class="border-0 text-white">{{ __('created') }}</th>
                                    <th class="border-0 pe-4 text-end" style="width: 100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $link)
                                    <tr onclick="window.location='{{ route('links.edit', $link->id) }}'" style="cursor: pointer;">
                                        <td class="border-0 ps-4">
                                            <div class="d-flex align-items-center">
                                                @if ($link->favicon)
                                                    <img src="data:image/x-icon;base64,{{ $link->favicon }}"
                                                         alt="Favicon" class="me-2" style="width: 16px; height: 16px;">
                                                @endif
                                                <span class="fw-medium">{{ Str::limit($link->title, 40) }}</span>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <a href="{{ $link->url }}" target="_blank" class="text-decoration-none" onclick="event.stopPropagation();">
                                                {{ Str::limit($link->formatted_url, 30) }}
                                                <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                            </a>
                                        </td>
                                        <td class="border-0 text-muted small">
                                            {{ $link->created_at->locale(app()->getLocale())->isoFormat('L') }}
                                        </td>
                                        <td class="border-0 pe-4 text-end">
                                            <div class="dropdown" onclick="event.stopPropagation();">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    {{ __('actions') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('links.edit', ['link' => $link->id]) }}" class="dropdown-item">
                                                            <i class="bi bi-pencil me-2"></i>{{ __('edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('links.destroy', $link->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('{{ __('delete_record_prompt') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>{{ __('delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($links->isEmpty())
                                    <tr>
                                        <td colspan="4" class="border-0 text-center text-muted py-5">
                                            <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                            {{ __('no_records_found') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($links->hasPages())
                    <div class="card-footer bg-body-secondary border-top py-3 px-4">
                        {{ $links->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('modals.create-modal', ['route' => route('tags.store')])
@endsection
