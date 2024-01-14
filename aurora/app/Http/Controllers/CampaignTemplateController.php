<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignTemplate;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class CampaignTemplateController extends Controller
{
    public function campaign_templates() {
        $campaign_templates = CampaignTemplate::where('user_id',auth()->user()->id)->get();
        // dd($campaign_templates);
        // $templateBody = "Hello , this is an  template. Please contact me at  and your salary is  this message from .";

        // // Use preg_match_all to find all placeholders
        // $pattern = '/\{\{([^}]+)\}\}/'; // Regular expression pattern to match placeholders
        // print_r(preg_match_all($pattern, $templateBody, $matches));
        
        // echo "<br>";
        // echo "<br>";
        // echo "<pre>";
        // print_r($matches);
        // echo "<br>";
        // echo "<br>";


        // $lead = Lead::where('id',1)->first();
        // $user = User::where('id',1)->first();

        // print_r($main = $lead->toArray());
        // echo "<br>";
        // print_r($decoded = json_decode($lead->json_data,true));
        // echo "<br>";

        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // // print_r($main=$main+$decoded );
        // $main['sender'] = $user->first_name;
        // print_r($main=array_merge($main,$decoded));
        // echo "<br>";
        // echo "<br>";
        
        // $final = [];
        // foreach ($matches[1] as $key => $value) {

        //     if (array_key_exists($value,$main)) {
        //         $final[$matches[0][$key]] = $main[$value];
        //     } else {
        //         $final[$matches[0][$key]] = "";
        //     }
        // }       
        // print_r($final);
        // echo "<br>";
        // // die;

        // foreach ($final as $key => $value) {
        //     $templateBody = str_replace($key,$value,$templateBody);
        // }
        // echo $templateBody;

        // die;        

        return view('user.campaign-template',['campaign_templates'=>$campaign_templates]);
    }

    public function create_template() {
        return view('user.create-template');
    }

    public function save_campaign_template(Request $request) {
        // return response()->json($request->all());

        $validator = Validator::make($request->all(),[
            'campaign_template_name'=>'required',
            'campaign_template_subject'=>'required',
            'campaign_template_body'=>'required',
        ]);
        
        if ($validator->passes()) {
            $campaign_templates = CampaignTemplate::create([
                'campaign_template_name'=> $request['campaign_template_name'],
                'campaign_template_subject'=> $request['campaign_template_subject'],
                'campaign_template_body'=> $request['campaign_template_body'],
                'user_id'=> auth()->user()->id,
            ]);
            $campaign_templates->token = md5(($campaign_templates->id.$campaign_templates->created_at));
            $campaign_templates->save();

            if ($campaign_templates) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
            
        } else {
            return response()->json(['error'=>'All fields are required template not saved!']);
        }
        
    }

    public function delete_campaign_template(Request $request) {
        // try {
            $campaign_template_delete = CampaignTemplate::where('token',$request['token'])->first();

            if (!is_null($campaign_template_delete)) {
                $campaign_template_delete->delete();
                return response()->json(1);
            } else {
                return response()->json(0);
            }
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // return response()->json(['error' => 'campaign template not deleted!']);
        // }

    }

    public function edit_campaign_template($token) {

        $edit_template = CampaignTemplate::where('token',$token)->first();
        return view('user.create-template',['edit_template'=>$edit_template]);

        // try {
        //     //code...
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            
        // }
    }

    public function update_campaign_template(Request $request) {

        $validator = Validator::make($request->all(),[
            'campaign_template_name'=>'required',
            'campaign_template_subject'=>'required',
            'campaign_template_body'=>'required',
        ]);
        
        if ($validator->passes()) {
            $campaign_templates = CampaignTemplate::where('token',$request['token'])->first()->update([
                'campaign_template_name'=> $request['campaign_template_name'],
                'campaign_template_subject'=> $request['campaign_template_subject'],
                'campaign_template_body'=> $request['campaign_template_body'],
            ]);

            if ($campaign_templates) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
            
        } else {
            return response()->json(['error'=>'All fields are required template not updated!']);
        }
    }

    public function template_view($token) {
            $campaign_template = CampaignTemplate::where('token',$token)->firstOrFail();
            if (!is_null($campaign_template)) {
                return view("user.template-view",["campaign_templateRR"=>$campaign_template]);
            }else{
                return redirect()->back();
            }
    }
}
