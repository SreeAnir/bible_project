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

class ApiController extends Controller
{

    public $successStatus = 200;
    public $failStatus = 200;
    public $failStatus1 = 200;

    public function getAllBibledata(){
        $bible = Bibledata::all();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Datas found', 'bibledatas'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No datas'], $this->failStatus);
        }
    }

    public function getAllPrayer(){
        $bible = Prayer::all();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Datas found', 'prayers'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No datas'], $this->failStatus);
        }
    }

    public function getAllPrayerTypes(){
        $bible = Prayertype::all();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Datas found', 'prayertypes'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No datas'], $this->failStatus);
        }
    }

    public function getAllPrayerByType(Request $request){
        $rules = [
            'prayertype_id' => 'integer|required|exists:prayertype,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

        $CollectionAgent = Prayer::wherePrayer($request->prayertype_id)->get();
        if(sizeof($CollectionAgent)>0){
            return response(['status'=>1,'message'=>'Datas found', 'prayer'=>$CollectionAgent], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No datas'], $this->failStatus);
        }
    }

    public function getBibleByDate(Request $request){
        $rules = [
            'date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

        $CollectionAgent = Bibledata::where('date', '=', $request->date)->get();
        if(sizeof($CollectionAgent)>0){
            return response(['status'=>1,'message'=>'Datas found', 'Bibledata'=>$CollectionAgent], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No datas'], $this->failStatus);
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
//            return redirect()->back()->withErrors(['message'=>$validator->errors()->first()])->withInput($request->all());
//            return response(['message'=>$validator->errors()->first()], $this->failStatus);
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

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

        return response(['status'=>1,'customer'=>$customer,'message'=>'User saved successfully'], $this->successStatus);
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
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);
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
            return response(['status'=>0,'message'=>"User does not exist"], $this->failStatus);
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
        return response(['status'=>1,'data'=>$customer,'message'=>'Customer updated successfully'], $this->successStatus);

    }

    public function agentLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    => 'email|exists:users,email',
            'password'    => 'required',
        ]);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);
        }
        $User = User::whereEmail($request->email)->whereStatus(1)->first();
        if($User && (Hash::check($request->password, $User->password))){
            $User->access_token = $this->LocalPassport();
            $User->save();
            $customer = Customer::whereId($User->customer_id)->get();
            return response(['status'=>1,'message'=>'Login successful','access_token' =>$User->access_token, 'customer'=>$customer], $this->successStatus);
        }
        return response(['status'=>0,'message'=>"Invalid email or password"], $this->failStatus);
    }


    public function getCustomer(Request $request){

        $rules = [
            'customer_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }
        $customer = Customer::whereId($request->customer_id)->get();
        if(isset($customer)){
            return response(['status'=>1,'message'=>'Customer details found', 'customer'=>$customer], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No such Customer'], $this->failStatus);
        }

    }
//    public function getRegions(Request $request){
//
////        $CollectionAgent =   Region::all();
//
//        $CollectionAgent = Region::select('id as location_id', 'region as parent_region',
//            'region as sublocation_name')->get();
//
//
//        return response(['status'=>1,'data' => $CollectionAgent, 'message'=>'Regions fetched successfully'], $this->successStatus);
//
//    }
//
//
//    public function getSublocations(Request $request){
//
//        $rules = [
//            'region_id' => 'required|string'
//        ];
//
//        $validator = Validator::make($request->all(), $rules);
//        if($validator->fails()){
//            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);
//
//        }
////        $customer = Sublocation::whereRegionId($request->region_id)->get();
//        $reg = Region::whereRegion($request->region_id)->first();
////        dd($reg);
////        return response($reg->id);
//
//        $customer = Sublocation::select('id', 'region_id','sublocation')->whereRegionId($reg->id)->get();
////        return response($customer);
//        if(count($customer)<=0){
//            return response(['status'=>0,'message'=>'No Sublocations'], $this->failStatus);
//        }else{
//            return response(['status'=>1,'message'=>'Sublocations found', 'sublocations'=>$customer], $this->successStatus);
//
//        }
//
//    }
    public function getRegions(Request $request){
//        $CollectionAgent =   Region::all();
        $rules = [
//            'region_id' => 'region_id'
            'sub_location' => 'required'
        ];
                $sub = Sublocation::whereSublocation($request->sub_location)->first();


        $CollectionAgent = Region::select('id as location_id', 'region as parent_region',
            'region as sublocation_name')->whereId($sub->region_id)->get();
//            'region as sublocation_name')->whereId($request->region_id)->get();
        return response(['status'=>1,'data' => $CollectionAgent, 'message'=>'Regions fetched successfully'], $this->successStatus);

    }

    public function getSublocations(Request $request){
        $rules = [
//            'region_id' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }
//        $customer = Sublocation::whereRegionId($request->region_id)->get();
//        $reg = Region::whereRegion($request->region_id)->first();
//        dd($reg);
//        return response($reg->id);

//        $customer = Sublocation::select('id', 'region_id','sublocation')->whereRegionId($reg->id)->get();
        $customer = Sublocation::select('id', 'region_id','sublocation')->get();
//        return response($customer);
        if(count($customer)<=0){
            return response(['status'=>0,'message'=>'No Sublocations'], $this->failStatus);
        }else{
            return response(['status'=>1,'message'=>'Sublocations found', 'sublocations'=>$customer], $this->successStatus);

        }
    }

    public function availablePlots(Request $request){
        $rules = [
            'customer_id'    => 'required|exists:customers,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

        $plot = Farm::whereId(1)->orderBy('id','DESC')->first();
        $plotofcs = Plot::whereCustomerId($request->customer_id)->orderBy('id','DESC')->count();
        $plotamount =$plot->rate_of_one_plot;
        if($plotofcs <=0){
            $plotamount =$plotamount-$plot->discount_amount;
        }
//        return response($plot);
        $CollectionAgent =   Farm::select('farming_partner_id','farming_partner_name','email',
        'phone','calender','register_date','id as farm_id','farm_name','farm_photo',
        'farm_description','farm_address','farm_location','plot_capacity','remain_capacity' ,'farm_latlong as farm_location',
            DB::raw("'$plotamount' as rate_of_one_plot"),DB::raw("'$plotofcs' as plots_of_customer"))
//        'farm_description','farm_address','farm_location','plot_capacity','remain_capacity' ,'farm_latlong as farm_location' )
            ->get();

        if(count($CollectionAgent)<=0){
            return response(['status'=>0,'plots' => $CollectionAgent, 'message'=>'No Plots Available'], $this->failStatus);
        }else{
            return response(['status'=>1,'plots' => $CollectionAgent, 'message'=>'Available Plots fetched successfully'], $this->successStatus);
        }

    }

    public function plotDetails(Request $request){
        $rules = [
            'farm_id' => 'required',
            'customer_id'    => 'required|exists:customers,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }
        $farm = Farm::whereId(1)->orderBy('id','DESC')->first();

//        $plot = Plot::whereCustomerId($request->customer_id)->orderBy('id','DESC')->first();
        $plot = Plot::whereFarmId(1)->orderBy('id','DESC')->first();


        $plotofcs = Plot::whereCustomerId($request->customer_id)->orderBy('id','DESC')->count();
        $plotamount =$farm->rate_of_one_plot;
        if($plotofcs <=0){
            $plotamount =$plotamount-$farm->discount_amount;
        }
        if(!$plot){
            $plid = 1;
        }else{
            $plid=$plot->id+1;

        }
        $lotnumber = "F1PL00".$plid;

        $CollectionAgent =   Farm::select('farming_partner_id','farming_partner_name','email',
            'phone','calender','register_date','id as farm_id','farm_name','farm_photo',
            'farm_description','farm_address','farms.farm_latlong as farm_location','plot_capacity','remain_capacity',
            DB::raw("'$lotnumber' as plot_number"),DB::raw("'$plotamount' as rate_of_one_plot"))
//            'farm_description','farm_address','farms.farm_latlong as farm_location','plot_capacity','remain_capacity',DB::raw("'$lotnumber' as plot_number"))
            ->whereId($request->farm_id)
            ->get();


//        return response($customer);
        if(!$CollectionAgent){
            return response(['status'=>0,'message'=>'No Such Plot'], $this->failStatus);
        }else{
            return response(['status'=>1,'message'=>'Plot Details Fetched Successfully', 'data'=>$CollectionAgent], $this->successStatus);

        }

    }



    public function vegetablesList(Request $request){

        $rules = [
            'farm_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }
//        veg_cat_id


        $customer1 = Crop::select('id as vegetable_id','veg_cat_id','veg_image',
            'veg_name','local_language','veg_calendar_id','farm_id','rotation','sapling_date',
            'sapling_date','deweeding1','deweeding2','deweeding3','fertilizing1','fertilizing2','fertilizing3','harvesting' )
            ->whereFarmId($request->farm_id)->whereVegCatId(0)->get();
        $customer2 = Crop::select('id as vegetable_id','veg_cat_id','veg_image',
            'veg_name','local_language','veg_calendar_id','farm_id','rotation','sapling_date',
            'sapling_date','deweeding1','deweeding2','deweeding3','fertilizing1','fertilizing2','fertilizing3','harvesting' )
            ->whereFarmId($request->farm_id)->whereVegCatId(1)->get();
//        if(count($customer)<=0){
//            return response(['status'=>0,'message'=>'No Vegetables'], $this->failStatus);
//        }else{
            return response(['status'=>1,'message'=>'Vegetables found', 'data'=>$customer1, 'admin_vegetablelist'=>$customer2], $this->successStatus);

//        }

    }

    public function vegetablesPopup(Request $request){

        $rules = [
            'farm_id' => 'required|integer',
            'vegetable_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

        $customer = Crop::select('farm_id', 'id as vegetable_id',
            'sapling_date', 'deweeding1', 'deweeding2','deweeding3', 'fertilizing1', 'fertilizing2',
            'fertilizing3', 'harvesting')
            ->whereId($request->vegetable_id)->get();
        if(!$customer){
            return response(['status'=>0,'message'=>'No Such Vegetable'], $this->failStatus);
        }else{
            return response(['status'=>1,'message'=>'Vegetable Deatils fetched successfully', 'data'=>$customer], $this->successStatus);

        }

    }


    public function addcustomerSlots(Request $request){
        $validator = Validator::make($request->all(), [
//            'customer_id'    => 'required|exists:customers,id',
            'customer_id'    => 'required|exists:customers,id',
            'farm_id'    => 'required|exists:farms,id',
            'plot_name'    => 'required|string',
            'plot_description'    => 'required|string',
//            'sub_location'    => 'required',
//            'address'    => 'required|string',
//            'landmark'    => 'required|string',
//            'referal_code'    => 'required|string',
//            'payment_referance'    => 'required|string',
//            'payment_date'    => 'required',
//            'amount'    => 'required',
//            'veg_list'    => 'required|string',
        ]);
        if($validator->fails()){
            return response(['message'=>$validator->errors()->first()], $this->failStatus);
        }

        $plotofcs = Plot::whereCustomerId($request->customer_id)->orderBy('id','DESC')->count();
        if($plotofcs >0){
            return response(['status'=>0,'message'=>"Plot Already Purchased"], $this->failStatus);
        }
//        if($request->has('plot_id')){
//            $Collections = Plot::whereId($request->farm_id)->first();
//        } else {
//            $Collections = new Plot();
//        }
//        $Collections = new Plot();

        $Collections = new Plot();
        $Collections->customer_id =  $request->customer_id;
        $Collections->farm_id = $request->farm_id;
        $Collections->plot_name = $request->plot_name;
        $Collections->plot_description = $request->plot_description;
        $Collections->landmark = $request->landmark;
        $Collections->payment_date = $request->payment_date;
        $Collections->payment_referance = $request->payment_referance;
        $Collections->referal_code = $request->referal_code;
        $Collections->amount = $request->amount;
        $Collections->veg_list = $request->veg_list;
        $Collections->save();

        $farmdet = Farm::whereId(1)->first();
        if($farmdet->remain_capacity==0){
            return response(['status'=>0,'message'=>"Reached Maximum Capacity"], $this->failStatus);

        }
        $farmdet->remain_capacity = $farmdet->remain_capacity-1;
        $farmdet->save();
//        $input = 'remain_capacity'
//        $result = Farm::whereId($request->id)->Update($input);

//        $Collections->farming_partner_id = $request->customer_id;
//        $Collections->farming_partner_name = $request->farming_partner_id;
//        $Collections->calender = $request->farming_partner_id;
//        $Collections->register_date = $request->farming_partner_id;
//        $Collections->farm_name = $request->farm_name;
////        $Collections->farm_photo = $request->running_id;
//        $Collections->farm_description = $request->plot_description;
//        $Collections->farm_address = $request->address;
//        $Collections->farm_location_id = $request->sub_location;
////        $Collections->plot_capacity = $request->running_id;
//        $Collections->plot_id = $request->plot_id;
//        $Collections->plot_name = $request->plot_name;
//        $Collections->plot_description = $request->plot_description;
//        $Collections->landmark = $request->landmark;
//        $Collections->payment_date = Carbon::createFromFormat('Y:m:d H:i:s', $request->payment_date);
//        $Collections->payment_referance = $request->payment_referance;
//        $Collections->referal_code = $request->referal_code;
//        $Collections->amount = $request->amount;
//        $Collections->veg_list = $request->veg_list;
//        $Collections->save();
//        return response();

        $customer = Farm::select('farming_partner_id', 'farming_partner_name',
            'email', 'phone', 'calender','register_date',  'farm_name', 'farm_photo', 'farm_description',
            'farm_address', 'farm_address','farm_location', 'plot_capacity')
            ->whereId($request->farm_id)->get();
        return response(['status'=>1, 'data'=>$customer,'message'=>'Farm saved successfully'], $this->successStatus);
    }


    public function manageCustomerfarm(Request $request){
        $rules = [
            'customer_id' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

//        $customer = Crop::select('farm_id', 'id as vegetable_id',
//            'sapling_date', 'deweeding1', 'deweeding2','deweeding3', 'fertilizing1', 'fertilizing2',
//            'fertilizing3', 'harvesting')
//            ->whereId($request->vegetable_id)->first();

//        $customer = Customer::with('Farm')->whereId($request->customer_id)->first();


        $plot = Plot::whereCustomerId($request->customer_id)->orderBy('id','DESC')->first();
        $plid=$plot->id;
        $lotnumber = "F1PL00".$plid;


    $data = DB::table('farms')
     ->select('customers.id as customer_id','customers.fname','customers.lname','customers.email',
         'farms.id as farm_id','plots.id as customer_plot_id','plots.plot_description',
         'plots.landmark','farms.farm_address as address','plots.payment_date','plots.payment_referance','plots.amount',
         DB::raw("'$lotnumber' as plot_number"),
         'farms.register_date as sapling_date',
         'farms.register_date as delivery_date1',
         'farms.register_date as delivery_date2',
         'farms.register_date as delivery_date3',
         'farms.register_date as delivery_date4',
//         'farms.farm_name','farms.farm_photo','plots.plot_name','farms.farming_partner_name',DB::raw("CONCAT(lat,long) AS sub_location "))
         'farms.farm_name','farms.farm_photo','plots.plot_name','farms.farming_partner_name','farms.farm_latlong as sub_location')
     ->join('customers','customers.farm_id','=','farms.id')
     ->join('plots','plots.farm_id','=','farms.id')
//     ->where(['plots.customer_id' => $request->customer_id])
     ->where(['customers.id' => $request->customer_id])
//     ->where(['plots.customer_id' => $request->customer_id])
     ->where(['plots.id' => $plot->id])
     ->get();


        if(count($data)<=0){
            return response(['status'=>0,'message'=>'No Such Details'], $this->failStatus);
        }else{
//            return response(['status'=>1,'message'=>'Details fetched successfully', 'vegetable'=>$customer], $this->successStatus);
            return response(['status'=>1,'message'=>'Details fetched successfully', 'data'=>$data], $this->successStatus);

        }

    }

    public function farmPlotlist(Request $request)
    {

        $rules = [
            'farm_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response(['status' => 0, 'message' => $validator->errors()->first()], $this->failStatus);

        }

        $customer = Farm::select('id as farm_id', 'plot_name','farms.farm_latlong as sub_location')
            ->whereId($request->farm_id)->get();
        if (!$customer) {
            return response(['status' => 0, 'message' => 'No Such Plot'], $this->failStatus);
        } else {
            return response(['status' => 1, 'message' => 'Plot Details fetched successfully', 'data' => $customer], $this->successStatus);

        }

    }

    public function instructFarmer(Request $request)
    {

        $rules = [
            'customer_id' => 'required|integer',
            'farming_partner_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response(['status' => 0, 'message' => $validator->errors()->first()], $this->failStatus);

        }
        $customer['customer_id'] = $request->customer_id;
        $customer['farming_partner_id'] = $request->farming_partner_id;
//        $customer = Farm::select('id as farm_id', 'plot_name')
//            ->whereId($request->farm_id)->first();
//        if (!$customer) {
//            return response(['status' => 0, 'message' => 'No Such Vegetable'], $this->failStatus);
//        } else {
            return response(['status' => 1, 'message' => 'Instructed successfully', 'data' => $customer], $this->successStatus);

//        }

    }


    public function getcustomerSlots(Request $request){

        $rules = [
            'customer_plot_id' => 'required'
        ];
//        customer_plot_id
//slot
//vegetable_id
//vegetable_name
//veg_image

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }
//        $customer = Plot::whereId($request->customer_plot_id)->first();
        $customer = Plot::whereCustomerId($request->customer_plot_id)->orderBy('id','DESC')->first();

        $vegarray = explode(",",$customer->veg_list);
//        return response($customer->veg_list);
//        foreach(){
//
//        }
//        $data = Crop::select(DB::raw("'$request->customer_plot_id' as customer_plot_id"),
//            'veg_name as vegetable_name','veg_image',DB::raw("'$request->customer_plot_id' as slot"))
//            ->whereIn('id', $vegarray)
//            ->get();


        $data = Crop::select(DB::raw("'$customer->id' as customer_plot_id"),DB::raw("'$customer->id' as slot"),'id as vegetable_id',
            'veg_name as vegetable_name','veg_image')
            ->whereIn('id', $vegarray)
            ->get();
//        $data = Crop::select("id as customer_plot_id",
//            'veg_name as vegetable_name','veg_image',"id as slot")
//            ->whereIn('id', $vegarray)
//            ->get();


//        return response($customer);
        if(!$data){
            return response(['status'=>0,'message'=>'No Such Plot'], $this->failStatus);
        }else{
            return response(['status'=>1,'message'=>'Plot Details Fetched Successfully', 'data'=>$data], $this->successStatus);

        }

    }

    public function forgotpassword(Request $request){

        $rules = [
            'email' => 'email|required|exists:customers,email'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

//        $data['email'] = "ajithmohan17may92@gmail.com";
        $data['email'] = "$request->email";
//        $current_timestamp = Carbon::now()->timestamp;
        $otp = rand ( 1000 , 9999 );

        $data['message'] = "Your password reset OTP is $otp";
        $data['subject'] =  "EFARMING RESET OTP";

//        Mail ::raw('Hi, welcome user!', function ($message) {
//            $message->to("ajithmohan17may92@gmail.com")
//                ->subject("test");
//        });
         Mail::raw( $data['message'], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['subject']);
        });

        $CollectionAgent = Customer::whereEmail($request->email)->first();
        $CollectionAgent->otp = $otp;
        $CollectionAgent->save();
        return response(['status'=>1,'message'=>'OTP send Successfully'], $this->successStatus);
    }


    public function customerForgotpassword(Request $request){
        $rules = [
            'email' => 'email|required|exists:customers,email',
            'sentcode' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);

        }

        $CollectionAgent = Customer::whereEmail($request->email)->whereOtp($request->sentcode)->first();
        if(!isset($CollectionAgent)){
            return response(['status'=>0,'message'=>'Wrong email OR OTP'], $this->failStatus);

        }
        return response(['status'=>1,'message'=>'OTP send Successfully'], $this->successStatus);
    }

    public function customerUpdatepassword(Request $request){
            $rules = [
                'email' => 'email|required|exists:customers,email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);
            }

            $pass =Hash::make($request->password);

            $CollectionAgent = Customer::whereEmail($request->email)->first();
            $CollectionAgent->password = $pass;


            $User = User::whereEmail($request->email)->first();
            if(!isset($User)){
                return response(['status'=>0,'message'=>"User does not exist"], $this->failStatus);
            }
            $CollectionAgent->save();

            $User->password = $pass;
            $User->save();

            $customer = Customer::select('id', 'fname', 'lname', 'email','password', 'phone', 'sub_location',
                'landmark', 'address', 'house_no')
                ->whereId($request->customer_id)->get();
            return response(['status'=>1,'data'=>$customer,'message'=>'Customer updated successfully'], $this->successStatus);

    }
    public function customerNewpassword(Request $request){
            $rules = [
                'email' => 'email|required|exists:customers,email',
                'old_password' => 'required',
                'new_password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response(['status'=>0,'message'=>$validator->errors()->first()], $this->failStatus);
            }


            $pass =Hash::make($request->new_password);


            $CollectionAgent = Customer::whereEmail($request->email)->first();
            if ( !Hash::check($request->old_password, $CollectionAgent->password)) {
                return response(['status'=>0,'message'=>"old password does not match"], $this->failStatus);
            }

            $CollectionAgent->password = $pass;

            $User = User::whereEmail($request->email)->first();
            if(!isset($User)){
                return response(['status'=>0,'message'=>"User does not exist"], $this->failStatus);
            }
            $CollectionAgent->save();

            $User->password = $pass;
            $User->save();

            $customer = Customer::select('id', 'fname', 'lname', 'email','password', 'phone', 'sub_location',
                'landmark', 'address', 'house_no')
                ->whereId($request->customer_id)->get();
            return response(['status'=>1,'data'=>$customer,'message'=>'Customer updated successfully'], $this->successStatus);

    }

//    public function resetPassword($request)
//    {
//        $email = $request->get('email');
//        $user = User::where(['email' => $email, 'active' => 1])->first();
//        if ($user) {
//            $content['for_test_new_pass'] = $random_password = str_random(8);
//            $user->password = bcrypt($random_password);
//            $user->save();
//            // send email to user /
//            Mail::to($email)->queue(new \Modules\Timetracker\Mail\ForgotPassword($random_password));
//           $content['success'] = true;
//           $content['message'] = 'Your password has been reset and the same is sent to your registerd mail id';
//           $content['code'] = 200;
//       } else {
//            $content['success'] = false;
//            $content['message'] = 'Sorry no records has been found';
//            $content['code'] = 401;
//        }
//        return $content;
//    }
        //******************* Agent API



}
