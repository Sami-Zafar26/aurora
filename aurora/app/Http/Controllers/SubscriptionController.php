<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function package_info() {
        $packages = Package::all();
        // dd($packages);
        return view('admin.packages',['packages'=>$packages]);
    }

    public function create_package(Request $request) {

        $make_package = Package::create($request->all());
        $make_package->token = md5(($make_package->id.$make_package->created_at));
        $make_package->save();

        if ($make_package) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
        
    }

    public function edit_package(Request $request) {

        $edit_package = Package::where('token',$request['token'])->first();
        $output="
        <div class='mb-3'>
                <label for=''>Package Name</label>
                <input type='text' class='form-control' name='package_name' value='{$edit_package->package_name}'>
            </div>
            <div class='mb-3'>
                <label for=''>Compaign Allowed</label>
                <input type='number' class='form-control' name='compaign_allowed' value='{$edit_package->compaign_allowed}'>
            </div>
            <div class='mb-3'>
                <label for=''>Lead Allowed</label>
                <input type='number' class='form-control' name='lead_allowed' value='{$edit_package->lead_allowed}'>
            </div>
            <div class='mb-3'>
                <label for=''>Package Duration</label>
                <input type='number' class='form-control' name='package_duration' value='{$edit_package->package_duration}'>
            </div>
            <div class='mb-3'>
                <label for=''>Package Price</label>
                <input type='number' class='form-control' name='package_price' value='{$edit_package->package_price}'>
                <input type='hidden' class='form-control' name='token' value='{$edit_package->token}'>
            </div>
        ";

        return response()->json($output);
    }

    public function update_package(Request $request) {

       $update_package = Package::where('token',$request['token'])->first()->update([
            'package_name'=> $request['package_name'],
            'compaign_allowed'=> $request['compaign_allowed'],
            'lead_allowed'=> $request['lead_allowed'],
            'package_duration'=> $request['package_duration'],
            'package_price'=> $request['package_price'],
        ]);

       if ($update_package) {
        return response()->json(1);
        } else {
           return response()->json(0);
        }

    }

    public function delete_package(Request $request) {
        $package_deleted = Package::where('token',$request['token'])->first()->delete();
        if ($package_deleted) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
        
    }


    // methods for users
    public function subscriptions() {
        $user_id = auth()->user()->id;
        $subscriptions = Package::select('users.*','subscriptions.*','packages.*','packages.token AS package_token')
        ->leftJoin('subscriptions', 'packages.id', '=', 'subscriptions.package_id')
        ->leftJoin('users', function ($join) use ($user_id) {
            $join->on('users.id', '=', 'subscriptions.user_id')
            ->where('users.id', '=', $user_id);
        })       
        ->get();

        // dd($subscriptions);
        return view('user.subscription',['subscriptions'=>$subscriptions]);
    }

    public function subscribe_package(Request $request) {
        if ($request['subscribe_token'] != "") {
        $package = Package::where('token',$request['subscribe_token'])->first();
        $cancel_previous_subscription = Subscription::where('user_id', auth()->user()->id)->where('current_plan',1)->update([
            'current_plan'=> 0,
        ]);

        if ($cancel_previous_subscription) {
            Subscription::create([
                'package_id' => $package->id,
                'user_id' => auth()->user()->id,
                'current_plan' => 1,
            ]);

                return response()->json(1);
            } else {
                return response()->json(0);
            }
        } else {
            return response()->json(0);
        }
    }
}
