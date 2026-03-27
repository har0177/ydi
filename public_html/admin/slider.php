<?php require 'header.php';
$db = new database();
$page = 'slider.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Slider', 'image', $page);
        if (isset($_POST["publish"])) {
            $title1 = cleanString($_POST["title1"]);
            $title2 = cleanString($_POST["title2"]);
            $title3 = cleanString($_POST["title3"]);
            $order = cleanString($_POST["order"]);
            $path = " ";

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $upload = secureFileUpload($_FILES['image'], dirname(__DIR__) . '/content/images');
                if ($upload['success']) {
                    $path = "content/images/" . $upload['filename'];
                } else {
                    adminAlert('error', $upload['error']);
                }
            }

            if ($path !== " ") {
                try {
                    $db->runQuery("INSERT INTO slider VALUES (null,?,?,?,?,?)", [$path, $title1, $title2, $title3, $order]);
                    adminAlert('success', 'Slider added successfully!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            } elseif (!isset($_FILES['image']) || $_FILES['image']['size'] == 0) {
                adminAlert('error', 'Please select an image for the slider.');
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminFileUpload('image', 'Slider Image');
            adminInput('title1', 'Title 1');
            adminInput('title2', 'Title 2');
            adminInput('title3', 'Title 3');
            adminInput('order', 'Display Order', '1', 'number');
            adminFormButtons($page, 'Add Slider');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Slider', 'edit', $page);
        if (isset($_POST["publish"])) {
            $title1 = cleanString($_POST["title1"]);
            $title2 = cleanString($_POST["title2"]);
            $title3 = cleanString($_POST["title3"]);
            $order = cleanString($_POST["order"]);

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $upload = secureFileUpload($_FILES['image'], dirname(__DIR__) . '/content/images');
                if ($upload['success']) {
                    $path = "content/images/" . $upload['filename'];
                    try {
                        $db->runQuery("UPDATE slider SET image=?, title1=?, title2=?, title3=?, s_order=? WHERE id=?",
                            [$path, $title1, $title2, $title3, $order, $id]);
                        adminAlert('success', 'Slider updated!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                } else {
                    adminAlert('error', $upload['error']);
                }
            } else {
                try {
                    $db->runQuery("UPDATE slider SET title1=?, title2=?, title3=?, s_order=? WHERE id=?",
                        [$title1, $title2, $title3, $order, $id]);
                    adminAlert('success', 'Slider updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM slider WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminFileUpload('image', 'Slider Image', '../' . $r->image);
            adminInput('title1', 'Title 1', $r->title1);
            adminInput('title2', 'Title 2', $r->title2);
            adminInput('title3', 'Title 3', $r->title3);
            adminInput('order', 'Display Order', $r->s_order, 'number');
            adminFormButtons($page, 'Update Slider');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM slider WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Slider deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM slider WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader('View Slider', 'image', $page);
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <img src="../<?php echo htmlspecialchars($r->image); ?>" class="w-full rounded-xl border">
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-500">Title 1</label>
                    <p class="text-lg text-slate-800"><?php echo htmlspecialchars($r->title1); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500">Title 2</label>
                    <p class="text-lg text-slate-800"><?php echo htmlspecialchars($r->title2); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500">Title 3</label>
                    <p class="text-lg text-slate-800"><?php echo htmlspecialchars($r->title3); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500">Order</label>
                    <p class="text-lg text-slate-800"><?php echo adminOrderBadge($r->s_order); ?></p>
                </div>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Slider', 'image', "$page?action=add", 'Add Slider');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Image', 'width' => '32'],
        ['label' => 'Title 1'],
        ['label' => 'Title 2'],
        ['label' => 'Title 3'],
        ['label' => 'Order', 'align' => 'center', 'width' => '20'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM slider ORDER BY s_order ASC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3">' . adminTableImage('../' . $r->image, 'w-24 h-16') . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . htmlspecialchars($r->title1) . '</td>
            <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->title2) . '</td>
            <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->title3) . '</td>
            <td class="px-4 py-3 text-center">' . adminOrderBadge($r->s_order) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
