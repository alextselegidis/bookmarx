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

@section('content')
<div>
    <div class="mx-auto my-5 text-center" style="max-width: 600px">
        <div class="mb-5">
            <img src="images/logo.png" alt="Logo" class="me-2" style="height: 128px">
        </div>

        <h1 class="fs-3 mb-5">
            Bookmarx <span class="text-muted">v{{config('app.version')}}</span>
        </h1>

        <div class="mb-5">
            Bookmarx is an open-source bookmark management application designed to help users easily organize,
            categorize, and access their favorite web links in one streamlined platform. With a clean, intuitive
            interface, Bookmarx allows seamless saving, tagging, and searching of bookmarks, making it simple to keep
            your online resources tidy and quickly retrievable. Whether for personal use or collaborative projects,
            Bookmarx empowers users to efficiently manage their digital collections without clutter.
        </div>

        <div>
            <a href="https://alextselegidis.com" class="btn btn-outline-primary" target="_blank">alextselegidis.com</a>
        </div>
    </div>
</div>
@endsection

