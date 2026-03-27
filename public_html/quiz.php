<?php require 'header.php'; ?>

<?php
$db = new database();
$db->query("SELECT * FROM topics WHERE parent_id = 0 ORDER BY topic_id ASC");

if ($db->rowCount() > 0) {
    $topics = [];
    while ($topic = $db->fetchObject()) {
        $topics[] = $topic;
    }

    // Pre-fetch all subtopics in one query
    $subDb = new database();
    $subDb->query("SELECT * FROM topics WHERE parent_id != 0 ORDER BY topic_id ASC");
    $subtopicsByParent = [];
    while ($st = $subDb->fetchObject()) {
        $subtopicsByParent[$st->parent_id][] = $st;
    }
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Online Quiz System</h1>
            <nav class="flex justify-center">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white">Quiz</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Quiz Topics -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block px-4 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4">Test Your Knowledge</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-4">
                Choose a <span class="gradient-text">Topic</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400">Select a quiz topic to test your knowledge and improve your skills.</p>
        </div>

        <!-- Topics Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php
            $colors = ['primary', 'green', 'blue', 'purple', 'pink', 'amber'];
            foreach ($topics as $index => $topic) {
                $color = $colors[$index % count($colors)];

                // Check for subtopics
                $topicChildren = $subtopicsByParent[$topic->topic_id] ?? [];
                $hasSubtopics = !empty($topicChildren);
            ?>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 card-hover">
                <!-- Topic Header -->
                <div class="bg-gradient-to-r from-<?php echo $color; ?>-500 to-<?php echo $color; ?>-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white uppercase"><?php echo htmlspecialchars(html_entity_decode($topic->topic_name, ENT_QUOTES, 'UTF-8')); ?></h3>
                    </div>
                </div>

                <!-- Subtopics or Direct Link -->
                <div class="p-4">
                    <?php if ($hasSubtopics) { ?>
                    <ul class="space-y-2">
                        <?php foreach ($topicChildren as $sub_topic) { ?>
                        <li>
                            <a href="quiz_online.php?id=<?php echo (int)$sub_topic->topic_id; ?>"
                               class="flex items-center gap-2 px-4 py-3 bg-white dark:bg-slate-700 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-<?php echo $color; ?>-50 dark:hover:bg-<?php echo $color; ?>-900/20 hover:text-<?php echo $color; ?>-600 transition-all group">
                                <svg class="w-4 h-4 text-<?php echo $color; ?>-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span class="text-sm font-medium"><?php echo htmlspecialchars(html_entity_decode($sub_topic->topic_name, ENT_QUOTES, 'UTF-8')); ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } else { ?>
                    <a href="quiz_online.php?id=<?php echo (int)$topic->topic_id; ?>"
                       class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-<?php echo $color; ?>-500 to-<?php echo $color; ?>-600 text-white font-semibold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Start Quiz
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php } else { ?>

<!-- No Topics Found -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Online Quiz</h1>
    </div>
</section>

<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">No Quizzes Available</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-8">There are no quizzes available at the moment. Please check back later.</p>
            <a href="index.php" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</section>

<?php } ?>

<?php require 'footer.php'; ?>
