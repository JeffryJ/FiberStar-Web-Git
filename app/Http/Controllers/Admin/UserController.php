<?php

namespace App\Http\Controllers\Admin;

use App\Mail\UserInviteEmail;
use App\RegisterInvitation;
use App\Rules\UniqueEmail;
use App\Rules\ValidUserRole;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function users_index(){
        $all = User::get();
        $me = $all->filter(function ($user){
            return $user->id == Auth::id();
        });
        $me = $me[0];
        $users = $all->reject(function ($user){
            return $user->id == Auth::id();
        });

        $pendings = RegisterInvitation::where('user_registered',0)->get();

        $data = [
            'users' => $users,
            'me' => $me,
            'pendings' => $pendings
        ];

        return view('admin/users/users_index',$data);
    }

    public function invite_user_modal(){
        $roles = UserRole::get();

        $data = [
            'roles' => $roles,
        ];

        return view('admin/users/invite_user_modal',$data);
    }

    public function invite_user(Request $request){
        $this->validate($request, [
            'email' => ['required','email', new UniqueEmail()],
            'role' => ['required', new ValidUserRole()],
        ]);

        $old = RegisterInvitation::where('email',$request->email)->first();
        if($old!=null){
            $invite = new RegisterInvitation();
            $invite->email = $request->email;
            $invite->invite_as_role_id = $request->role;
            $invite->confirmation_token = str_random(32);
            $invite->invited_by = Auth::id();
            $invite->save();
            $this->send_invitation_email($invite->id);
        }
        else{
            $old->email = $request->email;
            $old->invite_as_role_id = $request->role;
            $old->confirmation_token = str_random(32);
            $old->save();
            $this->send_invitation_email($old->id);
        }

        return redirect('admin/users');
    }

    public function send_invitation_email($id){
        $invite = RegisterInvitation::where('id',$id)->first();

        if($invite!=null){
            Mail::to($invite->email)->send(new UserInviteEmail($invite));
        }
    }

    public function delete_invite(Request $request){
        $invite = RegisterInvitation::where('id',$request->id);
        if($invite!=null){
            $invite->delete();
        }
        return redirect('admin/users');
    }

    public function edit_user_modal($id){
        $user = User::where('id',$id)->first();

        $roles = UserRole::get();

        $data = [
            'user' => $user,
            'roles' => $roles
        ];

        return view('admin/users/edit_user_modal',$data);
    }

    public function edit_user(Request $request){
        $rules = [
            'name' => 'required',
            'role' => ['sometimes','required', new ValidUserRole()],
            'password' => 'sometimes|confirmed',
        ];

        if($request->password != ""){
            $rules['password'].= '|min:6';
        }

        $this->validate($request, $rules);

        $user = User::where('id',$request->id)->first();
        $user->name = $request->name;

        if($request->has('role')) $user->role_id = $request->role;
        if($request->has('password')) $user->password = Hash::make($request->password);

        $user->save();

        return redirect('admin/users');
    }

    public function delete_user(Request $request){
        $user = User::where('id',$request->id)->first();

        if($user!=null){
            $user->delete();
        }

        return redirect('admin/users');
    }
}
