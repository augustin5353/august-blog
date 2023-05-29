<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        if($request->hasFile('image'))
        {
            if($request->user()->image !== null)
            {
                Storage::delete($request->user()->getImagePath());
            }
            //get filename with extension
            $filenameWithExtension = $request->file('image')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            //get the extension
            $extension = $request->file('image')->getClientOriginalExtension();

            //filename to store
            $filenameStore = $filename. '_'.time().'.'.$extension;

            //upload file
            $request->file('image')->storeAs('public/user_profile_image/'.$request->user()->id, $filenameStore);


            $request->user()->image = 'user_profile_image/'.$request->user()->id.'/'. $filenameStore;

            $request->user()->save();
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function resizeShowImage(User $user)
    {
        $imagePath = substr($user->getImagePath(), 1); // Obtenez le chemin de l'image depuis la base de données

        $image = Image::make($imagePath);
        
        $image->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });
        // Redimensionnez l'image selon vos besoins
    
        // Renvoyer la réponse HTTP avec l'image modifiée
        return response($image->encode('jpg'), 200)->header('Content-Type', 'image/jpeg');
    }
}
