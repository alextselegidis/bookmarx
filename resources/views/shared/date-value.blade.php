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

{{$value ? date('d F Y', strtotime($value)) : '-'}}
