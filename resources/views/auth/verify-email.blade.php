<x-guest-layout title="Verify Email — CDHNMS">
    <h1 class="font-semibold text-lg mb-2">Verify your email</h1>
    <p class="text-sm text-slate-500 mb-4">
        Thanks for signing up! Before getting started, please verify your email address by
        clicking the link we just emailed you. If you didn't receive it, we can resend it.
    </p>

    @session('status')
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">
                A new verification link has been sent to your email address.
            </div>
        @endif
    @endsession

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                Resend Verification Email
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-500 hover:underline">Log Out</button>
        </form>
    </div>
</x-guest-layout>
