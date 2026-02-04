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
    {{__('Account')}}
@endsection

@section('content')
    <div style="max-width: 600px" class="mx-auto my-4">

        <!-- Page Header -->
        <h5 class="fw-bold mb-3">{{ auth()->user()->name }}</h5>

        <!-- Account Details Card -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('account.update') }}" method="POST" id="account-form">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label text-primary fw-medium">
                            <span class="text-danger">*</span> {{ __('Name') }}
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', auth()->user()->name) }}"
                            required
                        >
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-primary fw-medium">
                            <span class="text-danger">*</span> {{ __('Email') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                        >
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Card Footer with Save Button -->
            <div class="card-footer bg-light border-top text-end py-3 px-4">
                <button type="submit" form="account-form" class="btn btn-dark">
                    {{ __('Save') }}
                </button>
            </div>
        </div>

        <!-- Change Password Section -->
        <h5 class="fw-bold mb-3">{{ __('Change your password') }}</h5>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('account.update') }}" method="POST" id="password-form">
                    @csrf
                    @method('PUT')

                    <!-- Hidden fields to preserve account data -->
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label text-primary fw-medium">
                            {{ __('Current Password') }}
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            autocomplete="current-password"
                        >
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-primary fw-medium">
                            {{ __('New Password') }}
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="new-password"
                        >
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-primary fw-medium">
                            {{ __('Confirm New Password') }}
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            autocomplete="new-password"
                        >
                    </div>
                </form>
            </div>

            <!-- Card Footer with Save Button -->
            <div class="card-footer bg-light border-top text-end py-3 px-4">
                <button type="submit" form="password-form" class="btn btn-dark">
                    {{ __('Save') }}
                </button>
            </div>
        </div>

    </div>
@endsection

