# Portal Login Redesign — Design Spec

**Date:** 2026-04-28
**Scope:** `portal.ydi.edu.pk/application/views/user/login.php` — the only login view in the portal app.
**Goal:** Bring the login page in line with the rest of the polished YDI Student Portal (Tailwind/Inter, slate palette, purple→blue gradients) and make it feel like a real welcome moment instead of a leftover ACE/Bootstrap login card.

---

## Context

The student portal has been progressively migrated from the legacy ACE/Bootstrap 3 theme to a Tailwind-utility + `portal-polish.css` overlay (Inter font, slate palette, gradient accents, FB-style profile cover, polished modals, chat widget). The login page at `application/views/user/login.php` is the last major surface still rendering in the old visual language: dark teal background, small white card, orange Login button, legacy `fieldset`/`legend` markup, ACE form helpers, the `mis.ydi.edu.pk` logo image.

The redesign must:

1. Visually match the post-login portal (no jarring transition after sign-in).
2. Stay on the existing CodeIgniter stack with no new build pipeline — CSS overlay + minimal markup change, exactly the pattern already used in `portal-polish.css`.
3. Preserve the existing form contract: same form actions (`user/login`, `user/forget`), same field names (`username`, `password`, `email`), same validation/flash-message wiring, same forgot-password toggle behavior.

---

## Design direction

**Layout:** Split screen.

- **Left (≈52% width):** Brand hero. Purple→blue mesh gradient identical to the FB-cover gradient already in `portal-polish.css` (`linear-gradient(135deg, #7c3aed 0%, #6d28d9 35%, #3b82f6 100%)`), dotted texture overlay, soft radial highlights. Contents: brand mark + "YDI Student Portal" wordmark, status pill ("Spring 2026 cohort is live"), large welcome headline, supporting lede, footer line.
- **Right (≈48% width):** Polished form on a white surface. Slate labels, soft `#f8fafc` inputs that focus to white with a purple ring, password show/hide toggle, "Keep me signed in" checkbox, "Forgot password?" link, full-width purple-gradient "Sign in" button, "Trouble signing in? Contact support" footer.

**Personality:** Cohesive (same gradient, type, radii, and palette as the rest of the portal) *and* welcoming (the hero side gives the page presence rather than treating login as just a chore).

**Responsive behavior:** Below ~900px the split collapses to stacked. The hero shrinks to a slim banner (brand mark + short tagline only, no pill, no lede), then the form below.

**Forgot-password panel:** Replaces the legacy in-page card swap. The right side swaps out (the left hero stays put) to show: "Back to sign in" link, "Account recovery / Reset your password" heading, single email input, "Send reset instructions" button.

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

### Status pill
Optional small pill above the headline showing a current event/announcement. First implementation: hardcoded "Spring 2026 cohort is live" with a green pulse dot. Easy to remove or wire to a config value later. Hidden on mobile.

### Form fields
- **Username** — text input, person/avatar icon on the right, name `username` (unchanged), `required` (unchanged).
- **Password** — password input with a SHOW/HIDE text toggle on the right that flips the input type. Name `password` (unchanged), `required` (unchanged).

### "Keep me signed in"
New checkbox below the password field, left-aligned. Name `remember`. Not currently supported by the backend — the markup is added so the controller can opt in later; for the initial PR the checkbox renders but the backend ignores it (no behavior change, no regression).

### Sign in button
Full-width gradient button. Replaces the small orange `btn-success` `width-35 pull-right` button. Includes a small arrow icon on the right.

### Help line
"Trouble signing in? Contact support" with a `mailto:` link to a support address (TBD which one — recommend `support@ydi.edu.pk` or whichever inbox is monitored). Replaces the lone "I Forgot My Password" link in the toolbar.

### Forgot password panel
Same right-side surface, swapped in via the existing jQuery toggle (`$('.widget-box.visible')` swap). Heading "Reset your password," single email field, "Send reset instructions" button, "Back to sign in" affordance both at the top (with arrow) and at the bottom (in the help line). Form action and field name (`email`) unchanged.

---

## Markup & CSS strategy

**Markup:** `application/views/user/login.php` is rewritten. The new markup uses semantic elements (`<main>`, `<aside>`, `<form>`, `<label>`) and a small set of new class names scoped under a single root class (e.g. `.login-v2`) so it doesn't collide with anything else in the portal. The existing CodeIgniter form helpers stay (`form_open`, `validation_errors`, `flash_alert`).

**CSS:** All new styles go in a new file `application/views/user/../../assets/css/portal-login.css` (or appended to `portal-polish.css` under a `/* === Login page === */` section — implementation plan can decide). Either way: scoped under `.login-v2` so it cannot leak. The legacy ACE stylesheets (`bootstrap.min.css`, `ace.min.css`, `font-awesome.css`) can be dropped from the login view since the new design doesn't depend on them — but the implementation plan should verify nothing else inherits from them on this page first.

**JS:** A small inline script handles three things: (1) the SHOW/HIDE password toggle, (2) the existing forgot-password panel swap (keep the existing jQuery handler — it works), (3) basic enter-key submit (already native).

**Inline assets only.** No new build step, no Tailwind compile, no React. Same constraints `portal-polish.css` operates under.

---

## Error & loading states

- **Validation errors:** keep the existing `validation_errors('<div class="alert alert-danger">', '</div>')` block, but restyle `.alert-danger` for this page (rose-50 bg, rose-200 border, rose-700 text, radius `10px`, no Bootstrap chrome). Renders above the first field.
- **Flash messages:** keep the `flash_alert()` call. Same restyle treatment as validation errors.
- **Submit loading:** the Sign-in button gets a `:disabled` style (slightly desaturated gradient, `cursor: not-allowed`) and a small spinner replaces the arrow. Form submission disables the button on submit via inline JS.
- **Network/server error:** unchanged from current behavior — the controller redirects back with a flash message, which renders in the alert slot.

---

## Out of scope (explicitly)

- Backend changes to `User` controller, sessions, or auth flow.
- "Remember me" actually working — markup only for now (see component note above).
- Social login, SSO, captcha — none currently exist; not adding them.
- New password reset flow — the existing email-instructions flow stays exactly as-is, only restyled.
- Updating the `mis.ydi.edu.pk` admin login — different app, different scope.

---

## Acceptance criteria

1. Visiting `portal.ydi.edu.pk/user/login` renders the new split layout on desktop ≥ 900px.
2. Below 900px the layout stacks, with the hero shrunk to a banner.
3. Submitting the form posts to `user/login` with `username` + `password` exactly as before; existing controller logic is unchanged.
4. Clicking "Forgot password?" swaps the right side to the recovery panel; submitting posts to `user/forget` with `email`.
5. Validation errors and flash messages render in the new alert style above the first field.
6. The page no longer depends on `mis.ydi.edu.pk/images/logo.jpg` (no remote logo image).
7. Lighthouse "looks reasonable" check: no horizontal scroll on desktop or mobile, no contrast failures on the gradient hero.
8. The legacy `<fieldset><legend>Student Login</legend>` block is gone.

---

## Open questions to resolve during implementation

- Confirm the support contact email (`support@ydi.edu.pk` proposed).
- Confirm whether the status pill should ship in v1 or be removed until the copy can be made dynamic. Default: ship hardcoded.
- Decide whether to keep the new styles in `portal-polish.css` or split into a dedicated `portal-login.css`. Default: dedicated file, loaded only on the login view.
