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
    public function addLanguage(){
        return view('admin.language.language-add-edit');
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
