# TezNevisan Pro — WordPress Theme

**Theme Name:** TezNevisan Pro  
**Version:** 1.0  
**Text Domain:** `teznevisan`  
**Type:** Classic WordPress PHP theme (RTL Persian) with partial Vite/React tooling  
**Business:** Academic / thesis consulting (موسسه تزنویسان)

> Documentation added 2026-08-06 after full repository inventory.
> See [`docs/`](docs/) for audit, plan, and stack decision.

---

## What this theme is today

A **full WordPress theme** (not a static SPA like Medical CRM).

| Area | Reality |
|------|--------|
| Templates | PHP (`header.php`, `index.php`, `page-*.php`, `single.php`, archives, taxonomies) |
| Logic | `functions.php` (~**646 KB**), `theme-helpers.php`, `inc/*` |
| Styles | `assets/css/main.css` (~148 KB) + many partial CSS files |
| Scripts | jQuery + large vanilla JS; small TS/React stubs via Vite |
| CPT | `services` + `service_category` taxonomy |
| Editor | Classic editor enhancements + React editor experiment |
| Fonts | IRANSans + Font Awesome (+ large `all.js` ~14 MB in repo) |

**README was previously empty** (`# TeznevisanTheme` only). This file replaces it.

---

## Install (WordPress)

1. Copy this folder to `wp-content/themes/TeznevisanTheme` (or `teznevisan-pro`).
2. Activate **TezNevisan Pro** in **Appearance → Themes**.
3. Assign menus: **primary** (and **mobile** if used).
4. Set logo / Customizer options (WhatsApp, phone, Telegram, Eitaa, email).
5. Create pages and assign templates (`page-contact.php`, `page-about.php`, etc.).

### Front-end assets expected

- `assets/css/main.css` (imported from `style.css`)
- `assets/css/chaty-fix.css` (hard-linked in `header.php`)
- Font Awesome classes (`fa-solid`, `fa-brands`) — ensure FA CSS is enqueued from `functions.php`
- Mobile menu + search modal JS

---

## Dev tooling (partial modern stack)

```bash
npm install
npm run dev      # Vite
npm run build    # tsc + vite build → dist/
```

**Vite entries** (`vite.config.ts`):

- `assets/js/main.ts`
- `assets/js/react-editor/TeznevisanEditor.tsx`
- `assets/js/admin.ts`

**Important:** Current `main.ts` is effectively a stub:

```ts
import '../css/main.css';
import './components/accessibility';
import './components/mobile-menu';
console.log('Teznevisan Theme Loaded');
```

Production front-end still relies heavily on **committed** `assets/js/*.js` and CSS, not only Vite `dist/`.

---

## Critical issues (summary)

Full severity list: **[docs/AUDIT.md](docs/AUDIT.md)**

| Severity | Issue |
|----------|--------|
| **P0** | `functions.php` ~646 KB monolith — hard to maintain, slow to load in admin |
| **P0** | `assets/fonts/fontawesome/js/all.js` ~**14 MB** in repo — must never load on front |
| **P0** | Template PHP files 50–115 KB each — likely massive inline markup/CSS |
| **P1** | Dual asset paths (legacy JS + Vite dist) — easy to enqueue wrong file |
| **P1** | Font bloat (TTF/EOT/WOFF/WOFF2 duplicates; Roboto Slab for a Persian site) |
| **P1** | Styling fragmentation (20+ CSS files) |
| **P2** | React/Tailwind present but not driving the public site |

---

## WordPress vs migrate

Decision matrix: **[docs/STACK.md](docs/STACK.md)**

**Recommendation:** Keep **WordPress** for Teznevisan (services CPT, blog, orders, hiring, forms) but **refactor and slim** the theme. Do **not** force a Medical CRM-style pure static SPA unless you abandon WP content management.

Optional later: headless WP + React marketing front — only after P0 cleanup.

---

## Roadmap

Phased plan: **[docs/PLAN.md](docs/PLAN.md)**

1. Audit complete (this docs push)  
2. P0 performance & load safety  
3. Split `functions.php`  
4. Unify enqueue + CSS  
5. Mobile/header/chaty polish  
6. Optional React islands where they add value  

---

## License

GPL v2 or later (per `style.css`).
