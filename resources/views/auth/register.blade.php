<x-guest-layout title="Register — CDHNMS">
    <h1 class="font-semibold text-lg mb-4">Create account</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 text-red-600 px-4 py-3 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            Register
        </button>
        <div class="text-xs text-slate-400 mt-2">
            Already registered? <a href="{{ route('login') }}" class="hover:underline text-indigo-600">Sign in</a>
        </div>
    </form>
</x-guest-layout>
