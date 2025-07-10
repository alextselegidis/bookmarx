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

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Link::query();

        $q = $request->query('q');
        $showArchived = $request->query('show_archived', false);

        if (!$showArchived) {
            $query->where('is_archived', false);
        }

        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        $sort = $request->query('sort');
        $direction = $request->query('direction');

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        }

        $links = $query->cursorPaginate(25);

        return view('pages.dashboard', [
            'links' => $links,
            'q' => $q,
            'showArchived' => $showArchived,
        ]);
    }
}
