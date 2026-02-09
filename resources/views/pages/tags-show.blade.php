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

    <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{ __('edit') }}
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
            @include('shared.settings-sidebar')
        </div>

        <!-- Main Content -->

        <div class="flex-grow-1">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">

                            @include('shared.show-text', ['label' => __('name'), 'value' => $tag->name])
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-medium mb-1">{{ __('count') }}</label>
                                <div>
                                    <span class="badge bg-primary">{{ $tag->count }}</span>
                                    <span class="text-muted small ms-1">{{ __('links') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @include('shared.show-date', ['label' => __('created'), 'value' => $tag->created_at])
                            @include('shared.show-date', ['label' => __('updated'), 'value' => $tag->updated_at])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connected Links -->

            @if($links->count())
                <h6 class="text-secondary fw-medium mb-3">{{ __('links') }}</h6>
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-body-tertiary">
                                    <tr>
                                        <th class="border-0 py-3 px-4">{{ __('title') }}</th>
                                        <th class="border-0 py-3 px-4">{{ __('url') }}</th>
                                        <th class="border-0 py-3 px-4">{{ __('created') }}</th>
                                        <th class="border-0 py-3 px-4 text-end">{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($links as $link)
                                        <tr>
                                            <td class="py-3 px-4">
                                                <div class="d-flex align-items-center">
                                                    @if ($link->favicon)
                                                        <img src="data:image/x-icon;base64,{{ $link->favicon }}"
                                                             alt="Favicon" class="me-2" style="width: 16px; height: 16px;">
                                                    @endif
                                                    <a href="{{ route('links.show', $link) }}" class="text-decoration-none">
                                                        {{ Str::limit($link->title, 40) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <a href="{{ $link->url }}" target="_blank" class="text-decoration-none small">
                                                    {{ Str::limit($link->formatted_url, 40) }}
                                                </a>
                                            </td>
                                            <td class="py-3 px-4 text-muted small">
                                                {{ $link->created_at->locale(app()->getLocale())->isoFormat('L') }}
                                            </td>
                                            <td class="py-3 px-4 text-end">
                                                <a href="{{ route('links.edit', $link) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
            @endif
        </div>
    </div>

    @include('modals.create-modal', ['route' => route('tags.store')])
@endsection

