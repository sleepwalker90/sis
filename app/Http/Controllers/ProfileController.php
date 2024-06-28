<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

use Illuminate\View\View;
use Intervention\Image\Drivers\Imagick\Driver;

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
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = $request->user();

        if($request->hasFile('photo')) {
            if($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $image = ImageManager::imagick()->read($request->file('photo')->get());
            $image->scaleDown(150,150);
    
            $photoPath = 'profile-photos/' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            Storage::disk('public')->put($photoPath, (string) $image->encode());
    
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');

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
}
