{{--
/* ----------------------------------------------------------------------------
 * Premium - Open Source Telemetry
 *
 * @package     Premium
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://premium.org
 * ---------------------------------------------------------------------------- */
--}}

<div class="mb-4">
    <h6 class="text-muted">
        {{$label}}
    </h6>
    <strong>
        @include('shared.id-value', ['value' => $value])
    </strong>
</div>
