<x-guest-layout title="Reset Password — CDHNMS">
    <h1 class="font-semibold text-lg mb-4">Reset password</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 text-red-600 px-4 py-3 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">New Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-sm font-medium">Confirm New Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            Reset Password
        </button>
    </form>
</x-guest-layout>
