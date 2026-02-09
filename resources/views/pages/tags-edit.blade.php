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

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="POST" id="edit-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-dark small fw-medium">
                                        <span class="text-danger">*</span> {{ __('name') }}
                                    </label>
                                    <input type="text" id="name" name="name" class="form-control" required
                                           value="{{ old('name', $tag?->name ?? null) }}">
                                    @error('name')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
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
        </div>
    </div>

    @include('modals.create-modal', ['route' => route('tags.store')])
@endsection

