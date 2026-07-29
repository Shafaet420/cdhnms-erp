<div>
    <h1 class="text-xl font-semibold mb-1">Application {{ $application->application_number }}</h1>
    <nav class="text-xs text-slate-400 mb-6">Dashboard / Admissions / {{ $application->application_number }}</nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Detail panel --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-4 text-sm text-slate-500 uppercase tracking-wide">Applicant Summary</h2>
            <dl class="grid grid-cols-2 gap-4 text-sm mb-6">
                <div><dt class="text-slate-400">Name</dt><dd class="font-medium">{{ $application->applicant_name_en }}</dd></div>
                <div><dt class="text-slate-400">Date of Birth</dt><dd class="font-medium">{{ $application->dob->format('d M Y') }}</dd></div>
                <div><dt class="text-slate-400">Guardian</dt><dd class="font-medium">{{ $application->guardian_name }} ({{ $application->guardian_mobile }})</dd></div>
                <div><dt class="text-slate-400">Desired Class</dt><dd class="font-medium">{{ $application->schoolClass->name_en ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Session</dt><dd class="font-medium">{{ $application->academicSession->name ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Current State</dt><dd class="font-medium">{{ ucfirst(str_replace('_',' ',$application->workflow_state)) }}</dd></div>
            </dl>

            @if ($application->created_student_id)
                <div class="rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm mb-4">
                    Student account already created: <strong>{{ $application->createdStudent->student_id }}</strong>
                </div>
            @endif

            <label class="text-sm font-medium">Remarks</label>
            <textarea wire:model="remarks" rows="3" class="mt-1 w-full rounded-xl border-slate-200 text-sm" placeholder="Add a note for this action (required for correction/rejection)"></textarea>

            <div class="flex flex-wrap gap-3 mt-4">
                @can('admission.verify')
                    @if (in_array($application->workflow_state, ['submitted','under_review']))
                    <button wire:click="verify" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Mark Verified</button>
                    @endif
                @endcan
                @can('admission.approve')
                    @if ($application->workflow_state === 'verified')
                    <button wire:click="approve" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">Approve &amp; Create Student</button>
                    @endif
                @endcan
                @can('admission.reject')
                    @if (! in_array($application->workflow_state, ['completed','rejected','archived']))
                    <button wire:click="requestCorrection" class="px-4 py-2 rounded-xl border border-amber-300 text-amber-600 text-sm font-medium hover:bg-amber-50">Request Correction</button>
                    <button wire:click="reject" class="px-4 py-2 rounded-xl border border-red-300 text-red-600 text-sm font-medium hover:bg-red-50">Reject</button>
                    @endif
                @endcan
            </div>
        </div>

        {{-- Workflow history (Part-4 History Policy: append-only, never deleted) --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-4 text-sm text-slate-500 uppercase tracking-wide">Workflow History</h2>
            <ol class="space-y-3 text-sm">
                @forelse ($logs as $log)
                <li class="border-l-2 border-indigo-200 pl-3">
                    <p class="font-medium">{{ ucfirst(str_replace('_',' ',$log->from_state ?? 'created')) }} → {{ ucfirst(str_replace('_',' ',$log->to_state)) }}</p>
                    <p class="text-xs text-slate-400">{{ $log->created_at->format('d M Y, H:i') }}</p>
                    @if ($log->remarks)<p class="text-xs text-slate-500 mt-1">{{ $log->remarks }}</p>@endif
                </li>
                @empty
                <li class="text-slate-400">No history yet.</li>
                @endforelse
            </ol>
        </div>
    </div>
</div>
