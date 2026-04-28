# Portal Login Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the legacy ACE/Bootstrap login at `portal.ydi.edu.pk/user/login` with a split-screen layout (purple→blue gradient hero on the left, polished form on the right; stacked on mobile) that matches the rest of the polished portal.

**Architecture:** Pure view rewrite + new scoped CSS file. The CodeIgniter `User::login()` controller, the `User_model::login()` validator, the form action (`user/login`), and field names (`username`, `password`, `email`) are unchanged. New CSS lives in a dedicated file (`portal-login.css`) loaded only by this view, scoped under a `.login-v2` root class so it cannot leak. Legacy ACE/Bootstrap stylesheets are dropped from the login view's `<head>` (still used by the rest of the portal). The existing `flash_alert()` and `validation_errors()` helpers are kept; their output is restyled via `.login-v2 .alert-danger` rules.

**Tech Stack:** PHP 7+ / CodeIgniter 3 (template helper), HTML5, vanilla CSS (no Tailwind compile), inline ES5-compatible JS, jQuery 3 (already loaded for the forgot-password panel toggle).

**Spec:** `docs/superpowers/specs/2026-04-28-portal-login-redesign-design.md`

**Pre-flight notes for the implementing engineer:**

- Project root: `C:/laragon/www/ydi-all/`. The portal is a separate Laragon vhost — open it in a browser at `http://portal.ydi.edu.pk/user/login` (Laragon should already have the vhost configured; if not, the vhost root is `C:/laragon/www/ydi-all/portal.ydi.edu.pk/`).
- Asset base URL inside views: `<?php echo base_url() ?>` resolves to the portal's web root, so a stylesheet at `portal.ydi.edu.pk/assets/css/portal-login.css` is referenced as `<?php echo base_url() ?>assets/css/portal-login.css` — exactly mirroring how `portal-polish.css` is loaded today (see `application/views/user/login.php:25`).
- The view uses CodeIgniter form helpers: `form_open('user/login', [...])`, `form_close()`, `validation_errors('<div class="alert alert-danger">', '</div>')`, and a project helper `flash_alert()`. **Keep all four** — only the surrounding markup and styling change.
- The `User` controller has no `forget()` method (`application/controllers/User.php:1-53`). The legacy view posts to `user/forget`, which currently 404s. **This is pre-existing behavior; do not fix the backend in this PR.** The redesign keeps the form action exactly as it is — restyling only.
- The portal's main jQuery is loaded at the bottom of the view: `<?php echo base_url() ?>dist/jquery.min.js`. The new inline JS must run *after* that script tag.
- The legacy view loads `bootstrap.min.css`, `font-awesome.css`, `fonts.googleapis.com.css`, `ace.min.css`, `ace-rtl.min.css`, and `portal-polish.css`. The new view loads **only** `fonts.googleapis.com.css` (Google Fonts for Inter) and `portal-login.css`. None of those legacy stylesheets is referenced by the new markup, and the view is a single self-contained page (it does not extend the portal's main template), so dropping them from this view does not affect any other page.
- All icons are inline SVG. No font-awesome dependency on the new login page.
- Verification is visual: load the page in a browser at desktop (1280px) and mobile (375px) widths and compare to the spec's mockups. Where this plan says "verify visually," use the Playwright MCP tools (`mcp__playwright__browser_navigate`, `mcp__playwright__browser_resize`, `mcp__playwright__browser_take_screenshot`) to capture screenshots at the relevant breakpoint and inspect them. There are no unit tests for this surface.
- **No static or dummy content** in the page (per project memory `feedback_no_static_data.md`). Brand copy ("Welcome back," "Sign in to continue your learning journey") is fine — those are taglines, not data. Do not add any hardcoded "stats," "announcements," or "cohort" pills.

---

## File Structure

| File | Action | Responsibility |
|------|--------|----------------|
| `portal.ydi.edu.pk/assets/css/portal-login.css` | NEW | All visual styles for the redesigned login page, scoped under `.login-v2`. Includes: page chrome, gradient hero, form panel, inputs/buttons, forgot-password panel, alert overrides, responsive (mobile) rules. |
| `portal.ydi.edu.pk/application/views/user/login.php` | REWRITE | New semantic markup (`<main class="login-v2">`, hero `<aside>`, form `<section>`, forgot panel `<section>`), drops legacy ACE/Bootstrap stylesheets, loads only `portal-login.css` + Google Fonts, keeps CodeIgniter form helpers and the existing forgot-panel jQuery toggle, adds inline JS for password show/hide and submit-disable. |
| `portal.ydi.edu.pk/application/controllers/User.php` | UNCHANGED | Stays as-is. |
| `portal.ydi.edu.pk/application/models/User_model.php` | UNCHANGED | Stays as-is. |

---

## Task 1: Capture a baseline screenshot of the current login

**Why:** We need a "before" we can compare against to confirm the redesign actually shipped end-to-end. This is also the smoke test that the local portal vhost is reachable from the implementing engineer's machine — if this task fails, the engineer needs to fix Laragon/hosts before doing anything else.

**Files:**
- Save to: `portal-login-before.png` (project root — same convention as the existing `*-before.png` / `*-after.png` files in this repo)

- [ ] **Step 1: Confirm the portal vhost is reachable**

Run (in a browser or via curl):

```
curl -I http://portal.ydi.edu.pk/user/login
```

Expected: HTTP 200 (or HTTP 302 if a session is already active — clear cookies and try again to land on the login page).

If this fails: open Laragon → Menu → Apache → sites-enabled, confirm `portal.ydi.edu.pk.conf` exists and points to `C:/laragon/www/ydi-all/portal.ydi.edu.pk`. Add `127.0.0.1 portal.ydi.edu.pk` to `C:\Windows\System32\drivers\etc\hosts` if missing. Restart Laragon's Apache.

- [ ] **Step 2: Screenshot the current login at desktop width**

Use Playwright MCP:

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "portal-login-before.png", fullPage: true)
```

The output file lands in the Playwright output dir; move/copy it to the project root as `portal-login-before.png`.

- [ ] **Step 3: Commit the baseline screenshot**

```bash
git add portal-login-before.png
git commit -m "Add baseline screenshot of legacy portal login (pre-redesign)"
```

---

## Task 2: Create the new CSS file (skeleton)

**Files:**
- Create: `portal.ydi.edu.pk/assets/css/portal-login.css`

- [ ] **Step 1: Write the file with only the scope reset and base layout**

Create `portal.ydi.edu.pk/assets/css/portal-login.css` with exactly this content:

```css
/* =============================================================
   YDI Student Portal — login page
   Scoped under .login-v2; nothing here may leak elsewhere.
============================================================= */

.login-v2 *,
.login-v2 *::before,
.login-v2 *::after { box-sizing: border-box; }

.login-v2 {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: #f8fafc;
    color: #0f172a;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    -webkit-font-smoothing: antialiased;
}

.login-v2 .frame {
    display: flex;
    width: 100%;
    max-width: 1080px;
    min-height: 600px;
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 20px 50px rgba(15, 23, 42, .12);
}
```

- [ ] **Step 2: Verify the file is syntactically valid CSS**

Run:

```bash
node -e "const fs=require('fs'); const css=fs.readFileSync('portal.ydi.edu.pk/assets/css/portal-login.css','utf8'); if(css.split('{').length !== css.split('}').length) {console.error('brace mismatch'); process.exit(1);} console.log('ok');"
```

Expected: `ok`.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: scaffold portal-login.css with page chrome"
```

---

## Task 3: Rewrite the view markup (skeleton)

**Files:**
- Rewrite: `portal.ydi.edu.pk/application/views/user/login.php`

- [ ] **Step 1: Replace the entire view file with the new markup**

Overwrite `portal.ydi.edu.pk/application/views/user/login.php` with exactly this content:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="YDI Student Portal — sign in to access your trainings, schedule, and progress." />
    <title>Sign in &middot; YDI Student Portal</title>

    <link rel="icon" type="image/jpg" href="<?php echo site_url('images/logo.jpg'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/fonts.googleapis.com.css" />
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
        <section id="login-box" class="form-side panel visible">
            <span class="eyebrow">Student Login</span>
            <h2 class="panel-title">Sign in to your portal</h2>
            <p class="panel-sub">Use the username and password issued by your trainer.</p>

            <?php
            flash_alert();
            echo validation_errors('<div class="alert alert-danger">', '</div>');
            ?>

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

                <div class="row">
                    <label class="check"><input type="checkbox" name="remember" value="1" /> Keep me signed in</label>
                    <a href="#" data-target="#forgot-box" class="forgot-link">Forgot password?</a>
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

        <!-- RIGHT: forgot-password panel (hidden until toggled) -->
        <section id="forgot-box" class="form-side panel">
            <a href="#" data-target="#login-box" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                </svg>
                Back to sign in
            </a>
            <span class="eyebrow">Account recovery</span>
            <h2 class="panel-title">Reset your password</h2>
            <p class="panel-sub">Enter your email and we&rsquo;ll send you instructions to get back in.</p>

            <?php echo form_open('user/forget', ['class' => 'login-form', 'novalidate' => '']); ?>

                <div class="field">
                    <label for="email">Email address</label>
                    <div class="input">
                        <input id="email" name="email" type="email" required placeholder="you@school.edu.pk" autocomplete="email" />
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" data-disable-on-submit>Send reset instructions</button>

            <?php echo form_close(); ?>

            <p class="help-line">Remembered it? <a href="#" data-target="#login-box" class="back-link inline">Back to sign in</a></p>
        </section>

    </div>
</main>

<script src="<?php echo base_url() ?>dist/jquery.min.js"></script>
<script>
jQuery(function ($) {

    // Forgot-password panel swap (preserves the legacy behavior).
    $(document).on('click', '.login-v2 [data-target]', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.login-v2 .panel.visible').removeClass('visible');
        $(target).addClass('visible');
    });

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
```

- [ ] **Step 2: PHP syntax check**

Run:

```bash
php -l portal.ydi.edu.pk/application/views/user/login.php
```

Expected: `No syntax errors detected in portal.ydi.edu.pk/application/views/user/login.php`.

- [ ] **Step 3: Smoke-load the page in a browser**

Use Playwright MCP:

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_take_screenshot(filename: "login-skeleton.png")
```

Expected: page loads (no PHP error, no 500). Layout will look raw (no CSS for hero/form yet) — that's normal; the next tasks add the styles. The form must render with the `Username`, `Password`, `Keep me signed in`, `Sign in`, and `Trouble signing in?` content visible. Inspect the screenshot to confirm.

- [ ] **Step 4: Commit**

```bash
git add portal.ydi.edu.pk/application/views/user/login.php
git commit -m "Login redesign: rewrite view markup with split layout skeleton"
```

---

## Task 4: Style the brand hero (left side)

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the hero block to portal-login.css**

Add to the end of `portal.ydi.edu.pk/assets/css/portal-login.css`:

```css
/* =============================================================
   Hero (left side)
============================================================= */
.login-v2 .hero {
    position: relative;
    flex: 1.05;
    color: #fff;
    padding: 40px 44px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 35%, #3b82f6 100%);
    overflow: hidden;
}
.login-v2 .hero::before {
    content: "";
    position: absolute; inset: 0;
    background:
        radial-gradient(80% 60% at 80% 20%, rgba(255, 255, 255, .18), transparent 60%),
        radial-gradient(60% 80% at 10% 100%, rgba(0, 0, 0, .20), transparent 60%);
    pointer-events: none;
}
.login-v2 .hero::after {
    content: "";
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, .14) 1px, transparent 1px);
    background-size: 22px 22px;
    pointer-events: none;
}
.login-v2 .hero > * { position: relative; z-index: 2; }

.login-v2 .brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    letter-spacing: -.01em;
    font-size: 15px;
}
.login-v2 .brand-mark {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: #fff;
    color: #6d28d9;
    display: grid; place-items: center;
    font-weight: 800;
    font-size: 14px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .18);
}

.login-v2 .hero-title {
    margin: 0 0 14px;
    font-size: 34px;
    line-height: 1.1;
    letter-spacing: -.025em;
    font-weight: 700;
    max-width: 420px;
}
.login-v2 .hero-lede {
    margin: 0;
    font-size: 14px;
    line-height: 1.55;
    opacity: .9;
    max-width: 380px;
}
.login-v2 .hero-foot {
    font-size: 11.5px;
    opacity: .75;
}
```

- [ ] **Step 2: Verify visually at 1280px**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-hero-styled.png")
```

Expected: the left side now shows the purple→blue gradient with dotted texture, the white "Y" tile + "YDI Student Portal" wordmark at the top, the welcome headline mid-card, and a small footer line at the bottom. The right side is still unstyled.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style brand hero (gradient, mark, headline)"
```

---

## Task 5: Style the form panel (right side)

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the form-panel block**

Add to the end of `portal.ydi.edu.pk/assets/css/portal-login.css`:

```css
/* =============================================================
   Form panel (right side) — shared by sign-in and forgot
============================================================= */
.login-v2 .panel {
    flex: .95;
    padding: 48px 56px;
    display: none;
    flex-direction: column;
    justify-content: center;
}
.login-v2 .panel.visible { display: flex; }

.login-v2 .eyebrow {
    color: #64748b;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 600;
    margin-bottom: 6px;
}
.login-v2 .panel-title {
    font-size: 24px;
    letter-spacing: -.02em;
    margin: 0 0 6px;
    font-weight: 700;
}
.login-v2 .panel-sub {
    color: #64748b;
    font-size: 13.5px;
    line-height: 1.5;
    margin: 0 0 28px;
}

.login-v2 .field { margin-bottom: 14px; }
.login-v2 .field label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}

.login-v2 .input { position: relative; }
.login-v2 .input input {
    width: 100%;
    height: 44px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0 44px 0 14px;
    font: inherit;
    font-size: 14px;
    color: #0f172a;
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
}
.login-v2 .input input:focus {
    border-color: #7c3aed;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, .12);
}
.login-v2 .input .icon {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    width: 18px; height: 18px;
    color: #94a3b8;
    pointer-events: none;
}
.login-v2 .input .toggle {
    position: absolute;
    right: 8px; top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: 0;
    padding: 6px 8px;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .04em;
    cursor: pointer;
    border-radius: 6px;
}
.login-v2 .input .toggle:hover { color: #6d28d9; background: #f1f5f9; }

.login-v2 .row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 4px 0 22px;
}
.login-v2 .row .check {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #475569;
    cursor: pointer;
}
.login-v2 .row .check input { width: 14px; height: 14px; accent-color: #7c3aed; }
.login-v2 .row a {
    font-size: 13px;
    color: #6d28d9;
    font-weight: 600;
    text-decoration: none;
}
.login-v2 .row a:hover { text-decoration: underline; }

.login-v2 .btn {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 0;
    font: inherit;
    font-weight: 600;
    font-size: 14.5px;
    letter-spacing: .01em;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform .1s, box-shadow .15s, opacity .15s;
}
.login-v2 .btn-primary {
    color: #fff;
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    box-shadow: 0 8px 22px rgba(124, 58, 237, .32);
}
.login-v2 .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 26px rgba(124, 58, 237, .38); }
.login-v2 .btn:disabled,
.login-v2 .btn.is-loading {
    cursor: not-allowed;
    opacity: .7;
    transform: none;
    box-shadow: 0 4px 12px rgba(124, 58, 237, .18);
}

.login-v2 .help-line {
    margin: 22px 0 0;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px;
    color: #64748b;
    text-align: center;
}
.login-v2 .help-line a { color: #6d28d9; font-weight: 600; text-decoration: none; }
.login-v2 .help-line a:hover { text-decoration: underline; }
```

- [ ] **Step 2: Verify visually at 1280px**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-form-styled.png")
```

Expected: the right side now shows the polished form — slate eyebrow ("Student Login"), large heading, sub-copy, two inputs with icons, checkbox row, gradient Sign-in button, and help line under a divider. Click into an input and confirm the focus ring (purple, soft glow, white background).

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style form panel (inputs, button, help line)"
```

---

## Task 6: Style the forgot-password panel and back-link

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the back-link block**

Add to the end of `portal.ydi.edu.pk/assets/css/portal-login.css`:

```css
/* =============================================================
   Forgot-password panel — back link
   (panel surface and form styles are reused from Task 5)
============================================================= */
.login-v2 .back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 14px;
    font-size: 12.5px;
    color: #6d28d9;
    font-weight: 600;
    text-decoration: none;
}
.login-v2 .back-link:hover { text-decoration: underline; }
.login-v2 .back-link.inline { display: inline; margin: 0; }
```

- [ ] **Step 2: Verify the forgot panel toggles correctly**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_click(element: "Forgot password? link", ref: "a.forgot-link")
mcp__playwright__browser_take_screenshot(filename: "login-forgot-panel.png")
```

Expected: clicking "Forgot password?" replaces the right panel with the recovery panel (Back to sign in link at top, "Account recovery" eyebrow, "Reset your password" heading, single email field, "Send reset instructions" button). The hero on the left is unchanged. Then click "Back to sign in" and confirm it returns to the sign-in panel.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style forgot-password panel back-link"
```

---

## Task 7: Style alert / flash messages

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append alert overrides**

Add to the end of `portal.ydi.edu.pk/assets/css/portal-login.css`:

```css
/* =============================================================
   Alerts (validation_errors + flash_alert output)
   Original markup is `<div class="alert alert-danger">…</div>`.
============================================================= */
.login-v2 .alert {
    margin: 0 0 18px;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid transparent;
    font-size: 13px;
    line-height: 1.45;
}
.login-v2 .alert-danger {
    background: #fff1f2;
    border-color: #fecdd3;
    color: #9f1239;
}
.login-v2 .alert-success {
    background: #ecfdf5;
    border-color: #a7f3d0;
    color: #065f46;
}
.login-v2 .alert p { margin: 0; }
.login-v2 .alert ul { margin: 0; padding-left: 18px; }
```

- [ ] **Step 2: Verify a validation error renders correctly**

Trigger an error: in the browser (or via Playwright) submit the form with an empty username and password (CodeIgniter's `validation_errors()` will return an error message after the controller redirects back).

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_click(element: "Sign in button", ref: "button.btn-primary")
mcp__playwright__browser_take_screenshot(filename: "login-alert-state.png")
```

Expected: a rose-tinted alert appears above the first field with the validation message. If no alert appears (because the controller redirects without setting a flash for empty fields), pass an obviously bad credential pair — the model returns a flash via `flash_alert()` in that case.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: restyle alert/flash messages to match palette"
```

---

## Task 8: Add responsive styles (≤900px → stacked layout)

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the responsive block**

Add to the end of `portal.ydi.edu.pk/assets/css/portal-login.css`:

```css
/* =============================================================
   Responsive: stack the split below 900px
============================================================= */
@media (max-width: 900px) {
    .login-v2 { padding: 0; align-items: stretch; }
    .login-v2 .frame {
        flex-direction: column;
        min-height: 100vh;
        max-width: none;
        border-radius: 0;
        box-shadow: none;
    }
    .login-v2 .hero {
        flex: 0 0 auto;
        padding: 24px 22px 28px;
    }
    .login-v2 .hero-mid { display: none; }       /* hide the long welcome on mobile */
    .login-v2 .hero-foot { display: none; }      /* footer line moves to the form panel area */
    .login-v2 .hero-top { margin-bottom: 4px; }
    .login-v2 .panel { padding: 28px 22px 36px; }
    .login-v2 .panel-title { font-size: 22px; }
}

@media (max-width: 480px) {
    .login-v2 .panel { padding: 24px 18px 32px; }
    .login-v2 .hero { padding: 22px 18px 26px; }
}
```

- [ ] **Step 2: Verify mobile layout at 375px**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 375, height: 812)
mcp__playwright__browser_take_screenshot(filename: "login-mobile.png", fullPage: true)
```

Expected: the layout is now stacked. Top: a slim gradient banner with the brand mark + "YDI Student Portal" wordmark only (no large headline, no footer). Below: the form panel filling the rest of the screen — eyebrow, heading, sub, two fields, checkbox row, sign-in button, help line. No horizontal scroll. Tap targets feel comfortable.

- [ ] **Step 3: Verify tablet layout at 768px**

```
mcp__playwright__browser_resize(width: 768, height: 1024)
mcp__playwright__browser_take_screenshot(filename: "login-tablet.png", fullPage: true)
```

Expected: still stacked (768 < 900). Same general look as mobile but with more breathing room.

- [ ] **Step 4: Verify desktop unchanged at 1280px**

```
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-desktop-final.png")
```

Expected: split layout intact, hero shows the full headline and lede, footer line visible.

- [ ] **Step 5: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: responsive stacking below 900px"
```

---

## Task 9: Final functional verification

**Why:** The redesign must not break the actual sign-in flow. Confirm form submission reaches the controller exactly as before.

- [ ] **Step 1: Confirm form posts the right fields**

Use Playwright MCP to inspect the form HTML:

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_evaluate(function: "() => { const f = document.querySelector('form.login-form'); return { action: f.action, fields: [...f.elements].filter(e => e.name).map(e => ({ name: e.name, type: e.type })) }; }")
```

Expected output (the `action` value will include the portal host prefix — confirm the path ends in `user/login`):

```
{
  "action": "http://portal.ydi.edu.pk/user/login",
  "fields": [
    { "name": "username", "type": "text" },
    { "name": "password", "type": "password" },
    { "name": "remember", "type": "checkbox" }
  ]
}
```

Field names `username` and `password` must be present and exactly named (the controller depends on them). The `remember` field is the new no-op markup — backend ignores it.

- [ ] **Step 2: Submit a known-bad credential pair end-to-end**

```
mcp__playwright__browser_fill_form(fields: [
  { name: "Username", type: "textbox", ref: "#username", value: "no-such-user" },
  { name: "Password", type: "textbox", ref: "#password", value: "wrong" }
])
mcp__playwright__browser_click(element: "Sign in button", ref: "button.btn-primary")
mcp__playwright__browser_wait_for(text: "Sign in to your portal")
mcp__playwright__browser_take_screenshot(filename: "login-bad-creds.png")
```

Expected: the page reloads, lands back on the login view, and shows a flash/alert message in the new rose-tinted style. The Sign-in button returns to its enabled state on reload.

- [ ] **Step 3: Confirm the password show/hide toggle works**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_fill_form(fields: [
  { name: "Password", type: "textbox", ref: "#password", value: "test123" }
])
mcp__playwright__browser_click(element: "SHOW toggle", ref: "[data-pw-toggle='password']")
mcp__playwright__browser_evaluate(function: "() => document.querySelector('#password').type")
```

Expected: returns `"text"`. Click again and confirm it returns to `"password"`.

- [ ] **Step 4: Capture the final "after" screenshot**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "portal-login-after.png", fullPage: true)
```

Move the file to the project root as `portal-login-after.png` (mirroring the `*-before.png` / `*-after.png` convention already in the repo).

- [ ] **Step 5: Commit the after-screenshot**

```bash
git add portal-login-after.png
git commit -m "Add post-redesign screenshot of portal login"
```

---

## Acceptance review

Before declaring done, walk the spec's acceptance criteria one by one against the running page:

1. ☐ `portal.ydi.edu.pk/user/login` renders the split layout at ≥ 900px.
2. ☐ Below 900px the layout stacks, hero is slim banner.
3. ☐ Form posts to `user/login` with `username` + `password` (Step 1 of Task 9).
4. ☐ "Forgot password?" swaps the right panel; recovery form posts to `user/forget` with `email` (visible in the markup; Task 6 verified the toggle).
5. ☐ Validation errors / flash messages render in the new alert style (Task 7 + Task 9 Step 2).
6. ☐ The page no longer references `mis.ydi.edu.pk/images/logo.jpg` — grep the view to confirm:
   ```bash
   grep -n "mis.ydi.edu.pk" portal.ydi.edu.pk/application/views/user/login.php
   ```
   Expected: no output (no remote logo).
7. ☐ No horizontal scroll on desktop or mobile (Task 8 screenshots).
8. ☐ The legacy `<fieldset><legend>Student Login</legend>` block is gone — grep to confirm:
   ```bash
   grep -n "fieldset\|legend" portal.ydi.edu.pk/application/views/user/login.php
   ```
   Expected: no output.

If any check fails, fix it before merging. Otherwise the work is done.
