<?php

/* ----------------------------------------------------------------------------
 * Bookmarx - Open Source Telemetry
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Link;

class LinkPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(Link $link, string $ability): bool|null
    {
        if ($link->role === RoleEnum::ADMIN->value) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the link can view any models.
     */
    public function viewAny(Link $link): bool
    {
        return false;
    }

    /**
     * Determine whether the link can view the model.
     */
    public function view(Link $link, Link $anotherLink): bool
    {
        return false;
    }

    /**
     * Determine whether the link can create models.
     */
    public function create(Link $link): bool
    {
        return false;
    }

    /**
     * Determine whether the link can update the model.
     */
    public function update(Link $link, Link $anotherLink): bool
    {
        return false;
    }

    /**
     * Determine whether the link can delete the model.
     */
    public function delete(Link $link, Link $anotherLink): bool
    {
        return false;
    }

    /**
     * Determine whether the link can restore the model.
     */
    public function restore(Link $link, Link $anotherLink): bool
    {
        return false;
    }

    /**
     * Determine whether the link can permanently delete the model.
     */
    public function forceDelete(Link $link, Link $anotherLink): bool
    {
        return false;
    }
}
