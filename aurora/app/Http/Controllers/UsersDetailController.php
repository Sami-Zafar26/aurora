<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersDetailController extends Controller
{
    function users_info() {
        $users=User::orderBy('first_name', 'asc')->paginate(14);
        return view('admin.users',['users_info'=>$users]);
    }

    public function user_bann(Request $request) {
        $user_bann = User::where('token',$request['token'])->first();
        $user_bann->banned = 1;
        $user_bann->save();

        if ($user_bann) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }

    }

    public function user_unbann(Request $request) {
        $user_unbann = User::where('token',$request['token'])->first();
        $user_unbann->banned = 0;
        $user_unbann->save();

        if ($user_unbann) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }

    }
}
