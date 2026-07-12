<?php
/**
 * dropdown-helper.php
 * Centralized, reusable dropdown (select) component for the admin panel.
 * Ensures consistent styling, spacing, typography, and behavior across all pages.
 *
 * Design tokens used (matching site theme):
 *   - Background:  bg-slate-50  (#F8FAFC)
 *   - Border:      border-slate-200/70
 *   - Text:        text-slate-700  (#334155)
 *   - Focus ring:  ring-[#13273F]/20, border-[#13273F]
 *   - Radius:      rounded-xl (0.75rem)
 *   - Font:        Inter 13px semibold
 */

/**
 * Get an SVG icon string by name.
 * Icons are used as left-side decorators inside filter/form dropdowns.
 */
function getDropdownIcon(string $icon): string {
    $icons = [
        'filter' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>',
        'tag' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.44 1.44 0 002.036 0l4.319-4.319a1.44 1.44 0 000-2.036L10.01 3.659A2.25 2.25 0 008.59 3z"></path></svg>',
        'status' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'role' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>',
        'category' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>',
        'visibility' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',
        'home' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>',
        'chevron' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>',
    ];
    return $icons[$icon] ?? $icons['filter'];
}

/**
 * Render a standardized dropdown (select) element.
 *
 * @param array $config Configuration options:
 *   - 'name'        (string)  Form field name attribute
 *   - 'id'          (string)  Element ID attribute
 *   - 'options'     (array)   Associative [value => label] pairs
 *   - 'selected'    (string)  Currently selected value
 *   - 'placeholder' (string)  Text for the default empty option (e.g. "All Categories")
 *   - 'icon'        (string)  Left icon name: filter|tag|status|role|category|visibility
 *   - 'class'       (string)  Additional CSS classes (e.g. 'js-table-filter')
 *   - 'width'       (string)  Container width class (e.g. 'w-48', 'w-full')
 *   - 'required'    (bool)    Whether field is required
 *   - 'disabled'    (bool)    Whether field is disabled
 *   - 'context'     (string)  'filter' or 'form' — applies styling preset
 *   - 'onchange'    (string)  JS onchange handler
 *   - 'attrs'       (string)  Extra HTML attributes
 * @return string Rendered HTML
 */
function renderDropdown(array $config): string {
    $name        = $config['name'] ?? '';
    $id          = $config['id'] ?? '';
    $options     = $config['options'] ?? [];
    $selected    = $config['selected'] ?? '';
    $placeholder = $config['placeholder'] ?? '';
    $icon        = $config['icon'] ?? '';
    $extraClass  = $config['class'] ?? '';
    $width       = $config['width'] ?? '';
    $required    = $config['required'] ?? false;
    $disabled    = $config['disabled'] ?? false;
    $context     = $config['context'] ?? 'filter';
    $onchange    = $config['onchange'] ?? '';
    $extraAttrs  = $config['attrs'] ?? '';

    $hasIcon = !empty($icon);

    // Base select classes — consistent across all dropdowns in the admin panel
    $selectClass = 'w-full py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl '
        . 'focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] '
        . 'text-[12.5px] font-semibold text-slate-700 appearance-none cursor-pointer '
        . 'hover:bg-slate-100/50 transition-all';

    // Padding based on whether icon is present
    $selectClass .= $hasIcon ? ' pl-9 pr-8' : ' pl-3.5 pr-8';

    // Add extra classes
    if ($extraClass) {
        $selectClass .= ' ' . $extraClass;
    }

    // Container width
    $containerClass = 'relative';
    if ($width) {
        $containerClass .= ' ' . $width;
    }

    // Build HTML
    $html = '<div class="' . htmlspecialchars($containerClass) . '">';

    // Left icon
    if ($hasIcon) {
        $html .= '<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">';
        $html .= getDropdownIcon($icon);
        $html .= '</span>';
    }

    // Select element
    $html .= '<select';
    if ($name) $html .= ' name="' . htmlspecialchars($name) . '"';
    if ($id)   $html .= ' id="' . htmlspecialchars($id) . '"';
    $html .= ' class="' . htmlspecialchars($selectClass) . '"';
    if ($required) $html .= ' required';
    if ($disabled) $html .= ' disabled';
    if ($onchange) $html .= ' onchange="' . htmlspecialchars($onchange) . '"';
    if ($extraAttrs) $html .= ' ' . $extraAttrs;
    $html .= '>';

    // Placeholder option
    if ($placeholder !== false && $placeholder !== null) {
        $html .= '<option value="">' . htmlspecialchars($placeholder) . '</option>';
    }

    // Options
    foreach ($options as $value => $label) {
        $isSelected = ((string)$value === (string)$selected) ? ' selected' : '';
        $html .= '<option value="' . htmlspecialchars($value) . '"' . $isSelected . '>' . htmlspecialchars($label) . '</option>';
    }

    $html .= '</select>';

    // Right chevron icon
    $html .= '<span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">';
    $html .= getDropdownIcon('chevron');
    $html .= '</span>';

    $html .= '</div>';

    return $html;
}

/**
 * Render a standardized filter bar for admin table pages.
 * Generates the search input, dropdown filters, and reset button
 * with the premium admin design system.
 *
 * @param array $config Configuration:
 *   - 'search'  (array|false)  Search config: ['placeholder' => '...', 'maxWidth' => '50%']
 *   - 'filters' (array)        Array of dropdown configs for renderDropdown()
 *   - 'reset'   (bool)         Whether to show reset button (default: true)
 */
function renderFilterBar(array $config): void {
    $search  = $config['search'] ?? false;
    $filters = $config['filters'] ?? [];
    $showReset = $config['reset'] ?? true;
    ?>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <?php if ($search !== false): 
            $placeholder = $search['placeholder'] ?? 'Search...';
            $maxWidth = $search['maxWidth'] ?? '50%';
        ?>
            <div class="relative flex-1 w-full md:max-w-[<?= htmlspecialchars($maxWidth) ?>]">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                </span>
                <input type="text" placeholder="<?= htmlspecialchars($placeholder) ?>" class="js-table-search bg-gray-50/50 border border-gray-200 text-slate-700 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none">
            </div>
        <?php endif; ?>

        <?php 
        $pagination = $config['pagination'] ?? null;
        $hasPaging = $pagination && ($pagination['enable_paging'] ?? false);
        if (!empty($filters) || $showReset || $hasPaging): 
        ?>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <?php foreach ($filters as $filter): 
                    // Set defaults for filter context
                    $filter['context'] = 'filter';
                    if (!isset($filter['class'])) $filter['class'] = 'js-table-filter';
                    if (!isset($filter['width'])) $filter['width'] = 'flex-1 md:w-44';
                    echo renderDropdown($filter);
                endforeach; ?>

                <?php if ($hasPaging): 
                    $perPage = $pagination['per_page'] ?? 10;
                    $totalItems = $pagination['total_items'] ?? 0;
                    
                    $perPageDropdown = [
                        'placeholder' => false,
                        'selected' => $perPage,
                        'options' => [
                            '10' => 'Show 10',
                            '25' => 'Show 25',
                            '50' => 'Show 50',
                            'all' => 'Show All'
                        ],
                        'class' => 'js-per-page-select',
                        'width' => 'w-full md:w-28',
                    ];
                    echo renderDropdown($perPageDropdown);
                endif; ?>

                <?php if ($showReset): ?>
                    <button class="js-reset-filter px-5 py-2.5 bg-rose-50/50 border border-rose-100/50 rounded-xl text-[12.5px] font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all shadow-sm">
                        Reset
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
