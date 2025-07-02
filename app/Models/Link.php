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

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['title', 'url', 'notes', 'is_read', 'is_archived'];

    protected $casts = [
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'link_tag');
    }
}
