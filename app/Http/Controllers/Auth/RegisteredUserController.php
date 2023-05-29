<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image,
        ]);

        if($request->hasFile('image'))
        {

            //get filename with extension
            $filenameWithExtension = $request->file('image')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image')->storeAs('public/user_profile_image/'.$user->id, $filenameStore);


            $user->image = 'user_profile_image/'.$user->id.'/'. $filenameStore;



            $user->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
