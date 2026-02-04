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
    {{ __('settings') }}
@endsection

@section('content')
<div class="d-flex flex-column flex-lg-row gap-4">
    <!-- Sidebar -->
    <div class="flex-shrink-0" style="min-width: 200px;">
        @include('shared.settings-sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <h5 class="fw-bold mb-3">{{ __('settings') }}</h5>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('settings.update') }}" method="POST" id="settings-form">
                    @csrf
                    @method('PUT')

                    <h6 class="text-primary fw-medium mb-3">{{ __('localization') }}</h6>

                    <div class="mb-3">
                        <label for="default-locale" class="form-label text-primary small fw-medium">
                            <span class="text-danger">*</span> {{ __('default_locale') }}
                        </label>
                        <input type="text" id="default-locale" name="default_locale" class="form-control" required
                               value="{{ old('default_locale', $defaultLocale ?? '') }}">
                        @error('default_locale')
                        <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="default-timezone" class="form-label text-primary small fw-medium">
                            <span class="text-danger">*</span> {{ __('default_timezone') }}
                        </label>

                        @include('shared.timezone-dropdown', [
                            'name' => 'default_timezone',
                            'id' => 'default-timezone',
                            'value' => $defaultTimezone,
                            'required'=> true,
                        ])

                        @error('default_timezone')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Card Footer with Save Button -->
            <div class="card-footer bg-light border-top text-end py-3 px-4">
                <button type="submit" form="settings-form" class="btn btn-dark">
                    {{ __('save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
