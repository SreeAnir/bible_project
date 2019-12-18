<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

     
use App\User;
use App\Prayertype;
use App\Prayer;
use DataTables;
use Carbon\Carbon;
use File;
use DB;
use App\Bibledata;
use Session;
use App\Patron;
use App\AppMessage;
use App\Language;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {     
        return view('admin.index');
    }
     
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
    
    public function saveLanguage($id=""){
        $data=array(); 
        Session::flash('flash_message_global', 'Failed To Update');
        if ($id!='') {

        $user = auth()->user();
        $user_id=($user->id);
          
        $user = User::where('id',$user_id)->first();
        $user->language = $id ;
        $user->save(); 
        Session::flash('flash_message_global', 'Language changed Successfully ');
        return back();
      }else{ 
       return back();
      }
      //  return view('admin.manage.manage-prayer',['details' => $prayer]);
    }
    public function addLanguage($id=""){
        $lans=Language::all();
        $params=array("list" => $lans);
        $params['row_data']="";
        if($id!=""){
         $params['row_data']=Language::where('id',$id)->first();
        }
        return view('admin.language.language-add-edit',$params);
    }
    public  function newLanguageSave(Request $request)
    {
      try{
           $rules = [
          'name'    => ['required', 'string'],
           'ShortName'    => ['required', 'string'],
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
           Session::flash('flash_error_language', $validator->errors()->first());
            return back();
      }else{ 
         Session::flash('flash_error_language','');
        $array_message='';
        $type='new';
          if ($request->has('id') && $request->id!="") {
          $Language = Language::where('id',$request->id)->first();
           $type='edit';
          } else{
          $Language =new Language;
          }
          $Language->name=$request->name;
          $Language->ShortName=$request->ShortName;
          if($Language->save()){
            
            if( $type=='new'){
              $array_message.="Language Added.";

              
            $new_field= \DB::statement('ALTER TABLE `prayertype` ADD  `name_'.$request->ShortName.'` VARCHAR(255)   NOT NULL');
             $new_field= \DB::statement('UPDATE `prayertype` SET `name_'.$request->ShortName.'` = `name`');



            $table_prayer= \DB::statement('CREATE TABLE prayers_'.$request->ShortName.' LIKE prayers_en');
            if( $table_prayer){
            \DB::statement('INSERT prayers_'.$request->ShortName.' SELECT * FROM prayers_en');
             $array_message.="Prayer  Table Added.";
            }else{
              $array_message.="Failed to Add Prayer Table.";
            }
            $table_bible= \DB::statement('CREATE TABLE bibledata_'.$request->ShortName.' LIKE bibledata_en');
            if( $table_bible){
            \DB::statement('INSERT bibledata_'.$request->ShortName.' SELECT * FROM bibledata_en');
             $array_message.="Bible Data  Table Added.";
            }else{
              $array_message.="Failed to Add Bible Data Table.";
            }
            }else{
              $array_message.="Language Updated.";
            }
             return redirect('admin/manage-users');
            

          }

      }
      Session::flash('flash_message_language', $array_message);

      
    } catch (Exception $e) {
           Session::flash('flash_error_language',  $e->getMessage());
 
        }
        return redirect('admin/language');
    }
    public function categoryDelete($id=""){
        $data=array(); 
         Session::flash('flash_message', ' Sorry!  Failed to Delete');
        if ($id!='') {
          $PrayerType = PrayerType::where('id',$id)->first();
          $PrayerType->status='2';
          $save=$PrayerType->save();
          if($save){
            Session::flash('flash_message', 'Deleted Successfully');
          }  
          } 
          return back();
    }
    public function appMessage(){
       $app_message=AppMessage::first();
        return view('admin.setting.message-add-edit' ,array('app_message' =>$app_message));
    }
    
    public function messageDataSave(Request $request){
        try{
           $rules = [
          'message'    => ['required', 'string'],
      ];

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
           Session::flash('flash_message_app', $validator->errors()->first());
            return back();
      }else{ 

        if ($request->has('id') && $request->id!="") {
          $Msg = AppMessage::where('id',$request->id)->first();
          } else{
          $Msg =new AppMessage;
          }
          $Msg->message=$request->message;
           
          $save=$Msg->save();
         
          if( $save){
             Session::flash('flash_message_app', 'Saved Message  Data');
          }else{
            Session::flash('flash_message_app', 'Saved Message Data');
          }
           return back();


      }
        }catch (Exception $e) {
           Session::flash('flash_message_patron', $e->getMessage());
            return back();

        }
    }
    public function patronData(){
      $patron=Patron::first();
        return view('admin.setting.add-edit-patron',array('patron' =>$patron));
    }
    public function patronDataSave(Request $request){
        try{
           $rules = [
          'patron_name'    => ['required', 'string', 'max:255'],
          'patron_date' => ['required', 'string', 'max:255'],
          'patron_text' => ['required', 'string'],
      ];

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
           Session::flash('flash_message_patron', $validator->errors()->first());
            return back();
      }else{ 

           if ($request->has('id') && $request->id!="") {
          $Patron = Patron::where('id',$request->id)->first();
          } else{
          $Patron =new Patron;
          }
          $Patron->patron_name=$request->patron_name;
          $Patron->patron_date=$request->patron_date;
          $Patron->patron_text=$request->patron_text;
          
          if($request->has('patron_image')){
            $uniqueid=uniqid();
             $file = $request->file('patron_image');
            $original_name=$request->file('patron_image')->getClientOriginalName();
            $size=$request->file('patron_image')->getSize();
            $extension=$request->file('patron_image')->getClientOriginalExtension();
            $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            //$audiopath=url('/storage/upload/files/audio/'.$filename);
            $destinationPath='storage/upload/files/image/';
            // $path=$file->storeAs('public/upload/files/audio/',$filename);die();
            $file->move($destinationPath,$filename);
            // $all_audios=$filename;\
             if(file_exists($destinationPath.$filename)){
               $Patron->patron_image=$filename;
             }
            
           }
          $save=$Patron->save();
         
          if( $save){
             Session::flash('flash_message_patron', 'Saved Patron Data');
          }else{
            Session::flash('flash_message_patron', 'Saved Patron Data');
          }
           return back();


      }
        }catch (Exception $e) {
           Session::flash('flash_message_patron', $e->getMessage());
            return back();

        }
    }
    
    public function loadBibleDateContent(Request $request){
        $data=array(); 
        $date=$request->date;
        $bibleData = Bibledata::where('date' ,$date)->first();
        $data['bibleData'] = $bibleData ; 
        $view=view('admin.manage.load-date-content',['bibleData' => $bibleData]);
        $view=$view->render();
        echo json_encode(['status'=> 1,'message'=>$view]); 
    }
     public function saveBibleDateContent(Request $request){
      
      $rules = [
            'dataId'    => 'sometimes|nullable',
            'ribbonColor' => ['required', 'string', 'max:255'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
             echo json_encode(['status'=>0,'message'=>$validator->errors()->first()]);
        }else{
            if ($request->has('date')) {
            $Bibledata = Bibledata::where('date',$request->date)->first();
            $message="Data Updated";
            } 
            if ($request->has('dataId')) {
            $Bibledata = Bibledata::where('dataId',$request->dataId)->first();
            $message="Data Updated";
            } 
            if($Bibledata==""){
             $Bibledata =new Bibledata;
             $message="New Data Added"; 
            }
            
            $Bibledata->dataId=$request->dataId;

            $Bibledata->ribbonColor = $request->ribbonColor;  
            $Bibledata->date = $request->date;  
            $Bibledata->weekDescription = $request->weekDescription;
            $Bibledata->psalter = $request->psalter;
            $Bibledata->saintOfTheDay = $request->saintOfTheDay;
            $Bibledata->saintOfTheDay = $request->saintOfTheDay;
            $Bibledata->significanceOfTheDay = $request->significanceOfTheDay;
            $Bibledata->firstReadingReference = $request->firstReadingReference;
            $Bibledata->firstReadingTitle = $request->firstReadingTitle;
            $Bibledata->firstReadingText = $request->firstReadingText;
            $Bibledata->psalmReference = $request->psalmReference;
            $Bibledata->psalmText = $request->psalmText;
            $Bibledata->psalmResponse = $request->psalmResponse;
            $Bibledata->secondReadingReference = $request->secondReadingReference;
            $Bibledata->secondReadingTitle = $request->secondReadingReference;
            $Bibledata->secondReadingText = $request->secondReadingText;
            $Bibledata->gospelReference = $request->gospelReference ;
            $Bibledata->gospelTitle = $request->gospelTitle;
            $Bibledata->gospelText = $request->gospelText;
            $Bibledata->reflectionText = $request->reflectionText;
            $Bibledata->readText = $request->readText;
            $Bibledata->reflectText = $request->reflectText;
            $Bibledata->prayText = $request->prayText;
            $Bibledata->actText = $request->actText;
            $save=$Bibledata->save();

            if( $save){
                 echo json_encode(['status'=> 1,'message'=>"Saved Content for ". $Bibledata->date ]); 
            }else{
              echo json_encode(['status'=> 0,'message'=>"Failed to save Data."]);
            }

        }
         
   }
    

     public function ListUser(){ 
       return view('admin.manage.manage-user'); 
    }
    
}
