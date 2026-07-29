<?php

use App\Http\Livewire\Admissions\AdmissionApprove;
use App\Http\Livewire\Admissions\AdmissionForm;
use App\Http\Livewire\Admissions\AdmissionList;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Institutions\InstitutionList;
use App\Http\Livewire\Students\StudentForm;
use App\Http\Livewire\Students\StudentList;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth', 'institution.active'])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Module 01 — Institution Management (Super Admin only)
    Route::get('/institutions', InstitutionList::class)
        ->middleware('can:institution.view')->name('institutions.index');

    // Module 04 — Student Management
    Route::get('/students', StudentList::class)
        ->middleware('can:student.view')->name('students.index');
    Route::get('/students/create', StudentForm::class)
        ->middleware('can:student.create')->name('students.create');
    Route::get('/students/{student}/edit', StudentForm::class)
        ->middleware('can:student.edit')->name('students.edit');

    // Module 05 — Admission Management
    Route::get('/admissions', AdmissionList::class)
        ->middleware('can:admission.view')->name('admissions.index');
    Route::get('/admissions/create', AdmissionForm::class)
        ->middleware('can:admission.create')->name('admissions.create');
    Route::get('/admissions/{application}', AdmissionApprove::class)
        ->middleware('can:admission.view')->name('admissions.show');
});

// Public, unauthenticated QR verification endpoint (Part-7.6)
Route::get('/verify/{token}', function (string $token) {
    $student = \App\Models\Student::withoutGlobalScope('institution')
        ->where('qr_token', $token)->firstOrFail();

    return view('public.verify', ['student' => $student]);
})->name('public.verify');

require __DIR__.'/auth.php';
