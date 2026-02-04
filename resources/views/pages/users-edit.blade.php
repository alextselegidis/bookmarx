{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://github.com/alextselegidis/bookmarx
 * ---------------------------------------------------------------------------- */
--}}

@php use App\Enums\RoleEnum; @endphp

@extends('layouts.main-layout')

@section('pageTitle')
    {{ $user->name }}
@endsection

@section('navTitle')
    {{ __('edit_user') }}
@endsection

@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{ __('create') }}
    </a>

    <form action="{{ route('users.destroy', $user->id) }}"
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
        <h5 class="fw-bold mb-3">{{ __('edit_user') }}</h5>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" id="edit-form">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="name" class="form-label text-primary small fw-medium">
                                    <span class="text-danger">*</span> {{ __('name') }}
                                </label>
                                <input type="text" id="name" name="name" class="form-control" required
                                       value="{{ old('name', $user?->name ?? null) }}">
                                @error('name')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label text-primary small fw-medium">
                                    <span class="text-danger">*</span> {{ __('email') }}
                                </label>
                                <input type="email" id="email" name="email" class="form-control" required
                                       value="{{ old('email', $user?->email ?? null) }}">
                                @error('email')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label text-primary small fw-medium">
                                    <span class="text-danger">*</span> {{ __('role') }}
                                </label>
                                <select name="role" id="role" class="form-select" required>
                                    @foreach(RoleEnum::values() as $role)
                                        <option value="{{ $role }}" @if($user?->role === $role) selected @endif>
                                            {{ __($role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="password" class="form-label text-primary small fw-medium">
                                    {{ __('password') }}
                                    <span class="text-muted small">({{ __('leave_blank_to_keep') }})</span>
                                </label>
                                <input type="password" id="password" name="password" class="form-control"
                                       value="{{ old('password') }}" autocomplete="new-password">
                                @error('password')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password-confirmation" class="form-label text-primary small fw-medium">
                                    {{ __('password_repeat') }}
                                </label>
                                <input type="password" id="password-confirmation" name="password_confirmation" class="form-control"
                                       value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Card Footer with Save Button -->
            <div class="card-footer bg-light border-top text-end py-3 px-4">
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

@include('modals.create-modal', ['route' => route('users.store')])
@endsection

