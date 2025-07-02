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
    {{__('User')}}: {{$user->name}}
@endsection

@section('content')

    <div class="d-flex">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1">

            <form action="{{route('users.update', ['user' => $user->id])}}" method="POST" style="max-width: 800px;" class="m-auto">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        {{ __('name') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="name" name="name" class="form-control" required
                           value="{{ old('name', $user?->name ?? null) }}">
                    @error('name')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        {{ __('email') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-control" required
                           value="{{ old('email', $user?->email ?? null) }}">
                    @error('email')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        {{ __('password') }}
                        <span class="text-danger" {{ $user ? 'hidden' : ''  }}>*</span>
                    </label>
                    <input type="password" id="password" name="password" class="form-control"
                           value="{{ old('password') }}" @required(!$user) autocomplete="new-password">
                    @error('password')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirmation" class="form-label">
                        {{ __('passwordRepeat') }}
                        <span class="text-danger" {{ $user ? 'hidden' : ''  }}>*</span>
                    </label>
                    <input type="password" id="password-confirmation" name="password_confirmation" class="form-control"
                           value="{{ old('password_confirmation') }}" @required(!$user)>
                    @error('password_confirmation')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

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


@endsection

