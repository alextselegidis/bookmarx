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
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'notes',
        'meta_description',
        'meta_author',
        'meta_keyword',
        'theme_color',
        'favicon',
        'og_title',
        'og_description',
        'og_type',
        'og_url',
        'og_image',
        'og_site_name',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'link_tag');
    }

    public function getFormattedTagsAttribute()
    {
        return $this->tags()->pluck('name')->implode(', ');
    }

    public function getFormattedUrlAttribute()
    {
        return str_replace(['https://', 'http://'], '', rtrim($this->url, '/'));
    }
}
