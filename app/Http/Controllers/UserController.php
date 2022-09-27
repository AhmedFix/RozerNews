<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        if(Auth::user()->isSuperAdmin()) {
            $users = User::where('type', 'admin')->orWhere('type', 'user')->latest()->paginate(10);
        }
        else{
             $users = User::where('type', 'user')->latest()->paginate(10);
        }
           

        return view('backend.users.index', compact('users'));

    }// end of index


    public function create()
    {
        return view('backend.users.create');

    }// end of create

    public function store(UserRequest $request)
    {
        $requestData = $request->validated();
        $requestData['password'] = bcrypt($request->password);
        if ($request->profile_picture) {
    
            $imageName = $request->profile_picture->hashName();

            // Public Folder
            $request->profile_picture->move(public_path('images/profile/'), $imageName);

            $requestData['profile_picture'] = $imageName;

        }//end of if 

            $user = User::create($requestData);
            $user->attachRole('user');

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('user.index');

    }// end of store
   /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));

    }// end of edit

    public function update(UserRequest $request, User $user)
    {
        $requestData = $request->validated();
       
        if ($request->profile_picture) {

            if ($user->hasImage() && $user->profile_picture!='avatar.png') {
                unlink("images/profile/".$user->profile_picture);
            }

            $imageName = $request->profile_picture->hashName();

            // Public Folder
            $request->profile_picture->move(public_path('images/profile/'), $imageName);

            // $request->profile_picture->store('public/uploads');
            $requestData['profile_picture'] = $imageName;

        }//end of if 
        $user->update($requestData);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('user.index');

    }// end of update

    public function destroy(User $user)
    {
        $this->delete($user);
        if ($user->hasImage() && $user->profile_picture!='avatar.png') {
            unlink("images/profile/".$user->profile_picture);
        }
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('user.index');

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $user = User::FindOrFail($recordId);
            $this->delete($user);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(User $user)
    {
        $user->delete();

    }// end of delete

}//end of controller
