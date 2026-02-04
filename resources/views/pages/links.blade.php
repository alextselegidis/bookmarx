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
    {{__('links')}}
@endsection

@section('navActions')
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="bi bi-plus-square me-2"></i>
        {{__('create')}}
    </a>
@endsection

@section('content')
<div>
    <div class="d-flex flex-column-reverse flex-lg-row">

        <div class="flex-grow-0 sidebar-width">
            @include('shared.settings-sidebar')
        </div>

        <div class="flex-grow-1 mb-5 mb-lg-0">

            <form action="{{route('links')}}" method="GET" class="mb-3">
                @csrf
                @method('GET')
                <div class="input-group mb-3">
                    <span class="bg-body-tertiary input-group-text px-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="q" name="q" class="form-control bg-body-tertiary border-start-0"
                           value="{{$q}}"
                           placeholder="{{__('search')}}" autofocus tabindex="-1" style="max-width: 300px;">
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50%">
                            <a href="{{ route('links', ['sort' => 'title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {!! sort_link('title', __('title')) !!}
                            </a>
                        </th>
                        <th style="width: 20%">
                            <a href="{{ route('links', ['sort' => 'url', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {!! sort_link('url', __('url')) !!}
                            </a>
                        </th>
                        <th style="width: 25%">
                            <a href="{{ route('tags', ['sort' => 'tags', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {!! sort_link('tags', __('tags')) !!}
                            </a>
                        </th>
                        <th>
                            <!-- Actions -->
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($links as $link)
                        <tr onclick="window.location='{{route('links.show', $link->id)}}'" style="cursor: pointer;">
                            <td>
                                {{$link->title}}
                            </td>
                            <td>
                                <a href="{{$link->url}}" target="_blank">
                                    {{$link->formatted_url}}
                                </a>
                            </td>
                            <td>
                                {{$link->formatted_tags}}
                            </td>
                            <td class="text-end">
                                <div class="dropdown" onclick="event.stopPropagation();">
                                    <button class="btn btn-link text-decoration-none dropdown-toggle py-0" type="button"
                                            data-bs-toggle="dropdown">
                                        {{__('actions')}}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{route('links.edit', ['link' => $link->id])}}"
                                               class="dropdown-item">
                                                {{__('edit')}}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{route('links.destroy', $link->id)}}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{__('delete_record_prompt')}}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    {{__('delete')}}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @endforeach

                    @if($links->isEmpty())
                        @include('shared.no_records_found')
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

    @include('modals.create-modal', ['route' => route('links.store'), 'input_name' => 'url', 'input_type' => 'url'])

@endsection

