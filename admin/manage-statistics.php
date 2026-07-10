<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$current_page = "manage-statistics";
$error = '';
$success = '';

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    
    if ($action === 'edit') {
        $edit_id = (int)($_POST['stat_id'] ?? 0);
        $new_value = trim($_POST['stat_value'] ?? '');
        
        if ($edit_id <= 0) {
            $error = "Invalid statistic ID.";
        } elseif ($new_value === '') {
            $error = "Value is required.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id FROM statistics WHERE id = ?");
                $stmt->execute([$edit_id]);
                $existing = $stmt->fetch();
                
                if (!$existing) {
                    $error = "Statistic not found.";
                } else {
                    $stmt = $pdo->prepare("UPDATE statistics SET stat_value = ? WHERE id = ?");
                    if ($stmt->execute([$new_value, $edit_id])) {
                        $success = "Statistic value updated successfully.";
                    } else {
                        $error = "Failed to update statistic value.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Fetch statistics
try {
    $stmt = $pdo->query("SELECT * FROM statistics ORDER BY display_order ASC");
    $statistics = $stmt->fetchAll();
} catch (PDOException $e) {
    $statistics = [];
    $error = "Table 'statistics' does not exist yet. Please execute the SQL commands first.";
}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Manage Home Page Statistics</h2>
        </div>

        

        

        <!-- Table Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Label</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Current Value (Count)</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 uppercase tracking-wider">Suffix</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-500 text-right uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($statistics)): ?>
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <p class="text-[14px] font-semibold text-gray-900 mb-1">No statistics found</p>
                                <p class="text-[12px] text-gray-500 max-w-sm">Please ensure the <code>statistics</code> database table is created and seeded.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($statistics as $stat): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <p class="text-[13px] font-medium text-gray-900"><?= htmlspecialchars($stat['stat_label']) ?></p>
                            <p class="text-[11px] text-gray-400 font-mono">Key: <?= htmlspecialchars($stat['stat_key']) ?></p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded text-[12px] font-mono bg-gray-100 text-gray-800 border border-gray-200">
                                <?= htmlspecialchars($stat['stat_value']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-[13px] text-gray-600 font-mono">
                            <?= !empty($stat['stat_suffix']) ? htmlspecialchars($stat['stat_suffix']) : '<em>None</em>' ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button onclick='openEditModal(<?= json_encode($stat, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors inline-flex items-center text-xs font-semibold" title="Edit Count">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                <span>Edit Count</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Modal -->
        <div id="statModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Edit Count Value
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors bg-white hover:bg-gray-100 rounded-full p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <form id="statForm" action="" method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="stat_id" id="modalStatId" value="">
                        
                        <div>
                            <label class="block text-[13px] font-medium text-gray-400 mb-2">Statistic Name (Read-only)</label>
                            <input type="text" id="modalStatLabel" readonly class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[13px] text-gray-500 font-semibold cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Count Value <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="stat_value" id="modalStatValue" required placeholder="e.g. 5, 32, 1250" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400 font-mono">
                                <span id="modalStatSuffixDisplay" class="px-3 py-3 bg-gray-50 border border-gray-200 text-gray-500 text-[13px] rounded-lg font-mono font-semibold"></span>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closeModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openEditModal(stat) {
            document.getElementById('modalStatId').value = stat.id;
            document.getElementById('modalStatLabel').value = stat.stat_label;
            document.getElementById('modalStatValue').value = stat.stat_value;
            
            const suffixEl = document.getElementById('modalStatSuffixDisplay');
            if (stat.stat_suffix) {
                suffixEl.textContent = stat.stat_suffix;
                suffixEl.style.display = 'inline-block';
            } else {
                suffixEl.style.display = 'none';
            }
            
            const modal = document.getElementById('statModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('statModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        </script>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
