<?php require 'header.php';
$db = new database();
$page = 'feedback.php';

// LIST
adminHeader('Enrolled Students', 'users', '', '');
adminTableStart([
    ['label' => 'Name'],
    ['label' => 'Program'],
    ['label' => 'Contact'],
    ['label' => 'Email'],
    ['label' => 'Address']
]);

$db->query("SELECT * FROM enroll ORDER BY id DESC");
while ($r = $db->fetchObject()) {
    echo '<tr class="hover:bg-slate-50">
        <td class="px-4 py-3 font-medium text-slate-800">' . htmlspecialchars($r->name) . '</td>
        <td class="px-4 py-3">' . adminBadge(program_name($r->program), 'blue') . '</td>
        <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->contact) . '</td>
        <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->email) . '</td>
        <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->address) . '</td>
    </tr>';
}

adminTableEnd();
adminFooter();

require 'footer.php';
