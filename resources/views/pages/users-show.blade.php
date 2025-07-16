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
    {{$user->name}}
@endsection

@section('pageActions')
    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{__('edit')}}
    </a>

    <form action="{{route('users.destroy', $user->id)}}"
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

    <div class="d-flex">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1">

            @include('shared.show-title', ['title' => $user->name])
            @include('shared.show-id', ['label' => __('id'), 'value' => $user->id])
            @include('shared.show-link', ['label' => __('email'), 'href' => 'mailto:' . $user->email, 'value' => $user->email])
            @include('shared.show-date', ['label' => __('created'), 'value' => $user->created_at])
            @include('shared.show-bool', ['label' => __('active'), 'value' => $user->is_active])

        </div>
    </div>

@endsection

