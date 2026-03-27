<?php require 'header.php';
$db = new database();
$page = 'videos.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Video', 'video', $page);
        if (isset($_POST["publish"])) {
            try {
                $videoId = extractYoutubeId($_POST["link"]);
                $db->runQuery("INSERT INTO videos (name, link, status, v_order) VALUES (?,?,?,?)",
                    [cleanString($_POST["title"]), cleanString($videoId), cleanString($_POST["status"]), cleanString($_POST["order"])]);
                adminAlert('success', 'Video added successfully!');
            } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <?php
            adminInput('title', 'Video Title');
            adminYoutubeInput('link', 'YouTube Video');
            adminInput('order', 'Display Order', '1', 'number');
            ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <?php adminFormButtons($page, 'Add Video'); ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Video', 'edit', $page);
        if (isset($_POST["publish"])) {
            try {
                $videoId = extractYoutubeId($_POST["link"]);
                $db->runQuery("UPDATE videos SET name=?, link=?, status=?, v_order=? WHERE id=?",
                    [cleanString($_POST["title"]), cleanString($videoId), cleanString($_POST["status"]), cleanString($_POST["order"]), $id]);
                adminAlert('success', 'Video updated!');
            } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
        }
        $db->query("SELECT * FROM videos WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Preview</label>
                <img src="https://i1.ytimg.com/vi/<?php echo htmlspecialchars($r->link); ?>/hqdefault.jpg" class="w-48 rounded-xl border">
            </div>
            <?php
            adminInput('title', 'Video Title', $r->name);
            adminYoutubeInput('link', 'YouTube Video', $r->link);
            adminInput('order', 'Display Order', $r->v_order, 'number');
            ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="1" <?php echo $r->status == '1' ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo $r->status == '0' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <?php adminFormButtons($page, 'Update Video'); ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM videos WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Video deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM videos WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->name), 'video', $page);
        ?>
        <div class="aspect-video rounded-xl overflow-hidden bg-black">
            <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($r->link); ?>?rel=0" class="w-full h-full" allowfullscreen></iframe>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Videos', 'video', "$page?action=add", 'Add Video');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Thumbnail', 'width' => '24'],
        ['label' => 'Title'],
        ['label' => 'Order', 'align' => 'center', 'width' => '20'],
        ['label' => 'Status', 'align' => 'center', 'width' => '24'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM videos ORDER BY v_order ASC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        $thumb = '<img src="https://i1.ytimg.com/vi/' . htmlspecialchars($r->link) . '/hqdefault.jpg" class="w-20 h-12 object-cover rounded-lg">';
        $status = $r->status == '1' ? adminBadge('Active', 'green') : adminBadge('Inactive', 'red');
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3">' . $thumb . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode($r->name) . '</td>
            <td class="px-4 py-3 text-center">' . adminOrderBadge($r->v_order) . '</td>
            <td class="px-4 py-3 text-center">' . $status . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
