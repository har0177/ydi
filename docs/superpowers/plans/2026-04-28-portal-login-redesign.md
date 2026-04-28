# Portal Login Redesign + SMS Password Reset — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the legacy ACE/Bootstrap login at `portal.ydi.edu.pk/user/login` with a split-screen redesign **and** ship a working SMS-OTP password-reset flow (the legacy email reset 404s today). One PR, one cohesive feature.

**Architecture:** The login page becomes a single view with four right-side panels (sign-in, forgot-identify, forgot-otp, forgot-newpw). The currently visible panel is server-driven via a `$active_panel` template variable — the controller decides which panel renders after each POST, so a wrong OTP reloads on the OTP panel, not the sign-in panel. Three new controller methods (`send_reset_code`, `verify_reset_code`, `set_new_password`) drive the reset flow; four new model methods back them. A new `password_reset_otp` table stores hashed OTPs with attempt counters. SMS goes through the existing `AdminLTE::sms()` helper — no new gateway. The visual layer is a single new scoped CSS file (`portal-login.css`) loaded only on this view.

**Tech Stack:** PHP 7+ / CodeIgniter 3, MySQL/MariaDB, HTML5, vanilla CSS, jQuery 3 (already loaded), inline ES5-compatible JS.

**Spec:** `docs/superpowers/specs/2026-04-28-portal-login-redesign-design.md`

---

## Pre-flight notes for the implementing engineer

- Project root: `C:/laragon/www/ydi-all/`. The portal is a separate Laragon vhost at `http://portal.ydi.edu.pk/`. The vhost root is `C:/laragon/www/ydi-all/portal.ydi.edu.pk/`. If the host doesn't resolve, add `127.0.0.1 portal.ydi.edu.pk` to `C:\Windows\System32\drivers\etc\hosts` and restart Apache.
- Asset URL pattern: `<?php echo base_url() ?>` resolves to the portal web root. Stylesheet at `portal.ydi.edu.pk/assets/css/portal-login.css` → reference as `<?php echo base_url() ?>assets/css/portal-login.css`. Mirror the existing `portal-polish.css` reference at `application/views/user/login.php:25` (legacy file).
- CodeIgniter form helpers stay in use: `form_open(...)`, `form_close()`, `validation_errors('<div class="alert alert-danger">', '</div>')`, and the project helpers `flash_alert()` (renders + clears) and `set_flash_alert($msg, $type = 'danger')` (sets) — both defined in `application/helpers/common_functions_helper.php:135` and `:145`. All four are auto-loaded.
- The `User` controller currently has only `__construct`, `login`, `logout`, `profile` (`application/controllers/User.php:1-53`). We add three methods.
- The `User_model` currently has only `login()` (`application/models/user_model.php:5+`). We add four methods.
- Phone column lives on `student.phone` (used in `application/views/students/profile.php:92`). Username column is `student.reg_no` (used in `User_model::login` at `user_model.php:33`).
- SMS helper: `AdminLTE::sms($no, $msg)` at `application/helpers/adminlte_helper.php:906`. It POSTs to `outreach.pk/api/sendsms.php` with hardcoded credentials and the `YDI` sender mask. **Side effect:** on success it calls `set_flash_alert($responce, 'success')`. We do NOT want a flash banner on the user-facing reset flow; the implementer will need to suppress the side effect (see Task 11 Step 3 for the approach — a thin local wrapper that calls cURL directly without the flash side effect).
- Password hashing: use `secure_password_hash($plain)` and `verify_password($plain, $hash)` (project helpers, used by `User_model::login` already).
- Database access in CodeIgniter: `$this->db` inside controllers/models. `$this->db->insert('table', $row)`, `$this->db->where(...)->get('table')`, `$this->db->update('table', $row)`. Auto-loaded.
- Sessions: `$this->session->set_userdata('key', value)`, `$this->session->userdata('key')`, `$this->session->unset_userdata('key')`, `$this->session->sess_regenerate(TRUE)`.
- Routes: CodeIgniter 3 default routing maps `/<controller>/<method>` → `Controller::method()`. So `user/send_reset_code` automatically maps to `User::send_reset_code()`. No `routes.php` edit needed.
- **Verification = manual + Playwright MCP for the visual side**, manual + DB inspection for the backend. There are no PHP unit tests in this app. Where this plan says "verify in browser," use `mcp__playwright__browser_navigate`, `mcp__playwright__browser_resize`, `mcp__playwright__browser_take_screenshot`, `mcp__playwright__browser_fill_form`, `mcp__playwright__browser_click`, `mcp__playwright__browser_evaluate`. Where it says "verify in DB," use `mysql` CLI (Laragon ships it on the path) or Laragon's MySQL prompt; DB credentials live in `portal.ydi.edu.pk/application/config/database.php`.
- **No static or dummy content** in the page (per project memory `feedback_no_static_data.md`). Brand copy is fine; hardcoded stats/announcements are not.
- **Security non-negotiables:**
  - Never write the plaintext OTP to the database, the session, or any log.
  - Never reveal whether a `reg_no` exists in any error message.
  - Always re-validate session keys on the server side before each step (don't trust the client).
  - Regenerate the session ID after a successful password reset before logging the user in (matches the existing `User_model::login` pattern at `user_model.php:58`).

---

## File Structure

| File | Action | Responsibility |
|------|--------|----------------|
| `portal.ydi.edu.pk/assets/css/portal-login.css` | NEW | All visual styles for the redesigned login page, scoped under `.login-v2`. |
| `portal.ydi.edu.pk/application/views/user/login.php` | REWRITE | New semantic markup with four right-side panels (sign-in + three reset steps). Loads `portal-login.css` and Google Fonts only. Renders the panel keyed by `$active_panel`. Includes inline jQuery for panel switching, password toggles, submit-disable, and the resend cooldown timer. |
| `portal.ydi.edu.pk/application/controllers/User.php` | MODIFY | Add `send_reset_code()`, `verify_reset_code()`, `set_new_password()`. Update `login()` to render with `$active_panel = 'login'` by default. |
| `portal.ydi.edu.pk/application/models/user_model.php` | MODIFY | Add `find_by_reg_and_phone()`, `create_otp()`, `consume_otp()`, `set_password()`. |
| `portal.ydi.edu.pk/application/helpers/adminlte_helper.php` | MODIFY | Add `normalize_pk_phone($raw)` helper function (procedural, alongside the AdminLTE class). Add a thin `send_sms_silent($no, $msg)` wrapper that calls outreach.pk without setting a flash. |
| `portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql` | NEW | One-shot DDL migration for the `password_reset_otp` table. |

---

# Phase A — Visual redesign

The first eight tasks rebuild the login surface. The view markup includes all four panels from the start (so we don't have to touch it twice); the reset-flow backend in Phase B then wires the panels to real handlers.

## Task 1: Capture a baseline screenshot of the current login

**Why:** Smoke test that the local vhost is reachable, and capture a "before" image we can compare against.

**Files:**
- Save to: `portal-login-before.png` (project root)

- [ ] **Step 1: Confirm the portal vhost is reachable**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
```

Expected: page loads (HTTP 200 with the legacy login HTML). If it fails: open Laragon → Menu → Apache → sites-enabled, confirm `portal.ydi.edu.pk.conf` exists and points to `C:/laragon/www/ydi-all/portal.ydi.edu.pk`. Add `127.0.0.1 portal.ydi.edu.pk` to `C:\Windows\System32\drivers\etc\hosts` if missing. Restart Apache.

- [ ] **Step 2: Screenshot the current login at desktop width**

```
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "portal-login-before.png", fullPage: true)
```

Move the file from the Playwright output dir to the project root as `portal-login-before.png`.

- [ ] **Step 3: Commit**

```bash
git add portal-login-before.png
git commit -m "Add baseline screenshot of legacy portal login (pre-redesign)"
```

---

## Task 2: Scaffold `portal-login.css`

**Files:**
- Create: `portal.ydi.edu.pk/assets/css/portal-login.css`

- [ ] **Step 1: Write the file with the scope reset and page chrome only**

Create `portal.ydi.edu.pk/assets/css/portal-login.css`:

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

- [ ] **Step 2: Verify brace balance**

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

## Task 3: Rewrite the view markup (all four panels)

**Files:**
- Rewrite: `portal.ydi.edu.pk/application/views/user/login.php`

The view must render *all four* panels in the markup; only the one matching `$active_panel` (passed by the controller) gets the `visible` class. This makes the panel state survive server-side redirects.

- [ ] **Step 1: Replace the entire view file**

Overwrite `portal.ydi.edu.pk/application/views/user/login.php` with exactly this content:

```php
<?php
$active_panel = isset($active_panel) ? $active_panel : 'login';
$resend_in    = isset($resend_in)    ? max(0, (int) $resend_in) : 0;
?>
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

<main class="login-v2" data-active-panel="<?php echo htmlspecialchars($active_panel, ENT_QUOTES); ?>" data-resend-in="<?php echo $resend_in; ?>">
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

        <!-- RIGHT: stack of panels -->
        <div class="panel-stack">

            <!-- 1. Sign-in -->
            <section id="login" class="panel<?php echo $active_panel === 'login' ? ' visible' : ''; ?>">
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
                    <div class="row">
                        <label class="check"><input type="checkbox" name="remember" value="1" /> Keep me signed in</label>
                        <a href="#forgot-identify" data-target="#forgot-identify" class="forgot-link">Forgot password?</a>
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

            <!-- 2. Forgot — Identify -->
            <section id="forgot-identify" class="panel<?php echo $active_panel === 'forgot-identify' ? ' visible' : ''; ?>">
                <a href="#login" data-target="#login" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                    Back to sign in
                </a>
                <span class="eyebrow">Account recovery</span>
                <h2 class="panel-title">Reset your password</h2>
                <p class="panel-sub">Enter your reg no and the phone number on file. We&rsquo;ll text you a 6-digit code.</p>

                <?php if ($active_panel === 'forgot-identify') { flash_alert(); echo validation_errors('<div class="alert alert-danger">', '</div>'); } ?>

                <?php echo form_open('user/send_reset_code', ['class' => 'login-form', 'novalidate' => '']); ?>
                    <div class="field">
                        <label for="reset_reg_no">Registration number</label>
                        <div class="input">
                            <input id="reset_reg_no" name="reg_no" type="text" required placeholder="e.g. 23-001" autocomplete="username" />
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6M9 11h6M9 15h4M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
                        </div>
                    </div>
                    <div class="field">
                        <label for="reset_phone">Phone number</label>
                        <div class="input">
                            <input id="reset_phone" name="phone" type="tel" required placeholder="e.g. 03001234567" autocomplete="tel" inputmode="tel" />
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.5 4.5a1 1 0 01-.272 1.07l-2.13 1.92a11 11 0 005.516 5.516l1.92-2.13a1 1 0 011.07-.272l4.5 1.5a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-disable-on-submit>Send code</button>
                <?php echo form_close(); ?>

                <p class="help-line">Don&rsquo;t have access anymore? <a href="mailto:info@ydi.edu.pk">Contact support</a></p>
            </section>

            <!-- 3. Forgot — OTP -->
            <section id="forgot-otp" class="panel<?php echo $active_panel === 'forgot-otp' ? ' visible' : ''; ?>">
                <a href="#login" data-target="#login" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                    Back to sign in
                </a>
                <span class="eyebrow">Verify</span>
                <h2 class="panel-title">Enter the code we sent</h2>
                <p class="panel-sub">Check your SMS for a 6-digit code. It expires in 10 minutes.</p>

                <?php if ($active_panel === 'forgot-otp') { flash_alert(); echo validation_errors('<div class="alert alert-danger">', '</div>'); } ?>

                <?php echo form_open('user/verify_reset_code', ['class' => 'login-form', 'novalidate' => '']); ?>
                    <div class="field">
                        <label for="reset_otp">6-digit code</label>
                        <div class="input">
                            <input id="reset_otp" name="otp" type="text" required maxlength="6" pattern="\d{6}" inputmode="numeric" autocomplete="one-time-code" placeholder="123456" class="otp-input" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-disable-on-submit>Verify</button>
                <?php echo form_close(); ?>

                <p class="help-line">
                    Didn&rsquo;t get it?
                    <a href="<?php echo site_url('user/send_reset_code?resend=1'); ?>" class="resend-link" data-cooldown="<?php echo $resend_in; ?>">Resend code</a>
                </p>
            </section>

            <!-- 4. Forgot — New password -->
            <section id="forgot-newpw" class="panel<?php echo $active_panel === 'forgot-newpw' ? ' visible' : ''; ?>">
                <a href="#login" data-target="#login" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                    Back to sign in
                </a>
                <span class="eyebrow">Almost done</span>
                <h2 class="panel-title">Choose a new password</h2>
                <p class="panel-sub">Make it at least 8 characters.</p>

                <?php if ($active_panel === 'forgot-newpw') { flash_alert(); echo validation_errors('<div class="alert alert-danger">', '</div>'); } ?>

                <?php echo form_open('user/set_new_password', ['class' => 'login-form', 'novalidate' => '']); ?>
                    <div class="field">
                        <label for="new_password">New password</label>
                        <div class="input">
                            <input id="new_password" name="new_password" type="password" required minlength="8" placeholder="At least 8 characters" autocomplete="new-password" />
                            <button type="button" class="toggle" data-pw-toggle="new_password" aria-label="Show password">SHOW</button>
                        </div>
                    </div>
                    <div class="field">
                        <label for="new_password_confirm">Confirm new password</label>
                        <div class="input">
                            <input id="new_password_confirm" name="new_password_confirm" type="password" required minlength="8" placeholder="Type it again" autocomplete="new-password" />
                            <button type="button" class="toggle" data-pw-toggle="new_password_confirm" aria-label="Show password">SHOW</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" data-disable-on-submit>Save and sign in</button>
                <?php echo form_close(); ?>
            </section>

        </div><!-- /.panel-stack -->
    </div><!-- /.frame -->
</main>

<script src="<?php echo base_url() ?>dist/jquery.min.js"></script>
<script>
jQuery(function ($) {

    // Client-side panel swap (when user clicks back/forgot links).
    // The server still drives initial visibility via $active_panel.
    $(document).on('click', '.login-v2 [data-target]', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.login-v2 .panel.visible').removeClass('visible');
        $(target).addClass('visible');
    });

    // Password show/hide toggle (works for any input by id).
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

    // Resend cooldown — disables the resend link for N seconds and counts down in its label.
    var $resend = $('.login-v2 .resend-link');
    if ($resend.length) {
        var seconds = parseInt($resend.attr('data-cooldown'), 10) || 0;
        if (seconds > 0) {
            var originalText = $resend.text();
            $resend.addClass('is-disabled').on('click.cd', function (e) { e.preventDefault(); });
            var tick = function () {
                if (seconds <= 0) {
                    $resend.removeClass('is-disabled').off('click.cd').text(originalText);
                    return;
                }
                $resend.text('Resend code (' + seconds + 's)');
                seconds -= 1;
                setTimeout(tick, 1000);
            };
            tick();
        }
    }

});
</script>

</body>
</html>
```

- [ ] **Step 2: PHP syntax check**

```bash
php -l portal.ydi.edu.pk/application/views/user/login.php
```

Expected: `No syntax errors detected ...`.

- [ ] **Step 3: Smoke-load the page**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_take_screenshot(filename: "login-skeleton.png")
```

Expected: page loads. Layout will look raw (no CSS for hero/form yet) — only the `login` panel is visible (other panels' `visible` class is absent so they're `display: none` once styles land). The sign-in form should render with Username, Password, Keep-me-signed-in, Sign in, and "Trouble signing in?".

- [ ] **Step 4: Commit**

```bash
git add portal.ydi.edu.pk/application/views/user/login.php
git commit -m "Login redesign: rewrite view with four-panel structure (server-driven visibility)"
```

---

## Task 4: Style the brand hero (left side)

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the hero block**

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

.login-v2 .brand { display: inline-flex; align-items: center; gap: 10px; font-weight: 700; letter-spacing: -.01em; font-size: 15px; }
.login-v2 .brand-mark {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: #fff;
    color: #6d28d9;
    display: grid; place-items: center;
    font-weight: 800; font-size: 14px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .18);
}

.login-v2 .hero-title { margin: 0 0 14px; font-size: 34px; line-height: 1.1; letter-spacing: -.025em; font-weight: 700; max-width: 420px; }
.login-v2 .hero-lede  { margin: 0; font-size: 14px; line-height: 1.55; opacity: .9; max-width: 380px; }
.login-v2 .hero-foot  { font-size: 11.5px; opacity: .75; }
```

- [ ] **Step 2: Verify visually at 1280px**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-hero-styled.png")
```

Expected: left half shows purple→blue gradient with dotted texture, white "Y" tile + wordmark, welcome headline, footer line. Right side still unstyled.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style brand hero (gradient, mark, headline)"
```

---

## Task 5: Style the panel-stack and shared form components

These styles apply to all four panels (sign-in + the three reset steps share the same input/button/help-line look).

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append the form/panel block**

```css
/* =============================================================
   Panel stack (right side) — sign-in + reset steps share these
============================================================= */
.login-v2 .panel-stack {
    flex: .95;
    display: flex;
    flex-direction: column;
    position: relative;
}
.login-v2 .panel {
    flex: 1;
    padding: 48px 56px;
    display: none;
    flex-direction: column;
    justify-content: center;
}
.login-v2 .panel.visible { display: flex; }

.login-v2 .eyebrow      { color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: .08em; font-weight: 600; margin-bottom: 6px; }
.login-v2 .panel-title  { font-size: 24px; letter-spacing: -.02em; margin: 0 0 6px; font-weight: 700; }
.login-v2 .panel-sub    { color: #64748b; font-size: 13.5px; line-height: 1.5; margin: 0 0 28px; }

.login-v2 .field { margin-bottom: 14px; }
.login-v2 .field label {
    display: block; font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 6px;
}

.login-v2 .input { position: relative; }
.login-v2 .input input {
    width: 100%;
    height: 44px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0 44px 0 14px;
    font: inherit; font-size: 14px; color: #0f172a;
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
}
.login-v2 .input input:focus {
    border-color: #7c3aed;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, .12);
}
.login-v2 .input .icon {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    width: 18px; height: 18px; color: #94a3b8;
    pointer-events: none;
}
.login-v2 .input .toggle {
    position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
    background: transparent; border: 0; padding: 6px 8px;
    color: #64748b; font-size: 11px; font-weight: 700; letter-spacing: .04em;
    cursor: pointer; border-radius: 6px;
}
.login-v2 .input .toggle:hover { color: #6d28d9; background: #f1f5f9; }

.login-v2 .row {
    display: flex; align-items: center; justify-content: space-between;
    margin: 4px 0 22px;
}
.login-v2 .row .check { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: #475569; cursor: pointer; }
.login-v2 .row .check input { width: 14px; height: 14px; accent-color: #7c3aed; }
.login-v2 .row a { font-size: 13px; color: #6d28d9; font-weight: 600; text-decoration: none; }
.login-v2 .row a:hover { text-decoration: underline; }

.login-v2 .btn {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 0;
    font: inherit; font-weight: 600; font-size: 14.5px; letter-spacing: .01em;
    cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
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
    cursor: not-allowed; opacity: .7; transform: none;
    box-shadow: 0 4px 12px rgba(124, 58, 237, .18);
}

.login-v2 .help-line {
    margin: 22px 0 0;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px; color: #64748b; text-align: center;
}
.login-v2 .help-line a { color: #6d28d9; font-weight: 600; text-decoration: none; }
.login-v2 .help-line a:hover { text-decoration: underline; }

/* Back link (top of every reset panel) */
.login-v2 .back-link {
    display: inline-flex; align-items: center; gap: 6px;
    margin-bottom: 14px;
    font-size: 12.5px; color: #6d28d9; font-weight: 600; text-decoration: none;
}
.login-v2 .back-link:hover { text-decoration: underline; }
```

- [ ] **Step 2: Verify visually at 1280px**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-form-styled.png")
```

Expected: right side shows the polished sign-in form — slate eyebrow, large heading, sub-copy, two inputs with icons/toggle, checkbox row, gradient button, help line.

- [ ] **Step 3: Verify a panel swap works**

```
mcp__playwright__browser_click(element: "Forgot password? link", ref: "a.forgot-link")
mcp__playwright__browser_take_screenshot(filename: "login-forgot-identify.png")
```

Expected: right panel switches to the **Identify** panel — Back link at top, "Account recovery" eyebrow, "Reset your password" heading, two fields (reg no + phone), Send code button. Click "Back to sign in" and confirm it returns.

- [ ] **Step 4: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style panel stack + shared form components (sign-in + reset)"
```

---

## Task 6: Style alerts / flash messages

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append**

```css
/* =============================================================
   Alerts (validation_errors + flash_alert output)
============================================================= */
.login-v2 .alert {
    margin: 0 0 18px;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid transparent;
    font-size: 13px; line-height: 1.45;
}
.login-v2 .alert-danger  { background: #fff1f2; border-color: #fecdd3; color: #9f1239; }
.login-v2 .alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
.login-v2 .alert p  { margin: 0; }
.login-v2 .alert ul { margin: 0; padding-left: 18px; }
```

- [ ] **Step 2: Verify**

Trigger an error by submitting the sign-in form empty:

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_click(element: "Sign in button", ref: "#login button.btn-primary")
mcp__playwright__browser_take_screenshot(filename: "login-alert.png")
```

Expected: rose-tinted alert above the first field with the validation message.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: restyle alert/flash messages"
```

---

## Task 7: Style the OTP-specific pieces (large input, resend link state)

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append**

```css
/* =============================================================
   OTP panel — larger numeric input + resend link state
============================================================= */
.login-v2 .otp-input {
    text-align: center;
    font-size: 22px !important;
    letter-spacing: .5em;
    font-variant-numeric: tabular-nums;
    height: 52px !important;
    padding: 0 14px !important;
}
.login-v2 .resend-link {
    color: #6d28d9; font-weight: 600; text-decoration: none;
}
.login-v2 .resend-link.is-disabled {
    pointer-events: none; cursor: not-allowed; opacity: .5;
}
```

- [ ] **Step 2: Verify**

Force the OTP panel to be visible by appending `?_panel=forgot-otp` — wait, that doesn't exist yet. Instead, click into the panel via the front-end:

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_click(element: "Forgot password? link", ref: "a.forgot-link")
mcp__playwright__browser_evaluate(function: "() => { document.querySelector('#forgot-identify').classList.remove('visible'); document.querySelector('#forgot-otp').classList.add('visible'); }")
mcp__playwright__browser_take_screenshot(filename: "login-otp-styled.png")
```

Expected: OTP panel shows the centered, large, letter-spaced numeric input. The Resend link is purple and bold.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: style OTP input and resend link"
```

---

## Task 8: Responsive — stack below 900px

**Files:**
- Modify: `portal.ydi.edu.pk/assets/css/portal-login.css` (append)

- [ ] **Step 1: Append**

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
    .login-v2 .hero { flex: 0 0 auto; padding: 24px 22px 28px; }
    .login-v2 .hero-mid  { display: none; }
    .login-v2 .hero-foot { display: none; }
    .login-v2 .hero-top  { margin-bottom: 4px; }
    .login-v2 .panel { padding: 28px 22px 36px; }
    .login-v2 .panel-title { font-size: 22px; }
}
@media (max-width: 480px) {
    .login-v2 .panel { padding: 24px 18px 32px; }
    .login-v2 .hero  { padding: 22px 18px 26px; }
}
```

- [ ] **Step 2: Verify mobile + desktop**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 375, height: 812)
mcp__playwright__browser_take_screenshot(filename: "login-mobile.png", fullPage: true)
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "login-desktop.png", fullPage: true)
```

Expected (mobile): stacked, slim hero banner on top with brand mark + wordmark only, form fills the rest. No horizontal scroll. Expected (desktop): split layout intact.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/assets/css/portal-login.css
git commit -m "Login redesign: responsive stacking below 900px"
```

---

# Phase B — SMS password reset (backend)

The visual layer is done. Now we wire the reset flow's three POST handlers, the model methods they call, and the database table they read/write.

## Task 9: Add `normalize_pk_phone` helper and a flash-free SMS wrapper

**Files:**
- Modify: `portal.ydi.edu.pk/application/helpers/adminlte_helper.php`

We need a phone normalizer (so user input and DB values can be compared) and a flash-free SMS sender (so the user-facing reset flow doesn't get a green "success" banner from the gateway response).

- [ ] **Step 1: Append the helpers to the bottom of `adminlte_helper.php`**

Open `portal.ydi.edu.pk/application/helpers/adminlte_helper.php` and append at the end of the file (after the closing `}` of the `AdminLTE` class, and after any existing procedural helpers — the file mixes class methods and procedural functions):

```php
if (!function_exists('normalize_pk_phone')) {
    /**
     * Normalize a Pakistani phone number to the form 92XXXXXXXXXX.
     * Returns null if the input cannot plausibly be a PK mobile number.
     *
     * Examples:
     *   "0300 123 4567"   -> "923001234567"
     *   "+92-300-1234567" -> "923001234567"
     *   "923001234567"    -> "923001234567"
     *   "300 1234567"     -> "923001234567"
     *   ""                -> null
     *   "abc"             -> null
     */
    function normalize_pk_phone($raw) {
        if ($raw === null) return null;
        $digits = preg_replace('/\D+/', '', (string) $raw);
        if ($digits === '' || $digits === null) return null;
        // Drop a leading '0' (local form).
        if (strlen($digits) === 11 && $digits[0] === '0') {
            $digits = substr($digits, 1);
        }
        // If it already starts with 92, keep as-is; otherwise prepend.
        if (substr($digits, 0, 2) !== '92') {
            $digits = '92' . $digits;
        }
        // PK mobile numbers are 12 digits in the 92XXXXXXXXXX form.
        if (strlen($digits) !== 12) return null;
        return $digits;
    }
}

if (!function_exists('send_sms_silent')) {
    /**
     * Send an SMS via the outreach.pk gateway WITHOUT setting a flash message.
     * Mirrors AdminLTE::sms() but suppresses the user-facing "success" banner
     * that helper produces — the password-reset flow shows its own copy.
     *
     * Returns true if cURL completed, false on transport failure. The gateway
     * itself does not return a structured success/failure code we can rely on.
     */
    function send_sms_silent($phone92, $msg) {
        $id = 'rchyouthins'; $pass = 'webnaxtor1'; $mask = 'YDI'; $lang = 'English';
        $data = http_build_query([
            'id' => $id, 'pass' => $pass, 'mask' => $mask,
            'to' => $phone92, 'lang' => $lang, 'msg' => $msg,
        ]);
        $ch = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $ok = ($response !== false);
        curl_close($ch);
        return $ok;
    }
}
```

- [ ] **Step 2: PHP syntax check**

```bash
php -l portal.ydi.edu.pk/application/helpers/adminlte_helper.php
```

Expected: `No syntax errors detected ...`.

- [ ] **Step 3: Smoke-test `normalize_pk_phone` from the CLI**

```bash
php -r "require 'portal.ydi.edu.pk/application/helpers/adminlte_helper.php'; foreach (['0300 123 4567','+92-300-1234567','923001234567','300 1234567','','abc','12345'] as \$in) { echo str_pad(\$in,20) . ' -> ' . var_export(normalize_pk_phone(\$in), true) . PHP_EOL; }"
```

Expected output:

```
0300 123 4567        -> '923001234567'
+92-300-1234567      -> '923001234567'
923001234567         -> '923001234567'
300 1234567          -> '923001234567'
                     -> NULL
abc                  -> NULL
12345                -> NULL
```

If the PHP CLI errors on `require` because the file uses CodeIgniter helpers like `set_flash_alert` at load time, ignore the error — only the new function definitions matter. Re-run the smoke test after wrapping the require in a try/catch if needed, or test inside the running app via a temporary controller route.

- [ ] **Step 4: Commit**

```bash
git add portal.ydi.edu.pk/application/helpers/adminlte_helper.php
git commit -m "Add normalize_pk_phone helper and flash-free SMS wrapper"
```

---

## Task 10: Database migration — `password_reset_otp` table

**Files:**
- Create: `portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql`

- [ ] **Step 1: Create the migration file**

Create `portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql`:

```sql
-- 2026-04-28 — Password reset OTP table
-- One row per reset attempt. Plain code is hashed with PHP password_hash() before insert.

CREATE TABLE IF NOT EXISTS `password_reset_otp` (
    `id`         INT NOT NULL AUTO_INCREMENT,
    `student_id` INT NOT NULL,
    `otp_hash`   VARCHAR(255) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `attempts`   TINYINT NOT NULL DEFAULT 0,
    `used`       TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_student_active` (`student_id`, `used`, `expires_at`),
    KEY `idx_recent_per_student` (`student_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

- [ ] **Step 2: Run the migration**

Read the DB credentials from `portal.ydi.edu.pk/application/config/database.php` (look for `$db['default']['username']`, `password`, `database`, `hostname`).

```bash
mysql -h <hostname> -u <username> -p<password> <database> < portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql
```

Verify the table exists:

```bash
mysql -h <hostname> -u <username> -p<password> <database> -e "DESCRIBE password_reset_otp;"
```

Expected: 7 columns matching the SQL above.

- [ ] **Step 3: Commit**

```bash
git add portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql
git commit -m "Add password_reset_otp table migration"
```

---

## Task 11: Step 1 — `send_reset_code` (controller + model)

**Files:**
- Modify: `portal.ydi.edu.pk/application/models/user_model.php`
- Modify: `portal.ydi.edu.pk/application/controllers/User.php`

This task wires the **Identify → OTP** transition: validate reg_no + phone, generate code, SMS it, render the OTP panel.

- [ ] **Step 1: Add `find_by_reg_and_phone` and `create_otp` to the model**

Append to `portal.ydi.edu.pk/application/models/user_model.php`, **inside the `User_model` class**, before the closing `}`:

```php
    /**
     * Look up a student by reg_no whose normalized phone matches the
     * normalized form of $raw_phone. Returns the row object or null.
     * No SMS or DB write happens here.
     */
    public function find_by_reg_and_phone($reg_no, $raw_phone) {
        $phone92 = normalize_pk_phone($raw_phone);
        if ($phone92 === null) return null;

        $this->db->select('*');
        $this->db->where('reg_no', $reg_no);
        $this->db->where('status', 1);
        $rows = $this->db->get('student')->result();
        if (empty($rows)) return null;

        foreach ($rows as $row) {
            if (empty($row->phone)) continue;
            if (normalize_pk_phone($row->phone) === $phone92) {
                return $row;
            }
        }
        return null;
    }

    /**
     * Create a new OTP for a student. Generates a random 6-digit code,
     * stores its hash with a 10-minute expiry, and returns the PLAIN code
     * so the caller can SMS it. The plain code is never persisted.
     */
    public function create_otp($student_id) {
        $code     = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hash     = password_hash($code, PASSWORD_DEFAULT);
        $expires  = date('Y-m-d H:i:s', time() + 600);

        $this->db->insert('password_reset_otp', [
            'student_id' => (int) $student_id,
            'otp_hash'   => $hash,
            'expires_at' => $expires,
            'attempts'   => 0,
            'used'       => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $code;
    }

    /**
     * Count how many OTP rows we've created for this student in the last 24 hours.
     * Used for the daily-cap rate limit.
     */
    public function recent_otp_count($student_id, $hours = 24) {
        $since = date('Y-m-d H:i:s', time() - ($hours * 3600));
        $this->db->where('student_id', (int) $student_id);
        $this->db->where('created_at >=', $since);
        return (int) $this->db->count_all_results('password_reset_otp');
    }
```

PHP syntax check:

```bash
php -l portal.ydi.edu.pk/application/models/user_model.php
```

Expected: `No syntax errors detected ...`.

- [ ] **Step 2: Add `send_reset_code` to the controller**

Append to `portal.ydi.edu.pk/application/controllers/User.php`, **inside the `User` class**, before the closing `}`:

```php
    /**
     * POST user/send_reset_code
     * Body: reg_no, phone
     * Always renders the OTP panel with a generic message — never reveals
     * whether the reg_no or phone matched. Internally only matches send SMS.
     *
     * Also handles GET ?resend=1 from the OTP panel's "Resend code" link,
     * which re-uses the session's pw_reset_student_id to issue a new OTP
     * without re-asking for reg_no/phone.
     */
    public function send_reset_code() {
        // 60-second per-session cooldown.
        $last_send = (int) $this->session->userdata('pw_reset_last_send_at');
        if ($last_send && (time() - $last_send) < 60) {
            set_flash_alert('Please wait a moment before requesting another code.');
            $this->render_panel('forgot-otp', 60 - (time() - $last_send));
            return;
        }

        $is_resend = ($this->input->get('resend') === '1');

        if ($is_resend) {
            $student_id = (int) $this->session->userdata('pw_reset_student_id');
            if (!$student_id) {
                $this->render_panel('forgot-identify');
                return;
            }
            $student = $this->user->find_by_id($student_id); // see Step 3 — small helper added in this task
            if (!$student) {
                $this->render_panel('forgot-identify');
                return;
            }
        } else {
            $reg_no = $this->input->post('reg_no', true);
            $phone  = $this->input->post('phone',  true);
            if (!$reg_no || !$phone) {
                set_flash_alert('Please fill in both fields.');
                $this->render_panel('forgot-identify');
                return;
            }
            $student = $this->user->find_by_reg_and_phone($reg_no, $phone);

            // Generic response on no-match: render the OTP panel with the same
            // copy as a real send, so an attacker can't tell the difference.
            if (!$student) {
                set_flash_alert('If we found a match, you\'ll get an SMS shortly.', 'success');
                $this->render_panel('forgot-otp', 60);
                return;
            }
        }

        // Daily cap: 5 OTPs per student per 24h.
        if ($this->user->recent_otp_count($student->id) >= 5) {
            set_flash_alert('Too many reset attempts. Please try again later.');
            $this->render_panel('forgot-identify');
            return;
        }

        // Generate, store, and send.
        $code     = $this->user->create_otp($student->id);
        $phone92  = normalize_pk_phone($student->phone);
        if ($phone92) {
            send_sms_silent($phone92, "YDI password reset code: $code. Expires in 10 minutes. Do not share this code.");
        }

        $this->session->set_userdata([
            'pw_reset_student_id'   => (int) $student->id,
            'pw_reset_last_send_at' => time(),
        ]);

        set_flash_alert('We\'ve sent a 6-digit code to the phone on file.', 'success');
        $this->render_panel('forgot-otp', 60);
    }

    /**
     * Render the login view with a specific panel visible.
     * $resend_in is the seconds remaining on the resend cooldown (0 = enabled).
     */
    private function render_panel($panel, $resend_in = 0) {
        $this->template->title('Sign in');
        $this->template->assign('active_panel', $panel);
        $this->template->assign('resend_in',    (int) $resend_in);
        $this->template->display('user/login');
    }
```

- [ ] **Step 3: Add `find_by_id` to the model (used by the resend path)**

Inside `User_model`, append:

```php
    /**
     * Look up a student by primary key. Used by the OTP resend path which
     * trusts the session-bound student_id rather than re-asking for credentials.
     */
    public function find_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', (int) $id);
        $this->db->where('status', 1);
        $rows = $this->db->get('student')->result();
        return empty($rows) ? null : $rows[0];
    }
```

- [ ] **Step 4: Update `User::login` to set `$active_panel = 'login'`**

Edit `User::login` so the existing rendering pass also passes `active_panel`:

Replace:

```php
        // Load template data
        $this->template->title('Login');
        $this->template->display('user/login');
```

With:

```php
        // Load template data
        $this->template->title('Login');
        $this->template->assign('active_panel', 'login');
        $this->template->display('user/login');
```

- [ ] **Step 5: PHP syntax check**

```bash
php -l portal.ydi.edu.pk/application/controllers/User.php
php -l portal.ydi.edu.pk/application/models/user_model.php
```

Expected: both report `No syntax errors detected ...`.

- [ ] **Step 6: End-to-end manual verification**

In the browser:
1. Open `http://portal.ydi.edu.pk/user/login`.
2. Click "Forgot password?" → Identify panel renders.
3. Submit with **wrong** `reg_no` + `phone`. Page reloads on the **OTP panel** with the success-tone flash "If we found a match, you'll get an SMS shortly." — and there's NO new row in `password_reset_otp` (verify with `SELECT * FROM password_reset_otp ORDER BY id DESC LIMIT 1;`).
4. Submit with a **valid** `reg_no` + matching `phone` (use a real test student row from `student` whose phone is set). The OTP panel renders with the same green flash, AND a new row exists in `password_reset_otp` for that `student_id`. The student receives an SMS (real send via outreach.pk — confirm against a test phone).

- [ ] **Step 7: Commit**

```bash
git add portal.ydi.edu.pk/application/controllers/User.php portal.ydi.edu.pk/application/models/user_model.php
git commit -m "Reset flow: send_reset_code (identify -> OTP) + supporting model methods"
```

---

## Task 12: Step 2 — `verify_reset_code` (controller + model)

**Files:**
- Modify: `portal.ydi.edu.pk/application/models/user_model.php`
- Modify: `portal.ydi.edu.pk/application/controllers/User.php`

- [ ] **Step 1: Add `consume_otp` to the model**

Append inside `User_model`:

```php
    /**
     * Validate an OTP submission for a student.
     * - Looks up the most recent unused, non-expired row for the student.
     * - Compares the provided plaintext code against the stored hash.
     * - On success: marks the row used, returns true.
     * - On failure: increments attempts; at 5 attempts, marks the row used
     *   so it can no longer be tried. Returns false either way.
     * - If no eligible row exists, returns false.
     */
    public function consume_otp($student_id, $code) {
        $now = date('Y-m-d H:i:s');
        $this->db->where('student_id', (int) $student_id);
        $this->db->where('used', 0);
        $this->db->where('expires_at >=', $now);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        $rows = $this->db->get('password_reset_otp')->result();
        if (empty($rows)) return false;
        $row = $rows[0];

        if (password_verify((string) $code, $row->otp_hash)) {
            $this->db->where('id', $row->id);
            $this->db->update('password_reset_otp', ['used' => 1]);
            return true;
        }

        $next_attempts = ((int) $row->attempts) + 1;
        $update = ['attempts' => $next_attempts];
        if ($next_attempts >= 5) {
            $update['used'] = 1;
        }
        $this->db->where('id', $row->id);
        $this->db->update('password_reset_otp', $update);
        return false;
    }
```

- [ ] **Step 2: Add `verify_reset_code` to the controller**

Append inside `User`:

```php
    /**
     * POST user/verify_reset_code
     * Body: otp
     */
    public function verify_reset_code() {
        $student_id = (int) $this->session->userdata('pw_reset_student_id');
        if (!$student_id) {
            $this->render_panel('forgot-identify');
            return;
        }
        $code = trim((string) $this->input->post('otp', true));
        if (!preg_match('/^\d{6}$/', $code)) {
            set_flash_alert('That code didn\'t work. Try again or request a new one.');
            $this->render_panel('forgot-otp');
            return;
        }

        $ok = $this->user->consume_otp($student_id, $code);
        if (!$ok) {
            set_flash_alert('That code didn\'t work. Try again or request a new one.');
            $this->render_panel('forgot-otp');
            return;
        }

        // Success — open a 10-minute window to set a new password.
        $this->session->set_userdata('pw_reset_verified_at', time());
        $this->render_panel('forgot-newpw');
    }
```

- [ ] **Step 3: PHP syntax check**

```bash
php -l portal.ydi.edu.pk/application/controllers/User.php
php -l portal.ydi.edu.pk/application/models/user_model.php
```

- [ ] **Step 4: End-to-end manual verification**

1. Run the Identify step from Task 11 with a real student. Look in `password_reset_otp` to see the row was created.
2. Read the SMS on the test phone OR (for testing without a phone) read the latest `otp_hash` and brute-force the 6-digit code by trying combinations in code — easier: temporarily add an `error_log("OTP=$code")` line to `User_model::create_otp` for testing only, and tail the PHP error log. **Remove this debug line before shipping.**
3. Submit the wrong code 4 times — the OTP panel re-renders each time with a generic error, `attempts` increments in the DB, the row stays `used = 0`.
4. Submit a 5th wrong code — `used` flips to 1 and the row is dead.
5. Run a fresh Identify+SMS, then submit the correct code — the New-password panel renders.

- [ ] **Step 5: Commit**

```bash
git add portal.ydi.edu.pk/application/controllers/User.php portal.ydi.edu.pk/application/models/user_model.php
git commit -m "Reset flow: verify_reset_code (OTP -> new password) with attempts cap"
```

---

## Task 13: Step 3 — `set_new_password` (controller + model)

**Files:**
- Modify: `portal.ydi.edu.pk/application/models/user_model.php`
- Modify: `portal.ydi.edu.pk/application/controllers/User.php`

- [ ] **Step 1: Add `set_password` to the model**

Append inside `User_model`:

```php
    /**
     * Hash and write a new password to the student row.
     * Returns true on success, false on DB failure.
     */
    public function set_password($student_id, $new_plain) {
        $hash = secure_password_hash($new_plain);
        $this->db->where('id', (int) $student_id);
        return (bool) $this->db->update('student', ['password' => $hash]);
    }
```

- [ ] **Step 2: Add `set_new_password` to the controller**

Append inside `User`:

```php
    /**
     * POST user/set_new_password
     * Body: new_password, new_password_confirm
     * Requires session keys pw_reset_student_id and pw_reset_verified_at
     * (set by send_reset_code and verify_reset_code respectively).
     * On success: writes hashed password, clears reset session, regenerates
     * session id, logs the user in, redirects to student/portal.
     */
    public function set_new_password() {
        $student_id  = (int) $this->session->userdata('pw_reset_student_id');
        $verified_at = (int) $this->session->userdata('pw_reset_verified_at');

        if (!$student_id || !$verified_at) {
            $this->render_panel('forgot-identify');
            return;
        }
        // Must finish within 10 minutes of OTP verification.
        if ((time() - $verified_at) > 600) {
            $this->session->unset_userdata(['pw_reset_student_id', 'pw_reset_verified_at', 'pw_reset_last_send_at']);
            set_flash_alert('Your reset session expired. Please start again.');
            $this->render_panel('forgot-identify');
            return;
        }

        $new     = (string) $this->input->post('new_password');
        $confirm = (string) $this->input->post('new_password_confirm');

        if (strlen($new) < 8) {
            set_flash_alert('Password must be at least 8 characters.');
            $this->render_panel('forgot-newpw');
            return;
        }
        if ($new !== $confirm) {
            set_flash_alert('Passwords don\'t match.');
            $this->render_panel('forgot-newpw');
            return;
        }

        $student = $this->user->find_by_id($student_id);
        if (!$student) {
            $this->render_panel('forgot-identify');
            return;
        }

        if (!$this->user->set_password($student_id, $new)) {
            set_flash_alert('We couldn\'t save your new password. Please try again.');
            $this->render_panel('forgot-newpw');
            return;
        }

        // Clear all reset-related session state.
        $this->session->unset_userdata(['pw_reset_student_id', 'pw_reset_verified_at', 'pw_reset_last_send_at']);

        // Regenerate session id and log the user in (matches User_model::login pattern).
        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata([
            'user_logged' => $student->reg_no,
            'user_name'   => isset($student->name)   ? $student->name   : '',
            'user_id'     => $student->id,
            'user_status' => isset($student->status) ? $student->status : 1,
        ]);

        redirect('student/portal');
    }
```

- [ ] **Step 3: PHP syntax check**

```bash
php -l portal.ydi.edu.pk/application/controllers/User.php
php -l portal.ydi.edu.pk/application/models/user_model.php
```

- [ ] **Step 4: End-to-end manual verification**

Run the full flow front-to-back:
1. Sign-in → click Forgot → Identify with real reg_no + phone → OTP → enter correct code → New password panel.
2. Submit two non-matching passwords → red flash, stays on New password panel.
3. Submit a 7-char password → red flash, stays.
4. Submit two matching ≥ 8-char passwords → redirected to `student/portal`, and the user is logged in.
5. Sign out, then sign in again with the new password — works.
6. Sign in with the OLD password — fails (it's been replaced).
7. Inspect `password_reset_otp` — the row is `used = 1`.

- [ ] **Step 5: Commit**

```bash
git add portal.ydi.edu.pk/application/controllers/User.php portal.ydi.edu.pk/application/models/user_model.php
git commit -m "Reset flow: set_new_password (writes hash, regenerates session, signs in)"
```

---

## Task 14: Final end-to-end + screenshot

**Files:** none modified — verification + before/after capture only.

- [ ] **Step 1: Walk the whole positive-path flow in the browser**

Use Playwright MCP. Use a real test student row (its `reg_no`, its `phone`, and a phone you can read SMS on). Capture screenshots at each step.

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "flow-1-login.png")

mcp__playwright__browser_click(element: "Forgot password? link", ref: "a.forgot-link")
mcp__playwright__browser_take_screenshot(filename: "flow-2-identify.png")

mcp__playwright__browser_fill_form(fields: [
  { name: "Registration number", type: "textbox", ref: "#reset_reg_no", value: "<TEST_REG_NO>" },
  { name: "Phone number",         type: "textbox", ref: "#reset_phone",  value: "<TEST_PHONE>"  }
])
mcp__playwright__browser_click(element: "Send code button", ref: "#forgot-identify button.btn-primary")
mcp__playwright__browser_take_screenshot(filename: "flow-3-otp.png")

# (Read the SMS or the temporary error_log debug line for the code.)
mcp__playwright__browser_fill_form(fields: [
  { name: "OTP", type: "textbox", ref: "#reset_otp", value: "<6_DIGIT_CODE>" }
])
mcp__playwright__browser_click(element: "Verify button", ref: "#forgot-otp button.btn-primary")
mcp__playwright__browser_take_screenshot(filename: "flow-4-newpw.png")

mcp__playwright__browser_fill_form(fields: [
  { name: "New password",         type: "textbox", ref: "#new_password",         value: "newpass123" },
  { name: "Confirm new password", type: "textbox", ref: "#new_password_confirm", value: "newpass123" }
])
mcp__playwright__browser_click(element: "Save and sign in", ref: "#forgot-newpw button.btn-primary")
mcp__playwright__browser_wait_for(text: "portal")
mcp__playwright__browser_take_screenshot(filename: "flow-5-portal.png")
```

Expected: each screenshot shows the next panel, and the final screenshot is the post-login portal home (`student/portal`).

- [ ] **Step 2: Capture the final "after" screenshot for the redesign comparison**

```
mcp__playwright__browser_navigate(url: "http://portal.ydi.edu.pk/user/login")
# (clear cookies if needed via mcp__playwright__browser_evaluate("() => document.cookie.split(';').forEach(c => document.cookie = c + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/')"))
mcp__playwright__browser_resize(width: 1280, height: 800)
mcp__playwright__browser_take_screenshot(filename: "portal-login-after.png", fullPage: true)
```

Move the file to the project root as `portal-login-after.png`.

- [ ] **Step 3: Remove any debug `error_log("OTP=$code")` that was added during Task 12**

```bash
grep -n "error_log.*OTP" portal.ydi.edu.pk/application/models/user_model.php
```

Expected: no output. If anything matches, delete the line before committing.

- [ ] **Step 4: Commit the screenshots**

`*.png` is in `.gitignore`, so the screenshots must be force-added (consistent with how Task 1 committed the baseline):

```bash
git add -f portal-login-after.png flow-1-login.png flow-2-identify.png flow-3-otp.png flow-4-newpw.png flow-5-portal.png
git commit -m "Add post-redesign + reset-flow walk-through screenshots"
```

---

## Acceptance review

Walk the spec's acceptance criteria one by one against the running page before declaring done.

**Visual / structural**
1. ☐ `portal.ydi.edu.pk/user/login` renders the new split layout at ≥ 900px.
2. ☐ Below 900px the layout stacks, hero is slim banner.
3. ☐ Validation errors / flash messages render in the new alert style on every panel.
4. ☐ The page no longer references `mis.ydi.edu.pk/images/logo.jpg`:
   ```bash
   grep -n "mis.ydi.edu.pk" portal.ydi.edu.pk/application/views/user/login.php
   ```
   Expected: no output.
5. ☐ No horizontal scroll on desktop or mobile.
6. ☐ Legacy `<fieldset><legend>Student Login</legend>` is gone:
   ```bash
   grep -n "fieldset\|legend" portal.ydi.edu.pk/application/views/user/login.php
   ```
   Expected: no output.

**Login (unchanged behavior)**
7. ☐ Submitting sign-in posts to `user/login` with `username` + `password`, and the controller flow is identical to before (verify by signing in with a known-good student).

**Reset flow**
8. ☐ "Forgot password?" → Identify panel.
9. ☐ Wrong reg_no/phone → generic "If we found a match…" message, **no** new row in `password_reset_otp` (verify with `SELECT MAX(id) FROM password_reset_otp;` before and after).
10. ☐ Right reg_no/phone → SMS sent, row inserted, OTP panel.
11. ☐ Wrong OTP × 5 → row marked `used = 1`, generic error each time.
12. ☐ Right OTP within 10 min → New-password panel.
13. ☐ Two matching ≥ 8-char passwords → password updated, session regenerated, redirected to `student/portal` and signed in.
14. ☐ Migration file runs cleanly:
    ```bash
    mysql ... -e "DESCRIBE password_reset_otp;"
    ```
15. ☐ No plaintext OTP appears anywhere:
    ```bash
    grep -rn "error_log.*OTP\|var_dump.*\$code\|echo.*\$code" portal.ydi.edu.pk/application/
    ```
    Expected: no output.

If any check fails, fix it before merging.
