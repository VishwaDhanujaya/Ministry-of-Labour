<?php
/**
 * Activity Logger Utility
 * Provides centralized tracking of admin actions across the portal.
 */

if (!function_exists('logActivity')) {
    function logActivity(PDO $pdo, int $adminId, string $actionType, string $description): bool {
        try {
            // Auto-ensure activity logs table exists
            $pdo->exec("CREATE TABLE IF NOT EXISTS admin_activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                admin_id INT NOT NULL,
                action_type VARCHAR(50) NOT NULL,
                description TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX (admin_id),
                INDEX (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $stmt = $pdo->prepare("INSERT INTO admin_activity_logs (admin_id, action_type, description) VALUES (:admin_id, :action_type, :description)");
            return $stmt->execute([
                'admin_id' => $adminId,
                'action_type' => $actionType,
                'description' => $description
            ]);
        } catch (PDOException $e) {
            error_log("Failed to log activity: " . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('getRecentActivities')) {
    function getRecentActivities(PDO $pdo, int $limit = 6): array {
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS admin_activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                admin_id INT NOT NULL,
                action_type VARCHAR(50) NOT NULL,
                description TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX (admin_id),
                INDEX (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $stmt = $pdo->prepare("SELECT l.*, a.name as admin_name 
                                  FROM admin_activity_logs l 
                                  LEFT JOIN admins a ON l.admin_id = a.id 
                                  ORDER BY l.created_at DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
