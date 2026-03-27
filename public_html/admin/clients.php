<?php require 'header.php';
$db = new database();
$page = 'clients.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Client', 'building', $page);
        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            elseif (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $title = cleanString($_POST["title"]);
                $order = cleanString($_POST["order"]);
                $upload = secureFileUpload($_FILES['image'], '../content/img/clients');
                if ($upload['success']) {
                    $path = "content/img/clients/" . $upload['filename'];
                    try {
                        $db->runQuery("INSERT INTO clients (title, image, c_order) VALUES (?,?,?)",
                            [$title, $path, $order]);
                        adminAlert('success', 'Client added successfully!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                } else {
                    adminAlert('error', $upload['error']);
                }
            } else {
                adminAlert('error', 'Please upload a logo image!');
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminInput('title', 'Client/Partner Name');
            adminInput('order', 'Display Order', '1', 'number');
            adminFileUpload('image', 'Logo Image', '', true);
            adminFormButtons($page, 'Add Client');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Client', 'edit', $page);

        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            else {
                $title = cleanString($_POST["title"]);
                $order = cleanString($_POST["order"]);

                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    $upload = secureFileUpload($_FILES['image'], '../content/img/clients');
                    if ($upload['success']) {
                        $path = "content/img/clients/" . $upload['filename'];
                        try {
                            $db->runQuery("UPDATE clients SET title=?, image=?, c_order=? WHERE id=?",
                                [$title, $path, $order, $id]);
                            adminAlert('success', 'Client updated with new logo!');
                        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                    } else {
                        adminAlert('error', $upload['error']);
                    }
                } else {
                    try {
                        $db->runQuery("UPDATE clients SET title=?, c_order=? WHERE id=?",
                            [$title, $order, $id]);
                        adminAlert('success', 'Client updated!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                }
            }
        }

        $db->query("SELECT * FROM clients WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="flex items-start gap-6 mb-4">
                <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-slate-300 dark:border-slate-600 flex-shrink-0 bg-white p-2">
                    <img src="../<?php echo htmlspecialchars($r->image); ?>" alt="" class="w-full h-full object-contain">
                </div>
                <div class="flex-1">
                    <?php adminFileUpload('image', 'Replace Logo'); ?>
                </div>
            </div>
            <?php
            adminInput('title', 'Client/Partner Name', $r->title);
            adminInput('order', 'Display Order', $r->c_order, 'number');
            adminFormButtons($page, 'Update Client');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM clients WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Client deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM clients WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->title), 'building', $page);
        ?>
        <div class="flex items-center gap-6">
            <div class="w-32 h-32 rounded-xl overflow-hidden border-4 border-primary-100 dark:border-primary-900/30 bg-white p-3">
                <img src="../<?php echo htmlspecialchars($r->image); ?>" alt="" class="w-full h-full object-contain">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-200"><?php echo decode($r->title); ?></h3>
                <p class="text-slate-400 text-sm mt-2">Display Order: <?php echo adminOrderBadge($r->c_order); ?></p>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Clients & Partners', 'building', "$page?action=add", 'Add Client');
    adminTableStart([
        ['label' => 'Logo', 'width' => '20'],
        ['label' => 'Name'],
        ['label' => 'Order', 'align' => 'center', 'width' => '20'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM clients ORDER BY c_order ASC");
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700">
            <td class="px-4 py-3">
                <div class="w-16 h-16 rounded-lg border bg-white p-2 flex items-center justify-center">
                    <img src="../' . htmlspecialchars($r->image) . '" alt="" class="max-w-full max-h-full object-contain">
                </div>
            </td>
            <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-200">' . decode($r->title) . '</td>
            <td class="px-4 py-3 text-center">' . adminOrderBadge($r->c_order) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
