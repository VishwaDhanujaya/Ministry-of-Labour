<?php
// includes/officials-service.php
require_once __DIR__ . '/translations.php';

function getTopOfficials(PDO $pdo): array {
    $stmt = $pdo->prepare("SELECT * FROM officials WHERE category = 'top' AND is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Normalize image_path to always have admin/ prefix for consistent URL generation
    foreach ($rows as &$row) {
        $row['image_path'] = normalizeOfficialImagePath($row['image_path'] ?? '');
        $row['image'] = $row['image_path'];
    }
    return $rows;
}

/**
 * Ensures the official image path always has the admin/ prefix.
 * Handles legacy paths (uploads/officials/...) and new ones (admin/uploads/officials/...).
 */
function normalizeOfficialImagePath(?string $path): string {
    if (empty($path)) return '';
    // Already prefixed correctly
    if (strpos($path, 'admin/') === 0) return $path;
    // Bare path – prefix with admin/
    if (strpos($path, 'uploads/') === 0) return 'admin/' . $path;
    return $path;
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
            $person['image_path'] = normalizeOfficialImagePath($person['image_path'] ?? '');
            $person['image'] = $person['image_path'];
            $person['designation'] = $person['title'] ?? '';
            $person['designation_si'] = $person['title_si'] ?? '';
            $person['designation_ta'] = $person['title_ta'] ?? '';
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

        $designation = !empty($top['title']) ? $top['title'] : '';
        if (empty($designation)) {
            if ($top['top_role'] === 'minister') $designation = 'Minister of Labour';
            if ($top['top_role'] === 'secretary') $designation = 'Secretary';
        }

        $contactDepts[] = [
            'id' => $modalId,
            'title' => str_replace('Hon. ', '', $top['title']),
            'title_si' => str_replace('ගරු ', '', $top['title_si'] ?? $top['title']),
            'title_ta' => str_replace('கௌரவ ', '', $top['title_ta'] ?? $top['title']),
            'people' => [
                [
                    'name' => $top['name'],
                    'name_si' => $top['name_si'] ?? '',
                    'name_ta' => $top['name_ta'] ?? '',
                    'title' => $top['title'],
                    'title_si' => $top['title_si'] ?? '',
                    'title_ta' => $top['title_ta'] ?? '',
                    'designation' => $designation,
                    'designation_si' => $top['title_si'] ?? '',
                    'designation_ta' => $top['title_ta'] ?? '',
                    'phone' => $top['phone'],
                    'fax' => $top['fax'],
                    'email' => $top['email']
                ]
            ]
        ];
    }

    foreach ($divisions as $div) {
        if ($div['slug'] === 'rti-officers') {
            continue;
        }
        $modalId = $div['slug'] . '-modal';
        // Maps
        if ($div['slug'] === 'administration') $modalId = 'admin-modal';
        if ($div['slug'] === 'internal-audit') $modalId = 'audit-modal';
        
        $title_en = get_division_translation($div['slug'], 'en', true);
        $title_si = get_division_translation($div['slug'], 'si', true);
        $title_ta = get_division_translation($div['slug'], 'ta', true);

        $contactDepts[] = [
            'id' => $modalId,
            'slug' => $div['slug'],
            'title' => $title_en,
            'title_si' => $title_si,
            'title_ta' => $title_ta,
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
    $title_si = $data['title_si'] ?? null;
    $title_ta = $data['title_ta'] ?? null;
    $name = $data['name'] ?? '';
    $name_si = $data['name_si'] ?? null;
    $name_ta = $data['name_ta'] ?? null;
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $fax = $data['fax'] ?? null;
    $image_path = $data['image_path'] ?? null;
    $remove_image = !empty($data['remove_image']);
    
    if ($id) {
        $sql = "UPDATE officials SET 
                category = :category, top_role = :top_role, division_id = :division_id,
                title = :title, title_si = :title_si, title_ta = :title_ta,
                name = :name, name_si = :name_si, name_ta = :name_ta,
                email = :email, phone = :phone, fax = :fax";
        
        $params = [
            ':category' => $category,
            ':top_role' => $top_role,
            ':division_id' => $division_id,
            ':title' => $title,
            ':title_si' => $title_si,
            ':title_ta' => $title_ta,
            ':name' => $name,
            ':name_si' => $name_si,
            ':name_ta' => $name_ta,
            ':email' => $email,
            ':phone' => $phone,
            ':fax' => $fax,
            ':id' => $id
        ];

        if ($remove_image) {
            $sql .= ", image_path = NULL";
        } elseif ($image_path !== null) {
            $sql .= ", image_path = :image_path";
            $params[':image_path'] = $image_path;
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
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
        
        $sql = "INSERT INTO officials (category, top_role, division_id, title, title_si, title_ta, name, name_si, name_ta, email, phone, fax, image_path, sort_order)
                VALUES (:category, :top_role, :division_id, :title, :title_si, :title_ta, :name, :name_si, :name_ta, :email, :phone, :fax, :image_path, :sort_order)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':category' => $category,
            ':top_role' => $top_role,
            ':division_id' => $division_id,
            ':title' => $title,
            ':title_si' => $title_si,
            ':title_ta' => $title_ta,
            ':name' => $name,
            ':name_si' => $name_si,
            ':name_ta' => $name_ta,
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
    
    if ($imagePath) {
        $physicalPath = __DIR__ . '/../' . $imagePath;
        if (strpos($imagePath, 'admin/') !== 0) {
            $physicalPath = __DIR__ . '/../admin/' . $imagePath;
        }
        if (file_exists($physicalPath)) {
            if (strpos($imagePath, 'admin/uploads/officials/') === 0 || strpos($imagePath, 'uploads/officials/') === 0) {
                @unlink($physicalPath);
            }
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
