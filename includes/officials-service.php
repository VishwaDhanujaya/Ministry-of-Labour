<?php
// includes/officials-service.php

function getTopOfficials(PDO $pdo): array {
    $stmt = $pdo->prepare("SELECT * FROM officials WHERE category = 'top' AND is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Alias image_path as image so templates can use $official['image'] consistently
    foreach ($rows as &$row) {
        $row['image'] = $row['image_path'];
    }
    return $rows;
}

function getDivisions(PDO $pdo): array {
    $stmt = $pdo->prepare("SELECT * FROM divisions ORDER BY sort_order ASC");
    $stmt->execute();
    $divisions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM officials WHERE category = 'division' AND is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute();
    $allOfficials = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $officialsByDivision = [];
    foreach ($allOfficials as $official) {
        $officialsByDivision[$official['division_id']][] = $official;
    }

    foreach ($divisions as &$div) {
        // Save the numeric ID for lookup
        $dbId = $div['id'];
        
        // Use 'id' matching 'slug-tab' format expected by about-us.php
        $div['id'] = $div['slug'] . '-tab';
        // Some mapping logic to preserve old IDs
        if ($div['slug'] === 'administration') $div['id'] = 'admin-tab';
        if ($div['slug'] === 'development') $div['id'] = 'dev-tab';
        if ($div['slug'] === 'internal-audit') $div['id'] = 'audit-tab';
        
        $div['id_db'] = $dbId; // Keep it just in case

        // Iterate using the correct numeric DB ID
        $div_people = $officialsByDivision[$dbId] ?? [];
        foreach ($div_people as &$person) {
            $person['image'] = $person['image_path'];
        }
        $div['people'] = $div_people;
    }

    return $divisions;
}

function buildContactDepartments(PDO $pdo): array {
    $topOfficials = getTopOfficials($pdo);
    $divisions = getDivisions($pdo);

    $contactDepts = [];

    // Map top officials title strings slightly for contact-us page
    foreach ($topOfficials as $top) {
        $modalId = '';
        if ($top['top_role'] === 'minister') $modalId = 'minister-modal';
        if ($top['top_role'] === 'deputy_minister') $modalId = 'deputy-minister-modal';
        if ($top['top_role'] === 'secretary') $modalId = 'secretary-modal';

        // Custom designation mappings
        $designation = $top['designation'];
        if (empty($designation)) {
            if ($top['top_role'] === 'minister') $designation = 'Minister of Labour';
            if ($top['top_role'] === 'secretary') $designation = 'Secretary';
        }

        $contactDepts[] = [
            'id' => $modalId,
            'title' => str_replace('Hon. ', '', $top['title']),
            'people' => [
                [
                    'name' => $top['name'],
                    'designation' => $designation,
                    'phone' => $top['phone'],
                    'fax' => $top['fax'],
                    'email' => $top['email']
                ]
            ]
        ];
    }

    foreach ($divisions as $div) {
        $modalId = $div['slug'] . '-modal';
        // Maps
        if ($div['slug'] === 'administration') $modalId = 'admin-modal';
        if ($div['slug'] === 'internal-audit') {
            $modalId = 'audit-modal';
            $title = 'Internal Audit'; // Remove 'Division' suffix
        } else {
            $title = $div['title'] . ' Division';
        }

        $contactDepts[] = [
            'id' => $modalId,
            'title' => $title,
            'people' => $div['people']
        ];
    }

    return $contactDepts;
}

function saveOfficial(PDO $pdo, array $data, ?int $id = null): int {
    $category = $data['category'] ?? 'division';
    $top_role = !empty($data['top_role']) ? $data['top_role'] : null;
    $division_id = !empty($data['division_id']) ? $data['division_id'] : null;
    $title = $data['title'] ?? '';
    $name = $data['name'] ?? '';
    $designation = $data['designation'] ?? null;
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $fax = $data['fax'] ?? null;
    $image_path = $data['image_path'] ?? null;
    
    if ($id) {
        $sql = "UPDATE officials SET 
                title = :title, name = :name, designation = :designation, 
                email = :email, phone = :phone, fax = :fax";
        
        if ($image_path !== null) {
            $sql .= ", image_path = :image_path";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $params = [
            ':title' => $title,
            ':name' => $name,
            ':designation' => $designation,
            ':email' => $email,
            ':phone' => $phone,
            ':fax' => $fax,
            ':id' => $id
        ];
        
        if ($image_path !== null) {
            $params[':image_path'] = $image_path;
        }
        
        $stmt->execute($params);
        return $id;
    } else {
        if ($category === 'top') {
            $stmt = $pdo->query("SELECT MAX(sort_order) FROM officials WHERE category = 'top'");
        } else {
            $stmt = $pdo->prepare("SELECT MAX(sort_order) FROM officials WHERE category = 'division' AND division_id = ?");
            $stmt->execute([$division_id]);
        }
        $maxSort = (int)$stmt->fetchColumn();
        $sort_order = $maxSort + 1;
        
        $sql = "INSERT INTO officials (category, top_role, division_id, title, name, designation, email, phone, fax, image_path, sort_order)
                VALUES (:category, :top_role, :division_id, :title, :name, :designation, :email, :phone, :fax, :image_path, :sort_order)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':category' => $category,
            ':top_role' => $top_role,
            ':division_id' => $division_id,
            ':title' => $title,
            ':name' => $name,
            ':designation' => $designation,
            ':email' => $email,
            ':phone' => $phone,
            ':fax' => $fax,
            ':image_path' => $image_path,
            ':sort_order' => $sort_order
        ]);
        return (int)$pdo->lastInsertId();
    }
}

function deleteOfficial(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare("SELECT image_path FROM officials WHERE id = ?");
    $stmt->execute([$id]);
    $imagePath = $stmt->fetchColumn();
    
    if ($imagePath && file_exists(__DIR__ . '/../' . $imagePath)) {
        if (strpos($imagePath, 'admin/uploads/officials/') === 0) {
            @unlink(__DIR__ . '/../' . $imagePath);
        }
    }

    $stmt = $pdo->prepare("DELETE FROM officials WHERE id = ?");
    return $stmt->execute([$id]);
}

function updateSortOrder(PDO $pdo, array $orderedIds): void {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE officials SET sort_order = :sort_order WHERE id = :id");
        foreach ($orderedIds as $index => $id) {
            $stmt->execute([
                ':sort_order' => $index + 1,
                ':id' => $id
            ]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
