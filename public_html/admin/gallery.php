<?php require 'header.php';
$db = new database();
$page = 'gallery.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Gallery', 'gallery', $page);
        if (isset($_POST["publish"])) {
            if (isset($_FILES['files']) && $_FILES['files']['tmp_name'][0] != '') {
                $title = cleanString($_POST["title"]);
                $order = cleanString($_POST["order"]);
                $imageData = [];

                $uploadError = false;
                foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                    $singleFile = [
                        'name'     => $_FILES['files']['name'][$key],
                        'type'     => $_FILES['files']['type'][$key],
                        'tmp_name' => $_FILES['files']['tmp_name'][$key],
                        'error'    => $_FILES['files']['error'][$key],
                        'size'     => $_FILES['files']['size'][$key]
                    ];
                    $upload = secureFileUpload($singleFile, '../content/images');
                    if ($upload['success']) {
                        $imageData[] = "content/images/" . $upload['filename'];
                    } else {
                        adminAlert('error', $upload['error']);
                        $uploadError = true;
                        break;
                    }
                }

                if (!$uploadError) {
                    try {
                        $db->runQuery("INSERT INTO gallery (title, images, g_order) VALUES (?,?,?)",
                            [$title, implode("|", $imageData), $order]);
                        adminAlert('success', 'Gallery added successfully!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                }
            } else {
                adminAlert('error', 'Please select at least one image.');
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminInput('title', 'Gallery Title');
            adminInput('order', 'Display Order', '1', 'number');
            ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gallery Images</label>
                <input name="files[]" type="file" multiple accept="image/*" required
                    class="w-full cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl p-2">
            </div>
            <?php adminFormButtons($page, 'Add Gallery'); ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Gallery', 'edit', $page);

        if (isset($_POST["publish"])) {
            $title = cleanString($_POST["title"]);
            $order = cleanString($_POST["order"]);

            if (isset($_FILES['files']) && $_FILES['files']['tmp_name'][0] != '') {
                $imageData = [];
                $uploadError = false;
                foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                    $singleFile = [
                        'name'     => $_FILES['files']['name'][$key],
                        'type'     => $_FILES['files']['type'][$key],
                        'tmp_name' => $_FILES['files']['tmp_name'][$key],
                        'error'    => $_FILES['files']['error'][$key],
                        'size'     => $_FILES['files']['size'][$key]
                    ];
                    $upload = secureFileUpload($singleFile, '../content/images');
                    if ($upload['success']) {
                        $imageData[] = "content/images/" . $upload['filename'];
                    } else {
                        adminAlert('error', $upload['error']);
                        $uploadError = true;
                        break;
                    }
                }
                if (!$uploadError) {
                    try {
                        $db->runQuery("UPDATE gallery SET title=?, images=?, g_order=? WHERE id=?",
                            [$title, implode("|", $imageData), $order, $id]);
                        adminAlert('success', 'Gallery updated with new images!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                }
            } else {
                try {
                    $db->runQuery("UPDATE gallery SET title=?, g_order=? WHERE id=?", [$title, $order, $id]);
                    adminAlert('success', 'Gallery updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }

        $db->query("SELECT * FROM gallery WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminInput('title', 'Gallery Title', $r->title);
            adminInput('order', 'Display Order', $r->g_order, 'number');
            ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Current Images</label>
                <div class="grid grid-cols-4 gap-2 mb-4">
                    <?php
                    foreach (explode("|", $r->images) as $img) {
                        echo '<img src="../' . htmlspecialchars($img) . '" class="w-full h-20 object-cover rounded-lg border">';
                    }
                    ?>
                </div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Replace Images (optional)</label>
                <input name="files[]" type="file" multiple accept="image/*"
                    class="w-full cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 rounded-xl p-2">
            </div>
            <?php adminFormButtons($page, 'Update Gallery'); ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM gallery WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Gallery deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM gallery WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->title), 'gallery', $page);
        ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <?php
            foreach (explode("|", $r->images) as $img) {
                echo '<a href="../' . htmlspecialchars($img) . '" target="_blank" class="aspect-square rounded-xl overflow-hidden border hover:shadow-lg transition-all">
                    <img src="../' . htmlspecialchars($img) . '" class="w-full h-full object-cover">
                </a>';
            }
            ?>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Gallery', 'gallery', "$page?action=add", 'Add Gallery');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Preview', 'width' => '24'],
        ['label' => 'Title'],
        ['label' => 'Photos', 'align' => 'center', 'width' => '20'],
        ['label' => 'Order', 'align' => 'center', 'width' => '20'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM gallery ORDER BY g_order ASC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        $images = explode("|", $r->images);
        $photoCount = count($images);
        echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3">' . adminTableImage('../' . $images[0], 'w-16 h-16') . '</td>
            <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-200">' . decode($r->title) . '</td>
            <td class="px-4 py-3 text-center">' . adminBadge($photoCount . ' photos', 'blue') . '</td>
            <td class="px-4 py-3 text-center">' . adminOrderBadge($r->g_order) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
