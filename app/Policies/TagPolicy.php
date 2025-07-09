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
use App\Models\Tag;

class TagPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(Tag $tag, string $ability): bool|null
    {
        if ($tag->role === RoleEnum::ADMIN->value) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the tag can view any models.
     */
    public function viewAny(Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can view the model.
     */
    public function view(Tag $tag, Tag $anotherTag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can create models.
     */
    public function create(Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can update the model.
     */
    public function update(Tag $tag, Tag $anotherTag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can delete the model.
     */
    public function delete(Tag $tag, Tag $anotherTag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can restore the model.
     */
    public function restore(Tag $tag, Tag $anotherTag): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can permanently delete the model.
     */
    public function forceDelete(Tag $tag, Tag $anotherTag): bool
    {
        return false;
    }
}
