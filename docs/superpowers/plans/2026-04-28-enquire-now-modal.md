# Enquire Now Modal Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a service-aware "Enquire Now" modal that opens from individual service pages (`program.php` and `trainings.php`), pre-fills the service name, submits via AJAX, and routes to `info@ydi.edu.pk`.

**Architecture:** A single Alpine.js-driven modal partial included site-wide via `footer.php`. Trigger buttons set `enquireService` + `enquireOpen` on the root `<body>` Alpine scope. The form POSTs to the existing `send_email.php` endpoint (extended to handle an `is_enquiry=1` path), which writes to `tblcontact` (with two new columns) and emails the inbox.

**Tech Stack:** PHP 7+, MySQL/MariaDB, Tailwind CSS (CDN), Alpine.js 3 (CDN), Playwright (e2e tests).

**Spec:** `docs/superpowers/specs/2026-04-28-enquire-now-modal-design.md`

**Pre-flight notes for the implementing engineer:**
- Project root: `C:/laragon/www/ydi-all/`. The website is served from `public_html/` at `http://localhost/ydi-all/public_html/`.
- The site uses Laragon (Windows Apache + MySQL). MySQL is reachable via `mysql` CLI on the PATH or via Laragon's MySQL prompt. DB credentials are in `public_html/config.php` — read them, don't hard-code.
- Existing CSRF helpers: `csrfField()` (form output), `validateCsrfToken()` (server check). Both live in `public_html/inc/csrf.php`.
- The existing contact form (in `footer.php`) uses field name `message` (not `msg`). Stay consistent.
- The honeypot/JS-marker is `bcheck=true` — the existing code rejects submissions where `$_POST['bcheck'] !== 'true'`. The new modal form must also send it.
- There's an existing "Enquire Now" button in `program.php` at lines 59–65 — this is the one we're rewiring. Don't add a second.

---

## File Structure

| File | Action | Responsibility |
|------|--------|----------------|
| `public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql` | NEW | One-shot DB migration to add `phone` and `service` columns |
| `public_html/inc/enquiry-modal.php` | NEW | Modal markup + Alpine.js form logic + AJAX submit script |
| `public_html/header.php` | MODIFY | Extend root `<body>` `x-data` to add `enquireOpen` + `enquireService` |
| `public_html/footer.php` | MODIFY | `require` the modal partial near close of body |
| `public_html/program.php` | MODIFY | Replace existing "Enquire Now" anchor (lines 59–65) with a button that opens the modal |
| `public_html/trainings.php` | MODIFY | Replace 6 "Learn More" links on service cards with "Enquire Now" buttons |
| `public_html/send_email.php` | MODIFY | Branch on `is_enquiry=1`: validate phone+service, build subject from service, include phone+service in DB row + email body, swap user-confirmation copy |
| `tests/enquiry-modal.spec.js` | NEW | Playwright e2e test for the modal open + submit + success state |

---

## Task 1: Add DB columns to `tblcontact`

**Files:**
- Create: `public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql`

- [ ] **Step 1: Write the migration SQL**

Create `public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql`:

```sql
-- Adds phone + service columns for Enquire Now modal submissions.
-- Both columns are nullable so existing contact form submissions remain valid.

ALTER TABLE tblcontact
  ADD COLUMN phone VARCHAR(32) NULL AFTER email,
  ADD COLUMN service VARCHAR(255) NULL AFTER phone;
```

- [ ] **Step 2: Read DB credentials from config**

Open `public_html/config.php` and note the values for `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` (variable names may differ — copy whatever the file uses). You'll need them for the next step.

- [ ] **Step 3: Apply the migration**

From a Laragon terminal (or any shell with `mysql` on PATH):

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> < public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql
```

(Note: no space between `-p` and the password. If the password is empty, omit `-p<DB_PASS>` entirely.)

Expected: command exits with code 0, no output.

- [ ] **Step 4: Verify the columns exist**

Run:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "DESCRIBE tblcontact;"
```

Expected: output includes rows for `phone` (`varchar(32)`, `YES` null) and `service` (`varchar(255)`, `YES` null).

- [ ] **Step 5: Commit**

```bash
git add public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql
git commit -m "Add phone and service columns to tblcontact for enquiries"
```

---

## Task 2: Extend `send_email.php` to handle the enquiry path

**Files:**
- Modify: `public_html/send_email.php`

- [ ] **Step 1: Read the current `send_email.php` end-to-end**

Open `public_html/send_email.php`. Confirm the existing flow: CSRF check → field extraction → validation → DB insert → admin email → user confirmation email → `200 OK`.

- [ ] **Step 2: Add enquiry-aware field extraction**

Find the block that extracts `$name`, `$email`, `$subject`, `$message` (around lines 25–28). Replace that block with:

```php
$is_enquiry = isset($_POST['is_enquiry']) && $_POST['is_enquiry'] === '1';

$name    = htmlspecialchars(trim($_POST['name'] ?? ''));
$email   = trim($_POST['email'] ?? '');
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if ($is_enquiry) {
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $subject = 'YDI Enquiry: ' . ($service !== '' ? $service : 'Service Enquiry');
} else {
    $phone   = '';
    $service = '';
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
}
```

- [ ] **Step 3: Add enquiry-specific validation**

Find the validation block (around lines 31–39, the `if (empty(...))` and `filter_var(...)` checks). Replace with:

```php
// Common required fields
if (empty($name) || empty($email) || empty($message)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Please fill in all required fields');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid email address');
}

if ($is_enquiry) {
    if (empty($phone) || empty($service)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Please fill in all required fields');
    }
    if (!preg_match('/^[0-9 +\-()]{6,32}$/', $phone)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Invalid phone number');
    }
} else {
    if (empty($subject)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Please fill in all required fields');
    }
}
```

- [ ] **Step 4: Update the DB insert to write the new columns**

Find the `INSERT INTO tblcontact ...` block (around lines 45–53). Replace with:

```php
try {
    $db = new database();
    $db->runQuery(
        "INSERT INTO tblcontact (title, name, short_description, email, phone, service, status, post_date, ip) VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?)",
        [
            cleanString($subject),
            cleanString($name),
            cleanString($message),
            $email,
            $is_enquiry ? cleanString($phone) : null,
            $is_enquiry ? cleanString($service) : null,
            $post_date,
            $ip,
        ]
    );
} catch (PDOException $e) {
    // Continue even if DB save fails — email is the user-facing path
}
```

- [ ] **Step 5: Update the admin email body**

Find the `$email_body = "New contact form submission:\n\n";` block (around lines 56–62). Replace the body construction (everything from that line up to and including the `$email_body .= "Message:\n$message\n";` line) with:

```php
if ($is_enquiry) {
    $email_body  = "New service enquiry from the YDI website:\n\n";
    $email_body .= "Service: $service\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Date: $post_date\n";
    $email_body .= "IP: $ip\n\n";
    $email_body .= "Message:\n$message\n";
} else {
    $email_body  = "New contact form submission:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Date: $post_date\n";
    $email_body .= "IP: $ip\n\n";
    $email_body .= "Message:\n$message\n";
}
```

- [ ] **Step 6: Update the user confirmation email**

Find the `$user_body = "Dear $name,\n\n";` block (around lines 72–80). Replace the entire user-body construction with:

```php
if ($is_enquiry) {
    $user_body  = "Dear $name,\n\n";
    $user_body .= "Thank you for contacting us. Our customer service team will get back to you soon.\n\n";
    $user_body .= "Your enquiry:\n";
    $user_body .= "Service: $service\n";
    $user_body .= "$message\n\n";
    $user_body .= "Best regards,\n";
    $user_body .= "YDI Team\n";
    $user_body .= "www.ydi.edu.pk";

    $user_subject = 'Thank you for your enquiry - YDI';
} else {
    $user_body  = "Dear $name,\n\n";
    $user_body .= "Thank you for contacting Youth Development Institute, Swat.\n\n";
    $user_body .= "We have received your message and will get back to you shortly.\n\n";
    $user_body .= "Your message:\n";
    $user_body .= "Subject: $subject\n";
    $user_body .= "$message\n\n";
    $user_body .= "Best regards,\n";
    $user_body .= "YDI Team\n";
    $user_body .= "www.ydi.edu.pk";

    $user_subject = 'Thank you for contacting YDI';
}
```

Then find the `@mail($email, "Thank you for contacting YDI", $user_body, $user_headers);` line and change the subject argument to use the variable:

```php
@mail($email, $user_subject, $user_body, $user_headers);
```

- [ ] **Step 7: Manual smoke test (regression — existing contact form)**

Start Laragon if not already running. Open `http://localhost/ydi-all/public_html/index.php` in a browser. Scroll to the "Send us a Message" footer form. Fill in name/email/subject/message. Submit.

Expected: green success toast appears, no JavaScript console errors, a new row appears in `tblcontact` with `phone` and `service` both NULL. Confirm via:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "SELECT id, title, name, email, phone, service FROM tblcontact ORDER BY id DESC LIMIT 1;"
```

- [ ] **Step 8: Commit**

```bash
git add public_html/send_email.php
git commit -m "Extend send_email.php to handle service enquiries"
```

---

## Task 3: Create the modal partial

**Files:**
- Create: `public_html/inc/enquiry-modal.php`

- [ ] **Step 1: Create the partial file with the full markup**

Create `public_html/inc/enquiry-modal.php` with the following content (this is the complete file — paste verbatim):

```php
<?php
/**
 * Enquiry Modal Partial
 * Included from footer.php. Reads Alpine state `enquireOpen` and `enquireService`
 * from the root <body> x-data scope (defined in header.php).
 */
?>
<div
    x-show="enquireOpen"
    x-cloak
    @keydown.escape.window="enquireOpen = false"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto"
    style="display:none;"
>
    <!-- Backdrop -->
    <div
        @click="enquireOpen = false"
        x-show="enquireOpen"
        x-transition.opacity
        class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"
    ></div>

    <!-- Card -->
    <div
        x-show="enquireOpen"
        x-transition
        x-data="enquiryForm()"
        class="relative w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden my-8"
    >
        <!-- Header -->
        <div class="flex items-start justify-between p-6 border-b border-slate-200 dark:border-slate-700">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Enquire Now</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1" x-show="!submitted">
                    About: <span class="font-medium text-primary-500" x-text="enquireService"></span>
                </p>
            </div>
            <button
                type="button"
                @click="enquireOpen = false"
                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                aria-label="Close"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form
            x-show="!submitted"
            @submit.prevent="submit"
            class="p-6 space-y-4"
        >
            <?php echo csrfField(); ?>
            <input type="hidden" name="bcheck" value="true">
            <input type="hidden" name="is_enquiry" value="1">
            <input type="hidden" name="service" :value="enquireService">

            <!-- Name -->
            <div>
                <label for="enquireName" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name</label>
                <input
                    type="text" name="name" id="enquireName" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="Your full name"
                >
            </div>

            <!-- Phone -->
            <div>
                <label for="enquirePhone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Phone Number</label>
                <input
                    type="tel" name="phone" id="enquirePhone" required
                    pattern="[0-9 +\-()]{6,32}"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="e.g. +92 300 1234567"
                >
            </div>

            <!-- Email -->
            <div>
                <label for="enquireEmail" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input
                    type="email" name="email" id="enquireEmail" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="you@example.com"
                >
            </div>

            <!-- Service (read-only display) -->
            <div>
                <label for="enquireServiceField" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Service</label>
                <input
                    type="text" id="enquireServiceField" readonly
                    :value="enquireService"
                    class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white cursor-not-allowed"
                >
            </div>

            <!-- Message -->
            <div>
                <label for="enquireMessage" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Message / Query</label>
                <textarea
                    name="message" id="enquireMessage" rows="4" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors resize-none"
                    placeholder="Tell us what you'd like to know..."
                ></textarea>
            </div>

            <!-- Inline error -->
            <div x-show="errorMessage" x-cloak class="p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-300" x-text="errorMessage"></div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="submitting"
                class="w-full py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0"
            >
                <span x-show="!submitting">Submit Enquiry</span>
                <span x-show="submitting" x-cloak class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Sending...
                </span>
            </button>
        </form>

        <!-- Success state -->
        <div x-show="submitted" x-cloak class="p-8 text-center" data-test="enquiry-success">
            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Thank you!</h4>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Thank you for contacting us. Our customer service team will get back to you soon.</p>
            <button
                type="button"
                @click="enquireOpen = false; resetForm()"
                class="px-6 py-2.5 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition-colors"
            >
                Close
            </button>
        </div>
    </div>
</div>

<script>
function enquiryForm() {
    return {
        submitting: false,
        submitted: false,
        errorMessage: '',
        async submit(event) {
            this.errorMessage = '';
            this.submitting = true;
            try {
                const formData = new FormData(event.target);
                const response = await fetch('send_email.php', {
                    method: 'POST',
                    body: formData
                });
                if (response.ok) {
                    this.submitted = true;
                    event.target.reset();
                } else {
                    const text = await response.text();
                    this.errorMessage = text || 'Failed to send. Please try again.';
                }
            } catch (err) {
                this.errorMessage = 'Network error. Please try again.';
            } finally {
                this.submitting = false;
            }
        },
        resetForm() {
            this.submitted = false;
            this.errorMessage = '';
        }
    };
}
</script>
```

- [ ] **Step 2: Verify the partial parses without PHP errors**

Run from a Laragon terminal:

```bash
php -l public_html/inc/enquiry-modal.php
```

Expected output: `No syntax errors detected in public_html/inc/enquiry-modal.php`

- [ ] **Step 3: Commit**

```bash
git add public_html/inc/enquiry-modal.php
git commit -m "Add Enquire Now modal partial"
```

---

## Task 4: Wire the modal into every page (header + footer changes)

**Files:**
- Modify: `public_html/header.php`
- Modify: `public_html/footer.php`

- [ ] **Step 1: Extend root `<body>` Alpine state in `header.php`**

Open `public_html/header.php`. Find line 127:

```php
<body class="font-sans bg-white text-slate-800" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="{ 'dark bg-slate-900 text-slate-200': darkMode }">
```

Replace it with:

```php
<body class="font-sans bg-white text-slate-800" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false, enquireOpen: false, enquireService: '' }" :class="{ 'dark bg-slate-900 text-slate-200': darkMode }">
```

- [ ] **Step 2: Include the modal partial from `footer.php`**

Open `public_html/footer.php`. Find the closing `</body>` tag (line 334). Insert the modal include immediately before it:

```php
<?php require __DIR__ . '/inc/enquiry-modal.php'; ?>
</body>
```

- [ ] **Step 3: Manual sanity check — modal does not appear unless triggered**

Reload `http://localhost/ydi-all/public_html/index.php` in a browser. Expected: page renders normally, no modal visible, no JS console errors.

In the browser console, run:

```js
document.querySelector('body').__x.$data.enquireOpen = true;
document.querySelector('body').__x.$data.enquireService = 'Test Service';
```

Expected: modal appears, "About: Test Service" line is visible, the read-only Service field shows "Test Service". Click the X or press ESC — modal closes.

(Note: In Alpine 3 the property accessor may differ; if `__x` is undefined, the simpler verification is to skip this and rely on Task 5/6's button-driven test.)

- [ ] **Step 4: Commit**

```bash
git add public_html/header.php public_html/footer.php
git commit -m "Mount Enquire Now modal site-wide via footer"
```

---

## Task 5: Wire the "Enquire Now" button on `program.php`

**Files:**
- Modify: `public_html/program.php`

- [ ] **Step 1: Replace the existing anchor with a modal-trigger button**

Open `public_html/program.php`. Find lines 59–65 (the `<a href="contact.php" ...>Enquire Now</a>` block inside the Quick Info Card). Replace those lines with:

```php
                            <button
                                type="button"
                                data-service="<?php echo htmlspecialchars($program->p_title, ENT_QUOTES, 'UTF-8'); ?>"
                                @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Enquire Now
                            </button>
```

(Using a `data-service` attribute with `htmlspecialchars(..., ENT_QUOTES)` cleanly handles apostrophes, quotes, and other special chars in program titles. `$program->p_title` is the raw title — pass it to `htmlspecialchars` here, not the already-escaped `$title` variable, so we don't double-encode.)

- [ ] **Step 2: Verify the file still parses**

```bash
php -l public_html/program.php
```

Expected: `No syntax errors detected in public_html/program.php`

- [ ] **Step 3: Manual smoke test**

Open a real program in the browser, e.g.:

```
http://localhost/ydi-all/public_html/program.php?id=1
```

(Use any valid `id` — find one with `mysql ... -e "SELECT p_id, p_title FROM programs LIMIT 5;"` if needed.)

Click "Enquire Now". Expected: modal opens, "About: <program title>" header shows the program's actual title, Service field is pre-filled with the title.

- [ ] **Step 4: Commit**

```bash
git add public_html/program.php
git commit -m "Wire program.php Enquire Now button to modal"
```

---

## Task 6: Wire the 6 service cards on `trainings.php`

**Files:**
- Modify: `public_html/trainings.php`

- [ ] **Step 1: Replace each "Learn More" anchor with an "Enquire Now" button**

Open `public_html/trainings.php`. The 6 cards live at roughly lines 33–134, each with a `<a href="contact.php" ...>Learn More ...</a>` block. The service titles per card (in source order) are:

1. `Teachers' Development`
2. `Students' Development`
3. `English Proficiency`
4. `Creative Writing`
5. `Film Making`
6. `Photography`

For **each** card, locate the anchor that currently looks like:

```php
                <a href="contact.php" class="inline-flex items-center gap-2 text-<color>-500 font-medium">
                    Learn More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
```

…and replace the anchor with a button using a `data-service` attribute (same clean pattern as program.php). Substitute `<COLOR>` with each card's existing color and `<SERVICE>` with the title:

```php
                <button
                    type="button"
                    data-service="<SERVICE>"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-<COLOR>-500 font-medium hover:text-<COLOR>-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
```

Do this for all six cards in order. Concrete mapping (use the HTML-escaped form for the `data-service` attribute value — `&#039;` is the HTML entity for an apostrophe; the browser decodes it back to `'` when reading `dataset.service`):

| Card | `<COLOR>` | `<SERVICE>` (paste literally as the data-service value) |
|------|-----------|------|
| 1 | `primary` | `Teachers&#039; Development` |
| 2 | `green`   | `Students&#039; Development` |
| 3 | `blue`    | `English Proficiency` |
| 4 | `purple`  | `Creative Writing` |
| 5 | `pink`    | `Film Making` |
| 6 | `amber`   | `Photography` |

(For example, card 1's button starts with `data-service="Teachers&#039; Development"`. The browser decodes the entity, so `event.currentTarget.dataset.service` returns the JS string `Teachers' Development`, which is what gets bound to `enquireService` and submitted to the server.)

- [ ] **Step 2: Verify the file parses and has no leftover `Learn More`**

```bash
php -l public_html/trainings.php
grep -c "Learn More" public_html/trainings.php
```

Expected: `No syntax errors detected ...` and the grep returns `0`.

- [ ] **Step 3: Manual smoke test**

Open `http://localhost/ydi-all/public_html/trainings.php`. For each of the 6 cards, click "Enquire Now". Expected: modal opens with the correct service in the header line ("About: ...") and pre-filled in the Service field.

- [ ] **Step 4: Commit**

```bash
git add public_html/trainings.php
git commit -m "Replace Learn More with Enquire Now on trainings cards"
```

---

## Task 7: End-to-end Playwright test for the modal flow

**Files:**
- Create: `tests/enquiry-modal.spec.js`

- [ ] **Step 1: Write the e2e test**

Create `tests/enquiry-modal.spec.js`:

```javascript
// @ts-check
const { test, expect } = require('@playwright/test');

const BASE_URL = 'http://localhost/ydi-all/public_html';

test.describe('Enquire Now modal', () => {

  test('opens from a trainings.php card with the correct service pre-filled', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);

    // Click the first "Enquire Now" button (Teachers' Development card)
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    // Modal heading
    await expect(page.getByRole('heading', { name: 'Enquire Now' })).toBeVisible();

    // Service field is read-only and pre-filled
    const serviceField = page.locator('#enquireServiceField');
    await expect(serviceField).toBeVisible();
    await expect(serviceField).toHaveValue("Teachers' Development");
    await expect(serviceField).toHaveAttribute('readonly', '');
  });

  test('closes when the close button is clicked', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();
    await expect(page.locator('#enquireServiceField')).toBeVisible();

    await page.getByRole('button', { name: 'Close' }).click();
    await expect(page.locator('#enquireServiceField')).toBeHidden();
  });

  test('closes when ESC is pressed', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();
    await expect(page.locator('#enquireServiceField')).toBeVisible();

    await page.keyboard.press('Escape');
    await expect(page.locator('#enquireServiceField')).toBeHidden();
  });

  test('submits successfully and shows the thank-you message', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    await page.locator('#enquireName').fill('Playwright Tester');
    await page.locator('#enquirePhone').fill('+92 300 1234567');
    await page.locator('#enquireEmail').fill('playwright@example.com');
    await page.locator('#enquireMessage').fill('This is an automated test enquiry. Please disregard.');

    await page.getByRole('button', { name: /Submit Enquiry/i }).click();

    // Success panel
    const success = page.locator('[data-test="enquiry-success"]');
    await expect(success).toBeVisible({ timeout: 10000 });
    await expect(success).toContainText('Thank you for contacting us. Our customer service team will get back to you soon.');
  });

  test('shows an inline error when submitting with invalid phone', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    // Bypass the HTML5 pattern check by removing the attribute, so the request reaches the server
    await page.locator('#enquirePhone').evaluate(el => el.removeAttribute('pattern'));

    await page.locator('#enquireName').fill('Bad Phone Tester');
    await page.locator('#enquirePhone').fill('not-a-phone');
    await page.locator('#enquireEmail').fill('bad@example.com');
    await page.locator('#enquireMessage').fill('Triggering server-side phone validation.');

    await page.getByRole('button', { name: /Submit Enquiry/i }).click();

    await expect(page.getByText('Invalid phone number')).toBeVisible({ timeout: 10000 });
  });
});
```

- [ ] **Step 2: Run the new tests**

From the project root:

```bash
npx playwright test tests/enquiry-modal.spec.js
```

Expected: 5 tests pass. If Playwright reports the dev server isn't reachable, ensure Laragon is running and `http://localhost/ydi-all/public_html/index.php` returns 200 in a browser.

- [ ] **Step 3: Confirm a real DB row was created (cleanup the test row afterwards)**

Run:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "SELECT id, title, name, email, phone, service FROM tblcontact WHERE email = 'playwright@example.com' ORDER BY id DESC LIMIT 1;"
```

Expected: one row, `title = 'YDI Enquiry: Teachers\' Development'`, `service = "Teachers' Development"`, `phone = '+92 300 1234567'`.

Cleanup:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "DELETE FROM tblcontact WHERE email IN ('playwright@example.com', 'bad@example.com');"
```

- [ ] **Step 4: Commit**

```bash
git add tests/enquiry-modal.spec.js
git commit -m "Add Playwright e2e test for Enquire Now modal"
```

---

## Task 8: Final verification + manual regression sweep

**Files:** none (verification only)

- [ ] **Step 1: Verify program page enquiry end-to-end**

Open `http://localhost/ydi-all/public_html/program.php?id=<known-good-id>` in a browser. Click "Enquire Now". Fill in:

- Name: `Manual Tester`
- Phone: `+92 300 0000000`
- Email: `manualtest@example.com`
- Message: `Manual end-to-end test via program page.`

Submit.

Expected:
1. Sending spinner appears, then form swaps to the green check + thank-you copy.
2. Modal can be closed via the in-modal "Close" button.

Verify the DB row:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "SELECT id, title, name, phone, service FROM tblcontact WHERE email = 'manualtest@example.com' ORDER BY id DESC LIMIT 1;"
```

Expected: row exists, `service` matches the program title, `phone` populated, `title` starts with `YDI Enquiry: `.

Cleanup:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "DELETE FROM tblcontact WHERE email = 'manualtest@example.com';"
```

- [ ] **Step 2: Regression check — existing `contact.php` form**

Open `http://localhost/ydi-all/public_html/contact.php`. Fill out the form (Name, Email, Subject, Message) and submit.

Expected: green success banner appears (`Thank you! Your message has been sent successfully.`), no JS console errors. (This form is the server-rendered version, not AJAX — confirms `send_email.php` is not the only path for non-enquiry submissions, and that the new code didn't break `contact.php`'s own POST handler.)

- [ ] **Step 3: Regression check — homepage AJAX contact form**

Open `http://localhost/ydi-all/public_html/index.php`. Scroll to the footer "Send us a Message" form. Submit a non-enquiry message via the AJAX form.

Expected: green success toast appears. Verify in DB:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> -e "SELECT id, title, phone, service FROM tblcontact ORDER BY id DESC LIMIT 1;"
```

Expected: row exists, `phone` and `service` are both `NULL` (proving the new columns don't break legacy submissions). Cleanup the row.

- [ ] **Step 4: Mobile viewport spot-check**

In Chrome DevTools, set the device to iPhone SE (375×667). Reload `trainings.php`. Click "Enquire Now" on any card.

Expected: modal is centered, scrollable if content exceeds viewport, all fields reachable, Submit button visible at the bottom.

- [ ] **Step 5: Run the full Playwright suite once more**

```bash
npx playwright test tests/enquiry-modal.spec.js
```

Expected: 5/5 pass.

- [ ] **Step 6: No-op commit (only if anything was tweaked during smoke testing)**

If smoke testing surfaced fixes, commit them with a clear message. If everything is clean, no commit needed.

---

## Done When

- All tasks above have every checkbox ticked.
- `npx playwright test tests/enquiry-modal.spec.js` passes 5/5.
- A real submission from `program.php` and from a `trainings.php` card both result in a `tblcontact` row with `title` starting `YDI Enquiry:`, `phone` and `service` populated.
- The existing footer AJAX contact form and the standalone `contact.php` form both still submit successfully and create rows with `phone` and `service` set to `NULL`.
- No JavaScript console errors on `program.php`, `trainings.php`, or `index.php`.
