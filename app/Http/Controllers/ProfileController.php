<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Find or create the profile associated with the user
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        // Update profile details
        $profile->bio = $request->bio;
        $profile->location = $request->location;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if it exists
            if ($profile->profile_image) {
                Storage::delete($profile->profile_image);
            }

            // Store new profile image
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profile->profile_image = $path;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);
        $posts = Post::with(['user', 'comments', 'likes'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.view', compact('user', 'posts'));
    }
}
