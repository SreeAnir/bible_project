<?php

namespace App\Http\Controllers\Api;

use App\Bibledata;
use App\Customer;
use App\Splash;
use App\Prayer;
use App\Prayertype;
use App\User;
use Config;
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
     public function __construct()
    {
        $this->middleware('is_api');
         
       // echo Config::get('lang_prefix') ;
        // die();
    }
     

    public function getAppMessage(){
        $lang= Config::get('lang_prefix') ;
        $msg_data = AppMessage::select('text')->where('language', $lang)->first();
        if(($msg_data)!=""){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$msg_data], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data', 'data' => []], $this->failStatus);
        }
    }
    public function getPatronData(){
        $path=URL::asset('storage/upload/files/image/');
        $lang= Config::get('lang_prefix') ;
        $msg_data = Patron::select( '*',DB::raw('CONCAT( "'.$path.'","/",patron_image) as patron_image') )->where('language', $lang)->first();
        if(($msg_data)!=""){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$msg_data], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data'=>[]], $this->failStatus);
        }
    }
    public function getSplashData(){
        $lang= Config::get('lang_prefix') ;
        $path=URL::asset('storage/upload/files/image/');
        $msg_data = Splash::select( '*',DB::raw('CONCAT( "'.$path.'","/",image) as image') )->where('language', $lang)->first();
        if(($msg_data)!=""){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$msg_data], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data'=>[]], $this->failStatus);
        }
    }
     public function getAllBibledata(){
         
         $lang= Config::get('lang_prefix') ;
         $currentYear= date("Y");

         $bible=Bibledata::select(DB::raw(" `dataId`, `date`, `ribbonColor`,
         COALESCE(`weekDescription`,'') as weekDescription ,CONCAT('PSALTER',' ', COALESCE(`psalter`,'') ) as psalter ,
         COALESCE(`saintOfTheDay`,'') as saintOfTheDay ,
         COALESCE(`significanceOfTheDay`,'') as significanceOfTheDay ,
          COALESCE(`firstReadingReference`,'') as firstReadingReference ,
           COALESCE(`firstReadingTitle`,'') as firstReadingTitle,
             COALESCE(`firstReadingText`,'') as firstReadingText,
              COALESCE(`psalmReference`,'') as psalmReference,
                COALESCE(`psalmText`,'') as psalmText,
                  COALESCE(`psalmResponse`,'') as psalmResponse,
             COALESCE(`secondReadingReference`,'') as secondReadingReference,
              COALESCE(`secondReadingTitle`,'') as secondReadingTitle, 
             COALESCE(`secondReadingText`,'') as secondReadingText, 
              COALESCE(`gospelReference`,'') as gospelReference, 
            COALESCE(`gospelTitle`,'') as gospelTitle, 
           COALESCE(`gospelText`,'') as gospelText, 
COALESCE(`reflectionText`,'') as reflectionText, 
COALESCE(`gospel_accumulation`,'') as gospel_accumulation, 
COALESCE(`prayer_faith`,'') as prayer_faith, 
COALESCE(`readText`,'') as readText, 
COALESCE(`reflectText`,'') as reflectText, 
COALESCE(`prayText`,'') as prayText, 
COALESCE(`actText`,'') as actText, 
COALESCE(`intercessoryPrayer`,'') as intercessoryPrayer, 
COALESCE(`dailyQuote`,'') as dailyQuote " ));

         if(date("m")==12) { //if december ,show jan details too'
            $nextYear=$currentYear+1;
           $bible = $bible->whereRaw(   "ribbonColor IS NOT NULL AND date BETWEEN '".$currentYear."-01-31' AND '".$nextYear."-01-31'")->get();
         }else{
            $bible =$bible->whereRaw(   "ribbonColor IS NOT NULL AND date LIKE '%".$currentYear."%'")->get();
         }
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' ,'data' => []], $this->failStatus);
        }
    }

    public function getAllPrayer(){
        $path=URL::asset('storage/upload/files/audio/');
         $path_default=URL::asset('storage/upload/files/audio/sample.mp3');
        $bible = Prayer::select('idprayers','prayer','title','subtitle','text',DB::raw(' (CASE WHEN  prayer_audio<> NULL THEN  CONCAT( "'.$path.'","/","prayer_audio") ELSE "'.
        $path_default.'" END) as prayer_audio'),'orderno')->where('status','1')->get();
        if(sizeof($bible)>0){
            return response(['status'=>1,'message'=>'Data Found', 'data'=>$bible], $this->successStatus);
        }else{
            return response(['status'=>0,'message'=>'No Data' , 'data' =>[] ], $this->failStatus);
        }
    }

    public function getAllPrayerTypes(){
        $lang= Config::get('lang_prefix') ;
        if($lang=='en'){
        $bible = Prayertype::select('id','name')->get();
        }else{
         $bible = Prayertype::select('id','name_'.$lang.' as name')->get();   
        }

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



}
