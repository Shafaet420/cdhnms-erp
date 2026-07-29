<div>
    <h1 class="text-xl font-semibold mb-1">{{ $student ? 'Edit Student' : 'Add Student' }}</h1>
    <nav class="text-xs text-slate-400 mb-6">Dashboard / Students / {{ $student ? 'Edit' : 'Create' }}</nav>

    <form wire:submit.prevent="save" class="space-y-6 max-w-3xl">

        {{-- Section: Student Information (Part-5.14) --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-4 text-sm text-slate-500 uppercase tracking-wide">Student Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Name (English)</label>
                    <input type="text" wire:model="name_en" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                    @error('name_en') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Name (Bangla)</label>
                    <input type="text" wire:model="name_bn" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                </div>
                <div>
                    <label class="text-sm font-medium">Date of Birth</label>
                    <input type="date" wire:model="dob" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                    @error('dob') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Gender</label>
                    <select wire:model="gender" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    @error('gender') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Blood Group</label>
                    <input type="text" wire:model="blood_group" placeholder="e.g. O+" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                </div>
            </div>
        </div>

        {{-- Section: Academic Information --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-4 text-sm text-slate-500 uppercase tracking-wide">Academic Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium">Academic Session</label>
                    <select wire:model="academic_session_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                        <option value="">Select</option>
                        @foreach ($academicSessions as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('academic_session_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Class</label>
                    <select wire:model.live="school_class_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                        <option value="">Select</option>
                        @foreach ($schoolClasses as $c)
                            <option value="{{ $c->id }}">{{ $c->name_en }}</option>
                        @endforeach
                    </select>
                    @error('school_class_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Section</label>
                    <select wire:model="section_id" class="mt-1 w-full rounded-xl border-slate-200 text-sm">
                        <option value="">Select</option>
                        @foreach ($sections as $sec)
                            <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                {{ $student ? 'Save Changes' : 'Create Student' }}
            </button>
            <a href="{{ route('students.index') }}" class="px-5 py-2 rounded-xl border border-slate-200 text-sm font-medium hover:bg-slate-50">Cancel</a>
        </div>
    </form>
</div>
