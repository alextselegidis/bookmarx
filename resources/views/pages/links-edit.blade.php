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
    {{$link->title}}
@endsection

@section('navTitle')
    {{__('edit_link')}}
@endsection

@section('navActions')
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{__('create')}}
    </a>

    <form action="{{route('links.destroy', $link->id)}}"
          method="POST"
          onsubmit="return confirm('{{__('delete_record_prompt')}}')">
        @csrf
        @method('DELETE')

        <button type="submit" class="nav-link">
            <i class="bi bi-trash me-2"></i>
            {{__('delete')}}
        </button>
    </form>
@endsection

@section('content')
<div>
    <div class="d-flex">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1">

            <form action="{{route('links.update', ['link' => $link->id])}}" method="POST" style="max-width: 800px;"
                  class="m-auto">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">
                        {{ __('title') }}
                    </label>
                    <input type="text" id="title" name="title" class="form-control"
                           value="{{ old('title', $link?->title ?? NULL) }}">
                    @error('title')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">
                        {{ __('url') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="url" id="url" name="url" class="form-control" required
                           value="{{ old('url', $link?->url ?? NULL) }}">
                    @error('url')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">
                        {{ __('notes') }}
                    </label>
                    <textarea type="url" id="notes" name="notes"
                              class="form-control">{{ old('notes', $link?->notes ?? NULL) }}</textarea>
                    @error('url')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if($tags->count())

                <h4>{{__('tags')}}</h4>

                @foreach ($tags as $tag)
                    <div>
                        <input
                            type="checkbox"
                            name="tags[]"
                            value="{{ $tag->id }}"
                            id="tag_{{ $tag->id }}"
                            @if(in_array($tag->id, old('tags', $link->tags->pluck('id')->toArray())))
                                checked
                            @endif
                        >
                        <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
                @endif


                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-primary" onclick="history.back()">
                        {{__('cancel')}}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{__('save')}}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

    @include('modals.create-modal', ['route' => route('links.store'), 'input_name' => 'url', 'input_type' => 'url'])


@endsection

