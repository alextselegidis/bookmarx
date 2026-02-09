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
    {{__('About')}}
@endsection

@section('breadcrumbs')
    @include('shared.breadcrumb', ['breadcrumbs' => [
        ['label' => __('about')]
    ]])
@endsection

@section('content')
    <div>
        <div class="mx-auto my-5 text-center" style="max-width: 600px">
            <div class="mb-5">
                <img src="images/logo.png" alt="Logo" class="me-2" style="height: 128px">
            </div>

            <h1 class="fs-3 mb-5">
                Bookmarx <span class="text-muted">v{{config('app.version')}}</span>
            </h1>
            <div class="mb-5 text-secondary">
                Bookmarx is an open-source bookmark management application that helps you organize, categorize, and
                access your favorite web links in one streamlined place. Save, tag, and search your bookmarks with
                a clean and intuitive interface, keeping your digital collections tidy and easily retrievable.
            </div>
            <div class="d-flex gap-2 justify-content-center">
                <a href="https://github.com/alextselegidis/bookmarx" class="btn btn-outline-primary" target="_blank">
                    <i class="bi bi-github me-2"></i>
                    GitHub
                </a>
                <a href="https://alextselegidis.com" class="btn btn-outline-secondary" target="_blank">
                    alextselegidis.com
                </a>
            </div>
        </div>
    </div>
@endsection

