<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Models\CampaignTemplate;
use App\Models\IntegrationCredential;
use App\Models\CsvList;
use App\Models\Lead;
use App\Models\User;
use App\Models\Schedule;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;

class SendCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendCampaign:send-campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This schedule for sending mail to others';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // $campaign = Campaign::where('status','pending')
        // ->where('is_active',1)
        // ->where('utc_time','<', now()) 
        // ->orderBy('utc_time', 'asc')
        // ->first();
        // print_r($campaign);
        $twentyMinutesAgo = Carbon::now()->subMinutes(20);
        $campaign = Campaign::where('campaigns.status', 'pending')
        ->where('is_active', 1)
        ->whereBetween('utc_time', [$twentyMinutesAgo, Carbon::now()])
        ->orderBy('utc_time', 'asc')
        ->first();
//  print_r($campaign);

        if ($campaign != null) {
        
        // if (strtotime($schedule->utc_time) <= strtotime(date("Y-m-d H:i:00"))) {

            Campaign::where('id',$campaign->id)->first()->update([
                'status'=>'sending'
            ]);

            $leads = Lead::where('csv_list_id',$campaign->csv_list_id)->get();
            $campaign_template = CampaignTemplate::where('id',$campaign->campaign_template_id)->first();
            $integration_credential = IntegrationCredential::where('id',$campaign->integration_credential_id)->first();
            $user = User::where('id',$campaign->user_id)->first();

            $decoded = json_decode($integration_credential->json_field_value,true);
            foreach ($leads as $keye => $lead) {
                
            $to['email'] = $lead->email;      
            $to['name'] =  $lead->first_name;   
            $subject = $campaign_template->campaign_template_subject;
            $str = $campaign_template->campaign_template_body;

            // $fname = $lead->first_name != null ? $lead->first_name : '';
            // $lname = $lead->last_name  != null ? $lead->last_name  : '';
            // $email = $lead->email      != null ? $lead->email      : '';
            // $sender = str_contains($str, '{{SENDER}}') ? $user->first_name : '';

            // $str = str_replace('{{FNAME}}',$fname, $str);
            // $str = str_replace('{{LNAME}}',$lname, $str);
            // $str = str_replace('{{EMAIL}}',$email, $str);
            // $str = str_replace('{{SENDER}}',$sender, $str);


            // this is for subject
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

            $mail = new PHPMailer();
            $mail->IsSMTP();                                     
            $mail->SMTPAuth = true;
            $mail->Host = $decoded[2]['MAIL_HOST'];
            $mail->Port = $decoded[3]['MAIL_PORT'];
            $mail->Username = $decoded[4]['MAIL_USERNAME'];
            $mail->Password = $decoded[5]['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->From = $decoded[1]['MAIL_FROM'];
            $mail->FromName = $user->first_name;
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
        } else {
            $mail->ClearAddresses();
        }
        }
            Campaign::where('id',$campaign->id)->first()->update([
                'status'=>'sent'
            ]);
        // }
    }

    }
}
