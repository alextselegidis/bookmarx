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
    {{__('view_link')}}
@endsection

@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{__('create')}}
    </a>

    <a href="{{ route('links.edit', ['link' => $link->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{__('edit')}}
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
    <div class="d-flex flex-column-reverse flex-lg-row">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1">

            @include('shared.show-title', ['title' => $link->title, 'icon' => $link->favicon])

            <div class="d-lg-flex">
                <div class="w-100">
                    @include('shared.show-text', ['label' => __('title'), 'value' => $link->title])
                    @include('shared.show-link', ['label' => __('url'), 'href' => $link->url, 'value' => $link->formatted_url])
                    @include('shared.show-text', ['label' => __('tags'), 'value' => $link->formatted_tags])
                    @include('shared.show-bool', ['label' => __('archived'), 'value' => $link->is_archived])
                    @include('shared.show-text', ['label' => __('notes'), 'value' => $link->notes])
                </div>
                <div class="w-100">
                    @include('shared.show-date', ['label' => __('created'), 'value' => $link->created_at])
                    @include('shared.show-date', ['label' => __('updated'), 'value' => $link->updated_at])
                </div>
            </div>

        </div>
    </div>
</div>

    @include('modals.create-modal', ['route' => route('links.store'), 'input_name' => 'url', 'input_type' => 'url'])

@endsection

