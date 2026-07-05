# Internly — Internship Platform

Internly connects students with companies that are hiring interns. Students browse public
internship listings, apply online, and track every application; companies publish roles and
manage their pipeline — all from one clean workspace.

The UI implements the Internly design system. The source of truth for the visuals lives in
`design/DESIGN.md` (tokens, typography, component patterns) and `design/INTEGRATION.md`
(how the design screens map onto Inertia layouts and pages).

## Tech stack

- **Laravel 12** (PHP 8.2+) with the slim `bootstrap/app.php` skeleton
- **Inertia.js v2** with **Vue 3** (`@inertiajs/vue3`, `<script setup>` for new code)
- **Vite** (`laravel-vite-plugin`) for assets
- **Tailwind CSS 3.4** with the Internly design tokens in `tailwind.config.js`
- **MySQL** database, **Pusher/Laravel Echo** for realtime messaging (optional)

## Running the app

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate
# set DB_DATABASE / DB_USERNAME / DB_PASSWORD in .env (MySQL)

# 3. Database + demo data
php artisan migrate:fresh --seed

# 4. Run it (two terminals)
php artisan serve     # http://127.0.0.1:8000
npm run dev           # Vite dev server (HMR)
```

For a production-style build use `npm run build` instead of `npm run dev`.

Realtime messaging broadcasts over Pusher: set the `PUSHER_*` / `VITE_PUSHER_*` variables and
run a websocket server if you want live inbox updates. Messages still work without it —
broadcast failures are logged and the message is saved. There are no queued jobs by default
(`QUEUE_CONNECTION=sync`); if you switch to a queue driver, also run `php artisan queue:work`.

### Demo accounts

The seeder creates a realistic demo world (Atlas Cloud, Novabyte, Greenfield, Stride Labs,
Lumen, Realinflo…) so every screen renders populated. Password is `password` for all:

| Account | Email |
|---|---|
| Student | `student@example.com` |
| Company (Realinflo) | `company@example.com` |
| Company (Atlas Cloud) | `atlascloud@example.com` |
| Admin | `admin@example.com` |

### Tests

Tests run against a separate MySQL database (`issatso_internships_testing` — create it once):

```bash
php artisan test
```

Coverage includes auth (Breeze), applying, saving roles, messaging, and a smoke test that
every ported page returns 200 with real Inertia props.

## What changed in the redesign

**Stack upgrade (incremental, one commit per step)**

- Laravel 8 → 9 → 10 → 12, ending on the Laravel 11+ slim skeleton: no HTTP/Console kernels,
  middleware and routing configured in `bootstrap/app.php`, providers in
  `bootstrap/providers.php`, minimal `config/app.php`.
- Laravel Mix replaced with Vite (`vite.config.mjs`, `@vite` directive, `VITE_*` env vars).
  The Node 16 pin is gone — the toolchain runs on current Node.
- Inertia upgraded to v2 (`@inertiajs/vue3` + `inertia-laravel` v2): `createInertiaApp`,
  `useForm()` everywhere the old `$inertia.form()` was, `Link` registered as `InertiaLink`
  so older templates keep working.
- Tailwind 2 → 3.4 with the design tokens ported verbatim from the design project
  (`blue`/`navy`/`ink`/`muted`/`line`/`paper` ramps, Space Grotesk + Plus Jakarta Sans,
  radii, shadows, `max-w-wrap`). Tailwind 4 was deliberately deferred: the design system
  ships a v3-format `tailwind.config.js` and fidelity won.

**UI (Phase 2)**

- New persistent layouts: `AppShell` (navy sidebar + topbar workspace chrome),
  `MarketingLayout` (sticky translucent header + navy footer), `AuthSplit` (login/signup),
  plus a global `v-reveal` scroll-reveal directive.
- Every design screen ported with the design's Tailwind classes verbatim: landing, about,
  blog + article, contact, browse (public) / internships (workspace), internship detail
  (public with login-required modal, and workspace), login, role-aware signup, dashboard,
  applications + application detail, saved roles, messages, companies + company detail,
  profile, settings.
- Shared UI primitives: `Ui/StatusPill` (design status colour table), `Ui/CompanyLogo`
  (per-company 140° gradients), `Ui/Pagination`, `Internship/RoleCard`.
- Pages render real controller data only — sections without backing data are hidden rather
  than filled with mock content.

**Backend (Phase 3)**

- `internships` gained `work_type`, `duration_weeks`, `term`, `pay_amount`, `pay_unit`,
  `status`; all exposed through resources and shown on cards and detail rails.
- `applications.status` migrated from a nullable boolean to the design's pipeline enum
  (`submitted → viewed → review → interview → offer → closed`) with a data-converting,
  reversible migration. Policies, the company review flow, and dashboards use the enum.
- New: `/settings` (account + security panels), authenticated password change
  (`PUT /password`), password-confirmed account deletion, `messages/{user}` deep-linking
  into the inbox, and an Inertia-friendly like toggle.
- Seeder produces the design's sample world with varied application stages so every screen
  demos well.

**Schema mapping notes** — the existing schema equivalents were kept where they already
served the screens: `likes` acts as the saved-internships pivot, attachments live as JSON
columns on internships/applications, messaging is user-to-user (`messages.from_id/to_id`),
and company identity (name/email) lives on the owning `users` row. Candidates for a future
pass: dedicated `application_events` timeline rows, `educations`/`experiences`/
`profile_links` tables for richer student profiles, notification/privacy preferences,
and skill CRUD (the skills catalog is read-only for now).
