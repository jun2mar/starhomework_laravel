<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;

class AccountController extends Controller
{
    public function getProfileInfo(){
        $current_loggedin = \Auth::user()->id;
        $result = DB::table("users AS u")
        ->select(
            'u.id',
            'u.firstname',
            'u.lastname',
            'u.email',
            'u.user_avatar',
            'u.user_status',
            'u.user_contactnum',
            'u.is_also_teacher',
            'u.created_at'
        )
        ->where('u.id', $current_loggedin)
        ->get();
        foreach ($result as $item) {
            $item->id = encrypt($item->id);
            $item->is_also_teacher = ($item->is_also_teacher == 1) ? true:false;
        }
        return $result;
    }

    public function updateUserInfo(Request $request){
        $userid = decrypt($request->id);
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
        $user->is_also_teacher = ($request->is_also_teacher == true) ? 1:0;
        $user->save();
    }
}
