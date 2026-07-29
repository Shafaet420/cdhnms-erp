<x-guest-layout title="Forgot Password — CDHNMS">
    <h1 class="font-semibold text-lg mb-2">Forgot password</h1>
    <p class="text-sm text-slate-500 mb-4">Enter your email and we'll send you a reset link.</p>

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

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            Email Password Reset Link
        </button>
    </form>
</x-guest-layout>
