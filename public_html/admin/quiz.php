<?php require 'header.php';
$db = new database();
$page = 'quiz.php';

if (isset($_GET["action"])) {
    $a = cleanString($_GET["action"]);

    // ADD
    if ($a === "add") {
        adminFormHeader('Add Quiz Question', 'question', $page);
        if (isset($_POST["publish"])) {
            $question = cleanString($_POST["question"]);
            $ansa = cleanString($_POST["ansa"]);
            $ansb = cleanString($_POST["ansb"]);
            $ansc = cleanString($_POST["ansc"]);
            $ansd = cleanString($_POST["ansd"]);
            $rightans = cleanString($_POST["rightans"]);
            $topicid = cleanString($_POST["topic"]);

            if (empty($question) || empty($ansa) || empty($ansb) || empty($ansc) || empty($ansd) || empty($topicid)) {
                adminAlert('error', 'All fields are required!');
            } else {
                try {
                    $db->runQuery("INSERT INTO quiz VALUES (null,?,?,?,?,?,?,?)",
                        [$question, $ansa, $ansb, $ansc, $ansd, $rightans, $topicid]);
                    adminAlert('success', 'Quiz question added!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        ?>
        <form method="POST" action="<?php echo $page; ?>?action=add" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Topic</label>
                    <select name="topic" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo topics(); ?>
                    </select>
                </div>
                <?php adminInput('question', 'Question'); ?>
                <?php adminInput('ansa', 'Answer 1'); ?>
                <?php adminInput('ansb', 'Answer 2'); ?>
                <?php adminInput('ansc', 'Answer 3'); ?>
                <?php adminInput('ansd', 'Answer 4'); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Correct Answer</label>
                    <select name="rightans" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo list_answer(); ?>
                    </select>
                </div>
            </div>
            <?php adminFormButtons($page, 'Add Question'); ?>
        </form>
        <?php
        adminFooter();
    }

    // EDIT
    else if ($a === "edit" && isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        adminFormHeader('Edit Quiz Question', 'edit', $page);
        if (isset($_POST["publish"])) {
            $question = cleanString($_POST["question"]);
            $ansa = cleanString($_POST["ansa"]);
            $ansb = cleanString($_POST["ansb"]);
            $ansc = cleanString($_POST["ansc"]);
            $ansd = cleanString($_POST["ansd"]);
            $rightans = cleanString($_POST["rightans"]);
            $topicid = cleanString($_POST["topic"]);

            if (empty($question) || empty($ansa) || empty($ansb) || empty($ansc) || empty($ansd) || empty($topicid)) {
                adminAlert('error', 'All fields are required!');
            } else {
                try {
                    $db->runQuery("UPDATE quiz SET question_name=?, answer1=?, answer2=?, answer3=?, answer4=?, answer=?, topic=? WHERE id=?",
                        [$question, $ansa, $ansb, $ansc, $ansd, $rightans, $topicid, $id]);
                    adminAlert('success', 'Quiz question updated!');
                } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
            }
        }
        $db->query("SELECT * FROM quiz WHERE id = ?", [$id]);
        $r = $db->fetchObject();
        ?>
        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Topic</label>
                    <select name="topic" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo list_topics($r->topic); ?>
                    </select>
                </div>
                <?php adminInput('question', 'Question', $r->question_name); ?>
                <?php adminInput('ansa', 'Answer 1', $r->answer1); ?>
                <?php adminInput('ansb', 'Answer 2', $r->answer2); ?>
                <?php adminInput('ansc', 'Answer 3', $r->answer3); ?>
                <?php adminInput('ansd', 'Answer 4', $r->answer4); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Correct Answer</label>
                    <select name="rightans" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none">
                        <?php echo list_answer($r->answer); ?>
                    </select>
                </div>
            </div>
            <?php adminFormButtons($page, 'Update Question'); ?>
        </form>
        <?php
        adminFooter();
    }

    // DELETE
    else if ($a === "delete" && isset($_GET["id"])) {
        try {
            $db->runQuery("DELETE FROM quiz WHERE id = ?", [intval($_GET["id"])]);
            adminDeleteSuccess('Quiz question deleted!', $page);
        } catch (PDOException $e) { adminAlert('error', $e->getMessage()); }
    }

    // VIEW
    else if ($a === "view" && isset($_GET["id"])) {
        $db->query("SELECT * FROM quiz WHERE id = ?", [intval($_GET["id"])]);
        $r = $db->fetchObject();
        adminFormHeader('View Question', 'question', $page);
        ?>
        <div class="space-y-4">
            <div class="p-4 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl border border-primary-100">
                <span class="text-sm text-primary-600">Topic:</span>
                <span class="font-semibold text-primary-800"><?php echo topic_name($r->topic); ?></span>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl">
                <h3 class="text-lg font-semibold text-slate-800 mb-4"><?php echo decode($r->question_name); ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <?php
                    $answers = [1 => $r->answer1, 2 => $r->answer2, 3 => $r->answer3, 4 => $r->answer4];
                    foreach ($answers as $num => $ans):
                        $isCorrect = ($r->answer == $num);
                    ?>
                    <div class="p-3 rounded-lg <?php echo $isCorrect ? 'bg-emerald-100 border-2 border-emerald-500' : 'bg-white border border-slate-200'; ?>">
                        <span class="font-medium <?php echo $isCorrect ? 'text-emerald-700' : 'text-slate-600'; ?>">
                            <?php echo $num; ?>. <?php echo decode($ans); ?>
                            <?php if ($isCorrect): ?>
                            <svg class="w-5 h-5 inline ml-2 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        adminFooter();
    }
}

// LIST
else {
    adminHeader('Manage Quiz Questions', 'question', "$page?action=add", 'Add Question');
    adminTableStart([
        ['label' => '#', 'width' => '12'],
        ['label' => 'Topic', 'width' => '20'],
        ['label' => 'Question'],
        ['label' => 'Correct', 'align' => 'center', 'width' => '16'],
        ['label' => 'Actions', 'align' => 'center', 'width' => '28']
    ]);

    $db->query("SELECT * FROM quiz ORDER BY id DESC");
    $i = 1;
    while ($r = $db->fetchObject()) {
        echo '<tr class="hover:bg-slate-50">
            <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
            <td class="px-4 py-3">' . adminBadge(topic_name($r->topic), 'blue') . '</td>
            <td class="px-4 py-3 font-medium text-slate-800">' . decode(substr($r->question_name, 0, 50)) . (strlen($r->question_name) > 50 ? '...' : '') . '</td>
            <td class="px-4 py-3 text-center">' . adminBadge('Ans ' . $r->answer, 'green') . '</td>
            <td class="px-4 py-3">' . adminTableActions($page, $r->id) . '</td>
        </tr>';
    }

    adminTableEnd();
    adminFooter();
}

require 'footer.php';
