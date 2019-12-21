<?php

namespace App\Http\Controllers\Api;

use App\Bibledata;
use App\Crop;
use App\Customer;
use App\Farm;
use App\Http\Controllers\CommonFunctions;
use App\Plot;
use App\Prayer;
use App\Prayertype;
use App\Region;
use App\Sublocation;
use App\User;
use URL ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\AppMessage ;
use App\Patron;

class ApiController extends Controller
{

    public $successStatus = 200;
    public $failStatus = 200;
    public $failStatus1 = 200;

    public function getAppMessage(){
        $msg_data = AppMessage::select('text')->first();
        if(($msg_data)!=""){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$msg_data], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data', 'data' => []], $this->failStatus);
        }
    }
    public function getPatronData(){
        $path=URL::asset('storage/upload/files/image/');
        $msg_data = Patron::select( '*',DB::raw('CONCAT( "'.$path.'",patron_image) as patron_image') )->first();
        if(($msg_data)!=""){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$msg_data], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data'=>[]], $this->failStatus);
        }
    }
     public function getAllBibledata(){
        // $bible = Bibledata::where('date', 'like', '%'.date("Y").'%')->get();
      $bible = Bibledata::get();  
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data' => []], $this->failStatus);
        }
    }

    public function getAllPrayer(){
        $path=URL::asset('storage/upload/files/audio/');
         $path_default=URL::asset('storage/upload/files/audio/sample.mp3');
        $bible = Prayer::select('idprayers','prayer','title','subtitle','text',DB::raw(' (CASE WHEN  prayer_audio<> NULL THEN  CONCAT( "'.$path.'","prayer_audio") ELSE "'.$path_default.'" END) as prayer_audio'),'orderno')->get();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' , 'data' =>[] ], $this->failStatus);
        }
    }

    public function getAllPrayerTypes(){
        $bible = Prayertype::all();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data' => [] ], $this->failStatus);
        }
    }

    public function getAllPrayerByType(Request $request){
        $rules = [
            'prayertype_id' => 'integer|required|exists:prayertype,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);

        }

        $CollectionAgent = Prayer::wherePrayer($request->prayertype_id)->get();
        if(sizeof($CollectionAgent)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$CollectionAgent], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data' => []], $this->failStatus);
        }
    }

    public function getBibleByDate(Request $request){
        $rules = [
            'date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);

        }

        $CollectionAgent = Bibledata::where('date', '=', $request->date)->get();
        if(sizeof($CollectionAgent)>0){
            return response(['status'=>1,'message'=>'Data Found', 'datat'=>$CollectionAgent], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data' => []], $this->failStatus);
        }
    }



    //----------------------------api------------------------------

    public function saveAgent(Request $request){

//        'fname',
//        'lname',
//        'address',
//        'house_no',
//        'region',
//        'landmark',
//        'sub_location',
//        'email',
//        'phone',
//        'dob',
//        'referal_code',
//        'password',
//        'device_id',
//        'device_token',
        $rules = [
            'id'    => 'sometimes|nullable|exists:customers,id',
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
//            'address' => ['required', 'string'],
//            'region' => ['required', 'string'],
//            'sub_location' => ['required', 'string'],
//            'device_id' => ['required', 'string'],
//            'device_token' => ['required', 'string'],
//            'phone' => ['required', 'string'],
//            'dob' => ['required', 'string'],
//            'referal_code' => ['string'],
//            'landmark' => ['string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'unique:customers'],
        ];
        if ($request->has('id')) {
            $CollectionAgent = Customer::whereId($request->id)->first();
//            if($CollectionAgent) {
//                $rules['email'] = 'required|unique:users,email,' . $CollectionAgent->user_id;
//            }
        } else {
//            $rules['password'] = 'required|string|confirmed|min:6';
            $rules['password'] = 'required|string';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
//            dd($validator->errors());
//            return redirect()->back()->withErrors(['message'=>$validator->errors()->first(),'data' => []])->withInput($request->all());
//            return response(['message'=>$validator->errors()->first(),'data' => []], $this->failStatus);
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);

        }
        if(!isset($CollectionAgent)){
            $CollectionAgent = new Customer();
        } else {
            $User = User::whereId($CollectionAgent->customer_id)->first();
        }
        if($CollectionAgent){

//        'fname',
//        'lname',
//        'address',
//        'house_no',
//        'region',
//        'landmark',
//        'sub_location',
//        'email',
//        'phone',
//        'dob',
//        'referal_code',
//        'password',
//        'device_id',
//        'device_token',

            $CollectionAgent->fname = $request->fname;
            $CollectionAgent->lname = $request->lname;
            $CollectionAgent->address = $request->address;
            $CollectionAgent->house_no = $request->house_no;
            $CollectionAgent->landmark = $request->landmark;
            $CollectionAgent->region = $request->region;
            $CollectionAgent->sub_location = $request->sub_location;
            $CollectionAgent->email = $request->email;
            $CollectionAgent->phone = $request->phone;
            $CollectionAgent->dob = $request->dob;
            $CollectionAgent->referal_code = $request->referal_code;
            $CollectionAgent->device_id = $request->device_id;
            $CollectionAgent->device_token = $request->device_token;
            $password = Hash::make($request->password);
            $CollectionAgent->password = $password;
            $CollectionAgent->save();

            if(!isset($User)){
                $User = new User();
            }
            $User->user_type = 0;
            $User->name = $request->fname;
            $User->email = $request->email;
            $User->customer_id = $CollectionAgent->id;
            if($request->has('password')) {
                $User->password = $password;
            }
            $User->save();

            $userresp=[];
            $customer = Customer::select('id', 'fname', 'lname', 'email','password', 'phone', 'sub_location',
                'landmark', 'address', 'house_no')
                ->whereId($CollectionAgent->id)->get();
        }

        return response(['status'=>1,'customer'=>$customer,'message'=>'User saved successfully','data' => []], $this->successStatus);
    }

    public function updateProfile(Request $request){
        $rules = [
            'customer_id'    => 'required|exists:customers,id',
//            'fname' => ['required', 'string', 'max:255'],
//            'lname' => ['required', 'string', 'max:255'],
//            'address' => ['required', 'string'],
//            'region' => ['required', 'string'],
//            'sub_location' => ['required', 'string'],
//            'device_id' => ['required', 'string'],
//            'device_token' => ['required', 'string'],
//            'phone' => ['required', 'string'],
//            'dob' => ['required', 'string'],
//            'referal_code' => ['string'],
//            'landmark' => ['string'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);
        }


        $CollectionAgent = Customer::whereId($request->customer_id)->first();
        $CollectionAgent->fname = $request->fname;
        $CollectionAgent->lname = $request->lname;
        $CollectionAgent->address = $request->address;
        $CollectionAgent->house_no = $request->house_no;
        $CollectionAgent->landmark = $request->landmark;
        $CollectionAgent->region = $request->region;
        $CollectionAgent->sub_location = $request->sub_location;
        $CollectionAgent->phone = $request->phone;
        $CollectionAgent->dob = $request->dob;


        $User = User::whereCustomerId($request->customer_id)->first();
        if(!isset($User)){
            return response(['status'=>0,'message'=>"User does not exist",'data' => []], $this->failStatus);
        }

        $file = $request->file('photo');
        if(isset($file) && $file!= '' ) {
            $destinationUrlPath = '/uploads/user';
            //destination folder
            $destinationPath = public_path() . $destinationUrlPath;
            //create folder to save image
            File::makeDirectory($destinationPath, 0775, true, true);
            // changing image name
            $name = Str::slug(Carbon::now());
            $filename = $file->getClientOriginalName();
//                $ImgName = explode(".",$filename);
//                $filename = $name.'.'.$ImgName[1];
            $extension = File::extension($filename);
            $filename = $name.'.'.$extension;

            Input::file('photo')->move($destinationPath, $filename);
            //save file to the destination folder
            $CollectionAgent->photo  = "https://efarming.tricta.com".$destinationUrlPath . '/' . $filename;
        }

        $CollectionAgent->save();

        if($request->fname) {
            $User->name = $request->fname;

        }

        $User->save();

        $customer = Customer::select('id', 'fname', 'lname', 'email','phone', 'photo','dob',
            DB::raw("'0' as plot_name"),DB::raw("'1' as farm_id"),DB::raw("'0' as plot_description"), 'sub_location',
            'landmark', 'address', 'house_no', 'photo')
            ->whereId($request->customer_id)->get();
        return response(['status'=>1,'data'=>$customer,'message'=>'Customer updated successfully','data' => []], $this->successStatus);

    }

    public function agentLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    => 'email|exists:users,email',
            'password'    => 'required',
        ]);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);
        }
        $User = User::whereEmail($request->email)->whereStatus(1)->first();
        if($User && (Hash::check($request->password, $User->password))){
            $User->access_token = $this->LocalPassport();
            $User->save();
            $customer = Customer::whereId($User->customer_id)->get();
            return response(['status'=>1,'message'=>'Login successful','access_token' =>$User->access_token, 'customer'=>$customer], $this->successStatus);
        }
        return response(['status'=>0,'message'=>"Invalid email or password",'data' => []], $this->failStatus);
    }


    public function getCustomer(Request $request){

        $rules = [
            'customer_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);

        }
        $customer = Customer::whereId($request->customer_id)->get();
        if(isset($customer)){
            return response(['status'=>1,'message'=>'Customer details found', 'data'=>$customer], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No such Customer','data' => []], $this->failStatus);
        }

    }
 



}
