<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
     
use App\User;
use App\Prayertype;
use App\Prayer;
use DataTables;
use Carbon\Carbon;
use File;
// use DB;
use App\Bibledata;
use App\solemnityDates;
use Session;


class HomeController extends Controller
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
    public function dashboard(){   
       $user = auth()->user();
        $data =array();
        $data['user_count']=  User::count();
        $data['category_count']= Prayertype::where('status','1')->count();
        $data['prayer_count'] = Prayer::where('status','1')->count();
        $data['date_count'] =  Bibledata::count();

        return view('admin.dashboard',compact('data'));
    }
     public function manageCategory(){   
       
        return view('admin.manage.manage-category');
   }
   
    
   public function saveCategory(Request $request){
      $rules = [
            'id'    => 'sometimes|nullable|exists:prayertype,id',
            'name' => ['required', 'string', 'max:255'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
             echo json_encode(['status'=>0,'message'=>$validator->errors()->first()]);
        }else{
            if ($request->has('id')) {
            $PrayerType = Prayertype::whereId($request->id)->first();
            } else{
            $PrayerType =new Prayertype;
            }
             $lang_prefix =  auth()->user()->lang['ShortName'] ; 
            if($lang_prefix=='en'){
            $field_name="name";
            }else{
            $field_name="name_".$lang_prefix;
            }
            $PrayerType->$field_name=$request->name;
            $save=$PrayerType->save();
            if( $save){
                 echo json_encode(['status'=> 1,'message'=>"Saved Prayer Type"]); 
            }

        }
         
   }
    public function categoryList(Request $request,$condition=array())
    {  
        if ($request->ajax()) {
            $data = PrayerType::latest();
            if(!empty($condition)){
                // add condtion
            }else{
                $data =$data->where('status' ,'1');
            }
            $data =$data->get();
            if(!empty($data)){
                return Datatables::of($data)
                    ->addIndexColumn()
                     ->addColumn('action', function($row){
                         $btn =  '<a href="/admin/category-details/'. $row->id .'" > <i alt="View/Edit"   class="material-icons">edit</i></a>';
                         $btn .='<a href="/admin/category-delete/'. $row->id .'" data-attr='. $row->id .' href1="/admin/category-delete/'. $row->id .'" > <i class="material-icons">delete</i></a>'; 
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            
        }
      
        return view('admin.manage.no-data'); 
    }
    public function categoryDetails($id=""){
        $data=array(); 
        Session::flash('flash_message', 'Invalid Prayer Type');
        if ($id!='') {
            $lang_prefix =  auth()->user()->lang['ShortName'] ; 
          if($lang_prefix=='en'){
          $field_name="name";
          }else{
          $field_name="name_".$lang_prefix;
          }
        $prayer_type = PrayerType::where('id',$id)->select( DB::raw( $field_name." as name"),'id','status')->first();
        $data['prayer_type'] = $prayer_type ; 
        $data['form_edit'] =1 ;
         Session::flash('flash_message', '');
        return view('admin.manage.view-prayer-type',$data);
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
    public function manageDate(){
        $data=array(); 
        $prayer_type = PrayerType::latest()->where('status' ,'1')->get();
        $data['prayer_type'] = $prayer_type ; 
        return view('admin.manage.manage-date',['prayer_type' => $prayer_type]);
    }
    public function loadBibleDateContent(Request $request){
        $data=array(); 
        $date=$request->date;
        $bibleData = Bibledata::where('date' ,$date)->first();
        $sdate = solemnityDates::where('date' ,$date)->count();
        $data['bibleData'] = $bibleData ; 
        $view=view('admin.manage.load-date-content',['bibleData' => $bibleData ,'solemnityDate' => $sdate]);
        $view=$view->render();
        echo json_encode(['status'=> 1,'message'=>$view]); 
    }
     public function saveBibleDateContent(Request $request){
      
      $rules = [
            'dataId'    => 'sometimes|nullable',
            'ribbonColor' => ['required'],
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

            $Bibledata->intercessoryPrayer = $request->intercessoryPrayer;  
            $Bibledata->dailyQuote = $request->dailyQuote;  
            
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
