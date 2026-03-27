<?php
require 'header.php';
require_once 'inc/csrf.php';
$db = new database();
$user = $_SERVER['REMOTE_ADDR'];

if (isset($_GET['result']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($user)) {
        $right_answer = 0;
        $wrong_answer = 0;
        $unanswered = 0;
        $question = array();
        $answers = array();

        // Get POST keys and exclude CSRF token
        $allKeys = array_keys($_POST);
        $keys = array_filter($allKeys, function($key) {
            return $key !== 'csrf_token';
        });
        $keys = array_values($keys); // Re-index array

        // Check if there's any quiz data
        if (count($keys) === 0) {
            msgBox("error", "No quiz answers submitted. Please complete the quiz.");
            require 'footer.php';
            exit();
        }

        // Validate that all question keys are integers to prevent SQL injection
        $validKeys = array_filter($keys, function($k) {
            return ctype_digit(strval($k));
        });
        $validKeys = array_values($validKeys);

        if (count($validKeys) !== count($keys)) {
            msgBox("error", "Invalid quiz data submitted");
            require 'footer.php';
            exit();
        }

        $order = join(",", $validKeys);
        $placeholders = implode(',', array_fill(0, count($validKeys), '?'));
        $response = $db->query("SELECT * FROM quiz WHERE id IN($placeholders) ORDER BY FIELD(id,$placeholders)", array_merge($validKeys, $validKeys));

        $ans = "";
        while ($result = $db->fetchObject($response)) {
            if ($_POST[$result->id] == 1) {
                $ans = $result->answer1;
            } else if ($_POST[$result->id] == 2) {
                $ans = $result->answer2;
            } else if ($_POST[$result->id] == 3) {
                $ans = $result->answer3;
            } else if ($_POST[$result->id] == 4) {
                $ans = $result->answer4;
            }

            if ($result->answer == $_POST[$result->id]) {
                $right_answer++;
                $question[] = $result->question_name;
                $answers[] = $ans . " <svg class='inline w-5 h-5 text-green-500' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'/></svg>";
            } else if ($_POST[$result->id] == 5) {
                $unanswered++;
            } else {
                $wrong_answer++;
                $question[] = $result->question_name;
                $answers[] = $ans . " <svg class='inline w-5 h-5 text-red-500' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z' clip-rule='evenodd'/></svg>";
            }
        }
        $id = $user;
        $topic = topic_name($_GET['result']);

        $db->query("insert into marks Values(null,?,?,?)", array($right_answer * 10, $id, $_GET['result']));

        $total_questions = $right_answer + $wrong_answer + $unanswered;
        $percentage = $total_questions > 0 ? round(($right_answer / $total_questions) * 100) : 0;
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Quiz Result</h1>
                <p class="text-white/80 text-lg"><?php echo htmlspecialchars($topic); ?></p>
            </div>
            <a href="quiz.php" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>
        </div>
    </div>
</section>

<!-- Result Section -->
<section class="py-16 bg-slate-50 dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Success Message -->
        <div id="successMessage" class="mb-8 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-700 dark:text-green-300 font-medium">Well done! Quiz completed successfully.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Score Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 text-center sticky top-24">
                    <!-- Circular Progress -->
                    <div class="relative w-40 h-40 mx-auto mb-6">
                        <svg class="w-40 h-40 transform -rotate-90">
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="none" class="text-slate-200 dark:text-slate-700"/>
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="none"
                                class="<?php echo $percentage >= 50 ? 'text-green-500' : 'text-primary-500'; ?>"
                                stroke-dasharray="<?php echo 2 * 3.14159 * 70; ?>"
                                stroke-dashoffset="<?php echo 2 * 3.14159 * 70 * (1 - $percentage / 100); ?>"
                                stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl font-bold text-slate-800 dark:text-white"><?php echo $percentage; ?>%</span>
                            <span class="text-sm text-slate-500 dark:text-slate-400">Score</span>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">
                        <?php echo $right_answer * 10; ?> Points
                    </h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Total Marks Earned</p>

                    <!-- Stats -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">Correct</span>
                            </div>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo $right_answer; ?></span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">Wrong</span>
                            </div>
                            <span class="text-2xl font-bold text-red-600 dark:text-red-400"><?php echo $wrong_answer; ?></span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-slate-100 dark:bg-slate-700/50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-400 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">Skipped</span>
                            </div>
                            <span class="text-2xl font-bold text-slate-600 dark:text-slate-400"><?php echo $unanswered; ?></span>
                        </div>
                    </div>

                    <!-- Retry Button -->
                    <a href="quiz.php" class="mt-8 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Try Another Quiz
                    </a>
                </div>
            </div>

            <!-- Answers Review -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 lg:p-8">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Answer Review
                    </h3>

                    <div class="space-y-4">
                        <?php
                        $i = 1;
                        $j = 0;
                        foreach ($question as $q) {
                        ?>
                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-600">
                            <p class="font-semibold text-slate-800 dark:text-white mb-2">
                                <span class="inline-flex items-center justify-center w-7 h-7 bg-primary-500 text-white text-sm rounded-full mr-2"><?php echo $i; ?></span>
                                <?php echo htmlspecialchars($q); ?>
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 pl-9">
                                <span class="font-medium">Your Answer:</span> <?php echo $answers[$j]; ?>
                            </p>
                        </div>
                        <?php
                            $i++;
                            $j++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    }
} elseif (isset($_GET['result']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Direct navigation to result URL without submitting quiz - redirect to quiz
    $topicid = intval($_GET['result']);
?>
<!-- Page Title Section - Invalid Access -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Invalid Access</h1>
        </div>
    </div>
</section>

<section class="py-16 bg-slate-50 dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-md mx-auto text-center">
            <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Quiz Not Submitted</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8">Please complete the quiz before viewing results.</p>
            <a href="quiz_online.php?id=<?php echo $topicid; ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                Start Quiz
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php
} elseif (isset($_GET["id"])) {
    $topicid = $_GET["id"];
    $topicid = intval($topicid);
    $db->query("SELECT * FROM quiz WHERE topic = ?", array($topicid));

    if ($db->rowCount() == 0) {
?>
<!-- Page Title Section - No Questions -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Quiz</h1>
                <p class="text-white/80 text-lg"><?php echo htmlspecialchars(topic_name($topicid)); ?></p>
            </div>
            <a href="quiz.php" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>
        </div>
    </div>
</section>

<section class="py-16 bg-slate-50 dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-md mx-auto text-center">
            <div class="w-20 h-20 bg-slate-200 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">No Questions Available</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8">There are no questions in this topic yet. Please check back later or try another quiz.</p>
            <a href="quiz.php" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                Browse Other Quizzes
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php
        require_once 'footer.php';
        exit();
    }

    $quizTime = $db->queryValue("SELECT time FROM topics WHERE topic_id = ?", "time", array($topicid))->time;
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Quiz</h1>
                <p class="text-white/80 text-lg"><?php echo htmlspecialchars(topic_name($topicid)); ?></p>
            </div>
            <a href="quiz.php" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>
        </div>
    </div>
</section>

<!-- Quiz Section -->
<section class="py-16 bg-slate-50 dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Timer Sidebar -->
            <div class="lg:col-span-1 order-first lg:order-last">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Time Remaining
                    </h3>
                    <div id="timer" class="text-center">
                        <script type="text/javascript">
                            var myCountdownTest = new Countdown({
                                time: <?php echo $quizTime; ?>,
                                width: 200,
                                height: 80,
                                rangeHi: "minute"
                            });
                        </script>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-slate-600 dark:text-slate-400">Progress</span>
                            <span id="progressText" class="font-medium text-slate-800 dark:text-white">1 / <?php echo $db->rowCount(); ?></span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                            <div id="progressBar" class="bg-gradient-to-r from-primary-500 to-secondary-500 h-2 rounded-full transition-all duration-300" style="width: <?php echo (1 / $db->rowCount()) * 100; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions -->
            <div class="lg:col-span-3">
                <form method="POST" id="quizForm" action="quiz_online.php?result=<?php echo $topicid ?>">
                    <?php echo csrfField(); ?>
                    <?php
                    $db->query("SELECT * FROM quiz WHERE topic = ? ORDER BY RAND()", array($topicid));
                    $rows = $db->rowCount();
                    $i = 1;
                    while ($result = $db->fetchObject()) {
                    ?>
                    <div id="question<?php echo $i; ?>" class="quiz-question bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 lg:p-8 <?php echo $i == 1 ? '' : 'hidden'; ?>">
                        <!-- Question Header -->
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-secondary-500 text-white text-lg font-bold rounded-full flex items-center justify-center">
                                <?php echo $i; ?>
                            </span>
                            <div>
                                <span class="text-sm text-slate-500 dark:text-slate-400">Question <?php echo $i; ?> of <?php echo $rows; ?></span>
                            </div>
                        </div>

                        <!-- Question Text -->
                        <h3 class="text-xl lg:text-2xl font-bold text-slate-800 dark:text-white mb-8">
                            <?php echo htmlspecialchars($result->question_name); ?>
                        </h3>

                        <!-- Answer Options -->
                        <div class="space-y-4 mb-8">
                            <label class="quiz-option flex items-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-transparent hover:border-primary-300 dark:hover:border-primary-500/50 cursor-pointer transition-all duration-200">
                                <input type="radio" value="1" name="<?php echo $result->id; ?>" class="w-5 h-5 text-primary-500 border-slate-300 focus:ring-primary-500"/>
                                <span class="ml-4 text-slate-700 dark:text-slate-200"><?php echo htmlspecialchars($result->answer1); ?></span>
                            </label>

                            <label class="quiz-option flex items-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-transparent hover:border-primary-300 dark:hover:border-primary-500/50 cursor-pointer transition-all duration-200">
                                <input type="radio" value="2" name="<?php echo $result->id; ?>" class="w-5 h-5 text-primary-500 border-slate-300 focus:ring-primary-500"/>
                                <span class="ml-4 text-slate-700 dark:text-slate-200"><?php echo htmlspecialchars($result->answer2); ?></span>
                            </label>

                            <label class="quiz-option flex items-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-transparent hover:border-primary-300 dark:hover:border-primary-500/50 cursor-pointer transition-all duration-200">
                                <input type="radio" value="3" name="<?php echo $result->id; ?>" class="w-5 h-5 text-primary-500 border-slate-300 focus:ring-primary-500"/>
                                <span class="ml-4 text-slate-700 dark:text-slate-200"><?php echo htmlspecialchars($result->answer3); ?></span>
                            </label>

                            <label class="quiz-option flex items-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-transparent hover:border-primary-300 dark:hover:border-primary-500/50 cursor-pointer transition-all duration-200">
                                <input type="radio" value="4" name="<?php echo $result->id; ?>" class="w-5 h-5 text-primary-500 border-slate-300 focus:ring-primary-500"/>
                                <span class="ml-4 text-slate-700 dark:text-slate-200"><?php echo htmlspecialchars($result->answer4); ?></span>
                            </label>

                            <!-- Hidden default for unanswered -->
                            <input type="radio" checked="checked" style="display:none" value="5" name="<?php echo $result->id; ?>"/>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                            <?php if ($i > 1) { ?>
                            <button type="button" data-question="<?php echo $i; ?>" class="previous inline-flex items-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Previous
                            </button>
                            <?php } else { ?>
                            <div></div>
                            <?php } ?>

                            <?php if ($i < $rows) { ?>
                            <button type="button" data-question="<?php echo $i; ?>" class="next inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                Next
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <?php } else { ?>
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Finish Quiz
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $i++;
                    } ?>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
}
require 'footer.php';
?>

<script>
    const totalQuestions = <?php echo isset($rows) ? $rows : 1; ?>;

    // Navigation functions
    function showQuestion(num) {
        document.querySelectorAll('.quiz-question').forEach(q => q.classList.add('hidden'));
        const target = document.getElementById('question' + num);
        if (target) {
            target.classList.remove('hidden');
            updateProgress(num);
        }
    }

    function updateProgress(current) {
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        if (progressBar && progressText) {
            const percentage = (current / totalQuestions) * 100;
            progressBar.style.width = percentage + '%';
            progressText.textContent = current + ' / ' + totalQuestions;
        }
    }

    // Next button handlers
    document.querySelectorAll('.next').forEach(btn => {
        btn.addEventListener('click', function() {
            const current = parseInt(this.getAttribute('data-question'));
            showQuestion(current + 1);
        });
    });

    // Previous button handlers
    document.querySelectorAll('.previous').forEach(btn => {
        btn.addEventListener('click', function() {
            const current = parseInt(this.getAttribute('data-question'));
            showQuestion(current - 1);
        });
    });

    // Highlight selected options
    document.querySelectorAll('.quiz-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove highlight from siblings
            this.closest('.space-y-4').querySelectorAll('.quiz-option').forEach(opt => {
                opt.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
                opt.classList.add('border-transparent');
            });
            // Add highlight to selected
            this.closest('.quiz-option').classList.remove('border-transparent');
            this.closest('.quiz-option').classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
        });
    });

    // Success message auto-hide
    $(document).ready(function() {
        $("#successMessage").delay(5000).slideUp(300);
    });
</script>
</body>
</html>
