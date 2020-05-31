<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function profile_save(Request $request){
        $userid = decrypt($request->userid);
        $this->validate($request,[
                'firstname' => 'required',
                'lastname' => 'required',
                'user_contactnum' => 'string',
            ],
            [
                'firstname.required'    => 'This field is required.',
                'lastname.required'    => 'This field is required.',
            ]
        );
        $user = User::find($userid);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->user_contactnum = $request->user_contactnum;
        $user->save();

        return redirect()->route('account_profile');
    }
}
