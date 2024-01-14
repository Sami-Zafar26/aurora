<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{
    function user_profile() {
        $userProfile=User::find(auth()->user()->id);
        dd($userProfile);
        return view('profile',['userProfile'=>$userProfile]);
    }
}
