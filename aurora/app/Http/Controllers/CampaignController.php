<?php

namespace App\Http\Controllers;

use App\Models\IntegrationCredential;
use Illuminate\Http\Request;
use App\Models\IntegrationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\IntegrationCredentialSaved;
use App\Models\Campaign;
use App\Models\CampaignTemplate;
use App\Models\Lead;
use App\Models\CsvList;
use App\Models\Timezone;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

use PHPMailer\PHPMailer\PHPMailer;
// require 'vendor/autoload.php';
use Mailgun\Mailgun;  
use PHPMailer\PHPMailer\Exception;
class CampaignController extends Controller
{
    public function all_campaigns() {
        $campaignsLeads = Campaign::withCount('campaignLeads')
        ->with('campaignTimezone')
        ->get();
        if ($campaignsLeads == null) {
            return response()->json(0);
        } else {
            return response()->json($campaignsLeads);
        }
        
    }

    public function campaign_preview($listToken,$templateToken,$credentialToken) {
        // return response()->json(['list_token'=>$listToken,'template_token'=>$templateToken]);
        $csvlist = Csvlist::where('token',$listToken)->first();
        $lead = Lead::where('csv_list_id',$csvlist->id)->first();
        // dd($lead);
        $user = auth()->user();

        $template = CampaignTemplate::where('token',$templateToken)->first();
        $credential = IntegrationCredential::where('token',$credentialToken)->first();

        $decoded_json_field_value = json_decode($credential->json_field_value,true);
        
        if ($csvlist == null && $lead == null && $template == null && $credential == null) {
            return response()->json(0);
        }

        // echo "<pre>";
        $templatea = $template->toArray();
        $subject = $templatea['campaign_template_subject'];
        // dd($subject);
        $str = $templatea['campaign_template_body'];
        // print_r($templatea);
        $subjectpattern = '/\{\{([^}]+)\}\}/'; // Regular expression pattern to match placeholders
        preg_match_all($subjectpattern, $subject, $match);
        
        $array_for_subject = $lead->toArray();

        $decoded_for_subject = json_decode($lead->json_data,true);

        // print_r($main=$main+$decoded );
        $array_for_subject['sender'] = $user->first_name;
        $main=array_merge($array_for_subject,$decoded_for_subject);
        
        $final_result_of_subject = [];
        foreach ($match[1] as $key => $value) {

            if (array_key_exists($value,$array_for_subject)) {
                $final_result_of_subject[$match[0][$key]] = $array_for_subject[$value];
            } else {
                $final_result_of_subject[$match[0][$key]] = "";
            }
        }  

        foreach ($final_result_of_subject as $key => $value) {
            $subject = str_replace($key,$value,$subject);
        }
        
        // subject End

        // Use preg_match_all to find all placeholders
        // this is for body
        $pattern = '/\{\{([^}]+)\}\}/'; // Regular expression pattern to match placeholders
        preg_match_all($pattern, $str, $matches);
        
        $main = $lead->toArray();

        $decode = json_decode($lead->json_data,true);

        // print_r($main=$main+$decoded );
        $main['sender'] = $user->first_name;
        $main=array_merge($main,$decode);
        
        $final = [];
        foreach ($matches[1] as $key => $value) {

            if (array_key_exists($value,$main)) {
                $final[$matches[0][$key]] = $main[$value];
            } else {
                $final[$matches[0][$key]] = "";
            }
        }  

        foreach ($final as $key => $value) {
            $str = str_replace($key,$value,$str);
        }

        // echo $subject;
        // echo $str;

        return response()->json(['subject'=>$subject,'body'=>$str,'sender_name'=>$user->first_name,'mail_from'=>$decoded_json_field_value[1]['MAIL_FROM']]);
        // print_r($body_subject);
        // return response()->json($body_subject);
        // return response()->json($bod_sub);

    }

    public function create_campaign() {
        $csvlists = CsvList::where('user_id',auth()->user()->id)->get();
        $templates = CampaignTemplate::where('user_id',auth()->user()->id)->get();
        $integrations = IntegrationCredential::where('user_id',auth()->user()->id)->get();
        $timezones = Timezone::orderBy('offset','asc')->get();
        // return response()->json(['csvlists'=>$csvlists]);
        return response()->json(['csvlists'=>$csvlists,'templates'=>$templates,'integrations'=>$integrations,'timezones'=>$timezones]);
    }

    public function save_campaign(Request $request) {

        $campaign_template = CampaignTemplate::where('token',$request['choose_template'])->first();
        $csvlist = CsvList::where('token',$request['choose_list'])->first();
        $integration = IntegrationCredential::where('token',$request['choose_credential'])->first();

        if ($campaign_template == null && $csvlist == null && $integration == null) {
            return response()->json(0);
        }

        $validate = null;

        if ($request['campaign_radio'] == 'schedule') {

            // return response()->json($request['time']);
            $timezone = Timezone::where('id',$request['choose_timezone'])->first();

            // $timestamp = '2023-01-14 5:45:00';
            // $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Karachi');
            // $test = $date->setTimezone('UTC');

            // return response()->json($test);

            $originaltime = Carbon::parse($request['date'].' '.$request['time'].':00', $timezone->name);
            $utctime = $originaltime->utc();
            $ori = $utctime->format('Y-m-d H:i:s');


            $validate = Validator::make($request->all(),[
                'campaign_name'=> 'required',
                'choose_template'=> 'required',
                'choose_list'=> 'required',
                'choose_credential'=> 'required',
                'date'=> 'required|date|after_or_equal:today',
                'time'=> 'required',
                'choose_timezone'=> 'required'
            ]);

            if ($validate->passes()) {

                $campaign = Campaign::create([
                    'campaign_name' => $request['campaign_name'],
                    'is_active' => 1,
                    'campaign_template_id' => $campaign_template->id,
                    'integration_credential_id' => $integration->id,
                    'csv_list_id' => $csvlist->id,
                    'utc_time'=> $ori,
                    'date'=> $request['date'],
                    'time'=> $request['time'],
                    'timezone_id'=> $timezone->id,
                    'user_id' => auth()->user()->id
                ]);
        
                $campaign->token = md5(($campaign->id.$campaign->created_at));
                $campaign->save();
        
                if ($campaign) {
                    return response()->json(1);
                } else {
                    return response()->json(0);
                }
                
                } else {
                    return response()->json(['error_missing_field'=>'Please fill all the fields and also schedule fields!']);
                }

        } 
        
        // if ($request['campaign_radio'] == 'send-now') {
        //     // return response()->json(1);
        //     $validate = Validator::make($request->all(),[
        //         'campaign_name'=> 'required',
        //         'choose_template'=> 'required',
        //         'choose_list'=> 'required',
        //         'choose_credential'=> 'required'
        //     ]);

        //     // date_default_timezone_set('UTC');

        //     $utcTime = gmdate('Y-m-d H:i:s');

        //     // Convert UTC time to a Unix timestamp
        //     $timestamp = strtotime($utcTime);

        //     // Add 2 minutes (2 * 60 seconds) to the timestamp
        //     $timestamp += 2 * 60;

        //     // Format the new timestamp as a UTC time string
        //     $twoMinutesAheadUtcTime = gmdate('Y-m-d H:i:s', $timestamp);

        //     if ($validate->passes()) {
    
    
        //     $campaign = Campaign::create([
        //         'campaign_name' => $request['campaign_name'],
        //         'campaign_template_id' => $campaign_template->id,
        //         'integration_credential_id' => $integration->id,
        //         'csv_list_id' => $csvlist->id,
        //         'utc_time'=> $twoMinutesAheadUtcTime,
        //         // 'date'=> date('Y-m-d'),
        //         // 'time'=> date('H:i:s'),
        //         'timezone_id'=> 1,
        //         'user_id' => auth()->user()->id
        //     ]);
    
        //     $campaign->token = md5(($campaign->id.$campaign->created_at));
        //     $campaign->save();
    
        //     if ($campaign) {
        //         return response()->json(1);
        //     } else {
        //         return response()->json(0);
        //     }
            
        //     } else {
        //         return response()->json(['error_missing_field'=>'Please fill all the fields!']);
        //     }
        // }


    }

    public function duplicate_campaign($token) {
        $duplicate_campaign = Campaign::where('token',$token)->first();
        $created_campaign= Campaign::create([
            'campaign_name'=>$duplicate_campaign->campaign_name,
            'is_active'=>0,
            'status'=> 'pending',
            'utc_time'=>$duplicate_campaign->utc_time,
            'date'=>$duplicate_campaign->date,
            'time'=>$duplicate_campaign->time,
            'timezone_id'=>$duplicate_campaign->timezone_id,
            'csv_list_id'=>$duplicate_campaign->csv_list_id,
            'integration_credential_id'=>$duplicate_campaign->integration_credential_id,
            'campaign_template_id'=>$duplicate_campaign->campaign_template_id,
            'user_id'=>$duplicate_campaign->user_id
        ]);

        $created_campaign->token = md5(($created_campaign->id.$created_campaign->created_at));
        $created_campaign->save();

        if ($created_campaign) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }

    }

    public function delete_campaign($token) {
        $campaign_delete = Campaign::where('token',$token)->first();
        if ($campaign_delete != null) {
            $campaign_delete->delete();
            return response()->json(1);
        } else {
            return response()->json(0);
        }
        
    }

    public function edit_campaign($token) {
        

       $edit_campaign = Campaign::where('token',$token)->first();

       $csvlists = CsvList::where('user_id',auth()->user()->id)->get();
       $templates = CampaignTemplate::where('user_id',auth()->user()->id)->get();
       $integrations = IntegrationCredential::where('user_id',auth()->user()->id)->get();
           $timezones = Timezone::orderBy('offset','asc')->get();

       return response()->json(['edit_campaign'=>$edit_campaign,'csvlists'=>$csvlists,'templates'=>$templates,'integrations'=>$integrations,'timezones'=>$timezones]);

    }

    public function update_campaign(Request $request) {
        $update_campaign = Campaign::where('token',$request['token'])->first();

        if($update_campaign == null) {
            return response()->json(0);
        }

        $validate = Validator::make($request->all(),[
            'campaign_name'=> 'required',
            'choose_template'=> 'required',
            'choose_list'=> 'required',
            'choose_credential'=> 'required',
            'date'=> 'required|date|after_or_equal:today',
            'time'=> 'required',
            'choose_timezone'=> 'required'
        ]);

        if ($validate->passes()) {

            $campaign_template = CampaignTemplate::where('token',$request['choose_template'])->first();
            $csvlist = CsvList::where('token',$request['choose_list'])->first();
            $integration = IntegrationCredential::where('token',$request['choose_credential'])->first();
            $timezone = Timezone::where('id',$request['choose_timezone'])->first();


            $originaltime = Carbon::parse($request['date'].$request['time'] , $timezone->name);
            $utctime = $originaltime->utc();

            // $update_campaign   
            $update_campaign->update([
                'campaign_name' => $request['campaign_name'],
                'csv_list_id' => $csvlist->id,
                'integration_credential_id' => $integration->id,
                'campaign_template_id' => $campaign_template->id,
                'utc_time' => $utctime,
                'date' => $request['date'],
                'time' => $request['time'],
                'timezone_id' => $timezone->id
            ]);
            return response()->json(1);

        } else {
            return response()->json(['error_missing_field'=>'Please fill all the fields!']);
        }
    }

    public function change_active($token) {
        $campaign = Campaign::where('token',$token)->first();
        // if ($campaign != null) {
            if ($campaign->is_active == 1) {
                $campaign_updated = Campaign::where('token',$token)->first()->update([
                    'is_active'=> 0
                ]);
                return response()->json(1);
            } else {
                $campaign_updated = Campaign::where('token',$token)->first()->update([
                    'is_active'=> 1
                ]);
                return response()->json(1);
            }
        // }

        return response()->json(0);
    }

    public function integration_credentials() {
        $integration_credentials = IntegrationService::select('integration_services.*','integration_credentials.*','integration_credentials.token AS credential_token')->join('integration_credentials','integration_services.id','=','integration_credentials.integration_service_id')
        ->where('integration_credentials.user_id',auth()->user()->id)
        ->whereNull('integration_credentials.deleted_at')
        ->get();
        // $test = IntegrationCredential::where('id',1)->first();
        // dd($integration_credentials);W
        
        return view('user.integration-credential',['integration_credentials'=>$integration_credentials]);
    }

    public function find_integration_service() {
       $integration_services = IntegrationService::where('status',1)->get();
       return response()->json($integration_services);

    }

    public function smpt_service(Request $request) {
        $integration_fields = IntegrationService::where('token',$request['token'])->first();

        
        $decoded = json_decode($integration_fields->field_json,true);

            return response()->json(['token'=>$request['token'],'json_fields'=>$decoded]);
    }

    public function create_integration_credential(Request $request) {
        // return response()->json($request->all());
        $integration_service = IntegrationService::where('token',$request['token'])->first();
        if (!$integration_service) {
            return response()->json(0);
        } 


        // $mgClient = new Mailgun(env('MAILGUN_SECRET'));
        // $domain = env('MAILGUN_DOMAIN');
        // # Make the call to the client.
        // $result = $mgClient->messages()->send($domain, array(
	    //     'from'	=> 'Excited User <samizafar262976@gmail.com>',
	    //     'to'	=> 'Baz <samizafar262976@gmail.com>',
	    //     'subject' => 'Hello',
	    //     'text'	=> 'Testing some Mailgun awesomeness!'
        // ));
        
        // echo $result;
        // die;
        // return response()->json(1);
        

        $validate = Validator::make($request->all(),[
            'MAIL_INTEGRATION_NAME'=>'required',
            'MAIL_FROM'=>'required|email',
            'MAIL_HOST'=>'required',
            'MAIL_PORT'=>'required|numeric',
            'MAIL_USERNAME'=>'required',
            'MAIL_PASSWORD'=>'required',
        ]);
        if ($validate->passes()) {
    
        $id = $integration_service->id;

        $to['email'] = $request['MAIL_FROM'];      
        $to['name'] = "sami zafar";   
        $subject = "My Mail";
        $str = "<p>Hello!</p></p>welcome to world of mails.</p>";
        $mail = new PHPMailer();
        $mail->IsSMTP();                                     
        $mail->SMTPAuth = true;
        $mail->Host = $request['MAIL_HOST'];
        $mail->Port = $request['MAIL_PORT'];
        $mail->Username = $request['MAIL_USERNAME'];
        $mail->Password = $request['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->From = $request['MAIL_FROM'];
        $mail->FromName = "Sami";
        $mail->AddReplyTo('xyz@domainname.com', 'any name'); 
        $mail->AddAddress($to['email'],$to['name']);
        $mail->Priority = 1;
        $mail->AddCustomHeader("X-MSMail-Priority: High");
        $mail->WordWrap = 50;
        // $debug = $mail->SMTPDebug = 2;    
        $mail->IsHTML(true);  
        $mail->Subject = $subject;
        $mail->Body    = $str;
        if(!$mail->Send()) {
        $err = 'Message could not be sent.';
        $err .= 'Mailer Error: ' . $mail->ErrorInfo;                        
        // echo $debug;
        $mail->ClearAddresses();
        return response()->json(['error'=>'Invalid Mail Credentials!']);
        // echo $err;
        }else{  
            // echo 'Message has been sent.';  
            // echo $debug;
            $json_field_value = [
                ['label'=>'Mail Integration Name','type'=>'text','name'=>'MAIL_INTEGRATION_NAME','MAIL_INTEGRATION_NAME'=>$request['MAIL_INTEGRATION_NAME'],'value'=>$request['MAIL_INTEGRATION_NAME'],'placeholder'=>'Mail Integration Name...'],
                ['label'=>'Mail From','type'=>'email','name'=>'MAIL_FROM','MAIL_FROM'=>$request['MAIL_FROM'],'value'=>$request['MAIL_FROM'],'placeholder'=>'Mail From...'],
                ['label'=>'Mail Host','type'=>'text','name'=>'MAIL_HOST','MAIL_HOST'=>$request['MAIL_HOST'],'value'=>$request['MAIL_HOST'],'placeholder'=>'Mail Host...'],
                ['label'=>'Mail Port','type'=>'number','name'=>'MAIL_PORT','MAIL_PORT'=>$request['MAIL_PORT'],'value'=>$request['MAIL_PORT'],'placeholder'=>'Mail Port...'],
                ['label'=>'Mail Username','type'=>'text','name'=>'MAIL_USERNAME','MAIL_USERNAME'=>$request['MAIL_USERNAME'],'value'=>$request['MAIL_USERNAME'],'placeholder'=>'Mail Username...'],
                ['label'=>'Mail Password','type'=>'password','name'=>'MAIL_PASSWORD','MAIL_PASSWORD'=>$request['MAIL_PASSWORD'],'value'=>$request['MAIL_PASSWORD'],'placeholder'=>'Mail Password...']
            ];
    
            $encoded = json_encode($json_field_value);
            
            $create_integration_credential = IntegrationCredential::create([
                'json_field_value'=>$encoded,
                'user_id'=> auth()->user()->id,
                'integration_service_id'=> $id,
            ]);
           $create_integration_credential->token = md5(($create_integration_credential->id.$create_integration_credential->created_at));
           $create_integration_credential->save();
           if ($create_integration_credential) {
            $mail->ClearAddresses();
            return response()->json(1);
            // echo 1;
            } else {
                $mail->ClearAddresses();
               return response()->json(0);
            // echo 0;
           }
           
        }
    } else {
        return response()->json(["missing_field"=>"Please fill all fields!"]);
    }
    
        
    }

    public function delete_integration_credential(Request $request) {
        $integration_credential_delete = IntegrationCredential::where('token',$request['token'])->first()->delete();
        if ($integration_credential_delete) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
        
    }

    public function edit_integration_credential(Request $request) {
        // return response()->json(json_encode($request->all()));
        $integration_credential = IntegrationCredential::where('token',$request['token'])->where('user_id',auth()->user()->id)->first();
        // dd($integration_service);
        $decoded = json_decode($integration_credential->json_field_value,true);


        return response()->json(['json_field_value'=>$decoded,'token'=>$request['token']]);
    }

    public function update_integration_credential(Request $request) {
        // return response()->json($request->all());
         $integration_credential = IntegrationCredential::where('token',$request['token'])->first();

         $validate = Validator::make($request->all(),[
            'MAIL_INTEGRATION_NAME'=>'required',
            'MAIL_FROM'=>'required|email',
            'MAIL_HOST'=>'required',
            'MAIL_PORT'=>'required|numeric',
            'MAIL_USERNAME'=>'required',
            'MAIL_PASSWORD'=>'required',
        ]);

        if ($validate->passes()) {
            
            
            $to['email'] = $request['MAIL_FROM'];      
            $to['name'] = "sami zafar";   
            $subject = "My Mail";
            $str = "<p>Hello, World welcome to world of mails Updating..............</p>";
            $mail = new PHPMailer();
            $mail->IsSMTP();                                     
            $mail->SMTPAuth = true;
            $mail->Host = $request['MAIL_HOST'];
            $mail->Port = $request['MAIL_PORT'];
            $mail->Username = $request['MAIL_USERNAME'];
            $mail->Password = $request['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->From = $request['MAIL_FROM'];
            $mail->FromName = "Sami";
            $mail->AddReplyTo('xyz@domainname.com', 'any name'); 
            $mail->AddAddress($to['email'],$to['name']);
            $mail->Priority = 1;
            $mail->AddCustomHeader("X-MSMail-Priority: High");
            $mail->WordWrap = 50;
            // $debug = $mail->SMTPDebug = 2;    
            $mail->IsHTML(true);  
            $mail->Subject = $subject;
            $mail->Body    = $str;
            if(!$mail->Send()) {
            $err = 'Message could not be sent.';
            $err .= 'Mailer Error: ' . $mail->ErrorInfo;                        
            // echo $debug;
            $mail->ClearAddresses();
            return response()->json(['error'=>'Invalid Mail Credentials!']);
            // echo $err;
            }else{  
        
         if ($integration_credential) {
            $json_field_value = [
                ['label'=>'Mail Integration Name','type'=>'text','name'=>'MAIL_INTEGRATION_NAME','MAIL_INTEGRATION_NAME'=>$request['MAIL_INTEGRATION_NAME'],'value'=>$request['MAIL_INTEGRATION_NAME'],'placeholder'=>'Mail Integration Name...'],
                ['label'=>'Mail From','type'=>'email','name'=>'MAIL_FROM','MAIL_FROM'=>$request['MAIL_FROM'],'value'=>$request['MAIL_FROM'],'placeholder'=>'Mail From...'],
                ['label'=>'Mail Host','type'=>'text','name'=>'MAIL_HOST','MAIL_HOST'=>$request['MAIL_HOST'],'value'=>$request['MAIL_HOST'],'placeholder'=>'Mail Host...'],
                ['label'=>'Mail Port','type'=>'number','name'=>'MAIL_PORT','MAIL_PORT'=>$request['MAIL_PORT'],'value'=>$request['MAIL_PORT'],'placeholder'=>'Mail Port...'],
                ['label'=>'Mail Username','type'=>'text','name'=>'MAIL_USERNAME','MAIL_USERNAME'=>$request['MAIL_USERNAME'],'value'=>$request['MAIL_USERNAME'],'placeholder'=>'Mail Username...'],
                ['label'=>'Mail Password','type'=>'password','name'=>'MAIL_PASSWORD','MAIL_PASSWORD'=>$request['MAIL_PASSWORD'],'value'=>$request['MAIL_PASSWORD'],'placeholder'=>'Mail Password...']
            ];
            $encoded = json_encode($json_field_value);
            $integration_credential->update([
                'json_field_value'=> $encoded,
            ]);

            return response()->json(1);


        } else {
            return response()->json(0);
        }
    }
    }
    else {
       return response()->json(['error_missing'=>'All fields are required!']);
   }


    }


}