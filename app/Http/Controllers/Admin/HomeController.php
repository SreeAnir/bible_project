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
   
   public function savePrayer(Request $request){
    $rules = [
          'idprayers'    => 'sometimes|nullable|exists:prayertype,id',
          'prayer' => ['required', 'string', 'max:255'],
          'title' => ['required', 'string', 'max:255'],
          'subtitle' => ['required', 'string', 'max:255'],
          'text' => ['required', 'string', 'max:255'],
          'prayer_audio' =>'nullable',
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
           echo json_encode(['status'=>0,'message'=>$validator->errors()->first()]);
      }else{
          if ($request->has('id')) {
          $Prayer = Prayer::whereId($request->id)->first();
          } else{
          $Prayer =new Prayer;
          }
          $Prayer->prayer=$request->prayer;
          $Prayer->title=$request->title;
          $Prayer->subtitle=$request->subtitle;
          $Prayer->text=$request->text;
          $Prayer->orderno=$request->orderno;
          if($request->has('prayer_audio')){
            $uniqueid=uniqid();
             $file = $request->file('prayer_audio');
            $original_name=$request->file('prayer_audio')->getClientOriginalName();
            $size=$request->file('prayer_audio')->getSize();
            $extension=$request->file('prayer_audio')->getClientOriginalExtension();
            $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            //$audiopath=url('/storage/upload/files/audio/'.$filename);
            $destinationPath='storage/upload/files/audio/';
            // $path=$file->storeAs('public/upload/files/audio/',$filename);die();
             $file->move($destinationPath,$filename);
            // $all_audios=$filename;\
             if(file_exists($destinationPath.$filename))
            $Prayer->prayer_audio=$request->filename;
           }
          $save=$Prayer->save();
          if( $save){
            echo json_encode(['status'=> 1,'message'=>"Saved Prayer Type"]); 
          }else{
            echo json_encode(['status'=> 0 ,'message'=>"Unable to save."]); 
          }

      }
       
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
    
    public function managePrayer(){   
        $data=array(); 
        $prayer_type = PrayerType::latest()->where('status' ,'1')->get();
        $data['prayer_type'] = $prayer_type ; 
        return view('admin.manage.manage-prayer',['prayer_type' => $prayer_type]);
   }
     public function prayerList(Request $request,$condition=array())
    {  
        if ($request->ajax()) {
            $data = Prayer::latest();
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

     public function ListUser(){ 
       return view('admin.manage.manage-user'); 
    }
    
}
