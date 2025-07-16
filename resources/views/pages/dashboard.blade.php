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

@extends('layouts.main-layout')

@section('pageTitle')
    {{__('dashboard')}}
@endsection

@section('pageActions')
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{__('add')}}
    </a>
@endsection

@section('content')
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
            <a href="{{ $toggleArchivedUrl }}" class="btn {{$showArchived ? 'btn-primary' : 'btn-outline-primary'}} w-100 w-lg-auto">
                {{ __($showArchived ? 'hide_archived' : 'show_archived') }}
            </a>
        </div>
    </div>

    @if ($links->count())

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($links as $link)
                <div class="col">
                    <div class="card h-100 shadow-sm card-hover-move position-relative"
                         style="border-bottom: 5px solid {{ $link->theme_color ?? '#dee2e6' }};">
                        @if ($link->favicon)
                            <img src="data:image/x-icon;base64,{{ $link->favicon }}" class="card-img-top bg-light p-2"
                                 alt="Favicon" style="width: 100%; height: 150px; object-fit: contain;">
                        @else
                            <img src="{{ url('images/logo.png') }}" class="card-img-top bg-light p-2"
                                 alt="Favicon" style="width: 100%; height: 150px; object-fit: contain;">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title text-body">
                                {{ $link->title ?? 'No Title' }}
                            </h5>
                            <p class="card-text text-truncate">
                                <a href="{{ $link->url }}" target="_blank"
                                   class="text-decoration-none stretched-link">{{ $link->formatted_url }}</a>
                            </p>

                            @if ($link->tags()->count())
                                <div class="mb-2">
                                    @foreach($link->tags as $tag)
                                        <span class="badge bg-secondary">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="card-footer text-muted small d-flex">
                            {{ $link->created_at->format('Y-m-d H:i') }}

                            <a href="{{route('links.edit', ['link' => $link])}}" class="ms-auto">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="{{route('links.archive', ['link' => $link])}}" class="ms-3">
                                <i class="bi bi-{{$link->is_archived ? 'archive-fill' : 'archive'}}"></i>
                            </a>

                            <form action="{{route('links.destroy', $link->id)}}"
                                  method="POST"
                                  class="ms-3"
                                  onsubmit="return confirm('{{__('delete_record_prompt')}}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h1 class="text-center my-5 py-5 d-flex align-items-center justify-content-center display-1 fw-light">
            <i class="bi bi-search me-4"></i>
            {{__('no_links_found')}}
        </h1>
    @endif

    @include('modals.create-modal', ['route' => route('links.store'), 'title' => __('add'), 'input_name' => 'url', 'input_type' => 'url'])

@endsection

