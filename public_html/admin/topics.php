<?php require 'header.php';
$db = new database();
$page = 'topics.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Topic', 'folder', $page);
        if (isset($_POST["publish"])) {
            $name = cleanString($_POST["name"]);
            $parent = $_POST["parent_id"];
            $time = $_POST["time"];
            if (empty($name)) {
                adminAlert('error', 'Topic name is required!');
            } else {
                try {
                    $db->runQuery("INSERT INTO topics VALUES (null,?,?,?)", [$name, $parent, $time]);
                    adminAlert('success', 'Topic added successfully!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <?php adminInput('name', 'Topic Name'); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Parent Topic</label>
                <select name="parent_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">No Parent (Root Topic)</option>
                    <?php echo list_topics(); ?>
                </select>
            </div>
            <?php
            adminInput('time', 'Time Limit (seconds)', '60', 'number');
            adminFormButtons($page, 'Add Topic');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Topic', 'edit', $page);
        if (isset($_POST["publish"])) {
            $name = cleanString($_POST["name"]);
            $parent = $_POST["parent_id"];
            $time = $_POST["time"];
            if (empty($name)) {
                adminAlert('error', 'Topic name is required!');
            } else {
                try {
                    $db->runQuery("UPDATE topics SET topic_name=?, parent_id=?, time=? WHERE topic_id=?", [$name, $parent, $time, $id]);
                    adminAlert('success', 'Topic updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM topics WHERE topic_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <?php adminInput('name', 'Topic Name', $r->topic_name); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Parent Topic</label>
                <select name="parent_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">No Parent (Root Topic)</option>
                    <?php echo list_topics($r->parent_id); ?>
                </select>
            </div>
            <?php
            adminInput('time', 'Time Limit (seconds)', $r->time, 'number');
            adminFormButtons($page, 'Update Topic');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM topics WHERE topic_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Topic deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM topics WHERE topic_id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->topic_name), 'folder', $page);
        ?>
        <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-slate-800"><?php echo decode($r->topic_name); ?></h3>
                    <p class="text-slate-500">Time: <?php echo $r->time; ?> seconds</p>
                </div>
            </div>
            <?php if ($r->parent_id): ?>
            <div class="p-4 bg-blue-50 rounded-xl">
                <span class="text-sm text-blue-600">Parent Topic:</span>
                <span class="font-medium text-blue-800"><?php echo topic_name($r->parent_id); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Topics', 'folder', "$page?action=add", 'Add Topic');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Topic Name'],
        ['label' => 'Time', 'align' => 'center', 'width' => '24'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM topics ORDER BY topic_id DESC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode($r->topic_name) . '</td>
            <td class="px-4 py-3 text-center">' . adminBadge($r->time . 's', 'blue') . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->topic_id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
