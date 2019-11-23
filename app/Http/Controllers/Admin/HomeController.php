<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
     
use App\User;
use App\Prayertype;
use App\Prayer;
use DataTables;

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
        return view('admin.manage.manage-prayer');
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
