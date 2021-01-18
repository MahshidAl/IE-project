<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController2 extends Controller
{
    public function index(User $user)
    {
        return view('profiles.index', compact('user'));
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
}
