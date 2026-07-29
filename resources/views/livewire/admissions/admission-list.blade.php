<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold">Admission Applications</h1>
            <nav class="text-xs text-slate-400 mt-1">Dashboard / Admissions</nav>
        </div>
        @can('admission.create')
        <a href="{{ route('admissions.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">+ New Application</a>
        @endcan
    </div>

    <div class="flex gap-3 mb-4">
        <select wire:model.live="stateFilter" class="rounded-xl border-slate-200 text-sm">
            <option value="">All States</option>
            <option value="submitted">Submitted</option>
            <option value="under_review">Under Review</option>
            <option value="verified">Verified</option>
            <option value="need_correction">Need Correction</option>
            <option value="approved">Approved</option>
            <option value="completed">Completed</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 text-left text-slate-400">
                <tr>
                    <th class="py-3 px-4">Application No.</th>
                    <th class="px-4">Applicant</th>
                    <th class="px-4">Desired Class</th>
                    <th class="px-4">State</th>
                    <th class="px-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $app)
                <tr class="border-t border-slate-50 dark:border-slate-700">
                    <td class="py-3 px-4 font-medium text-indigo-600">{{ $app->application_number }}</td>
                    <td class="px-4">{{ $app->applicant_name_en }}</td>
                    <td class="px-4">{{ $app->schoolClass->name_en ?? '-' }}</td>
                    <td class="px-4">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-slate-100 dark:bg-slate-700">
                            {{ ucfirst(str_replace('_', ' ', $app->workflow_state)) }}
                        </span>
                    </td>
                    <td class="px-4 text-right">
                        <a href="{{ route('admissions.show', $app) }}" class="text-indigo-500 hover:underline text-xs">Review</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-slate-400">No applications yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $applications->links() }}</div>
    </div>
</div>
