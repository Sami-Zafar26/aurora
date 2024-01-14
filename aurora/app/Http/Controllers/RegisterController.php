<?php

namespace App\Http\Controllers;

use App\Models\User;
// use App\Models\Subscription;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
  

        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'agreement' => ['accepted']
        ]);
        // dd(1);

        $attributes['password'] = bcrypt($attributes['password'] );
        // dd($attributes);
        // session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);

        $user->token=md5(($user->id.$user->created_at));
        $user->save();

        Auth::login($user);
        
        // $subscription = new Subscription;
        // $subscription->package_id = 1; 
        // $subscription->user_id = auth()->user()->id;
        // $subscription->current_plan = 1;
        // $subscription->save();

        return redirect('/dashboard');
    }
}
