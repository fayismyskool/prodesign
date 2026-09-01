<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SchoolProfileSettingController extends Controller
{
    public function index(): View
    {
        return view('frontend.school-dashboard.profile.index');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'school_name'         => 'required|string|max:255',
            'contact_person'      => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:100',
            'phone'               => 'nullable|string|max:20',
            'address'             => 'nullable|string|max:500',
            'image'               => 'nullable|image|max:2048',
        ]);

        $user = userAuth();
        $data = $request->only([
            'name', 'school_name', 'contact_person',
            'registration_number', 'phone', 'address',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/profiles', 'public');
            $data['image'] = $imagePath;
        }

        $user->update($data);

        $notification = ['messege' => __('Profile updated successfully.'), 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:4|max:100',
        ]);

        $user = userAuth();

        if (!Hash::check($request->current_password, $user->password)) {
            $notification = ['messege' => __('Current password does not match.'), 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        $user->update(['password' => Hash::make($request->password)]);

        $notification = ['messege' => __('Password updated successfully.'), 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
