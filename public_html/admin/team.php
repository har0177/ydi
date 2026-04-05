<?php require 'header.php';
$db = new database();
$page = 'team.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Team Member', 'user-plus', $page);
        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            elseif (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $title = cleanString($_POST["title"]);
                $desg = cleanString($_POST["desg"]);
                $department = cleanString($_POST["department"]);
                $contact = cleanString($_POST["contact"]);
                $bio = cleanString($_POST["bio"]);
                $order = cleanString($_POST["order"]);
                $upload = secureFileUpload($_FILES['image'], dirname(__DIR__) . '/content/img/home/team');
                if ($upload['success']) {
                    $path = "content/img/home/team/" . $upload['filename'];
                    try {
                        $db->runQuery("INSERT INTO team (title, desg, department, contact, bio, image, team_order) VALUES (?,?,?,?,?,?,?)",
                            [$title, $desg, $department, $contact, $bio, $path, $order]);
                        adminAlert('success', 'Team member added successfully!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                } else {
                    adminAlert('error', $upload['error']);
                }
            } else {
                adminAlert('error', 'Please select a photo.');
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" enctype="multipart/form-data" class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div><?php adminInput('title', 'Name'); ?></div>
                <div><?php adminInput('desg', 'Designation'); ?></div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><?php adminInput('department', 'Department'); ?></div>
                <div><?php adminInput('contact', 'Contact Information'); ?></div>
            </div>
            <?php
            adminTextarea('bio', 'Short Bio / Description');
            adminInput('order', 'Display Order', '1', 'number');
            adminFileUpload('image', 'Photo', '', true);
            adminFormButtons($page, 'Add Member');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Team Member', 'edit', $page);

        if (isset($_POST["publish"])) {
            if (!adminValidateCsrf()) { /* CSRF failed */ }
            else {
                $title = cleanString($_POST["title"]);
                $desg = cleanString($_POST["desg"]);
                $department = cleanString($_POST["department"]);
                $contact = cleanString($_POST["contact"]);
                $bio = cleanString($_POST["bio"]);
                $order = cleanString($_POST["order"]);

                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    $upload = secureFileUpload($_FILES['image'], dirname(__DIR__) . '/content/img/home/team');
                    if ($upload['success']) {
                        $path = "content/img/home/team/" . $upload['filename'];
                        try {
                            $db->runQuery("UPDATE team SET title=?, desg=?, department=?, contact=?, bio=?, image=?, team_order=? WHERE id=?",
                                [$title, $desg, $department, $contact, $bio, $path, $order, $id]);
                            adminAlert('success', 'Team member updated with new photo!');
                        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                    } else {
                        adminAlert('error', $upload['error']);
                    }
                } else {
                    try {
                        $db->runQuery("UPDATE team SET title=?, desg=?, department=?, contact=?, bio=?, team_order=? WHERE id=?",
                            [$title, $desg, $department, $contact, $bio, $order, $id]);
                        adminAlert('success', 'Team member updated!');
                    } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
                }
            }
        }

        $db->query("SELECT * FROM team WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="flex items-start gap-6 mb-4">
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-slate-300 dark:border-slate-600 flex-shrink-0">
                    <img src="../<?php echo htmlspecialchars($r->image); ?>" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <?php adminFileUpload('image', 'Replace Photo'); ?>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><?php adminInput('title', 'Name', $r->title); ?></div>
                <div><?php adminInput('desg', 'Designation', $r->desg); ?></div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><?php adminInput('department', 'Department', $r->department); ?></div>
                <div><?php adminInput('contact', 'Contact Information', $r->contact); ?></div>
            </div>
            <?php
            adminTextarea('bio', 'Short Bio / Description', $r->bio);
            adminInput('order', 'Display Order', $r->team_order, 'number');
            adminFormButtons($page, 'Update Member');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM team WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Team member deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM team WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->title), 'user', $page);
        ?>
        <div class="flex items-center gap-6">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-primary-100 dark:border-primary-900/30">
                <img src="../<?php echo htmlspecialchars($r->image); ?>" alt="" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-200"><?php echo decode($r->title); ?></h3>
                <p class="text-primary-500 font-medium"><?php echo decode($r->desg); ?></p>
                <?php if (!empty($r->department)) { ?>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Department: <?php echo decode($r->department); ?></p>
                <?php } ?>
                <?php if (!empty($r->contact)) { ?>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Contact: <?php echo decode($r->contact); ?></p>
                <?php } ?>
                <p class="text-slate-400 text-sm mt-2">Display Order: <?php echo $r->team_order; ?></p>
                <?php if (!empty($r->bio)) { ?>
                <p class="text-slate-600 dark:text-slate-400 mt-3"><?php echo decode($r->bio); ?></p>
                <?php } ?>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Team Members', 'team', "$page?action=add", 'Add Member');
    echo '<div class="px-6 -mt-2 mb-4"><a href="export-team.php" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg font-medium hover:bg-green-600 transition-colors text-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export to Excel</a></div>';
    adminTableStart([
        ['label' => 'Photo', 'width' => '16'],
        ['label' => 'Name'],
        ['label' => 'Designation'],
        ['label' => 'Department'],
        ['label' => 'Order', 'align' => 'center', 'width' => '20'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM team ORDER BY team_order ASC");
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700">
            <td class="px-4 py-2">' . adminTableImage('../' . $r->image, 'w-12 h-12', true) . '</td>
            <td class="px-4 py-2 font-medium text-slate-800 dark:text-slate-200">' . decode($r->title) . '</td>
            <td class="px-4 py-2 text-slate-600 dark:text-slate-400">' . decode($r->desg) . '</td>
            <td class="px-4 py-2 text-slate-600 dark:text-slate-400">' . decode($r->department ?? '') . '</td>
            <td class="px-4 py-2 text-center">' . adminOrderBadge($r->team_order) . '</td>
            <td class="px-4 py-2">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
