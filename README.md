# CDHNMS ERP — Laravel Starter (Institution / Student / Admission core)

This is a **working foundation**, not the full 15-module ERP — building all 15 modules with
complete workflow/document/SMS coverage is a multi-week project. What's here is a real,
runnable Laravel + Livewire + MySQL implementation of the architecture from Part-9
(reusable Engines, permission middleware, institution scoping, audit logging) applied to
three complete vertical slices:

- **Institution Management** (Module 01)
- **Student Management** (Module 04)
- **Admission Management** (Module 05, with workflow → auto student creation)

Plus the shared engines every other module will reuse:

- **Number Generator Engine** — generates Student ID, Admission No, etc. from configurable sequences
- **Workflow Engine** (via `status` + transition guard) — Draft → Submitted → Under Review → Verified → Approved
- **Institution Scope** (multi-tenancy) — every query auto-scoped to the logged-in user's institution
- **Audit Log** — via Spatie Activitylog, every create/update/delete recorded automatically
- **RBAC** — via Spatie Permission, roles/permissions fully configurable, nothing hardcoded

See `EXTENDING_GUIDE.md` for how to add the remaining 12 modules using this exact pattern.

---

## Setup

This package now includes the **full application skeleton** — `composer.json`, `artisan`,
`bootstrap/app.php`, `public/index.php`, and every `config/*.php` file needed to run. The
only thing that genuinely cannot be included in a zip from this environment (no internet
access here) is the `vendor/` folder itself — that's always fetched locally via Composer,
on every Laravel project, by design.

```bash
# 1. Extract this zip, then from inside the cdhnms/ folder:
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Auth (login/register/password-reset) is already included in this package —
#    routes/auth.php, app/Http/Controllers/Auth/*, resources/views/auth/* — no
#    Breeze install needed. (Optional: `composer require laravel/breeze --dev` only
#    if you want its extra scaffolding like 2FA or API tokens later.)

# 4. Spatie package migrations (already have config/permission.php and
#    config/activitylog.php here, but this republishes their own migrations)
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="permission-migrations"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

# 5. Set your MySQL credentials in .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Migrate + seed demo data, then run
php artisan migrate --seed
php artisan serve
```

Default seeded login (demo institution "Chongaon Model School"):
- **Institution Admin**: admin@demo.test / password
- **Teacher**: teacher@demo.test / password
- **Admission Officer**: admission@demo.test / password
- **Principal**: principal@demo.test / password
- **Super Admin**: superadmin@demo.test / password

Two sample admission applications are seeded — one `submitted` (Admission Officer can
verify it) and one already `verified` (Principal can approve it, which auto-creates the
Student record) — so the full workflow is testable immediately after `migrate --seed`.

### Why `vendor/` isn't in the zip

`vendor/` holds the actual source code of every third-party package (Laravel framework
itself included) — typically tens of thousands of files. It's always generated locally by
running `composer install` against `composer.json`, never hand-copied or shipped in a zip,
on any Laravel project anywhere. Everything else needed to run — your own app code, config,
and the framework's entry points — is in this package already.

## Folder Map (what's included here)

```
composer.json            -> dependencies (Laravel 11, Spatie Permission/Activitylog, Livewire, DomPDF, QrCode, Breeze)
artisan, public/index.php, bootstrap/app.php, bootstrap/providers.php  -> framework entry points
config/                  -> app, database (mysql), auth, session, cache, queue, filesystems, logging, services, permission, activitylog
database/migrations/     -> base Laravel tables (users/cache/jobs) + all custom CDHNMS tables
database/seeders/        -> roles/permissions + demo institution seed data
database/factories/      -> UserFactory (needed by Laravel's test/tinker tooling)
app/Models/               -> Institution, AcademicSession, Student, Guardian, Teacher, AdmissionApplication, Department, SchoolClass, Section, User
app/Traits/                -> BelongsToInstitution (multi-tenancy global scope)
app/Engines/                -> NumberGeneratorEngine, WorkflowEngine, DocumentEngine, QrEngine (bound as singletons in AppServiceProvider)
app/Http/Controllers/Auth/     -> Login/Register/Password-reset/Email-verification controllers
app/Http/Requests/Auth/        -> LoginRequest (rate-limited, checks account_status per Part-3)
app/Http/Middleware/         -> EnsureInstitutionActive (aliased in bootstrap/app.php)
app/Http/Livewire/           -> Dashboard, Students/*, Admissions/*, Institutions/*
resources/views/auth/          -> login, register, forgot/reset password, verify-email, confirm-password
resources/views/components/guest-layout.blade.php -> layout for the auth pages above
resources/views/              -> Tailwind-based layout + Livewire views (Part-5 design system: sidebar nav, cards, tables)
routes/web.php, routes/auth.php, routes/console.php -> route list with permission middleware applied
```
