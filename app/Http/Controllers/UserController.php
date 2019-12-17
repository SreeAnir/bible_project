<?php
     
namespace App\Http\Controllers;
     
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Session;
use Hash;
use Illuminate\Support\Facades\Auth;
use DB;
     
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
           if(  Auth::user()->type != User:: SUPER_ADMIN_TYPE){
            $data = User::latest()->where('language',Auth::user()->language )->get();
            }else{
                $data = User::latest()->get();
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn =  '<a href="/admin/user-details/'. $row->id .'" > <i class="material-icons">edit</i></a>';
                         $btn .='<a href="/admin/user-delete/'. $row->id .'" > <i alt="View/Edit" class="material-icons">delete</i></a>';
     
                            return $btn;
                    })
                    ->addColumn('status', function($row){
                      if($row->status == User::DELETED)
                        $btn2="<label class='label label-danger'>Deleted</label>" ;
                      if($row->status == User::ACTIVE)
                        $btn2="<label class='label label-success'>Active</label>" ;
                      if($row->status == User::INACTIVE)
                        $btn2="<label class='label label-warning'>Inactive</label>" ;

                            return $btn2;
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
      
        return view('users-');
    }

     public function userDelete($id=""){   
        $data=array(); 
          Session::flash('flash_success', ' Sorry!  Failed to Delete');

        if ($id!='') {
          $user = User::where('id',$id)->first();
          $user->status='2';
          $save=$user->save();
          if($save){
            Session::flash('flash_success', 'Deleted Successfully');

          }  
          }
          return back();

            
      //  return view('admin.manage.manage-prayer',['details' => $prayer]);
   }

     public function userDetails($id){   
        $data=array(); 
        $user = User::where('id',$id)->first();
        $data['details']= $user;
        return view('admin.manage.edit-user',$data);
      //  return view('admin.manage.manage-prayer',['details' => $prayer]);
   }
    public function checkUserExists($data){
     $email= $data['email'];
      $name=$data['name'];
      if(isset($data['id']) && $data['id']!=""){
      $exist=User::where(DB::raw('name ="'.$name.'"  OR  email="'.$email.'" AND id <> '.$data['id']) )->count();
      }else{
      $exist=User::where(['name'=> $name ])->orWhere(['email' => $email])->count();
      }
      if($exist>0){
        return true;
      }
      return false;
   }
   
      public function addEdituser(Request $request){
   

 try{
           $rules = [
          'name'    => ['required', 'string'],
          'email'    => ['required', 'string'],
          'type'    => ['required'],
          'language' => ['required'],
      ];
            $validator = Validator::make($request->all(), $rules);

       if($validator->fails()){
           Session::flash('flash_error', $validator->errors()->first());
            return back();
      }else{
      $exists=$this->checkUserExists( $request->all()); 
      if($exists){  
            Session::flash('flash_error',"User Already exists");
            return back();
      }

        Session::flash('flash_error','');

         if ($request->has('id') && $request->id!="") {
          $user = User::where('id',$request->id)->first();
         }else{
            $user =new User;
            $user->password=Hash::make('user@123');
         }
        $user->name=$request->name;
        $user->email=$request->email;
        $user->type=(int)$request->type;
        $user->language=$request->language;

        if ($user->save()){
             Session::flash('flash_success',"User Details saved");
            return back();
        }else{
             Session::flash('flash_error',"Failed To Save");
            return back();
        }
     }
    }catch (Exception $e) {
           Session::flash('flash_error',  $e->getMessage());
 
        }
    }
}