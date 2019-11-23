<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
     
use App\User;
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
        $data =array();
        $data['attendence']="0";
        $data['internals']="0";
        $data['uploads'] = 0;
        return view('admin.manage.manage-category',compact('data'));
   }
    
     public function ListUser(){ 
       return view('admin.manage.manage-user'); 
    }
    
}
