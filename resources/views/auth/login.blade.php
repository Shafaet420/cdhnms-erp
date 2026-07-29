<x-guest-layout title="Login — CDHNMS">
    <h1 class="font-semibold text-lg mb-4">Sign in</h1>

    @session('status')
        <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">{{ $value }}</div>
    @endsession

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 text-red-600 px-4 py-3 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" class="rounded border-slate-300">
            Remember me
        </label>
        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            Sign in
        </button>
        <div class="flex justify-between text-xs text-slate-400 mt-2">
            <a href="{{ route('password.request') }}" class="hover:underline">Forgot password?</a>
        </div>
    </form>
</x-guest-layout>
