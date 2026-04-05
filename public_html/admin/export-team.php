<?php
require 'header.php';
ob_end_clean();

$db = new database();
$db->query("SELECT title, desg, department, contact, image, bio, team_order FROM team ORDER BY team_order ASC");

$filename = 'team-data-' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

fputcsv($output, [
    'Full Name',
    'Designation / Role',
    'Department',
    'Contact Information',
    'Profile Image',
    'Short Bio / Description',
    'Display Order'
]);

while ($r = $db->fetchObject()) {
    fputcsv($output, [
        $r->title ?? '',
        $r->desg ?? '',
        $r->department ?? '',
        $r->contact ?? '',
        !empty($r->image) ? 'https://ydi.edu.pk/' . $r->image : '',
        $r->bio ?? '',
        $r->team_order ?? ''
    ]);
}

fclose($output);
exit();
