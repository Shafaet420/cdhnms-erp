<!DOCTYPE html>
<html lang="en" x-data="{ dark: false }" :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDHNMS ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script defer src="https://cdn.jsdelivr.net/npm/[email protected]/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans">
<div class="flex min-h-screen">

    {{-- Left sidebar navigation (Part-5.10) --}}
    <aside class="w-64 bg-white dark:bg-slate-800 border-r border-slate-100 dark:border-slate-700 flex flex-col">
        <div class="px-6 py-5 font-bold text-lg tracking-tight text-indigo-600 dark:text-indigo-400">
            CDHNMS
        </div>
        <nav class="flex-1 px-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-slate-700 text-indigo-600' : '' }}">Dashboard</a>

            @can('student.view')
            <a href="{{ route('students.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('students.*') ? 'bg-indigo-50 dark:bg-slate-700 text-indigo-600' : '' }}">Students</a>
            @endcan

            @can('admission.view')
            <a href="{{ route('admissions.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('admissions.*') ? 'bg-indigo-50 dark:bg-slate-700 text-indigo-600' : '' }}">Admissions</a>
            @endcan

            @can('institution.view')
            <a href="{{ route('institutions.index') }}" class="block px-3 py-2 rounded-xl text-sm font-medium hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('institutions.*') ? 'bg-indigo-50 dark:bg-slate-700 text-indigo-600' : '' }}">Institutions</a>
            @endcan
        </nav>
        <div class="p-3 text-xs text-slate-400">CDHNMS ERP · Enterprise Edition</div>
    </aside>

    <div class="flex-1 flex flex-col">
        {{-- Top navigation (Part-5.10) --}}
        <header class="h-16 bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between px-6">
            <div class="flex-1 max-w-md">
                <input type="text" placeholder="Search students, teachers, receipts..."
                       class="w-full rounded-xl border-slate-200 dark:bg-slate-700 dark:border-slate-600 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-center gap-4">
                <button @click="dark = !dark" class="text-sm text-slate-400 hover:text-slate-600">🌓</button>
                @auth
                    <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-red-500 hover:text-red-600">Logout</button>
                    </form>
                @endauth
            </div>
        </header>

        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
@livewireScripts
</body>
</html>
