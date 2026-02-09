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

@extends('layouts.main-layout')

@section('pageTitle')
    {{ $user->name }}
@endsection

@section('breadcrumbs')
    @include('shared.breadcrumb', ['breadcrumbs' => [
        ['label' => __('users'), 'url' => route('users')],
        ['label' => $user->name]
    ]])
@endsection

@section('navActions')
    <a href="#" class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{ __('create') }}
    </a>

    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="nav-link me-lg-3">
        <i class="bi bi-pencil me-2"></i>
        {{ __('edit') }}
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
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            @include('shared.show-text', ['label' => __('name'), 'value' => $user->name])
                            @include('shared.show-link', ['label' => __('email'), 'href' => 'mailto:' . $user->email, 'value' => $user->email])
                            @include('shared.show-text', ['label' => __('role'), 'value' => __($user->role)])
                        </div>
                        <div class="col-lg-6">
                            @include('shared.show-bool', ['label' => __('active'), 'value' => $user->is_active])
                            @include('shared.show-date', ['label' => __('created'), 'value' => $user->created_at])
                            @include('shared.show-date', ['label' => __('updated'), 'value' => $user->updated_at])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.create-modal', ['route' => route('users.store')])
@endsection

