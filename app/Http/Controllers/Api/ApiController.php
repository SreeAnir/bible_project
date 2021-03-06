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
use App\DeviceToken ;

use App\Patron;

class ApiController extends Controller
{

    public $successStatus = 200;
    public $failStatus = 200;
    public $failStatus1 = 200;
    public $app_version_ios= "2.0";
    public $app_version_android= "2.0";
    public $android_swah ="1.5";
    public $ios_swah="1.5";

   
    
     public function __construct()
    {
        $this->middleware('is_api');
         
       // echo Config::get('lang_prefix') ;
        // die();
    }
    public function uptateToken(Request $request){
        $lang= Config::get('lang_prefix') ;
        $rules = [
            'unique_id' => 'required',
            'fcm_token' => 'required',
            'device_type' => 'required'
        ];
        $res = DeviceToken::where('unique_id',$request->unique_id)->delete();
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response(['status'=>0,'message'=>$validator->errors()->first(),'data' => []], $this->failStatus);
        }
        $token=new DeviceToken();
        $token->unique_id = $request->unique_id;
        $token->fcm_token = $request->fcm_token;
        $token->device_type = $request->device_type;
        $token->app_lang='en';
        if($request->app_lang){
            $token->app_lang = $request->app_lang;
        }
        if ($token->save()){
            return response(['status'=>1,'message'=> 'Added Token',"lang"=> $request->app_lang, 
            "version_ios" => $this->app_version_ios , "version_android" => $this->app_version_android ,
            "ios_swah" => $this->ios_swah, "android_swah" => $this->android_swah ,
            "ios_en" => $this->app_version_ios, "android_en" => $this->app_version_android ,
            'data' => $token], 200);
        }else{
            return response(['status'=>0,'message'=>"Error While Updating","lang"=> $lang, $this->appversion,'data' => []], 404 );
        }


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
         COALESCE(`saintOfTheDayText`,'') as saintOfTheDayText ,
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
COALESCE(gospel_accumulation,'') as gospel_accumulation, 
COALESCE(gospel_accumulation,'') as gospelAcclemation, 

COALESCE(prayer_faith,'') as prayer_faith, 
COALESCE(prayer_faith,'') as prayerFaith, 

COALESCE(`readText`,'') as readText, 
COALESCE(`reflectText`,'') as reflectText, 
COALESCE(`prayText`,'') as prayText,
COALESCE(`actText`,'') as actText, 
COALESCE(`intercessoryPrayer`,'') as intercessoryPrayer, 
COALESCE(`dailyQuote`,'') as dailyQuote " ));
// COALESCE( REPLACE(prayText, '\r', '') ,'') as prayText,

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
        //        DB::raw('COALESCE( REPLACE(text, "\r", "") ,"") as text' ),
        $path=URL::asset('storage/upload/files/audio/');
         $path_default=URL::asset('storage/upload/files/audio/sample.mp3');
        $bible = Prayer::select('idprayers','prayer','title','subtitle','text as oldText',
        DB::raw('COALESCE( REPLACE( REPLACE( REPLACE( text, "<\/b>", "" ), "<b>", "" ), "\r", "" ) ,"" ) as text'),
        DB::raw(' (CASE WHEN  prayer_audio<> NULL THEN  CONCAT( "'.$path.'","/","prayer_audio") ELSE "'.
        $path_default.'" END) as prayer_audio'),'orderno' )->where('status','1')->get();
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


    public function testpush() {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $notification = array();
        $registatoin_ids='fCcK0Ei6KhE:APA91bFbvoo2hLQEx6r_Ii_tQoMTMjXNa4ACVzod7eHbHVTdpI_HHlVtoiXeKUOGf9Ml5Cv2juOphZuZ5WCqKTaeOSmNi__cCNUB7N0mEvbV8SYED-or5TyYUl_-DRHVm33dWwcrmt02';
        $notification["body"] ="TestPush Sri.";
        $notification["title"] = "TestPush Sri.Inform me    ";
        echo $registatoin_ids;
        echo '<br>';
        $notification["sound"] = "default";
        $notification["type"] = 1;
        $msg = array
            (
                'message'   => 'here is a message. message',
                'title'     => 'This is a title. title'
            );
           
         $fields = array
            (
                'to'            => $registatoin_ids,
                'notification' => array(
                    "title" => "Hello test push", 
                    "body" => "hi",
                    "icon" => "name_of_icon" ) ,
                'priority'      =>'high'
            );
        
        // if($device_type == "Android"){
        //       $fields = array(
        //           'to' => $registatoin_ids,
        //           'data' => $notification
        //       );
        // } else {
        //       $fields = array(
        //           'to' => $registatoin_ids,
        //           'notification' => $notification
        //       );
        // }
        // Firebase API Key
        $headers = array('Authorization:key=AAAAi0BnXBM:APA91bFCucmX7PCiOREsoRhbG0ZSleucBJJTIkaF4ip6RzAtYHvvwfFZP28_WZT4XR3HRkHYSKU6ALQfFctJ26QhNy85eGofHNv29q7NEEGWB3BsoqsVNQFXd4QPj-1HMOP26tlJSpAO','Content-Type:application/json');
       // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        print_r( $result );
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

}
