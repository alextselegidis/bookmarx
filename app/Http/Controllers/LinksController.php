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
use App\Models\Tag;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class LinksController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Link::class);

        $query = Link::query();

        $q = $request->query('q');

        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        $sort = $request->query('sort');
        $direction = $request->query('direction');

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        }

        $query->where('user_id', $request->user()->id);

        $links = $query->cursorPaginate(25);

        return view('pages.links', [
            'links' => $links,
            'q' => $q,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Link::class);

        $request->validate([
            'url' => 'required|url',
        ]);

        $payload = $request->all();

        $pageInfo = $this->fetchPageInfo($payload['url']);

        $pageInfo['user_id'] = $request->user()->id;

        $link = Link::create($pageInfo);

        return redirect(route('links.edit', ['link' => $link->id]));
    }

    public function show(Request $request, Link $link)
    {
        Gate::authorize('view', $link);

        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('pages.links-show', [
            'link' => $link,
        ]);
    }

    public function edit(Request $request, Link $link)
    {
        Gate::authorize('update', $link);

        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('pages.links-edit', [
            'link' => $link,
            'tags' => Tag::all(),
        ]);
    }

    public function update(Request $request, Link $link)
    {
        Gate::authorize('update', $link);

        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'url' => 'required|min:2',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $payload = $request->input();

        $pageInfo = $this->fetchPageInfo($payload['url']);

        // Only update favicon if we got a new one
        if (!empty($pageInfo['favicon'])) {
            $payload['favicon'] = $pageInfo['favicon'];
        }

        // Only update og_image if we got a new one
        if (!empty($pageInfo['og_image'])) {
            $payload['og_image'] = $pageInfo['og_image'];
        }

        $link->fill($payload);

        $link->save();

        $link->tags()->syncWithoutDetaching(request('tags'));

        return redirect(route('links.show', $link->id))->with('success', __('record_saved_message'));
    }

    public function destroy(Request $request, Link $link)
    {
        Gate::authorize('delete', $link);

        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $link->delete();

        return redirect('links')->with('success', __('record_deleted_message'));
    }

    public function archive(Request $request, Link $link)
    {
        Gate::authorize('update', $link);

        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $link->is_archived = !$link->is_archived;
        $link->save();
        return redirect()->back()->with('success', __('record_saved_message'));
    }

    function fetchPageInfo(string $url): array
    {
        $data = [
            'title' => '',
            'url' => $url,
            'notes' => '',
            'meta_description' => '',
            'meta_author' => '',
            'meta_keyword' => '',
            'theme_color' => '',
            'og_title' => '',
            'og_description' => '',
            'og_type' => '',
            'og_url' => '',
            'og_image' => '',
            'og_site_name' => '',
            'favicon' => '',
        ];

        try {
            // Fetch HTML
            $response = Http::withOptions([
                'allow_redirects' => true, // follow redirects
            ])->get($url);
        } catch (\Throwable $e) {
            return $data;
        }

        $html = $response->body();

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        // <title>
        $titleTag = $dom->getElementsByTagName('title');
        if ($titleTag->length) {
            $data['title'] = trim($titleTag->item(0)->nodeValue);
        }

        // <meta> tags
        foreach ($dom->getElementsByTagName('meta') as $meta) {
            $name = strtolower($meta->getAttribute('name') ?: $meta->getAttribute('property'));
            $content = trim($meta->getAttribute('content'));

            switch ($name) {
                case 'description':
                    $data['meta_description'] = $content;
                    break;
                case 'author':
                    $data['meta_author'] = $content;
                    break;
                case 'keywords':
                    $data['meta_keyword'] = $content;
                    break;
                case 'theme-color':
                    $data['theme_color'] = $content;
                    break;
                case 'og:title':
                    $data['og_title'] = $content;
                    break;
                case 'og:description':
                    $data['og_description'] = $content;
                    break;
                case 'og:type':
                    $data['og_type'] = $content;
                    break;
                case 'og:url':
                    $data['og_url'] = $content;
                    break;
                case 'og:image':
                    $data['og_image'] = $content;
                    break;
                case 'og:site_name':
                    $data['og_site_name'] = $content;
                    break;
            }
        }

        // <link rel="icon"> or fallback
        $faviconUrl = null;
        foreach ($dom->getElementsByTagName('link') as $link) {
            $rel = strtolower($link->getAttribute('rel'));
            if (str_contains($rel, 'icon')) {
                $href = $link->getAttribute('href');
                $faviconUrl = parse_url($href, PHP_URL_HOST) ? $href : rtrim($url, '/') . '/' . ltrim($href, '/');
                break;
            }
        }

        if (!$faviconUrl) {
            $faviconUrl = rtrim($url, '/') . '/favicon.ico'; // fallback
        }

        // Download and encode favicon
        try {
            $faviconResponse = Http::withOptions(['stream' => true])->get($faviconUrl);
            if ($faviconResponse->successful()) {
                $faviconBinary = $faviconResponse->body();
                $data['favicon'] = base64_encode($faviconBinary);
            }
        } catch (Exception $e) {
            // leave favicon as null
        }

        // Download and encode og:image
        if (!empty($data['og_image'])) {
            try {
                $ogImageUrl = $data['og_image'];
                // Handle relative URLs
                if (!parse_url($ogImageUrl, PHP_URL_HOST)) {
                    $ogImageUrl = rtrim($url, '/') . '/' . ltrim($ogImageUrl, '/');
                }

                $ogImageResponse = Http::withOptions(['stream' => true])->get($ogImageUrl);
                if ($ogImageResponse->successful()) {
                    $ogImageBinary = $ogImageResponse->body();
                    if (strlen($ogImageBinary) <= 512 * 1024) {
                        // 512KB
                        $data['og_image'] = base64_encode($ogImageBinary);
                    } else {
                        $data['og_image'] = '';
                    }
                } else {
                    $data['og_image'] = '';
                }
            } catch (Exception $e) {
                $data['og_image'] = '';
            }
        }

        return $data;
    }
}
