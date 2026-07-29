<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * NOTE: Part-3 "Auto User Management" says accounts should be system-generated on
 * approval (admission approved -> student account, teacher joined -> teacher account),
 * not self-registered. This controller exists for completeness/Breeze parity, but in
 * production you likely want to remove the public /register route entirely and rely
 * on the auto-creation flows in AdmissionService and its future Teacher/Staff
 * equivalents instead. Left here so Super Admin/Institution Admin bootstrap accounts
 * still have a path if no seeder has run yet.
 */
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'public_user_id' => 'USR-'.str_pad((string) (User::max('id') + 1), 4, '0', STR_PAD_LEFT),
            'account_status' => 'active',
            'must_change_password' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
