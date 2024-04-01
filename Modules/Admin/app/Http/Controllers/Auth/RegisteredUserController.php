<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Application|View
    {
        return view('admin::auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_active' => 1,
            'is_office_login_only' => 0,
        ]);

        $user->image = $this->generateImage($user);
        $user->save();

        $user->assignRole('admin');

        event(new Registered($user));

        $user->sendEmailVerificationNotification();
        flash('Please check your email for a verification link.')->info();

        return redirect()->back();
    }

    public function generateImage(User $user): string
    {
        $name = get_initials($user->name);
        $id = $user->id.'.png';
        $path = 'users/';

        return create_avatar($name, $id, $path);
    }
}
