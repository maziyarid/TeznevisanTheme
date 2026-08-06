# Teznevisan Theme — Full Audit

**Repo:** `maziyarid/TeznevisanTheme`  
**Audited:** 2026-08-06  
**Method:** Full recursive tree (224 paths) + key file reads (`style.css`, `package.json`, `vite.config.ts`, `header.php`, `main.ts`, `build-info.json`)

---

## 1. Architecture map

```
TeznevisanTheme/
├── style.css                 # Theme header only; @imports main.css
├── functions.php             # ~646 KB — ALL theme logic (CRITICAL)
├── theme-helpers.php         # ~50 KB
├── header.php / footer.php
├── index.php, single.php, page*.php, archive*.php, taxonomy*.php
├── order.php                 # Order / lead flow page
├── admin/                    # Meta boxes, menu icons UI
├── inc/                      # admin, ajax, nav walker, customizer, widgets, classic-editor
├── template-parts/           # cards, inquiry form
├── assets/
│   ├── css/                  # 20+ stylesheets (main.css ~148 KB)
│   ├── js/                   # jQuery, chaty, mobile-menu, critical, react-editor, dist/
│   ├── fonts/                # IRANSans, FA, flaticon, glyphicons, Roboto Slab, titanic
│   └── images/               # logo, favicons
├── package.json + vite.config.ts   # Partial modern toolchain
└── languages/teznevisan.pot
```

### Page templates identified

| File | Role (from name/size) |
|------|------------------------|
| `page-about.php` | About |
| `page-blog.php` | Blog landing |
| `page-contact.php` | Contact |
| `page-complaint.php` | Complaints |
| `page-hiring.php` | Hiring |
| `page-privacy-policy.php` | Privacy |
| `page-sitemap.php` | Sitemap |
| `page-categories.php` / `page-tags.php` | Taxonomy hubs |
| `page-service-categories.php` / `page-service-category.php` | Services taxonomy |
| `archive-services.php` / `single-services.php` | Services CPT |
| `order.php` | Order / request |
| `taxonomy-service_category.php` | Service category archive |

---

## 2. Findings by severity

### P0 — Must fix before serious performance work

#### P0-1. `functions.php` is a 646 KB monolith
- **Evidence:** Blob size `645963` bytes.
- **Impact:** Slow PHP parse on every request/admin load; impossible to review safely; high bug risk.
- **Fix:** Split into `inc/` modules already partially started (`ajax-handlers.php`, `admin-functions.php`, etc.) and thin `functions.php` to `require_once` only.

#### P0-2. Font Awesome `all.js` ~14 MB in repository
- **Path:** `assets/fonts/fontawesome/js/all.js` size **13,837,041** bytes.
- **Impact:** If ever enqueued on front, site becomes unusable. Even sitting in theme package inflates deploys/backups.
- **Fix:** Remove from theme or git-ignore; use CSS + subset WOFF2 only; never ship FA JS “all” on marketing pages.

#### P0-3. Oversized PHP templates
Examples:

| File | Size |
|------|------|
| `page-categories.php` | ~115 KB |
| `archive-services.php` | ~100 KB |
| `index.php` | ~95 KB |
| `category.php` / `tag.php` | ~90 KB |
| `page-contact.php` | ~80 KB |

- **Impact:** Inline HTML/CSS/JS duplication; hard RTL/responsive fixes; merge conflicts.
- **Fix:** Move markup to `template-parts/`; shared loops; CSS only in `assets/css`.

#### P0-4. Asset pipeline ambiguity
- Vite builds to `dist/` with hashed names.
- Theme also commits large non-hashed JS (`critical.js`, `header-enhanced.js`, `mobile-menu.js`, …).
- `main.ts` only logs and imports tiny stubs.
- **Impact:** “Styles/JS not loading” when enqueue points at wrong path or missing hash map.
- **Fix:** Single source of truth — either enqueue Vite manifest outputs **or** legacy files, not both without documentation.

---

### P1 — High impact UX / maintainability

#### P1-1. CSS fragmentation
20+ CSS files including `main.css` (148 KB), `services.css` (58 KB), `admin.css` (59 KB), `header-enhanced.css` (33 KB), `critical.css` (35 KB), etc.
- Risk of conflicting rules and mobile regressions.
- **Fix:** Design tokens + layered SCSS/Tailwind build; critical CSS only above-the-fold.

#### P1-2. Font payload
- IRANSans in TTF **and** iranSans eot/ttf/woff/woff2
- Roboto Slab full family (Latin) for a Persian academic site
- Flaticon + Glyphicons + old Font Awesome webfonts + FA “all”
- **Fix:** Keep **IRANSans woff2 only** (2–3 weights); drop EOT/TTF where possible; drop Roboto Slab unless required.

#### P1-3. Header / Chaty hardcoded in `header.php`
- Chaty CSS hard-linked outside `wp_enqueue_style`
- Chaty markup in header with theme_mod defaults
- **Impact:** Order/cascade issues; harder CSP; cache plugins may mishandle.
- **Fix:** Register/enqueue in `functions.php`; optional template-part.

#### P1-4. jQuery shipped in theme
- `assets/js/jquery.min.js` duplicated under `assets/js/jquery/`
- Prefer WP core jQuery if still needed; better: remove jQuery dependency over time.

#### P1-5. React/Tailwind not powering public pages
- `package.json`: React 18, Tailwind 3, Vite 5
- Public site is PHP + CSS
- React used for editor experiment (`TeznevisanEditor.tsx`)
- **Impact:** Expectation mismatch (“use React everywhere”) vs actual architecture.

---

### P2 — Quality / hygiene

| ID | Issue |
|----|--------|
| P2-1 | README was 17 bytes — fixed by this docs push |
| P2-2 | `build-info.json` looks hand-written / inconsistent JSON nesting |
| P2-3 | Filename with space: `favicon - Copy.svg` |
| P2-4 | TS UI stubs (`button.ts` etc.) are ~50–60 byte placeholders |
| P2-5 | Classic editor + React editor dual paths increase support cost |

---

## 3. Loading / styling failure hypotheses

Until a live site URL + Network panel is provided, most likely causes:

1. **Wrong enqueue** of Vite hashed files vs legacy paths after incomplete build.
2. **FA / font 404** if paths in CSS don’t match deployed structure.
3. **CSS order**: `chaty-fix.css` before `wp_head()` vs `main.css` via `@import` in `style.css` ( `@import` blocks rendering).
4. **Mobile menu JS** not enqueued on all templates.
5. **Plugin CSS** (Rank Math, page builders) overriding theme.

`header.php` already special-cases Rank Math for `<title>`.

---

## 4. What is done well

- Clear RTL (`dir="rtl"`, `lang="fa-IR"`, body classes).
- Accessibility hooks (`aria-*`, skip-oriented markup patterns).
- Services CPT + taxonomy structure for academic services.
- Multiple contact channels (WhatsApp, phone, SMS, email, Telegram, Eitaa).
- Template coverage for real business flows (order, hiring, complaint).
- Partial modern tooling (Vite/TS) already present — can be grown carefully.

---

## 5. Comparison to Medical CRM (drbastaninejad)

| Topic | Medical CRM | Teznevisan |
|-------|-------------|------------|
| Primary UI | React SPA | PHP templates |
| Deploy | `dist/` static | WP theme folder |
| Routing | React Router | WP template hierarchy |
| Content | Mostly static/code | WP posts/CPT |
| Biggest risk | Nginx cache MIME | Monolith PHP + FA payload |

**Do not** blindly convert Teznevisan to a pure SPA without a content plan — this theme is built around WP content.

---

## 6. Next verification steps (on a live install)

1. View-source: list all CSS/JS URLs → note 404s.
2. Network: size of FA/font requests.
3. Lighthouse mobile: LCP element (likely hero or logo).
4. Disable plugins one-by-one if styles “randomly” break.
5. Confirm `wp_enqueue_*` list via Query Monitor.

---

## 7. Card checklist (track progress)

- [ ] P0-1 Split `functions.php`
- [ ] P0-2 Remove/guard FA `all.js`
- [ ] P0-3 Extract template-parts from huge page templates
- [ ] P0-4 Document + fix enqueue vs Vite dist
- [ ] P1-1 Consolidate CSS pipeline
- [ ] P1-2 Font subset
- [ ] P1-3 Chaty enqueue
- [ ] P1-4 jQuery policy
- [ ] P2 hygiene (filenames, stubs, README)
