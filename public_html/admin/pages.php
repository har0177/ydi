<?php require 'header.php';
$db = new database();
$page = 'pages.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Page', 'document', $page);
        if (isset($_POST["publish"])) {
            $title = cleanString($_POST["title"]);
            $body = $_POST["body"];
            if (empty($title)) {
                adminAlert('error', 'Page title is required!');
            } else {
                try {
                    $db->runQuery("INSERT INTO pages(page_title, page_body) VALUES (?,?)", [$title, $body]);
                    adminAlert('success', 'Page added successfully!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <?php
            adminInput('title', 'Page Title');
            adminTextarea('body', 'Page Content', '', 10, true);
            adminFormButtons($page, 'Add Page');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Page', 'edit', $page);
        if (isset($_POST["publish"])) {
            $title = cleanString($_POST["title"]);
            $body = $_POST["body"];
            if (empty($title)) {
                adminAlert('error', 'Page title is required!');
            } else {
                try {
                    $db->runQuery("UPDATE pages SET page_title=?, page_body=? WHERE page_id=?", [$title, $body, $id]);
                    adminAlert('success', 'Page updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM pages WHERE page_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <?php
            adminInput('title', 'Page Title', $r->page_title);
            adminTextarea('body', 'Page Content', $r->page_body, 10, true);
            adminFormButtons($page, 'Update Page');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM pages WHERE page_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Page deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }
}

// LIST
else {
    adminHeader('Manage Pages', 'document', "$page?action=add", 'Add Page');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Title'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM pages ORDER BY page_id");
    $i = 1;
    while ($r = $db->fetchObject()) {
        $viewAction = '<a href="../page.php?id=' . $r->page_id . '" target="_blank" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="View">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </a>';
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode($r->page_title) . '</td>
            <td class="px-4 py-3">
                <div class="flex items-center justify-center gap-1">
                    ' . $viewAction . '
                    <a href="' . $page . '?action=edit&id=' . $r->page_id . '" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <a href="' . $page . '?action=delete&id=' . $r->page_id . '" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </a>
                </div>
            </td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
