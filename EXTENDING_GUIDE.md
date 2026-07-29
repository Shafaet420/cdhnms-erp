# Extending CDHNMS to the Remaining Modules

Every module follows the exact same recipe used for Student/Admission here. To add, say,
**Module 07 Attendance**:

1. **Migration** — new table with the standard fields (`institution_id`, `created_by`,
   `updated_by`, `status`, `remarks`, `deleted_at` via `SoftDeletes`), plus `session_id` if
   it's academic data (per Part-4 Session Support rule).

2. **Model** — `use BelongsToInstitution;` trait so every query is automatically scoped —
   you never write `->where('institution_id', ...)` by hand, and you can never
   accidentally leak another institution's rows.

3. **Permissions** — add rows to `RolePermissionSeeder.php`:
   `attendance:view`, `attendance:create`, `attendance:edit` — assign to the relevant roles.
   Nothing else needs to change; the `permission:` middleware you'll add to the route reads
   this automatically.

4. **Route + Livewire component** — one component per screen (List, Form/Bulk-entry),
   registered in `routes/web.php` behind `->middleware('can:attendance.view')` etc.

5. **Number Generator / Document Engine / Workflow Engine** — if the module produces a
   public identifier, a PDF document, or has an approval workflow, call the existing
   `NumberGeneratorEngine`, `DocumentEngine`, or `WorkflowEngine` — do not write new
   one-off logic. That's the entire point of Part-1's "no duplicate logic" rule.

6. **Audit** — nothing to do. Every model using `LogsActivity` (already on the base
   models here) is audited automatically on save/delete.

This is genuinely mechanical for most modules (Attendance, Fee, Exam, Result, SMS,
Notification, Reports, Settings) — the hard design decisions (schema, roles, engines) are
already made in Parts 1–9 and implemented once here.
