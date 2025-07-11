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
    {{$link->title}}
@endsection

@section('pageActions')
    <a href="{{ route('links.edit', ['link' => $link->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{__('edit')}}
    </a>

    <form action="{{route('links.destroy', $link->id)}}"
          method="POST"
          onsubmit="return confirm('{{__('deleteRecordPrompt')}}')">
        @csrf
        @method('DELETE')

        <button type="submit" class="nav-link">
            <i class="bi bi-trash me-2"></i>
            {{__('delete')}}
        </button>
    </form>
@endsection

@section('content')

    <div class="d-flex">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1">

            @include('shared.show-title', ['title' => $link->title, 'icon' => $link->favicon])
            @include('shared.show-id', ['label' => __('id'), 'value' => $link->id])
            @include('shared.show-value', ['label' => __('title'), 'value' => $link->title])
            @include('shared.show-link', ['label' => __('url'), 'href' => $link->url, 'value' => $link->formatted_url])
            @include('shared.show-date', ['label' => __('created'), 'value' => $link->created_at])
            @include('shared.show-value', ['label' => __('tags'), 'value' => $link->formatted_tags])
            @include('shared.show-bool', ['label' => __('archived'), 'value' => $link->is_archived])
            @include('shared.show-value', ['label' => __('notes'), 'value' => $link->notes])

        </div>
    </div>

@endsection

