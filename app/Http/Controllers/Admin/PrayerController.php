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


class PrayerController extends Controller
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
     
   public function savePrayer(Request $request){
    $rules = [
          'idprayers'    => 'sometimes|nullable',
          'prayer' => ['required', 'string', 'max:45'],
          'title' => ['required', 'string', 'max:1000'],
          'subtitle' => ['required', 'string', 'max:1000'],
          'text' => ['required', 'string'],
          'prayer_audio' =>['sometimes'],
      ];
      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
           echo json_encode(['status'=>0,'message'=>$validator->errors()->first()]);
      }else{
          if ($request->has('idprayers')) {
          $Prayer = Prayer::where('idprayers',$request->idprayers)->first();
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
             if(file_exists($destinationPath.$filename)){
               $Prayer->prayer_audio=$filename;
             }
            
           }
          $save=$Prayer->save();
          if( $save){
            echo json_encode(['status'=> 1,'message'=>"Saved Prayer"]); 
          }else{
            echo json_encode(['status'=> 0 ,'message'=>"Unable to save."]); 
          }

      }
       
 }

    public function managePrayer(){   
        $data=array(); 
        $prayer_type = PrayerType::latest()->where('status' ,'1')->get();
        $data['prayer_type'] = $prayer_type ; 
        return view('admin.manage.manage-prayer',['prayer_type' => $prayer_type]);
   }
   
   public function prayerDelete($idprayers=""){   
        $data=array(); 
          Session::flash('flash_message', ' Sorry!  Failed to Delete');

        if ($idprayers!='') {
          $Prayer = Prayer::where('idprayers',$idprayers)->first();
          $Prayer->status='2';
          $save=$Prayer->save();
          if($save){
            Session::flash('flash_message', 'Deleted Successfully');

          }  
          }
          return back();

            
      //  return view('admin.manage.manage-prayer',['details' => $prayer]);
   }
   public function prayerDetails($idprayers){   
        $data=array(); 
        $prayer = Prayer::where('idprayers',$idprayers)->first();
        $prayer_type = PrayerType::latest()->where('status' ,'1')->get();
        $data['prayer_type'] = $prayer_type ; 
        $data['details'] = $prayer ;
        $data['form_edit'] =1 ;
        return view('admin.manage.view-prayer',$data);
      //  return view('admin.manage.manage-prayer',['details' => $prayer]);
   }
     public function prayerList(Request $request,$condition=array())
    {  
        if ($request->ajax()) {
            $data = Prayer::select('idprayers','prayer','title','subtitle','text',DB::raw('(CASE WHEN orderno =0  THEN "NO ORDER" ELSE orderno END) as orderno'),DB::raw('(CASE WHEN status ="1"  THEN "ACTIVE" ELSE "INACTIVE" END) as status'))->latest();
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
                         $btn =  '<a href="/admin/prayer-details/'. $row->idprayers .'" > <i class="material-icons">edit</i></a>';
                         $btn .='<a href="/admin/prayer-delete/'. $row->idprayers .'" > <i alt="View/Edit" class="material-icons">delete</i></a>'; 
                        return $btn;
                    })
                    ->addColumn('prayer', function($row){
                         $btn = $row->prayertype['name']; 
                        return $btn;
                    })
                    ->rawColumns(['action','prayer'])
                    ->make(true);
            }
            
        }
      
        return view('admin.manage.no-data'); 
    }

     public function ListUser(){ 
       return view('admin.manage.manage-user'); 
    }
    
}
