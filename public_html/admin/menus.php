<?php require 'header.php';
$db = new database();
$page = 'menus.php';

if (isset($_GET["do"])) {
    $do = cleanString($_GET["do"]);

    // ADD
    if ($do === "add") {
        adminFormHeader('Add Menu Item', 'menu', $page);
        if (isset($_POST["add"])) {
            $label = cleanString($_POST["label"]);
            $link = "page.php?id=" . cleanString($_POST["link"]);
            $elink = $_POST['elink'];
            $parent_id = cleanString($_POST["parent_id"]);
            $order = cleanString($_POST["order"]);

            if (empty($label) || empty($order)) {
                adminAlert('error', 'Label and order are required!');
            } else {
                if (empty($parent_id)) $parent_id = NULL;
                if (!empty($elink)) $link = $elink;
                try {
                    $db->query("INSERT INTO menus VALUES (null, ?,?,?,?)", [$label, $link, $parent_id, $order]);
                    adminAlert('success', 'Menu item added!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" class="space-y-4">
            <?php adminInput('label', 'Menu Label'); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Link to Page</label>
                <select name="link" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <?php echo list_menu(); ?>
                </select>
                <p class="text-sm text-slate-500 mt-1">Select a page from your website</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center"><span class="px-4 bg-white text-sm text-slate-500">OR</span></div>
            </div>
            <?php adminInput('elink', 'External Link', '', 'url', false, 'https://example.com'); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Parent Menu</label>
                <select name="parent_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">No Parent (Top Level)</option>
                    <?php echo list_submenu(); ?>
                </select>
            </div>
            <?php
            adminInput('order', 'Display Order', '1', 'number');
            adminFormButtons($page, 'Add Menu', 'add');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($do === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Menu Item', 'edit', $page);
        if (isset($_POST["update"])) {
            $label = cleanString($_POST["label"]);
            $link = "page.php?id=" . cleanString($_POST["link"]);
            $elink = $_POST["elink"];
            $parent_id = cleanString($_POST["parent_id"]);
            $order = cleanString($_POST["order"]);

            if (empty($label) || empty($order)) {
                adminAlert('error', 'Label and order are required!');
            } else {
                if (empty($parent_id)) $parent_id = NULL;
                if (!empty($elink)) $link = $elink;
                try {
                    $db->query("UPDATE menus SET menu_label=?, menu_link=?, parent_id=?, menu_order=? WHERE menu_id=?",
                        [$label, $link, $parent_id, $order, $id]);
                    adminAlert('success', 'Menu item updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM menus WHERE menu_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <?php adminInput('label', 'Menu Label', $r->menu_label); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Link to Page</label>
                <select name="link" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <?php echo list_menu($r->menu_link); ?>
                </select>
            </div>
            <div class="relative">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center"><span class="px-4 bg-white text-sm text-slate-500">OR</span></div>
            </div>
            <?php
            $externalLink = (strpos($r->menu_link, "page.php?id") !== false) ? '' : $r->menu_link;
            adminInput('elink', 'External Link', $externalLink, 'url', false, 'https://example.com');
            ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Parent Menu</label>
                <select name="parent_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                    <option value="">No Parent (Top Level)</option>
                    <?php echo list_submenu($r->parent_id); ?>
                </select>
            </div>
            <?php
            adminInput('order', 'Display Order', $r->menu_order, 'number');
            adminFormButtons($page, 'Update Menu', 'update');
            ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($do === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM menus WHERE menu_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Menu item deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }
}

// LIST
else {
    adminHeader('Manage Menus', 'menu', "$page?do=add", 'Add Menu');
    adminTableStart([
        ['label' => '#', 'width' => '12'],
        ['label' => 'Label'],
        ['label' => 'Link'],
        ['label' => 'Parent', 'width' => '24'],
        ['label' => 'Order', 'align' => 'center', 'width' => '16'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '24']
    ]);

    $db->query("SELECT * FROM menus ORDER BY menu_order ASC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        $parent = ($r->parent_id == NULL) ? '<span class="text-slate-400">-</span>' : menu_name($r->parent_id);
        $linkDisplay = (strlen($r->menu_link) > 30) ? substr($r->menu_link, 0, 30) . '...' : $r->menu_link;
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode($r->menu_label) . '</td>
            <td class="px-4 py-3 text-sm text-slate-500">' . htmlspecialchars($linkDisplay) . '</td>
            <td class="px-4 py-3">' . $parent . '</td>
            <td class="px-4 py-3 text-center">' . adminOrderBadge($r->menu_order) . '</td>
            <td class="px-4 py-3">
                <div class="flex items-center justify-center gap-1">
                    <a href="' . $page . '?do=edit&id=' . $r->menu_id . '" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <a href="' . $page . '?do=delete&id=' . $r->menu_id . '" onclick="return confirm(\'Delete this menu item?\')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
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
