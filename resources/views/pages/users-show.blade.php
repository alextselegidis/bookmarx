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
    {{__('user')}}: {{$user->name}}
@endsection

@section('pageActions')
    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{__('edit')}}
    </a>

    <form action="{{route('users.destroy', $user->id)}}"
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

            <div class="mb-3">
                <a href="mailto:{{$user->email}}">
                    <i class="bi bi-envelope me-2"></i>
                    {{$user->email}}
                </a>
            </div>

            <div class="mb-3">
                {{__('active')}}:
                {{__($user->is_active ? 'yes' : 'no')}}
            </div>

        </div>
    </div>

@endsection

