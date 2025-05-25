<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class DocumentationController extends Controller
{
    /**
     * Display the documentation index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->show('index');
    }

    /**
     * Display a documentation page.
     *
     * @param string $page The page to display
     * @return \Illuminate\View\View
     */
    public function show($page = 'index')
    {
        // Sanitize the page parameter to prevent directory traversal
        $page = str_replace(['..', '\\'], '', $page);

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
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convertToHtml($content);

        // Get the title from the first h1 tag
        $title = Str::of($content)->match('/^# (.*)$/m')->trim();

        // Get the navigation structure
        $navigation = $this->getNavigation();

        return view('documentation.show', compact('html', 'title', 'page', 'navigation'));
    }

    /**
     * Display a module documentation page.
     *
     * @param string $module The module name
     * @return \Illuminate\View\View
     */
    public function module($module)
    {
        return $this->show("modules/{$module}");
    }

    /**
     * Get the navigation structure for the documentation.
     *
     * @return array
     */
    protected function getNavigation()
    {
        $navigation = [
            'Getting Started' => [
                'url' => route('documentation.show', 'getting-started'),
                'active' => request()->is('documentation/getting-started'),
            ],
            'Architecture' => [
                'url' => route('documentation.show', 'architecture'),
                'active' => request()->is('documentation/architecture'),
            ],
            'Core Features' => [
                'url' => route('documentation.show', 'core-features'),
                'active' => request()->is('documentation/core-features'),
            ],
            'Modules' => [
                'children' => [
                    'Overview' => [
                        'url' => route('documentation.show', 'modules/index'),
                        'active' => request()->is('documentation/modules/index'),
                    ],
                    'Admin' => [
                        'url' => route('documentation.module', 'admin'),
                        'active' => request()->is('documentation/modules/admin'),
                    ],
                    'Audit Trails' => [
                        'url' => route('documentation.module', 'audit-trails'),
                        'active' => request()->is('documentation/modules/audit-trails'),
                    ],
                    'Roles' => [
                        'url' => route('documentation.module', 'roles'),
                        'active' => request()->is('documentation/modules/roles'),
                    ],
                    'Settings' => [
                        'url' => route('documentation.module', 'settings'),
                        'active' => request()->is('documentation/modules/settings'),
                    ],
                    'Users' => [
                        'url' => route('documentation.module', 'users'),
                        'active' => request()->is('documentation/modules/users'),
                    ],
                ],
            ],
            'Navigation System' => [
                'url' => route('documentation.show', 'navigation'),
                'active' => request()->is('documentation/navigation'),
            ],
            'Frontend' => [
                'url' => route('documentation.show', 'frontend'),
                'active' => request()->is('documentation/frontend'),
            ],
            'Testing' => [
                'url' => route('documentation.show', 'testing'),
                'active' => request()->is('documentation/testing'),
            ],
            'Contributing' => [
                'url' => route('documentation.show', 'contributing'),
                'active' => request()->is('documentation/contributing'),
            ],
        ];

        return $navigation;
    }
}
