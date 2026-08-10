<?php
$pages = [
    'vacancies.php',
    'procurements.php',
    'downloads.php',
    'special-notices.php',
    'iau-updates.php',
    'learning-platforms-local.php',
    'learning-platforms-foreign.php'
];

$allOk = true;

foreach ($pages as $page) {
    // Run php -l to check for syntax errors
    $output = shell_exec("php -l ./$page 2>&1");
    if (strpos($output, 'No syntax errors detected') === false) {
        echo "Syntax Error in $page:\n$output\n";
        $allOk = false;
    } else {
        echo "$page: Syntax OK\n";
    }
}

if ($allOk) {
    echo "All listing pages passed syntax check (No 500 errors expected from parse errors).\n";
}
