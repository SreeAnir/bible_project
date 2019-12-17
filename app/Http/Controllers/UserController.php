<?php
     
namespace App\Http\Controllers;
     
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Session;
use Hash;

     
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('users-');
    }

 //      public function addEdituser(Request $request){

 // try{
 //           $rules = [
 //          'name'    => ['required', 'string'],
 //          'email'    => ['required', 'string'],
 //          'type'    => ['required'],
 //          'language' => ['required'],
 //      ];
 //            $validator = Validator::make($request->all(), $rules);

 //       if($validator->fails()){
 //           Session::flash('flash_error', $validator->errors()->first());
 //            return back();
 //      }else{ 
 //         Session::flash('flash_error','');

 //         if ($request->has('id') && $request->id!="") {
 //          $user = User::where('id',$request->id)->first();
 //         }else{
 //            $user =new User;
 //         }
 //        $user->name=$request->name;
 //        $user->email=$request->email;
 //        $user->type=$request->type;
 //        $user->language=$request->language;
 //        $user->password=Hash::make('user@123');

 //        if ($user->save()){
 //             Session::flash('flash_success',"User Details saved");
 //            return back();
 //        }else{
 //             Session::flash('flash_error',"Failed To Save");
 //            return back();
 //        }
 //     }
 //    }catch (Exception $e) {
 //           Session::flash('flash_error',  $e->getMessage());
 
 //        }
 //    }
}