import re
import os

files = [
    'admin/manage-action-plans.php',
    'admin/manage-acts.php',
    'admin/manage-learning-platforms-foreign.php',
    'admin/manage-learning-platforms-local.php',
    'admin/manage-procurements.php',
    'admin/manage-rti-reports.php',
    'admin/manage-special-notices.php',
    'admin/manage-vacancies.php'
]

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # 1. Update SELECT in Handle Delete
    content = re.sub(
        r'\$stmt = \$pdo->prepare\("SELECT (id, )?pdf_path FROM ([a-z_]+) WHERE id = \?"\);',
        r'$stmt = $pdo->prepare("SELECT \1pdf_path, pdf_path_si, pdf_path_ta FROM \2 WHERE id = ?");',
        content
    )
    
    # 2. Update unlink in Handle Delete
    unlink_pattern = r"if \(!empty\(\$([a-zA-Z0-9_]+)\['pdf_path'\]\) && file_exists\(\$\1\['pdf_path'\]\)\) \{\s*@?unlink\(\$\1\['pdf_path'\]\);\s*\}"
    unlink_replacement = r"""if (!empty($\1['pdf_path']) && file_exists($\1['pdf_path'])) {
            @unlink($\1['pdf_path']);
        }
        if (!empty($\1['pdf_path_si']) && file_exists($\1['pdf_path_si'])) {
            @unlink($\1['pdf_path_si']);
        }
        if (!empty($\1['pdf_path_ta']) && file_exists($\1['pdf_path_ta'])) {
            @unlink($\1['pdf_path_ta']);
        }"""
    content = re.sub(unlink_pattern, unlink_replacement, content)

    # Now we need to manually update the files for the rest of the chunks, 
    # since Add/Edit logic varies highly (e.g. some have categories, some have descriptions, some don't).
    # Let's save just the Delete logic for now to reduce diff size.
    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

print("Delete logic updated.")
