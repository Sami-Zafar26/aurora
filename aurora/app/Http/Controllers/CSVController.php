<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\CsvList;
use App\Models\User;
use App\Models\Lead;
use str_getcsv;
use Illuminate\Support\Facades\Validator;

class CSVController extends Controller
{
    function user_csv_lists()
    {
        $user_csv_lists = CsvList::where('user_id', auth()->user()->id)->whereNull('deleted_at')->paginate(14);
        // $csv = User::with('users_csv_lists')->get();
        // dd($csv);
        // // dd($csv[0]->users_csv_lists);
        // foreach ($csv as $key => $value) {
        //     echo $value->first_name." ";
        //     foreach ($csv[0]->users_csv_lists as $keye => $vaelue) {
        //         echo $vaelue->list_name;
                
        //     }
        //     echo "<br>";
        // }
        // die;

        return view('user.lists', ['user_csv_lists' => $user_csv_lists]);
    }

    function select_list()
    {
        $allowedStatuses = ['manual', 'completed'];
        $select_list = CsvList::whereIn("status", $allowedStatuses)->where('user_id', auth()->user()->id)->get();
        $output = "";
        $output .= "<option selected disabled >Choose list</option>";
        foreach ($select_list as $key => $value) {
            $output .= "<option value='{$value['token']}'>{$value['list_name']}</option>";
        }
        return response()->json($output);
    }

    function csv_file(Request $request)
    {
        // return response()->json($request->all());

        if ($request->hasFile('csv_file')) {
        
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv',
            'list_name' => 'required',
        ]);

        if ($validator->passes()) {
            if ($request->hasFile('csv_file')) {
                $file = $request->file('csv_file');
                $filename = $file->getClientOriginalName();
                $encryptedFileName = md5($filename . time()) . ".csv";
                $fileLocation = 'app/public/pendings/' . $encryptedFileName;
                $filePath = $file->storeAs('public/pendings', $encryptedFileName);

                // $directory = storage_path($filePath);

                // $fptr = fopen($directory,'r');
                // $header = fgets($fptr);
                // $trim = trim($header);
                // $lowercase = strtolower($trim);
                // $exploded = explode(',',$lowercase);
                // if (array_search('email',$exploded)) {

                // }

                $csvList = [
                    'file_name' => $filename,
                    'list_name' => $request['list_name'],
                    'list_description' => $request['list_description'],
                    'list_location' => $fileLocation,
                    'user_id' => auth()->user()->id,
                ];

                $csvList = CsvList::create($csvList);
                $csvList->token = md5(($csvList->id . $csvList->created_at));
                $csvList->save();

                if ($csvList) {
                    return response()->json(1);
                } else {
                    return response()->json(0);
                }
            }
        } else {
            return response()->json(["error" => "The file must be a csv type and list name is required!"]);
        }
    }
    else {
        $validator = Validator::make($request->all(), [
            // 'csv_file' => 'required|mimes:csv',
            'list_name' => 'required',
        ]);

        if ($validator->passes()) {
            // if ($request->hasFile('csv_file')) {
                // $file = $request->file('csv_file');
                // $filename = $file->getClientOriginalName();
                // $encryptedFileName = md5($filename . time()) . ".csv";
                // $fileLocation = 'app/public/pendings/' . $encryptedFileName;
                // $filePath = $file->storeAs('public/pendings', $encryptedFileName);

                // $directory = storage_path($filePath);

                // $fptr = fopen($directory,'r');
                // $header = fgets($fptr);
                // $trim = trim($header);
                // $lowercase = strtolower($trim);
                // $exploded = explode(',',$lowercase);
                // if (array_search('email',$exploded)) {

                // }




                $csvList = [
                    'list_name' => $request['list_name'],
                    'list_description' => $request['list_description'],
                    'status'=>'completed',
                    'user_id' => auth()->user()->id,
                ];

                $csvList = CsvList::create($csvList);
                $csvList->token = md5(($csvList->id . $csvList->created_at));
                $csvList->save();

                if ($csvList) {
                    return response()->json(1);
                } else {
                    return response()->json(0);
                }
            // }
        } else {
            return response()->json(["error" => "The list name is required!"]);
        }
    }

    }

    function processing_csv_lists()
    {
        $pending_lists = CsvList::where('status', 'pending')->get();
        foreach ($pending_lists as $pending_list) {

            $list_location = $pending_list['list_location'];
            $directory = storage_path($list_location);

            $csvlist = CsvList::find($pending_list['id']);
            $csvlist->processing_started_at = date("d-m-y g:i a", time());
            $csvlist->status = "processing";
            $csvlist->save();

            $fptr = fopen($directory, 'r');
            $header = fgets($fptr);
            $trim = trim($header);
            $lowercase = strtolower($trim);
            $underscore = str_replace(" ", "_", $lowercase);
            $converted_to_array = explode(",", $underscore);

            $unique_array = array_unique($converted_to_array);

            $valueAskey = array();
            $first_namePos = null;
            $last_namePos = null;
            $emailPos = null;
            $phonePos = null;
            $cityPos = null;
            $statePos = null;
            $countryPos = null;
            $designationPos = null;

            if (array_search("email", $unique_array)) {
                foreach ($unique_array as $key => $value) {

                    if ($value === 'first_name') {
                        $first_namePos = array_search($value, $unique_array);
                    } elseif ($value === 'last_name') {
                        $last_namePos = array_search($value, $unique_array);
                    } elseif ($value === 'email') {
                        $emailPos = array_search($value, $unique_array);
                    } elseif ($value === 'phone') {
                        $phonePos = array_search($value, $unique_array);
                    } elseif ($value === 'city') {
                        $cityPos = array_search($value, $unique_array);
                    } elseif ($value === 'state') {
                        $statePos = array_search($value, $unique_array);
                    } elseif ($value === 'country') {
                        $countryPos = array_search($value, $unique_array);
                    } elseif ($value === 'designation') {
                        $designationPos = array_search($value, $unique_array);
                    } else {
                        $valueAskey[array_search($value, $unique_array)] = $value;
                    }
                }
                // print_r($valueAskey);
                // die;
                $fillingTheArray = [];
                while ($a = fgets($fptr)) {
                    array_push($fillingTheArray, $a);
                }
                $unique_row_array = array_values(array_unique($fillingTheArray));

                $csv_data = array_map("str_getcsv", $unique_row_array);


                foreach ($csv_data as $key => $value) {
                    $filtred_as_column = array_values(array_unique($value));
                    $leadsInfo = [
                        'first_name' => $filtred_as_column[$first_namePos],
                        'last_name' => $filtred_as_column[$last_namePos],
                        'email' => $filtred_as_column[$emailPos],
                        'csv_list_id' => $pending_list['id'],
                    ];
                    if (in_array("phone", $unique_array)) {
                        $leadsInfo['phone'] = $filtred_as_column[$phonePos];
                    }
                    if (in_array("city", $unique_array)) {
                        $leadsInfo['city'] = $filtred_as_column[$cityPos];
                    }
                    if (in_array("state", $converted_to_array)) {
                        $leadsInfo['state'] = $filtred_as_column[$statePos];
                    }
                    if (in_array("country", $unique_array)) {
                        $leadsInfo['country'] = $filtred_as_column[$countryPos];
                    }
                    if (in_array("designation", $unique_array)) {
                        $leadsInfo['designation'] = $filtred_as_column[$designationPos];
                    }
                    if (!empty($valueAskey)) {
                        $leadsExtraInfo = [];
                        foreach ($valueAskey as $index => $counting) {
                            $leadsExtraInfo[$counting] = $value[$index];
                        }
                        $leadsInfo['json_data'] = json_encode($leadsExtraInfo);
                    }

                    $lead_token = Lead::create($leadsInfo);
                    $lead_token->token = md5(($lead_token->id . $lead_token->created_at));
                    $lead_token->save();
                }
                // die;
                $csvlist->status = "completed";
                $csvlist->processing_completed_at = date("d-m-y g:i a", time());
                $csvlist->save();
            } else {
                $csvlist = CsvList::find($pending_list['id']);
                $csvlist->status = "error";
                $csvlist->error_message = "The email column is missing";
                $csvlist->save();
            }
        }
        return redirect()->back();
    }

    function upload_csv_in_existed_list(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv',
            // 'list_token' => 'required',
        ]);

        $csvList = CsvList::where('token', $request['token'])->first();
        $id=$csvList->id;

        if ($validator->passes()) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $encryptedFileName = md5($filename . time()) . ".csv";
                $fileLocation = 'app/public/pendings/' . $encryptedFileName;
                $filePath = $file->storeAs('public/pendings', $encryptedFileName);
                $csvList = [
                    'file_name' => $filename,
                    'list_name' => $request['list_name'],
                    'list_description' => $request['list_description'],
                    'list_location' => $fileLocation,
                    'user_id' => auth()->user()->id,
                ];

                $directory = storage_path($fileLocation);

                $fptr = fopen($directory, 'r');
                $header = fgets($fptr);
                $trim = trim($header);
                $lowercase = strtolower($trim);
                $underscore = str_replace(" ", "_", $lowercase);
                $converted_to_array = explode(",", $underscore);

                $unique_array = array_values(array_unique($converted_to_array));

                $valueAskey = array();
                $first_namePos = null;
                $last_namePos = null;
                $emailPos = null;
                $phonePos = null;
                $cityPos = null;
                $statePos = null;
                $countryPos = null;
                $designationPos = null;

                if (array_search("email", $unique_array)) {
                    foreach ($unique_array as $key => $value) {

                        if ($value === 'first_name') {
                            $first_namePos = array_search($value, $unique_array);
                        } elseif ($value === 'last_name') {
                            $last_namePos = array_search($value, $unique_array);
                        } elseif ($value === 'email') {
                            $emailPos = array_search($value, $unique_array);
                        } elseif ($value === 'phone') {
                            $phonePos = array_search($value, $unique_array);
                        } elseif ($value === 'city') {
                            $cityPos = array_search($value, $unique_array);
                        } elseif ($value === 'state') {
                            $statePos = array_search($value, $unique_array);
                        } elseif ($value === 'country') {
                            $countryPos = array_search($value, $unique_array);
                        } elseif ($value === 'designation') {
                            $designationPos = array_search($value, $unique_array);
                        } else {
                            $valueAskey[array_search($value, $unique_array)] = $value;
                        }
                    }

                    $fillingTheArray = [];
                    while ($a = fgets($fptr)) {
                        array_push($fillingTheArray, $a);
                    }
                    $unique_row_array = array_values(array_unique($fillingTheArray));

                    $csv_data = array_map("str_getcsv", $unique_row_array);

                    $total=count($csv_data);
                    foreach ($csv_data as $key => $value) {
                        $filtred_as_column = array_values(array_unique($value));

                        $leadsInfo = [
                            'first_name' => $filtred_as_column[$first_namePos],
                            'last_name' => $filtred_as_column[$last_namePos],
                            'email' => $filtred_as_column[$emailPos],
                            'csv_list_id' => $id,

                        ];
                        if (in_array("phone", $unique_array)) {
                            $leadsInfo['phone'] = $filtred_as_column[$phonePos];
                        }
                        if (in_array("city", $unique_array)) {
                            $leadsInfo['city'] = $filtred_as_column[$cityPos];
                        }
                        if (in_array("state", $converted_to_array)) {
                            $leadsInfo['state'] = $filtred_as_column[$statePos];
                        }
                        if (in_array("country", $unique_array)) {
                            $leadsInfo['country'] = $filtred_as_column[$countryPos];
                        }
                        if (in_array("designation", $unique_array)) {
                            $leadsInfo['designation'] = $filtred_as_column[$designationPos];
                        }
                        if (!empty($valueAskey)) {
                            $leadsExtraInfo = [];
                            foreach ($valueAskey as $index => $counting) {
                                $leadsExtraInfo[$counting] = $value[$index];
                            }
                            $leadsInfo['json_data'] = json_encode($leadsExtraInfo);
                        }


                        $lead_token= Lead::updateOrCreate(
                            ['email'=>$filtred_as_column[$emailPos],'csv_list_id'=> $id],
                            $leadsInfo
                        );
                        $lead_token->token = md5(($lead_token->id . $lead_token->created_at));
                        $lead_token->save();
                        
                        if ($key === $total-1) {
                            return response()->json(1);
                        }

                    }
                    return response()->json(0);

                } else {
                    return response()->json(["column_missing" => "Email column not found in this csv list failed to save!"]);
                }
            }
        } else {
            return response()->json(["error" => "The file must be a csv type and list name is required!"]);
        }
    }

    function reupload_list(Request $request)
    {
        // return response()->json($request->all());

        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();

        $fileLocation = 'app/public/pendings/' . $filename;
        $file->storeAs('public/pendings', $filename);

        $csvList = CsvList::where('token', $request['token'])->first();
        $encryptedFileName = md5($filename . time()) . ".csv";
        $csvList->file_name = $encryptedFileName;
        $csvList->list_name = $request['list_name'];
        $csvList->list_description = $request['list_description'];
        $csvList->list_location = $fileLocation;
        $csvList->status = "pending";
        $csvList->error_message = null;
        $csvList->processing_started_at = null;
        $csvList->save();

        if ($csvList) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    function custom_list(Request $request)
    {
        // Validate the incoming form data
        $validator = Validator::make($request->all(), [
            'list_name' => 'required',
            // Add other validation rules for other fields
        ]);

        if ($validator->passes()) {
            $csvList = [
                'file_name' => $request['list_name'],
                'list_name' => $request['list_name'],
                'list_description' => $request['list_description'],
                'status' => "manual",
                'user_id' => auth()->user()->id,
            ];
            $csvList = CsvList::create($csvList);
            $csvList->token = md5(($csvList->id . $csvList->created_at));
            $csvList->save();

            if ($csvList) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
        } else {
            return response()->json(['error' => "List name is required!"]);
        }
    }

    function custom_add(Request $request)
    {
        $data = $request->all();
        // $validation=$request->validate([
        //     'email'=>'required|email',
        // ]);
        // if (empty($validation)) {
        //     return response()->json("crud");
        // }else{
        //     return response()->json($validation);
        // }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'list_token' => 'required',
        ]);
        if ($validator->passes()) {
            // return response()->json(['success'=>"successfully!"]);
            $csvList = CsvList::where('token', $request['list_token'])->first();
            $id = $csvList->id;
            $lead = Lead::where("csv_list_id", $id)->where("email", $request['email'])->exists();
            if ($lead) {
                return response()->json(2);
            }

            $user = [
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'csv_list_id' => $id,
            ];
            $load = Lead::create($user);

            if ($request->has('attribute_name') && $request->has('attribute_value')) {
                $optional_field = [];
                foreach ($request->input('attribute_name') as $key => $value) {
                    if (!empty($request->input('attribute_name')) && !empty($request->input('attribute_value')[$key])) {
                        $optional_field[$value] = $request->input('attribute_value')[$key];
                    }
                }
            }

            if (!empty($optional_field)) {
                $load->json_data = json_encode($optional_field);
                $load->save();
            }

            $load->token = md5(($load->id . $load->created_at));
            $load->save();

            if ($load) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
        } else {
            return response()->json(['error' => "Email field and list is required!"]);
        }
    }

    public function delete_list($token) {
        $list = CsvList::where("token",$token)->first()->delete();
        if ($list) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    public function edit_list($token) {

        $list = CsvList::where('token',$token)->first();

        if (!$list) {
            return response()->json(['error' => 'Lead not found'], 404);
        }
        $output="";
        $output.="
        <div>
            <div class='mb-3'>
                <input type='hidden' name='token' value='{$list->token}'>
                <label for='list_name' class='form-label'>Give name to your list</label>
                <input class='form-control' type='text' name='list_name' id='list_name' value='{$list->list_name}'>
            </div>";
        if (isset($list->list_description)) {
            $output.= "<div class='mb-3'>
                        <label for='list_description' class='form-label'>Description about list (Optional)</label>
                        <textarea name='list_description' id='list_description' class='form-control' cols='30' rows='4'>{$list->list_description}</textarea>
                    </div>
            </div>
            ";
        } else {
            $output.= "<div class='mb-3'>
                        <label for='list_description' class='form-label'>Description about list (Optional)</label>
                        <textarea name='list_description' id='list_description' class='form-control' cols='30' rows='4'
                        placeholder='Description here...'></textarea>
                    </div>
            </div>
            ";
        }

        return response()->json($output);

    }

    public function update_list(Request $request) {

            $csvList=CsvList::where('token',$request['token'])->first()->update([
                'list_name'=>$request['list_name'],
                'list_description'=>$request['list_description'],
            ]);

            if ($csvList) {
                return response()->json(1);
            } else {
                return response()->json(0);
            }
        
    }
}
