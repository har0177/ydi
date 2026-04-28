# Portal Login Redesign + SMS Password Reset — Design Spec

**Date:** 2026-04-28 (revised to add SMS reset flow)
**Scope:** Two related changes to `portal.ydi.edu.pk`:
1. Visual redesign of the login surface (`application/views/user/login.php`).
2. A working forgot-password flow via SMS OTP (the legacy `user/forget` action 404s today — there is no `forget()` method on the `User` controller and no `forget()` on `User_model`).

**Goal:** Bring the login page in line with the rest of the polished YDI Student Portal (Inter, slate palette, purple→blue gradients) *and* give students a working self-service password reset that uses the SMS gateway already wired into the codebase.

---

## Context

The student portal has been progressively migrated from the legacy ACE/Bootstrap 3 theme to a Tailwind-utility + `portal-polish.css` overlay (Inter font, slate palette, gradient accents, FB-style profile cover, polished modals, chat widget). The login page at `application/views/user/login.php` is the last major surface still rendering in the old visual language: dark teal background, small white card, orange Login button, legacy `fieldset`/`legend` markup, ACE form helpers, the `mis.ydi.edu.pk` logo image.

The redesign must:

1. Visually match the post-login portal (no jarring transition after sign-in).
2. Stay on the existing CodeIgniter stack with no new build pipeline — CSS overlay + minimal markup change, exactly the pattern already used in `portal-polish.css`.
3. Preserve the existing **login** form contract: same action (`user/login`), same field names (`username`, `password`), same validation/flash-message wiring.
4. Replace the broken email-based "Forgot password" with a working SMS OTP flow that reuses the existing SMS gateway (`AdminLTE::sms($no, $msg)` in `application/helpers/adminlte_helper.php:906`, which posts to `outreach.pk` with the YDI sender mask).

---

## Design direction

**Layout:** Split screen.

- **Left (≈52% width):** Brand hero. Purple→blue mesh gradient identical to the FB-cover gradient already in `portal-polish.css` (`linear-gradient(135deg, #7c3aed 0%, #6d28d9 35%, #3b82f6 100%)`), dotted texture overlay, soft radial highlights. Contents: brand mark + "YDI Student Portal" wordmark, large welcome headline, supporting lede, footer line. (No status pill — see "Out of scope.")
- **Right (≈48% width):** Polished form on a white surface. Slate labels, soft `#f8fafc` inputs that focus to white with a purple ring, password show/hide toggle, "Keep me signed in" checkbox, "Forgot password?" link, full-width purple-gradient "Sign in" button, "Trouble signing in? Contact support" footer.

**Personality:** Cohesive (same gradient, type, radii, and palette as the rest of the portal) *and* welcoming (the hero side gives the page presence rather than treating login as just a chore).

**Responsive behavior:** Below ~900px the split collapses to stacked. The hero shrinks to a slim banner (brand mark + short tagline only, no pill, no lede), then the form below.

**Forgot-password flow:** Three sequential panels swap into the right side (the hero stays put). Each panel has a "Back to sign in" link at the top. The flow is: **(1) Identify** (reg_no + phone) → **(2) Verify** (6-digit OTP from SMS) → **(3) Set new password** (new password + confirm). On success, the user is auto-logged-in and redirected to `student/portal`. Detailed flow under "Password reset (SMS OTP) flow" below.

---

## Visual system (matches existing portal)

| Token | Value |
| --- | --- |
| Font | `Inter`, system-ui fallback (already loaded in `portal-polish.css`) |
| Body bg | `#f8fafc` |
| Surface (form panel) | `#ffffff`, radius `16px`, shadow `0 12px 40px rgba(15, 23, 42, .12)` |
| Hero gradient | `linear-gradient(135deg, #7c3aed 0%, #6d28d9 35%, #3b82f6 100%)` |
| Hero overlays | radial highlights + dotted texture (same as `.cover-sec`) |
| Primary text | `#0f172a` |
| Muted text | `#64748b` |
| Input bg | `#f8fafc`, border `#e2e8f0`, radius `10px`, height `44px` |
| Input focus | bg `#ffffff`, border `#7c3aed`, ring `0 0 0 4px rgba(124,58,237,.12)` |
| Primary button | `linear-gradient(135deg, #7c3aed, #6d28d9)`, white text, radius `10px`, height `46px`, shadow `0 8px 22px rgba(124,58,237,.32)` |
| Brand mark | 32×32 white tile, `#6d28d9` "Y", radius `9px` |

All values are reusable extensions of patterns already in `portal-polish.css` — no new design language is being introduced.

---

## Components

### Brand mark
A simple white rounded-square tile (32×32) with a purple "Y" glyph, replacing the `mis.ydi.edu.pk/images/logo.jpg` image. Reasons: the current logo is a different palette (purple/blue circular logo with "Training & Consultancy" text underneath) that conflicts with the gradient hero, and remote-loading from `mis.ydi.edu.pk` is a fragile dependency for a login page.

The full color logo is not removed from the codebase — it stays available for the post-login portal. The login page just uses the simpler mark.

### Form fields
- **Username** — text input, person/avatar icon on the right, name `username` (unchanged), `required` (unchanged).
- **Password** — password input with a SHOW/HIDE text toggle on the right that flips the input type. Name `password` (unchanged), `required` (unchanged).

### "Keep me signed in"
New checkbox below the password field, left-aligned. Name `remember`. Not currently supported by the backend — the markup is added so the controller can opt in later; for the initial PR the checkbox renders but the backend ignores it (no behavior change, no regression).

### Sign in button
Full-width gradient button. Replaces the small orange `btn-success` `width-35 pull-right` button. Includes a small arrow icon on the right.

### Help line
"Trouble signing in? Contact support" with a `mailto:info@ydi.edu.pk` link. Replaces the lone "I Forgot My Password" link in the toolbar.

### Forgot-password panels (three steps)
Three panels share the right-side surface; the visible one is swapped via the same jQuery class-toggle pattern used for the sign-in panel.

1. **Identify panel** (`#forgot-identify`) — eyebrow "Account recovery," heading "Reset your password," sub "Enter your reg no and the phone number on file. We'll text you a 6-digit code." Two fields (Registration number `reg_no`, Phone number `phone`), button "Send code." Posts to `user/send_reset_code`.
2. **OTP panel** (`#forgot-otp`) — eyebrow "Verify," heading "Enter the code we sent," sub "Check your SMS for a 6-digit code. It expires in 10 minutes." One 6-digit OTP input (single text input, `inputmode="numeric"`, `maxlength="6"`, `pattern="\d{6}"` — keeps markup simple; per-digit boxes are out of scope for v1), button "Verify." Below the button: "Didn't get it?" + "Resend code" link with a 60s cooldown timer in JS. Posts to `user/verify_reset_code`.
3. **New-password panel** (`#forgot-newpw`) — eyebrow "Almost done," heading "Choose a new password," sub "Make it at least 8 characters." Two fields (New password, Confirm password — both with SHOW/HIDE toggles), button "Save and sign in." Posts to `user/set_new_password`.

Generic responses on every step: even if the reg_no doesn't exist, the phone doesn't match, the OTP is wrong, or the OTP expired, the user always sees a non-revealing message ("If we found a match, you'll get an SMS shortly" / "That code didn't work. Try again or request a new one"). Never confirm or deny that a `reg_no` exists.

---

## Password reset (SMS OTP) flow

### Why SMS OTP, not "send the password by SMS"
Passwords in `student.password` are hashed with `secure_password_hash()` (see `application/models/user_model.php`), so the plain password is not recoverable. The reset flow generates a one-time 6-digit code, SMSes it via the existing gateway, and lets the verified user pick a new password. The new password is hashed using the same `secure_password_hash()` helper before it's written.

### Backend pieces

**New table** `password_reset_otp`:

| Column | Type | Notes |
| --- | --- | --- |
| `id` | INT AUTO_INCREMENT PK | |
| `student_id` | INT NOT NULL | FK to `student.id` (no constraint added; existing tables don't use FKs) |
| `otp_hash` | VARCHAR(255) NOT NULL | `password_hash()` of the 6-digit code (NEVER store plaintext) |
| `expires_at` | DATETIME NOT NULL | created_at + 10 minutes |
| `attempts` | TINYINT NOT NULL DEFAULT 0 | incremented on failed verify; row invalidated at 5 |
| `used` | TINYINT(1) NOT NULL DEFAULT 0 | flipped to 1 after a successful verify |
| `created_at` | DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP | |

**Migration:** one-shot SQL file at `portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql`. Manually run by the engineer; the project doesn't have an automated migration system.

**Phone normalization:** Pakistani phone numbers are stored inconsistently in `student.phone` (some with leading `0`, some with `+92`, some bare 10 digits, some with spaces/dashes). Normalize both the user-supplied input and the DB value to the form `92XXXXXXXXXX` (strip non-digits, drop leading `0`, drop leading `+`, prepend `92` if missing) for comparison only — don't rewrite the stored value. The SMS gateway expects the `92XXXXXXXXXX` form (the existing `AdminLTE::sms` example uses `923339471086`).

**New controller methods on `application/controllers/User.php`:**

```php
public function send_reset_code()      // step 1 → step 2
public function verify_reset_code()    // step 2 → step 3
public function set_new_password()     // step 3 → portal
```

**New model methods on `application/models/user_model.php`:**

```php
public function find_by_reg_and_phone($reg_no, $phone) // returns student row or null
public function create_otp($student_id)                // generates code, inserts row, returns plain code
public function consume_otp($student_id, $code)        // validates, increments attempts, marks used; returns bool
public function set_password($student_id, $new_password)
```

**Session keys used during the flow** (cleared on completion or abandonment):

- `pw_reset_student_id` — set by `send_reset_code` after a successful match.
- `pw_reset_verified_at` — Unix timestamp set by `verify_reset_code` when the OTP is accepted. The `set_new_password` step requires this and rejects if older than 10 minutes.
- `pw_reset_last_send_at` — Unix timestamp of the last `send_reset_code` call for this session, used to enforce the 60-second resend cooldown server-side.

**SMS message template** (sent via `AdminLTE::sms($phone92, $msg)`):

> `YDI password reset code: 123456. Expires in 10 minutes. Do not share this code.`

### Rate limiting & abuse prevention

| Surface | Limit | Enforced where |
| --- | --- | --- |
| `send_reset_code` per session | 1 per 60 seconds | `pw_reset_last_send_at` session check |
| `send_reset_code` per phone | 5 per rolling 24h | `password_reset_otp` row count for the matching `student_id` in the last 24h |
| `verify_reset_code` attempts per OTP | 5 | `password_reset_otp.attempts` column; after 5 the row is marked `used = 1` and rejected |
| OTP lifetime | 10 minutes | `password_reset_otp.expires_at` |
| Password reset window after verify | 10 minutes | `pw_reset_verified_at` session check |

When a limit trips, the user sees a generic "Too many attempts. Please try again later." message — never a count, never a remaining-time hint that could be probed.

### Acceptance criteria for the reset flow

1. Visiting the login page and clicking "Forgot password?" shows the **Identify** panel.
2. Submitting a non-matching `reg_no`/`phone` shows the same generic success message as a matching pair (no enumeration). Internally, no SMS is sent and no row is inserted for non-matches.
3. Submitting a matching `reg_no`/`phone` SMSes a 6-digit code to the normalized phone via `AdminLTE::sms`, inserts a `password_reset_otp` row, and shows the **OTP** panel.
4. Entering a wrong OTP increments `attempts` and shows a generic error. After the 5th failure, the OTP is invalidated and the user is sent back to the **Identify** panel with a "Please request a new code" message.
5. Entering the correct OTP within 10 minutes flips `used = 1`, sets `pw_reset_verified_at`, and shows the **New password** panel.
6. Submitting two matching passwords (≥ 8 chars) writes the hashed password to `student.password`, clears all `pw_reset_*` session keys, regenerates the session ID (per existing login pattern), logs the user in, and redirects to `student/portal`.
7. The flow can be abandoned at any panel with "Back to sign in" — session keys are cleared on click.
8. The Resend link in the OTP panel is disabled for 60 seconds after the previous send. The countdown is rendered in the link text ("Resend code (47s)").

---

## Markup & CSS strategy

**Markup:** `application/views/user/login.php` is rewritten. The new markup uses semantic elements (`<main>`, `<aside>`, `<form>`, `<label>`) and a small set of new class names scoped under a single root class (e.g. `.login-v2`) so it doesn't collide with anything else in the portal. The existing CodeIgniter form helpers stay (`form_open`, `validation_errors`, `flash_alert`).

**CSS:** All new styles go in a new file `application/views/user/../../assets/css/portal-login.css` (or appended to `portal-polish.css` under a `/* === Login page === */` section — implementation plan can decide). Either way: scoped under `.login-v2` so it cannot leak. The legacy ACE stylesheets (`bootstrap.min.css`, `ace.min.css`, `font-awesome.css`) can be dropped from the login view since the new design doesn't depend on them — but the implementation plan should verify nothing else inherits from them on this page first.

**JS:** A small inline script (jQuery, since jQuery is already loaded for the portal) handles: (1) the SHOW/HIDE password toggles, (2) panel swapping via `data-target` attributes (sign-in ↔ identify ↔ otp ↔ new-password), (3) submit-disable on form post (prevents double-submits), (4) the 60-second resend cooldown on the OTP panel (countdown text on the resend link). All other behavior is server-driven — the server decides which panel is `visible` on each render, keyed off session state.

**Server-driven panel visibility:** When the page renders, the controller passes a `$active_panel` template variable (one of `login`, `forgot-identify`, `forgot-otp`, `forgot-newpw`). The view applies the `visible` class to the matching panel. This keeps the right panel showing after a server-side redirect (e.g. after a wrong OTP, the page reloads on the OTP panel, not the sign-in panel). Default is `login`.

**Inline assets only.** No new build step, no Tailwind compile, no React. Same constraints `portal-polish.css` operates under.

---

## Error & loading states

- **Validation errors:** keep the existing `validation_errors('<div class="alert alert-danger">', '</div>')` block, but restyle `.alert-danger` for this page (rose-50 bg, rose-200 border, rose-700 text, radius `10px`, no Bootstrap chrome). Renders above the first field.
- **Flash messages:** keep the `flash_alert()` call. Same restyle treatment as validation errors.
- **Submit loading:** the Sign-in button gets a `:disabled` style (slightly desaturated gradient, `cursor: not-allowed`) and a small spinner replaces the arrow. Form submission disables the button on submit via inline JS.
- **Network/server error:** unchanged from current behavior — the controller redirects back with a flash message, which renders in the alert slot.

---

## Out of scope (explicitly)

- Backend changes to the **login** path (`User::login`, `User_model::login`, session handling on success). Only the new reset methods are added.
- "Remember me" actually working — markup only for now (see component note above).
- Social login, SSO, captcha — none currently exist; not adding them.
- Email-based password reset — replaced wholesale by the SMS OTP flow; the legacy `user/forget` route is repurposed (or left to 404 with the new routes taking over — see `forgot-password panels` for new actions).
- Per-digit OTP boxes (the fancy 6-cell input). v1 uses a single 6-digit numeric input.
- Allowing students with no phone on file to reset. If `student.phone` is empty for a matched `reg_no`, treat it the same as no match (generic message; user must contact info@ydi.edu.pk).
- Updating the `mis.ydi.edu.pk` admin login — different app, different scope.
- Any hero-side dynamic content (status pill, announcements, cohort info, stats). The page must not display hardcoded or dummy content. If a dynamic-content slot is added later, it must be sourced from the database/controller.
- Refactoring the SMS gateway away from the hardcoded `outreach.pk` credentials. That's a separate piece of tech debt; v1 uses the helper as-is.

---

## Acceptance criteria

**Visual / structural**

1. Visiting `portal.ydi.edu.pk/user/login` renders the new split layout on desktop ≥ 900px.
2. Below 900px the layout stacks, with the hero shrunk to a banner.
3. Validation errors and flash messages render in the new alert style above the first field on every panel.
4. The page no longer depends on `mis.ydi.edu.pk/images/logo.jpg` (no remote logo image).
5. No horizontal scroll on desktop or mobile, and no contrast failures on the gradient hero.
6. The legacy `<fieldset><legend>Student Login</legend>` block is gone.

**Login (unchanged behavior)**

7. Submitting the sign-in form posts to `user/login` with `username` + `password` exactly as before; existing controller and model logic is unchanged.

**Reset flow**

8. Clicking "Forgot password?" swaps the right side to the **Identify** panel.
9. The acceptance points listed under "Password reset (SMS OTP) flow → Acceptance criteria for the reset flow" all hold.
10. The `password_reset_otp` table exists and the migration SQL (`portal.ydi.edu.pk/sql/2026-04-28-add-password-reset-otp.sql`) runs cleanly on a fresh DB.
11. No plaintext OTP is ever written to the database, the session, or any log line.

---

## Open questions to resolve during implementation

- Decide whether to keep the new styles in `portal-polish.css` or split into a dedicated `portal-login.css`. Default: dedicated file, loaded only on the login view.
