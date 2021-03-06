<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //Used for showing follow or unfolloow
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        //Used to prevent from showing Follow_Button for users
        $ownProfile = (Auth::id() === $user->getAttribute('id')) ? true : false;

        return view('profiles.index', compact('user', 'follows', 'ownProfile'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        //Set the policy
        $this->authorize('update', $user->profile);

        //Add validation
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'image' => '',
        ]);

        //Get image if exist and compress it
        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];

            //update db
            auth()->user()->profile->update(array_merge(
                $data,
                $imageArray ?? []
            ));
        } else
            auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/login');
    }
}
