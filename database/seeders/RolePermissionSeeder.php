<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permission Engine (Part-3): module.action pairs. Extend this list as each
        // new module (Attendance, Fee, Exam...) is added — see EXTENDING_GUIDE.md.
        $permissions = [
            'institution.view', 'institution.create', 'institution.edit',
            'institution.suspend', 'institution.activate', 'institution.delete',

            'user.view', 'user.create', 'user.edit', 'user.suspend',

            'student.view', 'student.create', 'student.edit', 'student.archive',

            'teacher.view', 'teacher.create', 'teacher.edit',

            'admission.view', 'admission.create', 'admission.verify',
            'admission.approve', 'admission.reject',

            'reports.view', 'audit.view', 'settings.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // System Level Roles (Part-3)
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all()); // Super Admin: entire system

        $institutionAdmin = Role::firstOrCreate(['name' => 'Institution Admin', 'guard_name' => 'web']);
        $institutionAdmin->syncPermissions([
            'user.view', 'user.create', 'user.edit', 'user.suspend',
            'student.view', 'student.create', 'student.edit', 'student.archive',
            'teacher.view', 'teacher.create', 'teacher.edit',
            'admission.view', 'admission.approve', 'admission.reject',
            'reports.view', 'settings.view',
        ]);

        $principal = Role::firstOrCreate(['name' => 'Principal', 'guard_name' => 'web']);
        $principal->syncPermissions([
            'student.view', 'teacher.view',
            'admission.view', 'admission.approve', 'admission.reject',
            'reports.view',
        ]);

        $admissionOfficer = Role::firstOrCreate(['name' => 'Admission Officer', 'guard_name' => 'web']);
        $admissionOfficer->syncPermissions([
            'admission.view', 'admission.create', 'admission.verify',
        ]);

        $officeStaff = Role::firstOrCreate(['name' => 'Office Staff', 'guard_name' => 'web']);
        $officeStaff->syncPermissions([
            'student.view', 'student.create', 'student.edit',
            'admission.view', 'admission.create',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'web']);
        $teacher->syncPermissions(['student.view']);

        $accountant = Role::firstOrCreate(['name' => 'Accountant', 'guard_name' => 'web']);
        $accountant->syncPermissions(['reports.view']);

        Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Guardian', 'guard_name' => 'web']);
    }
}
