# Smart Healthcare — Color Palette

Project: RSUP Prof. dr. I.G.N.G. Ngoerah Hospital Website  
Style: Clean HealthTech UI — trustworthy blues, neutral grays, and coral reserved for urgency.

**Source:** [Octet — Smart healthcare Color Palette](https://octet.design/colors/palette/smart-healthcare-color-palette-1732100703/) ([medical palettes index](https://octet.design/colors/tag/medical/)). The six swatches below match the published Octet set in display order.

---

## Application base (remember this)

These are the colors every screen builds on. Use Tailwind classes `rs-*` from `tailwind.config.js` — do not introduce one-off hex values in views.

| Layer | Hex | Tailwind | Role |
|-------|-----|----------|------|
| **Brand primary** | `#0564F5` | `rs-primary` | Hospital-wide brand: nav accents, primary buttons, links, focus rings, key headlines |
| **Page canvas** | `#EFEFEF` | `rs-background` | Default app shell background (e.g. ANSafe layout `bg-rs-background`) |
| **Content surface** | `#FFFFFF` | `rs-surface` | Cards, headers, modals, auth panels |
| **Body text** | `#2B2C2E` | `rs-text-primary` | Default copy on white and light gray |
| **Borders** | `#C5C4C5` | `rs-border` | Dividers, input outlines, card borders |

**Secondary brand tint:** `#639AE9` (`rs-primary-light` / `rs-accent`) for highlights, selected states, and charts.

**Urgency only:** `#EA4758` (`rs-emergency`) — IGD, critical alerts, high fall risk; not for general decoration.

**Launcher shell:** `#E8EEF5` (`rs-launcher`) — optional soft blue-gray canvas behind app launcher cards (when not using plain white).

**Status (extensions):** `#8BC97F` (`rs-success`), `#F4B266` (`rs-warning`) — risk badges, stats, positive/warning UI (not part of the six Octet swatches).

Landing and launcher pages may use `bg-white` for marketing clarity; in-app modules should default to **`#EFEFEF` canvas + `#FFFFFF` surfaces + `#0564F5` brand**.

---

## Octet Core Palette

| # | Swatch | Hex | Notes |
|---|--------|-----|-------|
| 1 | Light neutral | `#EFEFEF` | Page background, subtle fills |
| 2 | Neutral | `#C5C4C5` | Borders, dividers, disabled chrome |
| 3 | Mid neutral | `#9C9D9E` | Secondary text, icons, muted UI |
| 4 | Soft blue | `#639AE9` | Secondary actions, highlights, charts |
| 5 | Coral | `#EA4758` | Critical / emergency / destructive accent |
| 6 | Strong blue | `#0564F5` | Primary brand, links, main CTAs |

---

## Application Semantic Tokens

Maps hospital UI roles to the Octet palette. Rows marked **extension** are not part of the six Octet swatches but are required for accessible typography and card surfaces.

| Role | Hex | Octet / extension |
|------|-----|-------------------|
| Primary | `#0564F5` | Strong blue |
| Primary Dark (hover/active) | `#0449C4` | extension (darkened strong blue) |
| Primary Light (tints/backgrounds) | `#639AE9` | Soft blue (or `#EFEFEF` with blue accents) |
| Accent / Secondary | `#639AE9` | Soft blue |
| **Emergency / Critical** | `#EA4758` | Coral |
| **Emergency Dark (hover/active)** | `#C73545` | extension (darkened coral) |
| **Emergency Light (banners/badges bg)** | `#FCE8EB` | extension (coral tint on `#EFEFEF`) |
| Background | `#EFEFEF` | Light neutral |
| Surface / Card | `#FFFFFF` | extension |
| Border / Divider | `#C5C4C5` | Neutral |
| Text Primary | `#2B2C2E` | extension (darkest Octet neutral `#9C9D9E` is too light for body text on white) |
| Text Secondary | `#9C9D9E` | Mid neutral |
| Text on Primary / Emergency | `#FFFFFF` | extension |
| Success / low risk | `#8BC97F` | extension |
| Warning / medium risk | `#F4B266` | extension |
| Launcher canvas | `#E8EEF5` | extension (blue-tinted gray) |

### Tailwind `theme.colors.rs` (source of truth in code)

| Token | Hex |
|-------|-----|
| `primary` | `#0564F5` |
| `primary-dark` | `#0449C4` |
| `primary-light` | `#639AE9` |
| `accent` / `accent-dark` | `#639AE9` / `#0449C4` |
| `emergency` / `emergency-dark` / `emergency-light` | `#EA4758` / `#C73545` / `#FCE8EB` |
| `background` | `#EFEFEF` |
| `surface` | `#FFFFFF` |
| `border` | `#C5C4C5` |
| `text-primary` / `text-secondary` | `#2B2C2E` / `#9C9D9E` |
| `launcher` | `#E8EEF5` |
| `success` / `warning` | `#8BC97F` / `#F4B266` |

---

## Usage Guide

- **Strong blue (`#0564F5`)** — navigation bar, links, primary buttons, header accents.
- **Soft blue (`#639AE9`)** — secondary buttons, icons, chart series, wellness/preventive care highlights.
- **Neutrals (`#EFEFEF`, `#C5C4C5`, `#9C9D9E`)** — page chrome, borders, muted labels; keep cards on `#FFFFFF` for clarity.
- **Coral (`#EA4758`)** — reserved *only* for urgent/critical elements:
  - "IGD / Emergency" call-to-action button
  - Emergency contact banner
  - Critical alerts or system-down notices
  - Use sparingly for real urgency, not decoration; it should read clearly against the gray-and-blue base.
- **Background / surface** — default page background `#EFEFEF`; content areas and cards on `#FFFFFF` so blues and coral stay legible.
- **Text** — primary copy on `#2B2C2E`; secondary/muted on `#9C9D9E`.

---

## Accessibility Notes

- **Primary on white:** `#0564F5` on `#FFFFFF` meets WCAG AA for normal text; use `#0449C4` for hover/focus on filled buttons if you need slightly stronger emphasis.
- **Emergency:** Prefer filled buttons with `#EA4758` background and `#FFFFFF` text rather than coral body copy on white. Use `#C73545` for hover/active on emergency controls.
- **Coral as text:** `#EA4758` on white is suitable for large text and icons; avoid small coral text on white for long passages.
- **Routing urgency:** Do not use primary or soft blue for life-safety or IGD-critical CTAs — use the emergency coral tokens so urgent actions stay unmistakable.
