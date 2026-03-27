<?php require 'header.php';
if ($_SESSION["user_level"] !== "Admin") {
    die(adminAlert('error', 'What Are You Looking For?'));
}
$db = new database();
$page = 'users.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add User', 'user-plus', $page);
        if (isset($_POST["publish"])) {
            $login = cleanString($_POST["login"]);
            $password = cleanString($_POST["password"]);
            $email = cleanString($_POST["email"]);
            $name = cleanString($_POST["name"]);
            $address = cleanString($_POST["address"]);
            $contact = cleanString($_POST["contact"]);
            $qualification = cleanString($_POST["qualification"]);
            $gender = cleanString($_POST["gender"]);
            $level = "Admin";

            if (empty($login) || empty($email) || empty($password) || empty($name) || empty($address) || empty($contact) || empty($qualification) || empty($gender)) {
                adminAlert('error', 'All fields are required!');
            } else {
                try {
                    $password = securePasswordHash($password);
                    $db->runQuery("INSERT INTO users VALUES (null,?,?,?,?,?,?,?,?,?)",
                        [$login, $password, $email, $name, $level, $qualification, $address, $contact, $gender]);
                    adminAlert('success', 'User added successfully!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php
                adminInput('login', 'Username');
                adminInput('password', 'Password', '', 'password');
                adminInput('email', 'Email Address', '', 'email');
                adminInput('name', 'Full Name');
                adminInput('contact', 'Contact Number');
                adminInput('qualification', 'Qualification');
                adminInput('address', 'Address');
                ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Gender</label>
                    <select name="gender" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo list_gender(); ?>
                    </select>
                </div>
            </div>
            <?php adminFormButtons($page, 'Add User'); ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit User', 'edit', $page);
        if (isset($_POST["publish"])) {
            $login = cleanString($_POST["login"]);
            $password = cleanString($_POST["password"]);
            $email = cleanString($_POST["email"]);
            $name = cleanString($_POST["name"]);
            $address = cleanString($_POST["address"]);
            $contact = cleanString($_POST["contact"]);
            $qualification = cleanString($_POST["qualification"]);
            $gender = cleanString($_POST["gender"]);

            if (empty($login) || empty($email) || empty($password) || empty($name) || empty($address) || empty($contact) || empty($qualification) || empty($gender)) {
                adminAlert('error', 'All fields are required!');
            } else {
                try {
                    $password = securePasswordHash($password);
                    $db->runQuery("UPDATE users SET user_login=?, user_password=?, user_email=?, user_name=?, user_qualification=?, user_address=?, user_contact=?, user_gender=? WHERE user_id=?",
                        [$login, $password, $email, $name, $qualification, $address, $contact, $gender, $id]);
                    adminAlert('success', 'User updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM users WHERE user_id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php
                adminInput('login', 'Username', $r->user_login);
                adminInput('password', 'Password', '', 'password');
                adminInput('email', 'Email Address', $r->user_email, 'email');
                adminInput('name', 'Full Name', $r->user_name);
                adminInput('contact', 'Contact Number', $r->user_contact);
                adminInput('qualification', 'Qualification', $r->user_qualification);
                adminInput('address', 'Address', $r->user_address);
                ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Gender</label>
                    <select name="gender" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo list_gender($r->user_gender); ?>
                    </select>
                </div>
            </div>
            <?php adminFormButtons($page, 'Update User'); ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM users WHERE user_id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('User deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM users WHERE user_id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader('User Profile', 'user', $page);
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        <?php echo strtoupper(substr($r->user_name, 0, 1)); ?>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800"><?php echo htmlspecialchars($r->user_name); ?></h3>
                        <p class="text-slate-500"><?php echo htmlspecialchars($r->user_login); ?></p>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-slate-500">Email</span>
                    <span class="text-slate-800"><?php echo htmlspecialchars($r->user_email); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-slate-500">Contact</span>
                    <span class="text-slate-800"><?php echo htmlspecialchars($r->user_contact); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-slate-500">Qualification</span>
                    <span class="text-slate-800"><?php echo htmlspecialchars($r->user_qualification); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-slate-500">Gender</span>
                    <span class="text-slate-800"><?php echo htmlspecialchars($r->user_gender); ?></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Address</span>
                    <span class="text-slate-800"><?php echo htmlspecialchars($r->user_address); ?></span>
                </div>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Users', 'users', "$page?action=add", 'Add User');
    adminTableStart([
        ['label' => 'Name'],
        ['label' => 'Email'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM users WHERE user_level = 'Admin' ORDER BY user_id ASC");
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-full flex items-center justify-center text-white font-bold">
                        ' . strtoupper(substr($r->user_name, 0, 1)) . '
                    </div>
                    <span class="font-medium text-slate-800">' . htmlspecialchars($r->user_name) . '</span>
                </div>
            </td>
            <td class="px-4 py-3 text-slate-600">' . htmlspecialchars($r->user_email) . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->user_id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
