{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://premium.org
 * ---------------------------------------------------------------------------- */
--}}

@if($value)
    <a href="{{$href ?? $value}}" target="_blank">
        {{$value}}
    </a>
@else
    -
@endif
