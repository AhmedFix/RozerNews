<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } // end of __construct

    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    } // end of getChangeData

    public function update(ProfileRequest $request)
    {
        $requestData = $request->validated();

        if ($request->profile_picture) {
            if (auth()->user()->hasImage() && auth()->user()->profile_picture != 'avatar.png') {
                $image_path = public_path('images/profile') . '/' . auth()->user()->profile_picture;
                unlink($image_path);
            }
            $profile = $request->profile_picture->hashName();
            $request->profile_picture->move(public_path('images/profile'), $profile);

            $requestData['profile_picture'] = $profile;
        } //end of if 

        auth()->user()->update($requestData);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('profile');
    } // end of postChangeData

}//end of controller
