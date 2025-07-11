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
    {{$tag->name}}
@endsection

@section('pageActions')
    <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{__('edit')}}
    </a>

    <form action="{{route('tags.destroy', $tag->id)}}"
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

            @include('shared.show-title', ['title' => $tag->name])
            @include('shared.show-id', ['label' => __('id'), 'value' => $tag->id])
            @include('shared.show-date', ['label' => __('created'), 'value' => $tag->created_at])
            @include('shared.show-value', ['label' => __('count'), 'value' => $tag->count])

        </div>

    </div>

@endsection

