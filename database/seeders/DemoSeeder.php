<?php

/* ----------------------------------------------------------------------------
 * Bookmarx - Simple Bookmark Manager
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://github.com/alextselegidis/bookmarx
 * ---------------------------------------------------------------------------- */

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Demo data seeder.
 *
 * Generates a realistic dataset of users, tags and bookmark links so the
 * application can be explored without manually creating content.
 *
 * This seeder is intentionally NOT registered in DatabaseSeeder. Run it
 * explicitly:
 *
 *     php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding demo users, tags and links...');

        // 1. Create the demo users (1 admin + 2 standard users).
        $admin = $this->createAdmin();
        $alice = $this->createStandardUser('Alice Johnson', 'alice@example.org');
        $bob = $this->createStandardUser('Bob Martin', 'bob@example.org');

        $users = [$admin, $alice, $bob];

        // 2. Create a per-user pool of tags. Tags belong to one user, so
        //    we generate the same conceptual tag set for each account.
        $tagNames = [
            'work', 'personal', 'reading', 'tools', 'inspiration',
            'tutorials', 'news', 'open-source', 'design', 'reference',
        ];

        $tagsByUser = [];
        foreach ($users as $user) {
            $tagsByUser[$user->id] = collect($tagNames)->map(
                fn(string $name) => Tag::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $name,
                ]),
            );
        }

        // 3. Distribute 50 curated demo links across the 3 users.
        //    ~30% of them are archived so the archive view also has data.
        $websites = $this->demoWebsites();

        foreach ($websites as $index => $site) {
            // Round-robin assignment keeps each user's library populated.
            $owner = $users[$index % count($users)];

            // updateOrCreate keyed on (user_id, url) keeps re-runs idempotent
            // and avoids duplicate bookmarks for the same owner.
            $link = Link::updateOrCreate([
                'user_id' => $owner->id,
                'url' => $site['url'],
            ], [
                'title' => $site['title'],
                'notes' => $site['notes'],
                'meta_description' => $site['notes'],
                'meta_author' => $site['author'] ?? null,
                'meta_keyword' => implode(', ', $site['tags']),
                'theme_color' => $site['theme_color'] ?? '#4f46e5',
                'favicon' => '',
                'og_title' => $site['title'],
                'og_description' => $site['notes'],
                'og_type' => 'website',
                'og_url' => $site['url'],
                'og_image' => '',
                'og_site_name' => parse_url($site['url'], PHP_URL_HOST),
                // Mark roughly every 3rd link as archived for variety.
                'is_archived' => $index % 3 === 0,
            ]);

            // Attach the owner's matching tags (create them on demand
            // if a curated tag is not in the default pool).
            $tagIds = collect($site['tags'])
                ->map(function (string $name) use ($owner, &$tagsByUser) {
                    $existing = $tagsByUser[$owner->id]->firstWhere('name', $name);

                    if ($existing) {
                        return $existing->id;
                    }

                    $created = Tag::firstOrCreate([
                        'user_id' => $owner->id,
                        'name' => $name,
                    ]);

                    $tagsByUser[$owner->id]->push($created);

                    return $created->id;
                })
                ->all();

            $link->tags()->sync($tagIds);
        }

        $this->command->info(sprintf(
            'Demo data ready: %d users, %d links (%d archived), %d tags.',
            count($users),
            Link::count(),
            Link::where('is_archived', true)->count(),
            Tag::count(),
        ));

        // Per-user breakdown so it is obvious that every account – including
        // the admin – received its share of bookmarks.
        foreach ($users as $user) {
            $this->command->info(sprintf(
                '  - %s <%s> [%s]: %d links',
                $user->name,
                $user->email,
                $user->role,
                Link::where('user_id', $user->id)->count(),
            ));
        }
    }

    /**
     * Resolve the admin account that should receive demo links.
     *
     * If an admin already exists (e.g. the default one created by the
     * install migration, or one the operator promoted manually) we reuse
     * it so its bookmarks land on the account they actually log in with.
     * Otherwise a known demo admin is provisioned.
     */
    private function createAdmin(): User
    {
        $existing = User::where('role', RoleEnum::ADMIN->value)->orderBy('id')->first();

        if ($existing) {
            $existing->update([
                'is_active' => true,
                'email_verified_at' => $existing->email_verified_at ?? now(),
            ]);

            return $existing;
        }

        return User::updateOrCreate(
            ['email' => 'admin@example.org'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('12345678'),
                'role' => RoleEnum::ADMIN->value,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );
    }

    /**
     * Create or update a standard demo user with a known password.
     */
    private function createStandardUser(string $name, string $email): User
    {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('12345678'),
                'role' => RoleEnum::USER->value,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );
    }

    /**
     * Curated list of 50 real-world websites used as demo bookmarks.
     *
     * Hand-written titles, notes and tags keep the demo content useful
     * and avoid filler text such as lorem ipsum.
     *
     * @return array<int, array{title: string, url: string, notes: string, tags: array<int, string>, author?: string, theme_color?: string}>
     */
    private function demoWebsites(): array
    {
        return [
            ['title' => 'Laravel Documentation', 'url' => 'https://laravel.com/docs', 'notes' => 'Official Laravel framework documentation and guides.', 'tags' => ['work', 'reference', 'tutorials'], 'theme_color' => '#ff2d20'],
            ['title' => 'PHP: The Right Way', 'url' => 'https://phptherightway.com', 'notes' => 'Quick reference for modern PHP best practices.', 'tags' => ['work', 'reference']],
            ['title' => 'MDN Web Docs', 'url' => 'https://developer.mozilla.org', 'notes' => 'Reference for HTML, CSS and JavaScript APIs.', 'tags' => ['work', 'reference']],
            ['title' => 'GitHub', 'url' => 'https://github.com', 'notes' => 'Source code hosting and collaboration platform.', 'tags' => ['work', 'tools', 'open-source']],
            ['title' => 'GitLab', 'url' => 'https://gitlab.com', 'notes' => 'Self-hostable DevOps platform with built-in CI/CD.', 'tags' => ['work', 'tools', 'open-source']],
            ['title' => 'Stack Overflow', 'url' => 'https://stackoverflow.com', 'notes' => 'Q&A community for programmers.', 'tags' => ['work', 'reference']],
            ['title' => 'Vue.js Guide', 'url' => 'https://vuejs.org/guide/introduction.html', 'notes' => 'Progressive JavaScript framework documentation.', 'tags' => ['work', 'tutorials']],
            ['title' => 'React Documentation', 'url' => 'https://react.dev', 'notes' => 'Library for building user interfaces.', 'tags' => ['work', 'tutorials']],
            ['title' => 'Tailwind CSS', 'url' => 'https://tailwindcss.com', 'notes' => 'Utility-first CSS framework documentation.', 'tags' => ['work', 'design', 'reference']],
            ['title' => 'Hacker News', 'url' => 'https://news.ycombinator.com', 'notes' => 'Tech and startup news aggregator.', 'tags' => ['news', 'reading']],
            ['title' => 'Lobsters', 'url' => 'https://lobste.rs', 'notes' => 'Computing-focused community link aggregator.', 'tags' => ['news', 'reading']],
            ['title' => 'The Verge', 'url' => 'https://www.theverge.com', 'notes' => 'Technology, science and culture news.', 'tags' => ['news']],
            ['title' => 'Ars Technica', 'url' => 'https://arstechnica.com', 'notes' => 'In-depth technology reporting.', 'tags' => ['news', 'reading']],
            ['title' => 'Smashing Magazine', 'url' => 'https://www.smashingmagazine.com', 'notes' => 'Articles on web design and front-end development.', 'tags' => ['design', 'reading']],
            ['title' => 'CSS-Tricks', 'url' => 'https://css-tricks.com', 'notes' => 'Tips, tricks and techniques on CSS.', 'tags' => ['design', 'tutorials']],
            ['title' => 'Dribbble', 'url' => 'https://dribbble.com', 'notes' => 'Design inspiration from the community.', 'tags' => ['design', 'inspiration']],
            ['title' => 'Behance', 'url' => 'https://www.behance.net', 'notes' => 'Portfolio site for creative professionals.', 'tags' => ['design', 'inspiration']],
            ['title' => 'Awwwards', 'url' => 'https://www.awwwards.com', 'notes' => 'Showcase of well-designed websites.', 'tags' => ['design', 'inspiration']],
            ['title' => 'Figma', 'url' => 'https://www.figma.com', 'notes' => 'Collaborative interface design tool.', 'tags' => ['design', 'tools']],
            ['title' => 'Excalidraw', 'url' => 'https://excalidraw.com', 'notes' => 'Virtual whiteboard for sketching diagrams.', 'tags' => ['tools', 'work']],
            ['title' => 'Notion', 'url' => 'https://www.notion.so', 'notes' => 'Notes, docs and project management workspace.', 'tags' => ['tools', 'personal']],
            ['title' => 'Trello', 'url' => 'https://trello.com', 'notes' => 'Kanban-style task and project boards.', 'tags' => ['tools', 'work']],
            ['title' => 'Todoist', 'url' => 'https://todoist.com', 'notes' => 'Cross-platform task manager.', 'tags' => ['tools', 'personal']],
            ['title' => 'Pocket', 'url' => 'https://getpocket.com', 'notes' => 'Save articles and videos to read later.', 'tags' => ['reading', 'tools']],
            ['title' => 'Medium', 'url' => 'https://medium.com', 'notes' => 'Publishing platform with engineering and product writing.', 'tags' => ['reading']],
            ['title' => 'Dev.to', 'url' => 'https://dev.to', 'notes' => 'Community of software developers sharing posts.', 'tags' => ['reading', 'tutorials']],
            ['title' => 'freeCodeCamp', 'url' => 'https://www.freecodecamp.org', 'notes' => 'Free programming courses and tutorials.', 'tags' => ['tutorials', 'personal']],
            ['title' => 'Coursera', 'url' => 'https://www.coursera.org', 'notes' => 'Online courses from universities and companies.', 'tags' => ['tutorials', 'personal']],
            ['title' => 'Khan Academy', 'url' => 'https://www.khanacademy.org', 'notes' => 'Free educational videos and exercises.', 'tags' => ['tutorials', 'personal']],
            ['title' => 'YouTube', 'url' => 'https://www.youtube.com', 'notes' => 'Video sharing platform for tutorials and entertainment.', 'tags' => ['personal', 'tutorials']],
            ['title' => 'Spotify', 'url' => 'https://www.spotify.com', 'notes' => 'Music streaming service.', 'tags' => ['personal']],
            ['title' => 'Wikipedia', 'url' => 'https://www.wikipedia.org', 'notes' => 'Free online encyclopedia.', 'tags' => ['reference', 'reading']],
            ['title' => 'Project Gutenberg', 'url' => 'https://www.gutenberg.org', 'notes' => 'Library of free public-domain ebooks.', 'tags' => ['reading', 'reference']],
            ['title' => 'Goodreads', 'url' => 'https://www.goodreads.com', 'notes' => 'Track and review the books you read.', 'tags' => ['reading', 'personal']],
            ['title' => 'Symfony Documentation', 'url' => 'https://symfony.com/doc/current/index.html', 'notes' => 'Documentation for the Symfony PHP framework.', 'tags' => ['work', 'reference']],
            ['title' => 'Composer', 'url' => 'https://getcomposer.org', 'notes' => 'Dependency manager for PHP.', 'tags' => ['work', 'tools']],
            ['title' => 'Packagist', 'url' => 'https://packagist.org', 'notes' => 'The PHP package repository.', 'tags' => ['work', 'reference']],
            ['title' => 'npm', 'url' => 'https://www.npmjs.com', 'notes' => 'JavaScript package registry.', 'tags' => ['work', 'reference']],
            ['title' => 'Vite', 'url' => 'https://vitejs.dev', 'notes' => 'Fast frontend build tool documentation.', 'tags' => ['work', 'tools']],
            ['title' => 'Docker Hub', 'url' => 'https://hub.docker.com', 'notes' => 'Repository of Docker container images.', 'tags' => ['work', 'tools']],
            ['title' => 'Kubernetes Docs', 'url' => 'https://kubernetes.io/docs/home', 'notes' => 'Official documentation for Kubernetes.', 'tags' => ['work', 'reference']],
            ['title' => 'DigitalOcean Community', 'url' => 'https://www.digitalocean.com/community', 'notes' => 'Tutorials on Linux, deployment and DevOps.', 'tags' => ['tutorials', 'reference']],
            ['title' => 'Cloudflare Blog', 'url' => 'https://blog.cloudflare.com', 'notes' => 'Articles on networking, performance and security.', 'tags' => ['reading', 'work']],
            ['title' => 'Mozilla Hacks', 'url' => 'https://hacks.mozilla.org', 'notes' => 'Web platform news from Mozilla engineers.', 'tags' => ['reading', 'work']],
            ['title' => 'A List Apart', 'url' => 'https://alistapart.com', 'notes' => 'Essays on web standards, design and content.', 'tags' => ['design', 'reading']],
            ['title' => 'Unsplash', 'url' => 'https://unsplash.com', 'notes' => 'Free high-resolution photos for any project.', 'tags' => ['design', 'inspiration']],
            ['title' => 'Pexels', 'url' => 'https://www.pexels.com', 'notes' => 'Free stock photos and videos.', 'tags' => ['design', 'inspiration']],
            ['title' => 'Open Source Initiative', 'url' => 'https://opensource.org', 'notes' => 'Steward of the Open Source Definition.', 'tags' => ['open-source', 'reference']],
            ['title' => 'Linux Kernel Archives', 'url' => 'https://www.kernel.org', 'notes' => 'Source for the Linux kernel.', 'tags' => ['open-source', 'reference']],
            ['title' => 'Bookmarx on GitHub', 'url' => 'https://github.com/alextselegidis/bookmarx', 'notes' => 'Source code for this bookmark manager.', 'tags' => ['open-source', 'tools']],
        ];
    }
}
