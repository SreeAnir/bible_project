<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class LoginController  extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('is_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.login');
    }
    public function logout()
    {
         return redirect('admin/login');
    }
     
     
    public function checkLogin(Request $request){
        // Hash::make('123456') ;die();
        $rules = array(
            'name' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) { 
            $validation =  $validator->messages();
            return redirect('admin/login')->with('validation',$validation);
        } else {
  
            if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
               
                // Authentication passed...
//            return redirect()->intended('dashboard');
                return redirect('admin/dashboard');
            }else{  
               
                $error ="Invalid username or password";
                return redirect('admin/login')->with('error',$error);
            }
        }


    }
    
}
