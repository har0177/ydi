# Enquire Now Modal — Design Spec

**Date:** 2026-04-28
**Author:** Haroon Yousaf (with Claude)
**Status:** Draft — pending user review

## Goal

Let prospective clients enquire about a specific YDI service (IELTS Training, English Training, STEM Training, etc.) without leaving the page they're reading. Replace the current behavior where clicking buttons on `program.php` and `trainings.php` navigates to the generic `contact.php` page.

## User Flow

1. User visits a program page (`program.php?id=X`) or the training services page (`trainings.php`).
2. User clicks an "Enquire Now" button on the program/service of interest.
3. A modal opens overlaying the page. The "Service" field is pre-filled (read-only) with the program/service name.
4. User fills in Name, Phone, Email, and Message. Submits.
5. Form submits via AJAX to `send_email.php`. On success, the modal swaps its content for the confirmation message: *"Thank you for contacting us. Our customer service team will get back to you soon."*
6. Email is delivered to `info@ydi.edu.pk` with the service name in the subject; submission is also logged to `tblcontact` for backup.
7. User dismisses the modal (or it auto-closes after a few seconds).

## Scope

**In scope:**
- Modal trigger buttons on:
  - `program.php` — replace the existing "Enquire Now" button's behavior (currently links to `contact.php`).
  - `trainings.php` — replace the 6 service cards' "Learn More" links; rename them to "Enquire Now" and wire them to the modal.
- Shared modal partial included site-wide via `footer.php`.
- Extending `send_email.php` to accept `phone` and `service` fields.
- Schema additions to `tblcontact`.

**Out of scope:**
- Per-service email routing (single inbox `info@ydi.edu.pk` for all enquiries).
- Admin UI changes to view enquiries (existing admin views over `tblcontact` are reused as-is).
- Touching `consultancy.php`, `quiz.php`, `gallery.php`, or other unrelated pages.
- Rewriting the existing `contact.php` form.

## Architecture

### Frontend

**New file:** `public_html/inc/enquiry-modal.php`

A single Alpine.js-driven modal partial. Contains:
- Hidden by default (`x-show="enquireOpen"`).
- Backdrop + centered card with the form.
- Form fields: Name (required), Phone (required), Email (required), Service (read-only, pre-filled), Message (required, textarea), CSRF token, hidden `bcheck=true` honeypot, hidden `is_enquiry=1` flag.
- Submit handler uses `fetch()` to POST to `send_email.php`, then toggles the modal body to a success state.
- Inline error display for validation failures.
- ESC key + backdrop click + close button all dismiss.

**Inclusion point:** rendered once near the bottom of `public_html/footer.php`, inside the body's Alpine.js `x-data` scope (the existing root `<body x-data="{...}">` in `header.php` is extended to also expose `enquireOpen` and `enquireService`).

**Triggering pattern:**
```html
<button @click="enquireService = 'IELTS Training'; enquireOpen = true">Enquire Now</button>
```

The service name is set via Alpine state, then bound into the form's `service` input via `x-model` / `:value`.

### Backend

**Modified file:** `public_html/send_email.php`

Add handling for two new optional fields:
- `phone` (required when `is_enquiry=1`)
- `service` (required when `is_enquiry=1`)

Behavior changes:
- If `is_enquiry=1`:
  - Email subject becomes: `YDI Enquiry: {service}`
  - Email body includes `Service:` and `Phone:` lines before the message.
  - DB insert into `tblcontact` populates the new `phone` and `service` columns.
  - User confirmation email body is reworded: *"Thank you for contacting us. Our customer service team will get back to you soon."*
- If `is_enquiry` is absent: existing contact-form behavior is unchanged.

Validation: phone is validated as non-empty + simple length/character check (digits, spaces, `+`, `-`, `(`, `)` only). Email validation is unchanged. CSRF and honeypot checks are unchanged.

### Database

**Migration:** `public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql`

```sql
ALTER TABLE tblcontact
  ADD COLUMN phone VARCHAR(32) NULL AFTER email,
  ADD COLUMN service VARCHAR(255) NULL AFTER phone;
```

Both columns are nullable so existing contact-form submissions continue to work without changes.

## Components & Files

| File | Action | Purpose |
|------|--------|---------|
| `public_html/inc/enquiry-modal.php` | NEW | Modal markup + Alpine.js form logic |
| `public_html/footer.php` | EDIT | `require 'inc/enquiry-modal.php';` near close of body |
| `public_html/header.php` | EDIT | Extend root `x-data` to include `enquireOpen` and `enquireService` |
| `public_html/program.php` | EDIT | Rewire existing "Enquire Now" button to trigger modal with `$program->p_title` |
| `public_html/trainings.php` | EDIT | Replace 6 "Learn More" links with "Enquire Now" buttons that trigger modal with the card's service title |
| `public_html/send_email.php` | EDIT | Accept + handle `phone` and `service` fields when `is_enquiry=1` |
| `public_html/sql/2026-04-28-add-phone-service-to-tblcontact.sql` | NEW | DB migration |

## Data Flow

```
[Service page]
  └─ User clicks "Enquire Now" (service title set in Alpine state)
        ↓
[Modal opens, form pre-filled with service]
  └─ User submits → fetch POST to send_email.php
        ↓
[send_email.php]
  ├─ Verify CSRF + honeypot
  ├─ Validate name/phone/email/service/message
  ├─ INSERT INTO tblcontact (..., phone, service)
  ├─ mail() → info@ydi.edu.pk (subject: "YDI Enquiry: {service}")
  └─ mail() → user@... (confirmation)
        ↓
[Modal swaps body to thank-you state]
```

## Error Handling

- **CSRF failure:** 403 response → modal shows "Security token expired. Please refresh the page."
- **Validation failure (missing/invalid field):** 400 response with message → shown inline in modal.
- **DB insert failure:** logged silently; email delivery continues (matches current `send_email.php` behavior).
- **Email send failure:** suppressed with `@`; DB row is the durable record (matches current behavior).
- **Network failure on client:** generic "Something went wrong, please try again" message in modal.

## Testing

Manual test checklist (since the project uses Playwright per `playwright.config.js`, an automated test for the modal flow is a stretch goal but not required for this spec):

1. Open `program.php?id=X` for a real program → click Enquire Now → modal appears with service pre-filled.
2. Submit with all fields valid → confirmation message appears in the modal.
3. Submit with empty Name → inline error.
4. Submit with invalid email → inline error.
5. Submit with empty Phone → inline error.
6. Open `trainings.php` → all 6 cards have "Enquire Now" → click each, service auto-fills correctly.
7. Verify email arrives at `info@ydi.edu.pk` with subject `YDI Enquiry: {service}` and body containing Phone + Service lines.
8. Verify row in `tblcontact` has `phone` and `service` populated.
9. Verify the existing `contact.php` form still works end-to-end (regression check).
10. ESC + backdrop click + close button all dismiss the modal.
11. Mobile viewport (≤640px) — modal is scrollable and fields are reachable.

## Security

- CSRF token via existing `csrfField()` helper, validated by `validateCsrfToken()` in `send_email.php`.
- Honeypot `bcheck=true` field already in `send_email.php`.
- Input sanitized via existing `cleanString()` and `htmlspecialchars()` helpers.
- Phone field accepts only `0-9`, space, `+`, `-`, `(`, `)`.
- Service field, although hidden/read-only on the client, is re-validated on the server (sanitized + length-capped at 255).

## Open Questions / Future Work

- Auto-close timer for the success modal (e.g., dismiss after 5s) — left as a polish item.
- Per-service email routing — explicitly out of scope; revisit if YDI departments grow.
- Admin filter in `tblcontact` view to show only enquiries — out of scope; the new `service` column makes this trivial later.
