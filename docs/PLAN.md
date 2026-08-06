# Teznevisan Theme — Execution Plan

**Goal:** Stable, responsive, faster WordPress theme without throwing away CPT/content workflows.

---

## Phase 0 — Documentation (done)

- [x] Repository inventory
- [x] README
- [x] AUDIT
- [x] STACK decision notes

---

## Phase 1 — Safety & performance (P0)

### 1.1 Font Awesome
- Delete or gitignore `assets/fonts/fontawesome/js/all.js`
- Ensure front uses CSS + woff2 only
- Grep theme for `all.js` enqueue and remove

### 1.2 Enqueue map
Create `docs/ENQUEUE-MAP.md` from live `wp_enqueue` list:
- Which CSS/JS load on front
- Which load on admin
- Which are dead

### 1.3 `functions.php` split (incremental)
Target structure:

```
functions.php              # boot only
inc/setup.php              # theme supports, menus
inc/enqueue.php            # all scripts/styles
inc/cpt-services.php
inc/ajax-handlers.php      # already exists — keep
inc/admin-functions.php    # already exists
inc/customizer.php         # already exists
inc/navigation-manager.php # already exists
... 
```

Move in **small PR-sized** chunks; test after each.

### 1.4 Stop `@import` in `style.css` for main CSS
- Enqueue `main.css` properly with version query
- Avoid CSS `@import` (render-blocking)

---

## Phase 2 — Template slim-down

Priority templates (largest first):

1. `page-categories.php`
2. `archive-services.php`
3. `index.php`
4. `category.php` / `tag.php`
5. `page-contact.php`

For each:
- Extract loops → `template-parts/`
- Remove inline CSS/JS → assets
- Keep PHP data logic only

---

## Phase 3 — Front UX polish

- Sticky/fixed header behaviour (match Medical CRM lessons: avoid overflow ancestors; prefer fixed + padding)
- Mobile menu reliability
- Chaty panel direction/z-index
- Button contrast audit (green solid vs outline)
- Center section titles where design requires

---

## Phase 4 — Asset pipeline unify

**Option A (recommended short-term):**  
Keep legacy CSS/JS; Vite only for editor/admin. Document clearly.

**Option B (medium-term):**  
Vite builds all front CSS/JS; `enqueue.php` reads `manifest.json`.

Do not mix A and B silently.

---

## Phase 5 — Optional modern islands

Reuse Medical CRM patterns **only where WP remains source of truth**:

- Contact form enhancement (React or Alpine)
- Service filter UI
- Not a full SPA replacement

Stack available: React 18, Vite, Tailwind 3 (upgrade to 4 later), TS.

---

## Phase 6 — SEO & content

- Rank Math compatibility (already partially handled)
- Schema for Organization / Service
- Image WebP discipline for logos/heroes

---

## Definition of done

- [ ] No 14 MB JS in deploy path
- [ ] `functions.php` &lt; 50 KB boot file
- [ ] Lighthouse mobile Performance ≥ 70 on staging (realistic for WP)
- [ ] No console 404 for theme assets
- [ ] Mobile menu + contact form verified on real device
- [ ] Docs match actual enqueue

---

## Out of scope (unless requested)

- Full rewrite as static React SPA (kills WP admin workflows)
- New SMS OTP provider
- Multi-site city automation
