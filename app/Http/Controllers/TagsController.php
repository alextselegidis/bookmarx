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

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query();

        $q = $request->query('q');

        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }

        $sort = $request->query('sort');
        $direction = $request->query('direction');

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        }

        $query->where('user_id', $request->user()->id);

        $tags = $query->cursorPaginate(25);

        return view('pages.tags', [
            'tags' => $tags,
            'q' => $q,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $payload = $request->all();

        $tag = Tag::create([
            'name' => $payload['name'],
            'user_id' => $request->user()->id,
        ]);

        return redirect(route('tags.edit', ['tag' => $tag->id]));
        // return redirect(request()->fullUrlWithoutQuery('create'));
    }

    public function show(Request $request, Tag $tag)
    {
        return view('pages.tags-show', [
            'tag' => $tag,
        ]);
    }

    public function edit(Request $request, Tag $tag)
    {
        return view('pages.tags-edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);

        $payload = $request->input();

        $tag->fill($payload);

        $tag->save();

        return redirect(route('tags.show', $tag->id))->with('success', __('recordSavedMessage'));
    }

    public function destroy(Request $request, Tag $tag)
    {
        $tag->delete();

        return redirect()->back()->with('success', __('recordDeletedMessage'));
    }
}
