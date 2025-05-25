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
     * Section priorities
     *
     * @var array<string, int>
     */
    protected array $sectionPriorities = [];

    /**
     * Register a navigation item for a specific section
     *
     * @param  string  $section  Section name (e.g., 'navigation.dashboard')
     * @param  array<string, string|null>  $item  Navigation item data
     * @param  string|null  $moduleName  Module name to check if enabled
     * @param  int  $sectionPriority  Priority of the section (lower numbers appear first)
     * @param  int  $itemPriority  Priority of the item within the section (lower numbers appear first)
     */
    public function register(string $section, array $item, ?string $moduleName = null, int $sectionPriority = 100, int $itemPriority = 100): void
    {
        // Skip if module is specified but not enabled
        if ($moduleName !== null && ! Module::isEnabled($moduleName)) {
            return;
        }

        if (! isset($this->items[$section])) {
            $this->items[$section] = [];
        }

        // Set section priority if not already set or if new priority is lower (higher precedence)
        if (! isset($this->sectionPriorities[$section]) || $sectionPriority < $this->sectionPriorities[$section]) {
            $this->sectionPriorities[$section] = $sectionPriority;
        }

        // Add item with priority
        $item['priority'] = $itemPriority;
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
        $items = $this->items[$section] ?? [];

        // Sort items by priority (lower numbers first)
        usort($items, function ($a, $b) {
            return ($a['priority'] ?? 100) <=> ($b['priority'] ?? 100);
        });

        return $items;
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
        $sections = array_keys($this->items);

        // Sort sections by priority (lower numbers first)
        usort($sections, function ($a, $b) {
            $priorityA = $this->sectionPriorities[$a] ?? 100;
            $priorityB = $this->sectionPriorities[$b] ?? 100;

            return $priorityA <=> $priorityB;
        });

        return $sections;
    }
}
