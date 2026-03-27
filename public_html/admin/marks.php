<?php require 'header.php';
$db = new database();
$page = 'marks.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // DELETE
    if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM marks WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Student marks deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }
}

// LIST
else {
    adminHeader('Student Marks', 'chart', '', '');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Student'],
        ['label' => 'Score', 'align' => 'center', 'width' => '20'],
        ['label' => 'Topic'],
        ['label' => 'Action', 'align' => 'center', 'width' => '20']
    ]);

    $db->query("SELECT * FROM marks ORDER BY id DESC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . htmlspecialchars($r->user_id) . '</td>
            <td class="px-4 py-3 text-center">' . adminBadge($r->score, 'green') . '</td>
            <td class="px-4 py-3 text-slate-600">' . topic_name($r->topic) . '</td>
            <td class="px-4 py-3 text-center">
                <a href="' . $page . '?action=delete&id=' . $r->id . '" onclick="return confirm(\'Delete this record?\')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors inline-block" title="Delete">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </a>
            </td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
