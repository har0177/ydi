<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="YDI Student Portal — sign in to access your trainings, schedule, and progress." />
    <title>Sign in &middot; YDI Student Portal</title>

    <link rel="icon" type="image/jpg" href="<?php echo site_url('images/logo.jpg'); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/portal-login.css" />
</head>
<body>

<main class="login-v2">
    <div class="frame">

        <!-- LEFT: brand hero -->
        <aside class="hero">
            <div class="hero-top">
                <div class="brand">
                    <span class="brand-mark">Y</span>
                    <span class="brand-text">YDI Student Portal</span>
                </div>
            </div>
            <div class="hero-mid">
                <h1 class="hero-title">Welcome back.<br>Pick up where you left off.</h1>
                <p class="hero-lede">Your trainings, schedule, and progress &mdash; all in one place. Sign in to continue your learning journey.</p>
            </div>
            <div class="hero-foot">YDI Training &amp; Consultancy &middot; Xpertz Dev &copy; <?php echo date('Y'); ?></div>
        </aside>

        <!-- RIGHT: sign-in form -->
        <section class="panel">
            <span class="eyebrow">Student Login</span>
            <h2 class="panel-title">Sign in to your portal</h2>
            <p class="panel-sub">Use the username and password issued by your trainer.</p>

            <?php flash_alert(); echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <?php echo form_open('user/login', ['class' => 'login-form', 'novalidate' => '']); ?>
                <div class="field">
                    <label for="username">Username</label>
                    <div class="input">
                        <input id="username" name="username" type="text" required placeholder="e.g. ahmed.k" autocomplete="username" />
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 14a4 4 0 10-8 0M12 11a3 3 0 100-6 3 3 0 000 6zM4 20c0-3.314 3.582-6 8-6s8 2.686 8 6"/>
                        </svg>
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input">
                        <input id="password" name="password" type="password" required placeholder="Enter your password" autocomplete="current-password" />
                        <button type="button" class="toggle" data-pw-toggle="password" aria-label="Show password">SHOW</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" data-disable-on-submit>
                    <span class="btn-label">Sign in</span>
                    <svg class="btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0l-6-6m6 6l-6 6"/>
                    </svg>
                </button>
            <?php echo form_close(); ?>

            <p class="help-line">Trouble signing in? <a href="mailto:info@ydi.edu.pk">Contact support</a></p>
        </section>

    </div>
</main>

<script src="<?php echo base_url() ?>dist/jquery.min.js"></script>
<script>
jQuery(function ($) {
    // Password show/hide toggle.
    $(document).on('click', '.login-v2 [data-pw-toggle]', function () {
        var id = $(this).data('pw-toggle');
        var $input = $('#' + id);
        var showing = $input.attr('type') === 'text';
        $input.attr('type', showing ? 'password' : 'text');
        $(this).text(showing ? 'SHOW' : 'HIDE')
               .attr('aria-label', showing ? 'Show password' : 'Hide password');
    });

    // Disable submit button on form submit (prevents double-post).
    $(document).on('submit', '.login-v2 form', function () {
        $(this).find('[data-disable-on-submit]')
               .prop('disabled', true)
               .addClass('is-loading');
    });
});
</script>

</body>
</html>
