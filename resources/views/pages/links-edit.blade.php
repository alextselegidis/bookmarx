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
    {{ $link->title }}
@endsection

@section('breadcrumbs')
    @include('shared.breadcrumb', ['breadcrumbs' => [
        ['label' => __('links'), 'url' => route('links')],
        ['label' => Str::limit($link->title, 30)]
    ]])
@endsection

@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{ __('add') }}
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
            @include('shared.edit-sidebar', ['items' => [
                ['label' => __('details'), 'route' => 'links.edit', 'params' => ['link' => $link->id], 'icon' => 'file-text']
            ]])
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('links.update', ['link' => $link->id]) }}" method="POST" id="edit-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label text-dark small fw-medium">
                                        {{ __('title') }}
                                    </label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           value="{{ old('title', $link?->title ?? null) }}">
                                    @error('title')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="url" class="form-label text-dark small fw-medium">
                                        <span class="text-danger">*</span> {{ __('url') }}
                                    </label>
                                    <input type="url" id="url" name="url" class="form-control" required
                                           value="{{ old('url', $link?->url ?? null) }}">
                                    @error('url')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label text-dark small fw-medium">
                                        {{ __('notes') }}
                                    </label>
                                    <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes', $link?->notes ?? null) }}</textarea>
                                    @error('notes')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                @if($tags->count())
                                    <div class="mb-3">
                                        <label class="form-label text-dark small fw-medium">
                                            {{ __('tags') }}
                                        </label>
                                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($tags as $tag)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                                           value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                                           @if(in_array($tag->id, old('tags', $link->tags->pluck('id')->toArray()))) checked @endif>
                                                    <label class="form-check-label" for="tag_{{ $tag->id }}">
                                                        {{ $tag->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label text-dark small fw-medium">
                                        {{ __('archived') }}
                                    </label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_archived" id="is_archived" value="1"
                                               @if(old('is_archived', $link->is_archived)) checked @endif>
                                        <label class="form-check-label" for="is_archived">
                                            {{ __('mark_as_archived') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Card Footer with Save Button -->
                <div class="card-footer bg-body-secondary border-top text-end py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="history.back()">
                        {{ __('cancel') }}
                    </button>
                    <button type="submit" form="edit-form" class="btn btn-dark">
                        {{ __('save') }}
                    </button>
                </div>
            </div>

    @include('modals.create-modal', ['route' => route('links.store'), 'input_name' => 'url', 'input_type' => 'url'])
@endsection

