<?php

namespace Database\Seeders;

use App\Engines\WorkflowEngine;
use App\Models\AcademicSession;
use App\Models\AdmissionApplication;
use App\Models\Institution;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoInstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institution = Institution::create([
            'institution_code' => 'INST-0001',
            'name_en' => 'Chongaon Model School & Madrasa',
            'name_bn' => 'চড়গাঁও মডেল স্কুল ও মাদ্রাসা',
            'type' => 'school',
            'status' => 'active',
        ]);

        $session = AcademicSession::create([
            'institution_id' => $institution->id,
            'name' => '2025-2026',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'is_current' => true,
        ]);

        $classes = [];
        foreach (['Class One', 'Class Two', 'Class Three'] as $i => $name) {
            $classes[] = SchoolClass::create([
                'institution_id' => $institution->id,
                'name_en' => $name,
                'display_order' => $i + 1,
            ]);
        }

        foreach ($classes as $class) {
            foreach (['A', 'B'] as $sectionName) {
                Section::create([
                    'institution_id' => $institution->id,
                    'school_class_id' => $class->id,
                    'academic_session_id' => $session->id,
                    'name' => $sectionName,
                    'seat_capacity' => 40,
                ]);
            }
        }

        $admin = User::create([
            'name' => 'Institution Admin',
            'email' => 'admin@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0001',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Institution Admin');

        $teacher = User::create([
            'name' => 'Demo Teacher',
            'email' => 'teacher@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0002',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $teacher->assignRole('Teacher');

        $admissionOfficer = User::create([
            'name' => 'Demo Admission Officer',
            'email' => 'admission@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0003',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $admissionOfficer->assignRole('Admission Officer');

        $principal = User::create([
            'name' => 'Demo Principal',
            'email' => 'principal@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0004',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $principal->assignRole('Principal');

        // Super Admin has no institution_id — sees every institution (Part-3 data scope)
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0000',
            'institution_id' => null,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Sample admission applications in different workflow states, so the
        // Approval Queue (Part-8.3) has something to review right after seeding.
        $workflow = app(WorkflowEngine::class);

        $submitted = AdmissionApplication::create([
            'institution_id' => $institution->id,
            'academic_session_id' => $session->id,
            'school_class_id' => $classes[0]->id,
            'applicant_name_en' => 'Rahim Uddin',
            'dob' => '2019-03-14',
            'gender' => 'male',
            'guardian_name' => 'Karim Uddin',
            'guardian_mobile' => '01711000001',
            'workflow_state' => 'draft',
        ]);
        $workflow->transition($submitted, 'submitted', 'Seeded demo application.');

        $verified = AdmissionApplication::create([
            'institution_id' => $institution->id,
            'academic_session_id' => $session->id,
            'school_class_id' => $classes[1]->id,
            'applicant_name_en' => 'Ayesha Akter',
            'dob' => '2018-07-22',
            'gender' => 'female',
            'guardian_name' => 'Shafiq Akter',
            'guardian_mobile' => '01711000002',
            'workflow_state' => 'draft',
        ]);
        $workflow->transition($verified, 'submitted', 'Seeded demo application.');
        $workflow->transition($verified, 'under_review', 'Seeded demo application.');
        $workflow->transition($verified, 'verified', 'Seeded — ready for Principal approval.');
    }
}

