<?php require 'header.php';
$db = new database();
$page = 'programs.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Program', 'programs', $page);
        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            elseif (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $title = cleanString($_POST["title"]);
                $body = $_POST["body"];
                $upload = secureFileUpload($_FILES['image'], '../content/images');
                if ($upload['success']) {
                    $path = "content/images/" . $upload['filename'];
                    try {
                        $db->runQuery("INSERT INTO programs (p_title, p_body, image) VALUES (?,?,?)",
                            [$title, $body, $path]);
                        adminAlert('success', 'Program added successfully!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                } else {
                    adminAlert('error', $upload['error']);
                }
            } else {
                adminAlert('error', 'Please select an image for the program.');
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminInput('title', 'Program Title');
            adminTextarea('body', 'Program Description', '', 8, true);
            adminFileUpload('image', 'Program Image', '', true);
            adminFormButtons($page, 'Publish Program');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Program', 'edit', $page);

        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            else {
                $title = cleanString($_POST["title"]);
                $body = $_POST["body"];

                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    $upload = secureFileUpload($_FILES['image'], '../content/images');
                    if ($upload['success']) {
                        $path = "content/images/" . $upload['filename'];
                        try {
                            $db->runQuery("UPDATE programs SET p_title=?, p_body=?, image=? WHERE p_id=?",
                                [$title, $body, $path, $id]);
                            adminAlert('success', 'Program updated with new image!');
                        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                    } else {
                        adminAlert('error', $upload['error']);
                    }
                } else {
                    try {
                        $db->runQuery("UPDATE programs SET p_title=?, p_body=? WHERE p_id=?",
                            [$title, $body, $id]);
                        adminAlert('success', 'Program updated!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                }
            }
        }

        $db->query("SELECT * FROM programs WHERE p_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php
            adminInput('title', 'Program Title', $r->p_title);
            adminTextarea('body', 'Program Description', $r->p_body, 10, true);
            adminFileUpload('image', 'Replace Image', '../' . $r->image);
            adminFormButtons($page, 'Update Program');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM programs WHERE p_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Program deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM programs WHERE p_id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->p_title), 'programs', $page);
        ?>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-600">
                    <img src="../<?php echo htmlspecialchars($r->image); ?>" alt="" class="w-full h-auto">
                </div>
            </div>
            <div class="md:col-span-2">
                <div class="prose prose-slate dark:prose-invert max-w-none">
                    <?php echo $r->p_body; ?>
                </div>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Programs', 'programs', "$page?action=add", 'Add Program');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Image', 'width' => '20'],
        ['label' => 'Title'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM programs ORDER BY p_id");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3">' . adminTableImage('../' . $r->image, 'w-14 h-14') . '</td>
            <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-200">' . decode($r->p_title) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->p_id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
