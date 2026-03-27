<?php require 'header.php';
$db = new database();
$page = 'features.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Feature', 'star', $page);
        if (isset($_POST["publish"])) {
            $title = cleanString($_POST["title"]);
            $body = $_POST["body"];
            if (empty($title)) {
                adminAlert('error', 'Feature title is required!');
            } else {
                try {
                    $db->runQuery("INSERT INTO features (feature_title, feature_body) VALUES (?,?)", [$title, $body]);
                    adminAlert('success', 'Feature added successfully!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <?php
            adminInput('title', 'Feature Title');
            adminTextarea('body', 'Feature Description', '', 6, true);
            adminFormButtons($page, 'Add Feature');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Feature', 'edit', $page);
        if (isset($_POST["publish"])) {
            $title = cleanString($_POST["title"]);
            $body = $_POST["body"];
            if (empty($title)) {
                adminAlert('error', 'Feature title is required!');
            } else {
                try {
                    $db->runQuery("UPDATE features SET feature_title=?, feature_body=? WHERE feature_id=?", [$title, $body, $id]);
                    adminAlert('success', 'Feature updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM features WHERE feature_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <?php
            adminInput('title', 'Feature Title', $r->feature_title);
            adminTextarea('body', 'Feature Description', $r->feature_body, 6, true);
            adminFormButtons($page, 'Update Feature');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM features WHERE feature_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Feature deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM features WHERE feature_id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader(decode($r->feature_title), 'star', $page);
        ?>
        <div class="prose max-w-none">
            <?php echo $r->feature_body; ?>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Features', 'star', "$page?action=add", 'Add Feature');
    adminTableStart([
        ['label' => '#', 'width' => '16'],
        ['label' => 'Title'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM features ORDER BY feature_id");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode($r->feature_title) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->feature_id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
