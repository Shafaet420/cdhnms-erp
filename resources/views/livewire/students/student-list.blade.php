<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold">Students</h1>
            <nav class="text-xs text-slate-400 mt-1">Dashboard / Students</nav>
        </div>
        @can('student.create')
        <a href="{{ route('students.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">+ Add Student</a>
        @endcan
    </div>

    {{-- Smart Filters (Part-5.13) --}}
    <div class="flex gap-3 mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or Student ID..."
               class="w-72 rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        <select wire:model.live="statusFilter" class="rounded-xl border-slate-200 text-sm">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="promoted">Promoted</option>
            <option value="transferred">Transferred</option>
            <option value="archived">Archived</option>
        </select>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700/50 text-left text-slate-400">
                <tr>
                    <th class="py-3 px-4">Student ID</th>
                    <th class="px-4">Name</th>
                    <th class="px-4">Class</th>
                    <th class="px-4">Section</th>
                    <th class="px-4">Roll</th>
                    <th class="px-4">Status</th>
                    <th class="px-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr class="border-t border-slate-50 dark:border-slate-700">
                    <td class="py-3 px-4 font-medium text-indigo-600">{{ $student->student_id }}</td>
                    <td class="px-4">{{ $student->name_en }}</td>
                    <td class="px-4">{{ $student->schoolClass->name_en ?? '-' }}</td>
                    <td class="px-4">{{ $student->section->name ?? '-' }}</td>
                    <td class="px-4">{{ $student->roll_number ?? '-' }}</td>
                    <td class="px-4">
                        <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-600">{{ ucfirst($student->status) }}</span>
                    </td>
                    <td class="px-4 text-right">
                        @can('student.edit')
                        <a href="{{ route('students.edit', $student) }}" class="text-indigo-500 hover:underline text-xs">Edit</a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-slate-400">No students found — add your first student to get started.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $students->links() }}</div>
    </div>
</div>
