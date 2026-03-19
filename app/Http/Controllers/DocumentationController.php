<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use League\CommonMark\CommonMarkConverter;

class DocumentationController extends Controller
{
    /**
     * Display the documentation index page.
     */
    public function index(): View
    {
        return $this->show("index");
    }

    /**
     * Display a documentation page.
     *
     * @param  string  $page  The page to display
     */
    public function show(string $page = "index"): View
    {
        // Sanitize the page parameter to prevent directory traversal
        $page = str_replace(["..", "\\"], "", $page);

        // Build the path to the markdown file
        $path = resource_path("docs/{$page}.md");

        // Check if the file exists
        if (!File::exists($path)) {
            abort(404);
        }

        // Get the content of the markdown file
        $content = File::get($path);

        // Convert markdown to HTML
        $converter = new CommonMarkConverter([
            "html_input" => "strip",
            "allow_unsafe_links" => false,
        ]);

        $html = (string) $converter->convert($content);

        // Rewrite .md links to proper documentation URLs
        $html = $this->rewriteDocLinks($html, $page);

        // Get the title from the first h1 tag
        $title = Str::of($content)->match('/^# (.*)$/m')->trim();

        // Get the navigation structure
        $navigation = $this->getNavigation();

        return view(
            "documentation.show",
            compact("html", "title", "page", "navigation"),
        );
    }

    /**
     * Display a module documentation page.
     *
     * @param  string  $module  The module name
     */
    public function module(string $module): View
    {
        return $this->show("modules/{$module}");
    }

    /**
     * Rewrite .md file links to proper documentation route URLs.
     *
     * This allows markdown files to use standard .md links (which work on GitHub, etc.)
     * while rendering correct URLs in the browser.
     */
    protected function rewriteDocLinks(
        string $html,
        string $currentPage,
    ): string {
        // Determine the base directory of the current page for resolving relative links
        $baseDir = str_contains($currentPage, "/")
            ? Str::beforeLast($currentPage, "/") . "/"
            : "";

        // Rewrite href attributes that end in .md (with optional #anchor)
        return (string) preg_replace_callback(
            '/href="([^"]*?)\.md(#[^"]*)?"/i',
            function (array $matches) use ($baseDir) {
                $relativePath = $matches[1];
                $anchor = $matches[2] ?? "";

                // Resolve relative paths (e.g., "../something" or "modules/admin")
                if (str_starts_with($relativePath, "../")) {
                    // Go up one directory level from the base
                    $resolved = Str::beforeLast(rtrim($baseDir, "/"), "/");
                    $relativePath = substr($relativePath, 3);
                    $resolved = $resolved
                        ? $resolved . "/" . $relativePath
                        : $relativePath;
                } elseif (str_starts_with($relativePath, "./")) {
                    $resolved = $baseDir . substr($relativePath, 2);
                } elseif (
                    !str_starts_with($relativePath, "/") &&
                    $baseDir !== ""
                ) {
                    $resolved = $baseDir . $relativePath;
                } else {
                    $resolved = ltrim($relativePath, "/");
                }

                $url = route("documentation.show", $resolved);

                return 'href="' . e($url) . $anchor . '"';
            },
            $html,
        );
    }

    /**
     * Get the navigation structure for the documentation.
     *
     * @return array<string, mixed>
     */
    protected function getNavigation(): array
    {
        return [
            "Getting Started" => [
                "url" => route("documentation.show", "getting-started"),
                "active" => request()->is("documentation/getting-started"),
            ],
            "Architecture" => [
                "url" => route("documentation.show", "architecture"),
                "active" => request()->is("documentation/architecture"),
            ],
            "Core Features" => [
                "url" => route("documentation.show", "core-features"),
                "active" => request()->is("documentation/core-features"),
            ],
            "Modules" => [
                "children" => [
                    "Overview" => [
                        "url" => route("documentation.show", "modules/index"),
                        "active" => request()->is(
                            "documentation/modules/index",
                        ),
                    ],
                    "Admin" => [
                        "url" => route("documentation.module", "admin"),
                        "active" => request()->is(
                            "documentation/modules/admin",
                        ),
                    ],
                    "Audit Trails" => [
                        "url" => route("documentation.module", "audit-trails"),
                        "active" => request()->is(
                            "documentation/modules/audit-trails",
                        ),
                    ],
                    "Roles" => [
                        "url" => route("documentation.module", "roles"),
                        "active" => request()->is(
                            "documentation/modules/roles",
                        ),
                    ],
                    "Settings" => [
                        "url" => route("documentation.module", "settings"),
                        "active" => request()->is(
                            "documentation/modules/settings",
                        ),
                    ],
                    "Users" => [
                        "url" => route("documentation.module", "users"),
                        "active" => request()->is(
                            "documentation/modules/users",
                        ),
                    ],
                ],
            ],
            "Navigation System" => [
                "url" => route("documentation.show", "navigation"),
                "active" => request()->is("documentation/navigation"),
            ],
            "Actions" => [
                "children" => [
                    "Export Action" => [
                        "url" => route("documentation.show", "exportaction"),
                        "active" => request()->is("documentation/exportaction"),
                    ],
                ],
            ],
            "Frontend" => [
                "url" => route("documentation.show", "frontend"),
                "active" => request()->is("documentation/frontend"),
            ],
            "Testing" => [
                "url" => route("documentation.show", "testing"),
                "active" => request()->is("documentation/testing"),
            ],
            "Contributing" => [
                "url" => route("documentation.show", "contributing"),
                "active" => request()->is("documentation/contributing"),
            ],
        ];
    }
}
