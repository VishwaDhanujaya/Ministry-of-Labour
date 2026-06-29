<?php
require_once 'admin/includes/db.php';

try {
    // 1. Create learning_platforms_local table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `learning_platforms_local` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text DEFAULT NULL,
      `pdf_path` varchar(255) NOT NULL,
      `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
      `created_at` timestamp NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    echo "Created learning_platforms_local table.\n";

    // 2. Create learning_platforms_foreign table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `learning_platforms_foreign` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `description` text DEFAULT NULL,
      `pdf_path` varchar(255) NOT NULL,
      `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
      `created_at` timestamp NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    echo "Created learning_platforms_foreign table.\n";

    // 3. Migrate existing data from publications to local (as default)
    // Check if publications table exists first
    $tableExists = $pdo->query("SHOW TABLES LIKE 'publications'")->rowCount() > 0;
    if ($tableExists) {
        $stmt = $pdo->query("SELECT * FROM `publications`");
        $publications = $stmt->fetchAll();
        
        if (count($publications) > 0) {
            $insertLocal = $pdo->prepare("INSERT INTO `learning_platforms_local` (title, description, pdf_path, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($publications as $pub) {
                $insertLocal->execute([$pub['title'], $pub['description'], $pub['pdf_path'], $pub['status'], $pub['created_at'], $pub['updated_at']]);
            }
            echo "Migrated " . count($publications) . " records to learning_platforms_local.\n";
        }

        // 4. Drop publications table
        $pdo->exec("DROP TABLE IF EXISTS `publications`;");
        echo "Dropped publications table.\n";
    } else {
        echo "Table publications does not exist, skipping data migration.\n";
    }

    echo "Migration completed successfully!\n";

} catch (PDOException $e) {
    echo "Error during migration: " . $e->getMessage() . "\n";
}
?>
