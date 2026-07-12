<?php
/**
 * table-helper.php
 * Premium reusable table component for administrative panels.
 *
 * Design tokens (matching site theme):
 *   - Container:   bg-white rounded-2xl border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)]
 *   - Header row:  bg-slate-50/50 text-slate-400 text-[11px] uppercase tracking-wider
 *   - Body rows:   hover:bg-slate-50/60 border-b border-slate-50/70
 *   - Pagination:  bg-[#13273F] (active), border-slate-200 (inactive), rounded-xl
 *   - Accent:      #4E0000 (maroon)
 */

require_once __DIR__ . '/dropdown-helper.php';

function renderAdminTable(array $headers, array $rows, callable $renderRowCallback, array $options = []) {
    $minWidth       = $options['minWidth'] ?? '800px';
    $emptyTitle     = $options['emptyTitle'] ?? 'No records found';
    $emptySubtitle  = $options['emptySubtitle'] ?? 'There are no items matching your criteria.';
    $emptyIcon      = $options['emptyIcon'] ?? 'document';
    $tableClass     = $options['tableClass'] ?? 'js-filterable-table w-full text-left border-collapse';
    $containerClass = $options['containerClass'] ?? 'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12';
    $pagination     = $options['pagination'] ?? null;
    $filters        = $options['filters'] ?? null;
    $itemsPerPage   = $options['itemsPerPage'] ?? false;
    $tableId        = $options['tableId'] ?? 'admin-table-' . uniqid();

    // Render filter bar if provided or pagination is enabled
    if ($filters !== null) {
        if ($pagination !== null) {
            $filters['pagination'] = $pagination;
        }
        renderFilterBar($filters);
    } elseif ($pagination && ($pagination['enable_paging'] ?? false)) {
        renderFilterBar(['pagination' => $pagination, 'reset' => false]);
    }
    ?>
    <div class="<?= htmlspecialchars($containerClass) ?>" data-table-id="<?= htmlspecialchars($tableId) ?>">
        <div class="overflow-x-auto">
            <table class="<?= htmlspecialchars($tableClass) ?>" style="min-width: <?= htmlspecialchars($minWidth) ?>;" id="<?= htmlspecialchars($tableId) ?>">
                <thead>
                    <tr class="bg-gray-50/70 text-gray-650 border-b border-gray-100 text-[13.5px] font-semibold font-inter select-none">
                        <?php foreach ($headers as $header): 
                            $thClass = $header['class'] ?? '';
                            $thLabel = $header['label'] ?? '';
                        ?>
                            <th class="py-4 px-6 <?= htmlspecialchars($thClass) ?>"><?= htmlspecialchars($thLabel) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <?php
                $tbodyClass = $options['tbodyClass'] ?? 'divide-y divide-gray-100 text-[13px]';
                $tbodyAttrs = $options['tbodyAttrs'] ?? '';
                ?>
                <tbody class="<?= htmlspecialchars($tbodyClass) ?>" <?= $tbodyAttrs ?>>
                    <?php if (empty($rows)): ?>
                    <tr class="js-empty-state">
                        <td colspan="<?= count($headers) ?>" class="py-16 px-6 text-center text-slate-400">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-inner">
                                <?php if ($emptyIcon === 'users'): ?>
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20M3 16.172c0-2.278 1.964-4.122 4.382-4.122 2.419 0 4.382 1.844 4.382 4.122 0 1.139-.491 2.164-1.282 2.9M3 16.172v.109A11.386 11.386 0 007.91 20M3 16.172a11.387 11.387 0 014.91-4.085m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                <?php elseif ($emptyIcon === 'news'): ?>
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" /></svg>
                                <?php else: ?>
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <span class="font-bold text-slate-700 block mb-1"><?= htmlspecialchars($emptyTitle) ?></span>
                            <span class="text-xs text-slate-400"><?= htmlspecialchars($emptySubtitle) ?></span>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $index => $row) {
                            $renderRowCallback($row, $index);
                        } ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($pagination && !empty($rows)): 
            $totalItems   = $pagination['total_items'] ?? count($rows);
            $showingCount = $pagination['showing_count'] ?? count($rows);
            $perPage      = $pagination['per_page'] ?? $totalItems; // default shows all
            $enablePaging = $pagination['enable_paging'] ?? ($totalItems > 10);
        ?>
            <!-- Pagination -->
            <div class="js-table-pagination px-6 py-4 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-3 font-inter bg-slate-50/30"
                 data-total="<?= (int)$totalItems ?>" 
                 data-per-page="<?= (int)$perPage ?>"
                 data-table-id="<?= htmlspecialchars($tableId) ?>">
                <div class="flex items-center gap-4">
                    <p class="js-pagination-info text-[12.5px] text-slate-500 font-medium">
                        Showing <span class="font-semibold text-slate-800"><?= min($perPage, $totalItems) ?></span> of <span class="font-semibold text-slate-800"><?= htmlspecialchars($totalItems) ?></span> entries
                    </p>
                </div>
                <div class="js-pagination-buttons flex gap-1.5">
                    <!-- Pagination buttons rendered by JS -->
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
