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
    {{__('dashboard')}}
@endsection

@section('breadcrumbs')
    @include('shared.breadcrumb', ['breadcrumbs' => [
        ['label' => __('dashboard')]
    ]])
@endsection

@section('navActions')
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{__('add')}}
    </a>
@endsection

@section('content')
    <div>
        <div class="row mb-3 mb-lg-0">
            <div class="col-lg-6">
                <form action="{{route('dashboard')}}" method="GET" class="mb-3">
                    @csrf
                    @method('GET')
                    <div class="input-group mb-3">
                    <span class="bg-body-tertiary input-group-text px-3">
                        <i class="bi bi-search"></i>
                    </span>
                        <input type="text" id="q" name="q" class="form-control bg-body-tertiary border-start-0"
                               value="{{$q}}"
                               placeholder="{{__('search')}}" autofocus tabindex="-1" style="max-width: 300px;">
                    </div>
                </form>
            </div>

            @php
                $toggleArchivedUrl = request()->fullUrlWithQuery([
                    'show_archived' => $showArchived ? 0 : 1,
                ]);
            @endphp

            <div class="col-lg-6 text-lg-end">

                {{-- TAG FILTER --}}

                <div class="d-lg-flex justify-content-lg-end gap-lg-4 align-items-center">

                    @if($tags->count())
                        <div class="d-flex gap-2 mb-3 mb-lg-0">
                            <div class="dropdown flex-grow-1 flex-lg-grow-0">
                                <button class="btn btn-primary dropdown-toggle w-100 w-lg-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($selectedTagId)
                                        {{ $tags->firstWhere('id', $selectedTagId)?->name ?? __('filter_by_tag') }}
                                    @else
                                        {{ __('filter_by_tag') }}
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end w-100" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($tags as $tag)
                                        <li>
                                            <a class="dropdown-item {{ $selectedTagId == $tag->id ? 'active' : '' }}"
                                               href="{{ route('dashboard', ['q' => $q, 'show_archived' => $showArchived ? 1 : 0, 'tag_id' => $tag->id]) }}">
                                                {{ $tag->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if($selectedTagId)
                                <a href="{{ route('dashboard', ['q' => $q, 'show_archived' => $showArchived]) }}"
                                   class="btn btn-primary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                    <a href="{{ $toggleArchivedUrl }}"
                       class="btn {{$showArchived ? 'btn-primary' : 'btn-outline-primary'}} w-100 w-lg-auto">
                        {{ __($showArchived ? 'hide_archived' : 'show_archived') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- LIST LINKS --}}

        @if ($links->count())

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($links as $link)
                    <div class="col">
                        <div class="card h-100 shadow-sm card-hover-move {{ $link->is_archived ? 'bg-opacity-10 bg-warning' : '' }}"
                             style="border-bottom: 5px solid {{ $link->theme_color ?? '#dee2e6' }};">
                            @if ($link->og_image)
                                <img src="data:image/x-icon;base64,{{ $link->og_image }}"
                                     class="card-img-top"
                                     alt="Preview" style="width: 100%; height: 150px; object-fit: cover;">
                            @elseif ($link->favicon)
                                <img src="data:image/x-icon;base64,{{ $link->favicon }}"
                                     class="card-img-top p-4"
                                     alt="Favicon" style="width: 100%; height: 150px; object-fit: contain;">
                            @else
                                <img src="{{ url('images/logo.png') }}" class="card-img-top p-4"
                                     alt="Favicon" style="width: 100%; height: 150px; object-fit: contain;">
                            @endif

                            <a href="{{ $link->url }}" target="_blank" class="text-decoration-none">
                                <div class="card-body">
                                    <h6 class="card-title text-body">
                                        {{ $link->title ? Str::limit($link->title, 100) : 'No Title' }}
                                    </h6>
                                    <p class="card-text text-truncate small" style="color: #0d6efd;">
                                        {{ $link->formatted_url }}
                                    </p>
                                    <div class="mb-2" style="min-height: 24px;">
                                        @if ($link->tags()->count())
                                            @foreach($link->tags as $tag)
                                                <span class="badge bg-dark">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <div class="card-footer bg-body-secondary text-muted small d-flex align-items-center">
                                {{ $link->created_at->locale(app()->getLocale())->isoFormat('L LT') }}
                                <a href="{{ route('links.edit', ['link' => $link]) }}" class="ms-auto" title="{{ __('edit') }}">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="{{ route('links.archive', ['link' => $link]) }}" class="ms-3" title="{{ __($link->is_archived ? 'unarchive' : 'archive') }}">
                                    <i class="bi bi-{{ $link->is_archived ? 'archive-fill' : 'archive' }}"></i>
                                </a>

                                <form action="{{ route('links.destroy', $link->id) }}"
                                      method="POST"
                                      class="ms-3"
                                      onsubmit="return confirm('{{ __('delete_record_prompt') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent p-0 text-danger" title="{{ __('delete') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center my-5 py-5">
                <div class="mb-5">
                    <i class="bi bi-search display-1 text-primary"></i>
                </div>
                <h1>
                    {{__('no_links_found')}}
                </h1>
            </div>

        @endif

        @if ($length)
            <div class="text-center mt-4">
                <a href="{{ request()->fullUrlWithQuery(['length' => $length + 25]) }}" class="btn btn-outline-primary">
                    {{ __('show_more') }}
                </a>
            </div>
        @endif
    </div>

    @include('modals.create-modal', ['route' => route('links.store'), 'title' => __('add'), 'input_name' => 'url', 'input_type' => 'url'])

@endsection

