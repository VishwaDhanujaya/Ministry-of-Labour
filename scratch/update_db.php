<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=mol_db;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("UPDATE divisions SET name_si = 'මිනිස්බල හා රැකිරක්ෂා දෙපාර්තමේන්තුව' WHERE name_si LIKE '%මිනිස්බල%'");
    $stmt->execute();
    echo "Updated " . $stmt->rowCount() . " rows in divisions.\n";

    $stmt2 = $pdo->prepare("UPDATE settings SET value = REPLACE(value, 'මිනිස්බල හා රැකියා නියුක්ති දෙපාර්තමේන්තුව', 'මිනිස්බල හා රැකිරක්ෂා දෙපාර්තමේන්තුව')");
    $stmt2->execute();
    echo "Updated " . $stmt2->rowCount() . " rows in settings.\n";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
