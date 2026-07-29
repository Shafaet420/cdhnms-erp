<div>
    <h1 class="text-xl font-semibold mb-1">Welcome back, {{ $user->name }}</h1>
    <p class="text-sm text-slate-500 mb-6">{{ $user->institution->name_en ?? 'System-wide view' }}</p>

    {{-- Statistics Cards (Part-5.9) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-slate-400">Total Students</p>
            <p class="text-2xl font-bold mt-1">{{ $stats['students'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-slate-400">Total Teachers</p>
            <p class="text-2xl font-bold mt-1">{{ $stats['teachers'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-slate-400">Pending Admissions</p>
            <p class="text-2xl font-bold mt-1 text-amber-500">{{ $stats['pending_admissions'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-slate-400">Approved Today</p>
            <p class="text-2xl font-bold mt-1 text-emerald-500">{{ $stats['approved_today'] }}</p>
        </div>
    </div>

    {{-- Quick Actions (Part-5.9) --}}
    <div class="flex gap-3 mb-8">
        @can('student.create')
        <a href="{{ route('students.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">+ Add Student</a>
        @endcan
        @can('admission.create')
        <a href="{{ route('admissions.create') }}" class="px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-medium hover:bg-slate-50">+ New Application</a>
        @endcan
        @can('admission.view')
        <a href="{{ route('admissions.index') }}" class="px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-medium hover:bg-slate-50">Review Admissions</a>
        @endcan
    </div>

    {{-- Recent Activities --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold mb-3">Recent Admission Applications</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-400 border-b border-slate-100 dark:border-slate-700">
                    <th class="py-2">Applicant</th>
                    <th>Application No.</th>
                    <th>State</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentAdmissions as $app)
                <tr class="border-b border-slate-50 dark:border-slate-700">
                    <td class="py-2">{{ $app->applicant_name_en }}</td>
                    <td>{{ $app->application_number }}</td>
                    <td><span class="px-2 py-0.5 rounded-full text-xs bg-slate-100 dark:bg-slate-700">{{ ucfirst(str_replace('_',' ',$app->workflow_state)) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" class="py-4 text-center text-slate-400">No applications yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
