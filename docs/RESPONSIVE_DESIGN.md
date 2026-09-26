# Responsive Design — RSUP Prof. dr. I.G.N.G. Ngoerah

Project: Hospital web platform (public landing, staff launcher, Surgicare, Angsmart, ANSafe)  
Stack: Laravel Blade, Tailwind CSS, Alpine.js where used  
Related: [`docs/PRD.md`](PRD.md) (NFR compatibility), [`docs/COLOR_PALLETE.md`](COLOR_PALLETE.md) (visual tokens)

This document defines **what “responsive” means for this repository**, **expected deliverables**, **viewport support**, and **how we implement and test** layouts. It complements the PRD; when they differ during active development, align with the PRD first, then update this file.

---

## 1. Goals and scope

### 1.1 Product goals (from PRD)

| Surface | Responsive expectation |
|--------|-------------------------|
| **Public landing** | Usable on desktop, tablet, and mobile; education videos and CTAs work without horizontal scroll |
| **Staff modules** (Surgicare, Angsmart, ANSafe) | Optimized for **nurse station desktops** and **bedside / point-of-care tablets** |
| **Out of scope (v1)** | Native iOS/Android apps — first delivery is **responsive web** |

### 1.2 Technical scope

- **One responsive HTML document per route** — fluid layout, CSS media queries (via Tailwind breakpoints), not separate mobile/desktop sites.
- **Viewport meta** is required on all layouts (`width=device-width, initial-scale=1`). Already present in `resources/views/layouts/*.blade.php`.
- **Do not disable zoom** (`maximum-scale=1`, `user-scalable=no`) except where a future security review explicitly requires it; zoom is an accessibility requirement.

---

## 2. Principles

1. **Mobile-first** — Default styles target the narrowest supported width. Add complexity with `sm:`, `md:`, `lg:`, etc., not the reverse.
2. **Content-driven breakpoints** — Breakpoints are where **layout or readability breaks** (line length, crushed tables, overlapping labels), not a fixed list of phone models. See [MDN — Media queries](https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/CSS_layout/Media_queries).
3. **Same tasks, different layout** — Users must complete core workflows on tablet and desktop; hiding secondary actions is fine, hiding primary tasks is not.
4. **Tokens over one-offs** — Colors and spacing should follow [`COLOR_PALLETE.md`](COLOR_PALLETE.md) and Tailwind scale; avoid arbitrary hex or pixel spacing in views.
5. **Clinical context** — Assume gloves, quick taps, and interruptions; prefer large touch targets and clear hierarchy on tablet.

---

## 3. Supported viewports (not a device catalog)

The web platform supports **CSS viewport widths**, not individual handset SKUs. There is no official “list of every supported phone”; QA uses **width buckets** plus real browsers.

### 3.1 Minimum and maximum

| Constraint | Value | Notes |
|------------|-------|--------|
| **Minimum width** | **320px** | No horizontal scroll on primary content; critical flows must work |
| **Primary clinical band** | **768px – 1280px** | Tablet portrait/landscape and typical nurse-station displays |
| **Large desktop** | **1280px – 1920px+** | Multi-column dashboards, wide tables with sensible max-width on prose |

### 3.2 QA width checklist (test all critical routes)

Test **at**, **20px below**, and **20px above** each threshold where layout changes ([Sizzy breakpoint checklist](https://sizzy.co/blog/responsive-breakpoint-checklist)).

| Width | Role |
|-------|------|
| 320px | Smallest common phone |
| 375px | Common design / phone reference |
| 768px | Tablet portrait; Tailwind `md` |
| 1024px | Tablet landscape / laptop; Tailwind `lg`; bedside tablet landscape |
| 1280px | Desktop; Tailwind `xl` |
| 1440px | Wide desktop artboard |
| 1920px | Full HD nurse station |

Also verify **portrait ↔ landscape** on tablet widths and **200% browser zoom** on at least one dashboard and one form-heavy screen.

### 3.3 Browsers (minimum matrix)

| Environment | Browsers |
|-------------|----------|
| Desktop (nurse station) | Current **Chrome** or **Edge**; **Firefox** for regression spot-checks |
| Tablet (bedside) | **Safari (iPadOS)** and/or **Chrome (Android tablet)** — match devices used in hospital pilot |
| Mobile (landing / staff login) | **iOS Safari**, **Android Chrome** |

---

## 4. Breakpoints in this project

### 4.1 Tailwind defaults (source of truth in code)

`tailwind.config.js` does **not** override `theme.screens`. Use these prefixes ([Tailwind — Responsive design](https://tailwindcss.com/docs/responsive-design)):

| Prefix | Min width | Typical use in this app |
|--------|-----------|-------------------------|
| *(none)* | 0 | Phone: stacked layout, collapsed nav, single-column cards |
| `sm:` | 640px | Large phones; optional 2-column card grids |
| `md:` | 768px | Tablet: side-by-side panels, visible secondary columns |
| `lg:` | 1024px | Full module chrome, multi-column dashboards, wide tables |
| `xl:` | 1280px | Extra horizontal space; max-width containers |
| `2xl:` | 1536px | Ultra-wide; avoid infinite line length on text blocks |

**Important:** Unprefixed utilities apply to **all** sizes. `md:flex` means “from 768px upward,” not “only on tablet.”

Range-only styling: combine `md:` with `max-lg:` when a behavior must exist only between breakpoints (see Tailwind docs).

### 4.2 Design handoff mapping (Figma / specs)

When designers document artboards, align names to Tailwind to reduce translation errors:

| Design label | Suggested artboard width | Tailwind anchor |
|--------------|--------------------------|-----------------|
| Mobile | 375px (320px stress test) | Base + `sm:` as needed |
| Tablet | 768px | `md:` |
| Desktop | 1024px – 1280px | `lg:` / `xl:` |
| Wide | 1440px+ | `xl:` / `2xl:` + `max-w-*` on content |

Optional reference for **pane-based** layouts (list + detail): [Material Design 3 breakpoints](https://m3.material.io/foundations/layout/breakpoints) (compact &lt; 600, medium 600–839, expanded 840+).

### 4.3 Module-specific layout notes

| Module | Layout priority |
|--------|-----------------|
| **Landing** | Marketing clarity; hero and education hub readable on mobile; staff login entry always reachable |
| **Launcher** | Card grid reflow: 1 → 2 → 3+ columns; `rs-launcher` / `rs-background` per color doc |
| **ANSafe / Angsmart / Surgicare** | Data-dense UI: tables may scroll horizontally **inside** a container before the whole page scrolls horizontally; forms and risk badges remain legible on tablet |
| **Auth (guest)** | Single column, centered panel; keyboard must not cover primary submit on mobile |

---

## 5. Deliverables

### 5.1 Design deliverables (before build or major UI change)

- [ ] **Screen inventory** — flows, default and edge states (empty, loading, error, permission denied).
- [ ] **Layouts per breakpoint** for shell, navigation, dashboard, and at least one complex form and one data table — not desktop-only with “make it responsive.”
- [ ] **Breakpoint behavior matrix** — per width: columns, stack rules, hidden/shown regions, table vs card treatment.
- [ ] **Spacing scale** — prefer 4/8px rhythm; document exceptions.
- [ ] **Typography** — sizes for headings and table density on tablet vs desktop if they differ.
- [ ] **Interaction specs** — mobile nav pattern, modals/drawers, focus order.
- [ ] **Touch targets** — see §6.
- [ ] **Tokens** — map to `rs-*` Tailwind colors; no ad-hoc hex in mockups without token name.

Template inspiration: [Design-to-dev handoff checklist](https://www.desisle.com/resources/design-to-dev-handoff-checklist).

### 5.2 Engineering deliverables (implementation)

- [ ] Layout includes viewport meta (already standard in project layouts).
- [ ] Mobile-first Tailwind classes in Blade components and views under `resources/views/`.
- [ ] **Max-width** on long-form text (`max-w-prose` or project convention) on large screens.
- [ ] Images: appropriate sizing; avoid layout shift; preserve aspect ratio.
- [ ] **No page-level horizontal scroll** at 320px for primary content (embedded wide tables excepted if documented).
- [ ] Reuse existing layout shells (`layouts/ansafe.blade.php`, `angsmart.blade.php`, etc.) before inventing new chrome.
- [ ] Feature tests or manual QA evidence for critical paths at 320, 768, and 1024px when behavior changes.

---

## 6. Touch, pointer, and accessibility

| Requirement | Target |
|-------------|--------|
| **Minimum tap target (recommended)** | **44×44 CSS px** interactive area ([Apple Design Tips](https://developer.apple.com/design/tips/)) |
| **WCAG 2.2 minimum (AA)** | **24×24 CSS px** for pointer targets ([WCAG 2.5.8](https://www.w3.org/WAI/WCAG22/Understanding/target-size-minimum.html)) — treat 44px as hospital UX default |
| **Spacing between controls** | Enough separation that adjacent buttons are not mis-tapped on tablet |
| **Color** | Risk badges and status use icon + color ([PRD §10 accessibility](PRD.md)); see [`COLOR_PALLETE.md`](COLOR_PALLETE.md) |
| **Zoom** | Layout must remain usable at 200% zoom |
| **Focus** | Visible focus rings on keyboard navigation (`focus:ring-*` with `rs-primary` where appropriate) |

Use `@media (hover: hover)` and `pointer: fine` sparingly to enhance desktop hover without breaking touch-only devices.

---

## 7. Common patterns (implementation)

### 7.1 Navigation

- **Compact:** hamburger or bottom-accessible menu; primary module switcher reachable with one hand on tablet.
- **Expanded (`lg:`+):** persistent sidebar or top nav per module layout; active route clearly indicated.

Reuse `resources/views/components/responsive-nav-link.blade.php` and module navigation partials where they exist.

### 7.2 Grids and cards

```html
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
```

Adjust column counts per screen content, not per device name.

### 7.3 Tables on narrow viewports

Preferred order:

1. Reduce non-essential columns at `md:` / `lg:` via `hidden md:table-cell`.
2. Allow **horizontal scroll inside** `<div class="overflow-x-auto">` wrapping the table.
3. Switch to **card list** layout only when designed and specified — do not silently drop clinical columns.

### 7.4 Modals and drawers

- Full-width or nearly full-screen on mobile/tablet when content is form-heavy.
- Ensure close/submit actions sit in the thumb zone and remain visible when the on-screen keyboard is open.

---

## 8. Definition of done (acceptance)

A screen or feature is **responsive-complete** when:

1. Primary user story works at **320px, 768px, and 1024px** without page-level horizontal scroll (except documented table containers).
2. Layout matches the agreed breakpoint matrix or an documented intentional deviation.
3. Interactive controls meet **44px touch target** guidance on tablet and mobile routes.
4. Visual design uses **`rs-*` tokens** and module layout conventions.
5. Orientation change on tablet does not lose context (scroll position or selected patient/tab where applicable).

---

## 9. References

| Topic | Link |
|-------|------|
| Responsive fundamentals | [MDN — Responsive design](https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/CSS_layout/Responsive_Design) |
| Viewport meta | [MDN — viewport](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/meta/name/viewport) |
| Tailwind breakpoints | [Tailwind — Responsive design](https://tailwindcss.com/docs/responsive-design) |
| Adaptive layout (panes) | [Material Design 3 — Breakpoints](https://m3.material.io/foundations/layout/breakpoints) |
| Quality/testing mindset | [arc42 — Responsive design](https://quality.arc42.org/approaches/responsive-design) |
| Handoff checklist | [Desisle — Design-to-dev handoff](https://www.desisle.com/resources/design-to-dev-handoff-checklist) |

---

## 10. Document maintenance

- **Owner:** Product + frontend lead (assign in team process).
- **Update when:** PRD NFR changes, Tailwind `screens` customized, or hospital pilot defines mandatory tablet resolution.
- **Bahasa Indonesia version:** [`DESAIN_RESPONSIF.md`](DESAIN_RESPONSIF.md) — keep both files structurally in sync.
