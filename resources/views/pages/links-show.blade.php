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
    {{ $link->title }}
@endsection

@section('navTitle')
    {{ __('view_link') }}
@endsection

@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{ __('create') }}
    </a>

    <a href="{{ route('links.edit', ['link' => $link->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{ __('edit') }}
    </a>

    <form action="{{ route('links.destroy', $link->id) }}"
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
        <h5 class="fw-bold mb-3">{{ __('details') }}</h5>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6">
                        @include('shared.show-text', ['label' => __('title'), 'value' => $link->title])
                        @include('shared.show-link', ['label' => __('url'), 'href' => $link->url, 'value' => $link->formatted_url, 'target' => '_blank'])

                        <div class="mb-3">
                            <label class="form-label text-primary small fw-medium mb-1">{{ __('tags') }}</label>
                            <div>
                                @if($link->tags->count())
                                    @foreach($link->tags as $tag)
                                        <span class="badge bg-light text-dark border">{{ $tag->name }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        @include('shared.show-bool', ['label' => __('archived'), 'value' => $link->is_archived])
                    </div>
                    <div class="col-lg-6">
                        @include('shared.show-text', ['label' => __('notes'), 'value' => $link->notes])
                        @include('shared.show-date', ['label' => __('created'), 'value' => $link->created_at])
                        @include('shared.show-date', ['label' => __('updated'), 'value' => $link->updated_at])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.create-modal', ['route' => route('links.store'), 'input_name' => 'url', 'input_type' => 'url'])
@endsection

