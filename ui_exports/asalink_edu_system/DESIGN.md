---
name: Asalink Edu System
colors:
  surface: '#faf8ff'
  surface-dim: '#d5d9f4'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f2ff'
  surface-container: '#ebedff'
  surface-container-high: '#e4e7ff'
  surface-container-highest: '#dde1fc'
  on-surface: '#161b2e'
  on-surface-variant: '#444652'
  inverse-surface: '#2a2f44'
  inverse-on-surface: '#eff0ff'
  outline: '#757684'
  outline-variant: '#c5c5d4'
  surface-tint: '#3d57b7'
  primary: '#223f9f'
  on-primary: '#ffffff'
  primary-container: '#3e58b8'
  on-primary-container: '#d1d8ff'
  inverse-primary: '#b7c4ff'
  secondary: '#4158af'
  on-secondary: '#ffffff'
  secondary-container: '#8aa1fd'
  on-secondary-container: '#18338a'
  tertiary: '#1b3bac'
  on-tertiary: '#ffffff'
  tertiary-container: '#3a55c5'
  on-tertiary-container: '#d2d8ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dde1ff'
  primary-fixed-dim: '#b7c4ff'
  on-primary-fixed: '#001452'
  on-primary-fixed-variant: '#213e9e'
  secondary-fixed: '#dde1ff'
  secondary-fixed-dim: '#b7c4ff'
  on-secondary-fixed: '#001452'
  on-secondary-fixed-variant: '#274096'
  tertiary-fixed: '#dde1ff'
  tertiary-fixed-dim: '#b8c3ff'
  on-tertiary-fixed: '#001355'
  on-tertiary-fixed-variant: '#1a3aab'
  background: '#faf8ff'
  on-background: '#161b2e'
  surface-variant: '#dde1fc'
  canvas-bg: '#EBF0FA'
  surface-card: '#FFFFFF'
  chart-track: '#CAD6F7'
  text-muted: '#737A90'
  text-caption: '#9FA6BC'
  border-subtle: '#E2E7F3'
  success: '#22C55E'
  warning: '#F59E0B'
  danger: '#EF4444'
typography:
  display-metric:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 38px
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 26px
  title-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 15px
    fontWeight: '600'
    lineHeight: 22px
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
  label-sm:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '500'
    lineHeight: 14px
  caption:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '400'
    lineHeight: 14px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  space-xxs: 0.25rem
  space-xs: 0.5rem
  space-sm: 0.75rem
  space-md: 1rem
  space-lg: 1.25rem
  space-xl: 1.5rem
  space-2xl: 2rem
  space-3xl: 2.5rem
  gutter-grid: 1.25rem
  sidebar-rail: 4.5rem
  sidebar-expanded: 12.5rem
---

## Brand & Style

The design system embodies **Approachable Modern EdTech with Soft Corporate Precision**. It bridges rigorous academic administration with an encouraging, cognitive-friendly workspace for modern learners. The visual identity avoids cold, clinical institutional paradigms and excessive gamification, favoring calm structure, generous whitespace, rounded tactile geometry, and a cohesive dual-blue palette.

### Key Pillars
- **Cognitive Clarity:** Dense learning schedules, assessment metrics, and task streams are decomposed into independent, high-affordance card surfaces.
- **Friendly Professionalism:** Rounded radii (16px–24px), tactile pill tags, and soft atmospheric blue canvas layers create a supportive, welcoming environment.
- **Dynamic Dual-Rail Architecture:** Efficient navigation hierarchy separating high-level module categories (icon rail) from focused sub-routes and workspaces.

## Colors

The palette revolves around a calibrated dual-blue spectrum framed by an atmospheric canvas and crisp white cards:

- **Primary (`#3E58B8`):** Anchors the master navigation rail, primary brand elements, metric progress rings, and dominant chart states.
- **Secondary / Deep Navy (`#30489E`):** Serves as interactive hover/pressed states on dark rails, focused headers, and deep structural elements.
- **Tertiary / Active Accent (`#5B75E6`):** Drives high-priority schedule items (e.g., active ongoing live classes), interactive link states, and prominent callouts.
- **Chart Track / Soft Blue (`#CAD6F7`):** Forms background tracks for percentage donut rings and comparative maximum metrics on vertical bar charts.
- **Canvas (`#EBF0FA`):** Provides a tinted, eye-resting background that allows pure white cards (`#FFFFFF`) to stand out naturally.
- **Typography Neutrals:** Primary headings and critical metrics use deep `#1E2337` for WCAG AAA contrast, supported by secondary `#737A90` and caption `#9FA6BC`.

## Typography

The typography couples **Plus Jakarta Sans** for expressive, open geometric letterforms in headings and metric values with **Inter** for dense UI data, metadata tags, and tabular schedules.

- **Bilingual Context:** Supports clear English and Indonesian terminology (`Jadwal Pelajaran`, `Materi Kuliah`, `Penilaian`).
- **Data Display:** Top-level metrics and scores leverage `display-metric` (32px Bold) for immediate scannability.
- **Hierarchical Balance:** Card headers maintain a compact `title-sm` (15px/22px SemiBold) to maximize data density inside modular grid cells.

## Layout & Spacing

The layout is built on an **8px base rhythmic grid** with a multi-column modular structure optimized for learning workspaces:

### Desktop Blueprint (>= 1280px)
- **Persistent Dual Sidebar (300px total):** A 72px condensed icon rail merged seamlessly into a 200px secondary route panel finished in `#3E58B8`.
- **Top Utility Bar:** Transparent 64px header containing global search, multilingual toggles (`ENG` / `IDN`), notifications, and student profile chips.
- **Central Learning Hub (8 Columns):** Hosts the welcome hero card, assessment performance charts, and donut progress metrics.
- **Right Schedule & Context Rail (4 Columns):** Houses the continuous daily timeline, current live lesson highlights, and upcoming webinars or teacher connection chips.

### Responsive Reflow
- **Tablet (768px – 1279px):** Collapses the secondary menu into an off-canvas drawer; keeps the 72px icon rail visible. The right schedule rail drops below the primary analytics cards.
- **Mobile (< 768px):** Desktop sidebars collapse into a 5-item sticky bottom bar. Cards stack into a single column with horizontal swipe carousels for metric rings.

## Elevation & Depth

Visual depth is achieved through **tonal surface stacking** rather than heavy drop shadows:

- **Canvas Layer (Base):** Colored in `#EBF0FA`, establishing clear contrast against elevated components.
- **Surface Elevation (`elevation-card`):** Pure white `#FFFFFF` cards use a soft, tinted drop shadow: `0 8px 24px rgba(62, 88, 184, 0.05)`. This creates a floating appearance with minimal harshness.
- **Interactive Hover (`elevation-hover`):** Cards translate `-2px` on the Y-axis accompanied by `0 12px 32px rgba(62, 88, 184, 0.10)`.
- **Active Class Highlighting:** The active schedule block utilizes solid `#5B75E6` with crisp white text, elevated directly over standard neutral cards.
- **Borders:** Low-contrast `1px solid #E2E7F3` strokes are reserved for form controls, dividers, and pill outline buttons.

## Shapes

The design system applies a **Rounded Geometry** scale to convey friendliness and safety:

- **Primary Cards & Modals:** Standardized at `20px` (`rounded-lg`) corner radii.
- **Hero Welcome Containers:** Enhanced to `24px`–`28px` to integrate smoothly with rounded 3D illustrations.
- **Interactive Navigation Cutouts:** The active navigation item uses a smooth negative-radius / pill cutout (`9999px`) in white `#FFFFFF` against the primary blue sidebar.
- **Tags, Search Fields, and Buttons:** Full pill geometry (`rounded-full` / `9999px`).
- **Avatar Surfaces:** Fully circular (`50%` radius) with 2px borders when stacked.

## Components

### 1. Buttons & Selectors
- **Primary Action:** Solid `#3E58B8` background, `#FFFFFF` text, pill radius, 36px/40px height, medium 13px typography.
- **Outline Pill ("All lessons", Filter Tags):** `#FFFFFF` fill, 1px `#E2E7F3` border, `#1E2337` text, subtle hover lift.
- **Dropdown Filters ("Today", "December"):** Compact pill button with muted text and a 16px chevron icon.

### 2. Navigation Rail & Active Indicator
- The dark primary blue panel (`#3E58B8`) hosts white icon labels.
- The active item spans horizontally into the content margin using a solid `#FFFFFF` pill container with `#3E58B8` text and icon fill, visually connecting the navigation to the workspace canvas.

### 3. Metric Donut Indicators
- Standardized at 64px diameter with an 8px stroke.
- Track color: `#CAD6F7`. Value fill: `#3E58B8` with `stroke-linecap: round`. Centered percentage text in bold 14px.

### 4. Dual-Tone Performance Bar Chart
- Bars use an underlying light blue track (`#CAD6F7`) indicating maximum potential (100%), with a solid blue fill (`#3E58B8`) reflecting the current score.
- Column caps are rounded (`radius: 4px` top corners) and labeled with vertical category text.

### 5. Daily Schedule Timeline
- Vertical axis connected by a dashed `#E2E7F3` line.
- Inactive lessons render inside neutral white or soft-tinted cards with secondary text.
- Ongoing/active lesson card uses a full `#5B75E6` background, white text, and a circular lesson icon badge.

### 6. Teacher & Mentor Micro-Cards
- Horizontal layout containing a 40px circular avatar, teacher name in SemiBold, subject discipline caption, and dual utility buttons (chat bubble and phone receiver) in light `#EBF0FA` pill circles.