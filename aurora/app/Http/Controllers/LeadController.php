<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\CsvList;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    function leads(Request $request) {
        // $UserLeads=User::join("csv_lists","csv_lists.user_id","=","users.id")
        //                 ->join("leads","leads.csv_list_id","=","csv_lists.id")
        //                 ->where("users.id",auth()->user()->id)
        //                 ->whereNull('leads.deleted_at')
        //                 ->paginate(14);

        // $campaign = Campaign::where('campaigns.status','pending')
        // ->where('utc_time','<', now()) // This replaces DATE(schedules.utc_time) = CURDATE()
        // ->orderBy('utc_time', 'asc')
        // ->get();

        // dd($campaign);


        $search=$request['search_query'] ?? "";

        if ($search != "") {
            $UserLeads= Lead::whereHas('leads_belongsto_csv_lists', function ($query) {
                $query->whereNull('deleted_at')
                      ->where('user_id',auth()->user()->id);
            })
            ->whereNull('deleted_at')
            ->where("first_name",$search)
            ->paginate(14);
            return view('user.leads',['userLeads'=>$UserLeads,'search'=>$search]);
        } else {
            $UserLeads= Lead::whereHas('leads_belongsto_csv_lists', function ($query) {
                $query->whereNull('deleted_at')
                      ->where('user_id',auth()->user()->id);
            })
            ->whereNull('deleted_at')
            ->paginate(14);
            // dd($UserLeads);
            $userleads_count = User::join('csv_lists','users.id','=','csv_lists.user_id')
                            ->join('leads','leads.csv_list_id','=','csv_lists.id')
                            ->where('users.id',auth()->user()->id)
                            ->count();
            // dd($userleads);
            $lead = User::join('subscriptions','users.id','=','subscriptions.user_id')
            ->join('packages','packages.id','=','subscriptions.package_id')
            ->where('users.id',auth()->user()->id)
            ->where('subscriptions.current_plan',1)
            ->first();
            // dd($leadCount);
            return view('user.leads',['userLeads'=>$UserLeads,'userleads_count'=>$userleads_count,'lead_allowed'=>$lead]);
        }

    }

    function list_leads(Request $request, $token) {
        $search=$request['search_query'] ?? "";
        if ($search != "") {
            $listId=CsvList::where('token',$token)->first();
            $listLeads=Lead::where('csv_list_id',$listId->id)
            ->where('first_name',$search)
            ->paginate(14);
            return view('user.list_leads',['listLeads'=>$listLeads,'search'=>$search,'token'=>$token,'list_name'=>$listId->list_name]);     
        } else {
            $listId=CsvList::where('token',$token)->first();
            $listLeads=Lead::where('csv_list_id',$listId->id)->paginate(14);
            return view('user.list_leads',['listLeads'=>$listLeads,'token'=>$token,'list_name'=>$listId->list_name]);
        }

    }

     function list_lead_manaully_user_add(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        $csvlist = CsvList::where('token',$request['token'])->first();
        $id = $csvlist->id;
        $lead_existed = Lead::where('csv_list_id',$id)->where('email',$request['email'])->exists();
        if ($lead_existed) {
            return response()->json(2);
        }
        if ($validator->passes()) {
            $lead = Lead::create([
                'first_name'=> $request['first_name'],
                'last_name'=> $request['last_name'],
                'email'=> $request['email'],
                'csv_list_id'=> $id,
            ]);

            if ($request->has('attribute_name') && $request->has('attribute_value')) {
                $optional_field = [];
                foreach ($request->input('attribute_name') as $key => $value) {
                    if (!empty($request->input('attribute_name')) && !empty($request->input('attribute_value')[$key])) {
                        $optional_field[$value] = $request->input('attribute_value')[$key];
                    }
                }
            }

            if (!empty($optional_field)) {
                $lead->json_data = json_encode($optional_field);
                $lead->save();
            }

            $lead->token = md5(($lead->id.$lead->created_at));
            $lead->save();
            if ($lead) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
            
        } else {
            return response()->json(['error'=>"Email field and list is required!"]);
        }
        
    }

    function lead_info($token) {

        try {
            $lead = Lead::where("token", $token)->firstOrFail();
            $list = CsvList::where('id',$lead->csv_list_id)->first();
            // Lead found, continue processing
            $output = "<p>List Name: {$list->list_name}</p>";

            $output .= "<p>First Name: {$lead->first_name}</p><p>Last Name: {$lead->last_name}</p><p>Email: {$lead->email}</p>";
    
            if (!is_null($lead->phone)) {
                $output.="<p>Phone: $lead->phone</p>";
            }
            if (!is_null($lead->city)) {
                $output.="<p>City: $lead->city</p>";
            }
            if (!is_null($lead->state)) {
                $output.="<p>State: $lead->state</p>";
            }
            if (!is_null($lead->country)) {
                $output.="<p>Country: $lead->country</p>";
            }
            if (!is_null($lead->designation)) {
                $output.="<p>Designation: $lead->designation</p>";
            }
            if (!is_null($lead->json_data)) {
                foreach (json_decode($lead->json_data) as $key => $value) {
                    $output.="<p>{$key}: {$value}</p>";     
                }
            }
        
            return response()->json($output);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['error' => 'Lead not found!']);
        }

    }

    public function delete_lead($token) {
        $lead_delete = Lead::where('token',$token)->first()->delete();
        if (($lead_delete)) {
            // $lead_delete;
            return response()->json(1);
        }else{
            return response()->json(0);
        }
    }

    public function delete_listlead($token) {
        $lead_delete = Lead::where('token',$token)->first()->delete();
        if (($lead_delete)) {
            // $lead_delete;
            return response()->json(1);
        }else{
            return response()->json(0);
        }
    }

    public function edit_lead($token) {
        $lead = Lead::where('token',$token)->first();

        if (!$lead) {
            return response()->json(['error' => 'Lead not found'], 404);
        }
        $output = "";
            $output.="<div class='row'>
                        <div class='col-md-6'>
                            <label>First Name</label>
                            <input type='text' class='form-control' name='first_name' value='{$lead->first_name}'>
                        </div>
                        <div class='col-md-6'>
                            <label>Last Name</label>
                            <input type='text' class='form-control' name='last_name' value='{$lead->last_name}'>
                        </div>
                        <input type='hidden' name='token' value='{$token}'>
                        <div class='col-md-12 mb-1'>
                            <label>Email</label>
                            <input type='text' class='form-control' name='email' value='{$lead->email}'>
                        </div>
                    </div>
                    <div class='row'>";
                    if (isset($lead->phone)) {
                        $output.="<div class='col-md-6'>
                                    <label>Phone</label>
                                    <input type='text' class='form-control' name='phone' value='{$lead->phone}'>
                                 </div>";
                    }
                    if (isset($lead->city)) {
                        $output.="<div class='col-md-6'>
                                    <label>City</label>
                                    <input type='text' class='form-control' name='city' value='{$lead->city}'>
                                 </div>";
                    }
                    if (isset($lead->state)) {
                        $output.="<div class='col-md-6'>
                                    <label>State</label>
                                    <input type='text' class='form-control' name='state' value='{$lead->state}'>
                                 </div>";
                    }
                    if (isset($lead->country)) {
                        $output.="<div class='col-md-6'>
                                    <label>Country</label>
                                    <input type='text' class='form-control' name='country' value='{$lead->country}'>
                                 </div>";
                    }
                    if (isset($lead->designation)) {
                        $output.="<div class='col-md-12 mb-1'>
                                    <label>Designation</label>
                                    <input type='text' class='form-control' name='designation' value='{$lead->designation}'>
                                 </div>";
                    }
                    $output.="</div>";
                    if (isset($lead->json_data)) {
                        $i=0;
                        foreach (json_decode($lead->json_data) as $key => $value) {
                            $i++;
                            if ($i==1) {
                                $output.="<label>Additional Attributes</label>";
                            }
                            
                            $output.="<div class='row g-2'>
                                    <div class='col-md-5'>
                                        <input type='text' class='form-control mb-2' name='attribute_name[]' value='{$key}'>
                                     </div>
                                     <div class='col-md-5'>
                                        <input type='text' class='form-control mb-2' name='attribute_value[]' value='{$value}'>
                                     </div>
                                     <div class='col-md-2'>
                                     <button class='remove utility-icon mt-1'><svg class='demolish' xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg></button>
                                        </div>
                                      </div>";
                        }
                    }

                    // $output.="<div class='reference'></div>";
                    // $output.="<button type='button' class='additional-attribute-btn btn btn-sm btn-info my-2'>Additional Attribute</button>";

        return response()->json($output);
    }

    public function update_lead(Request $request) {

        if (is_null($request['email'])) {
            return response()->json(["error"=>"Email is required Lead not Updated!"]);
        }

        $lead = Lead::where('token', $request['token'])->first();
    
        if ($lead) {
            $lead->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'designation' => $request['designation'],
            ]);
    
            if ($request->has('attribute_name') && $request->has('attribute_value')) {
                $optional_field = [];
                foreach ($request->input('attribute_name') as $key => $value) {
                    if (!empty($request->input('attribute_name')) && !empty($request->input('attribute_value')[$key])) {
                        $optional_field[$value] = $request->input('attribute_value')[$key];
                    }
                }
                $lead->json_data = json_encode($optional_field);
                $lead->save();
            }
    
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }
    
}
