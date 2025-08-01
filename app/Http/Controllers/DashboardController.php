<?php

/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Link::query();

        $q = $request->query('q');
        $length = $request->query('length', 25);
        $showArchived = $request->query('show_archived', false);
        $tagId = $request->query('tag_id');

        if (!$showArchived) {
            $query->where('is_archived', false);
        }

        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        if ($tagId) {
            $query->whereHas('tags', fn($q) => $q->where('tags.id', $tagId));
        }

        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        }

        $query->where('user_id', $request->user()->id);

        $total = $query->count();

        $links = $query->cursorPaginate($length);

        $tags = $request->user()->tags()->orderBy('name')->get(); // Assuming user has many tags via links

        return view('pages.dashboard', [
            'links' => $links,
            'q' => $q,
            'length' => $total > $length ? $length : null,
            'showArchived' => $showArchived,
            'tags' => $tags,
            'selectedTagId' => $tagId,
        ]);
    }
}
