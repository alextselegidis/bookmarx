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

use App\Models\Observer;
use App\Models\User;

class ObserverPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // or implement logic
    }

    public function view(User $user, Observer $observer): bool
    {
        return $user->id === $observer->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Observer $observer): bool
    {
        return $user->id === $observer->user_id;
    }

    public function delete(User $user, Observer $observer): bool
    {
        return $user->id === $observer->user_id;
    }

    public function restore(User $user, Observer $observer): bool
    {
        return $user->id === $observer->user_id;
    }

    public function forceDelete(User $user, Observer $observer): bool
    {
        return $user->id === $observer->user_id;
    }
}
