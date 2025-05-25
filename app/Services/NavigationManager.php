<?php

declare(strict_types=1);

namespace App\Services;

use Nwidart\Modules\Facades\Module;

class NavigationManager
{
    /**
     * Navigation items organized by section
     *
     * @var array<string, array<array<string, mixed>>>
     */
    protected array $items = [];

    /**
     * Register a navigation item for a specific section
     *
     * @param  string  $section  Section name (e.g., 'navigation.dashboard')
     * @param  array<string, string>  $item  Navigation item data
     * @param  string|null  $moduleName  Module name to check if enabled
     */
    public function register(string $section, array $item, ?string $moduleName = null): void
    {
        // Skip if module is specified but not enabled
        if ($moduleName !== null && ! Module::isEnabled($moduleName)) {
            return;
        }

        if (! isset($this->items[$section])) {
            $this->items[$section] = [];
        }

        $this->items[$section][] = $item;
    }

    /**
     * Get all navigation items for a section
     *
     * @param  string  $section  Section name
     * @return array<array<string, mixed>>
     */
    public function getItems(string $section): array
    {
        return $this->items[$section] ?? [];
    }

    /**
     * Check if a section has any items
     *
     * @param  string  $section  Section name
     */
    public function hasItems(string $section): bool
    {
        return ! empty($this->items[$section]);
    }

    /**
     * Get all navigation sections
     *
     * @return array<int, string>
     */
    public function getSections(): array
    {
        return array_keys($this->items);
    }
}
