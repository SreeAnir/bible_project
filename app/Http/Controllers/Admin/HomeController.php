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
        $data =array();
        $data['attendence']="0";
        $data['internals']="0";
        $data['uploads'] = 0;
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
            $PrayerType->name=$request->name;
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
   
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            
        }
      
        return view('admin.manage.no-data'); 
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
