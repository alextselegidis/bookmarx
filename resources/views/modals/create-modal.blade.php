{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Open Source Telemetry
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */
--}}

<div class="modal" tabindex="-1" id="create-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{$route}}" method="POST">
                @csrf
                @method('POST')

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{__('create')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            {{ __('name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-secondary" data-bs-dismiss="modal">
                        {{__('close')}}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{__('save')}}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
