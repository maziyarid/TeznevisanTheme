# Stack decision — Teznevisan vs Medical CRM

## Teznevisan current stack

| Layer | Technology |
|-------|------------|
| CMS | **WordPress** |
| Templates | PHP |
| CSS | Large static CSS (+ Tailwind available in npm, not primary) |
| JS | jQuery + vanilla + partial TypeScript |
| React | Editor / admin experiment only |
| Build | Vite 5 (partial) |
| Fonts | IRANSans, Font Awesome, extras |
| i18n | `teznevisan` text domain + POT |

## Medical CRM stack (drbastaninejad)

| Layer | Technology |
|-------|------------|
| App | React + TypeScript SPA |
| Build | Vite 6 |
| CSS | Tailwind 4 + SCSS |
| Routing | React Router 7 |
| Hosting | Static `public_html` |
| CMS | None (or external) |

---

## Decision

### Stay on WordPress — **recommended for Teznevisan**

**Reasons:**

1. Services CPT, taxonomies, order/hiring/complaint pages already model the business.
2. Non-technical staff need wp-admin for content.
3. A pure SPA rewrite is a **product** rewrite, not a theme fix.

### When to migrate to static React (Medical CRM model)

Only if:

- Content is mostly marketing with rare updates, **and**
- You accept editing via code/CMS headless, **and**
- WP plugins are not required.

### Hybrid (headless WP + React front)

Good **later** option after P0 cleanup:

- WP remains API/content
- React front for speed
- Higher ops cost (two deploys)

---

## Technologies to adopt from Medical CRM (into WP theme)

| Practice | How on Teznevisan |
|----------|------------------|
| Explicit button contrast | Global CSS utilities |
| Fixed header + content offset | `header-enhanced` CSS/JS fix |
| Image lazy + WebP | Template `loading="lazy"`, compress assets |
| No dead OTP flows | Forms submit → thank you / CRM |
| Engintron awareness | If same host class, purge cache after CSS deploys |
| Local fonts only | Already local; reduce formats |
| Manifest-based hashed assets | Vite enqueue when pipeline unified |

## Technologies **not** to force yet

- Full React Router SPA for all pages
- Replacing PHP templates wholesale in one PR
- Adding Alpine + React + jQuery together on every page

---

## Summary one-liner

**Fix and slim the WordPress theme first; borrow Medical CRM performance/UI discipline; only then consider headless/SPA.**
