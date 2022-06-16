<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Rules\PasswordField;
use Exception;
use Validator;
use File;
use App\User;
use App\Manager;
use Image;
use Auth;

class ManagerController extends Controller
{
    public function index(Request $request){
      $posts = User::orderBy('id','DESC')->where('user_type','2');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'managers' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'address' => 'required',
        ]);
        if($request->hasFile('photo')){
            $this->validate($request, [
                'photo' => 'required|mimes:jpg,jpeg,png|max:1024',
            ]);
            $file = $request->file('photo');
            $destinationPath = 'image/manager';
            $name_enc = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $destinationThumbPath = 'image/manager/thumbnail/'.$name_enc;
            Image::make($file->getRealPath())->save($destinationThumbPath);
            $file->move($destinationPath, $name_enc);
            return User::create([
               'name' => $request['name'],
               'user_code' => strtotime("now"),
               'email' => $request->email,
               'password' => Hash::make($request->password),
               'phone' => $request['phone'],
               'address' => $request['address'],
               'is_active' => '1',
               'user_type' => '2',
               'image' => $name,
               'image_enc' => $name_enc,
               'date' => date("Y-m-d"),
               'date_np' => $this->helper->date_np_con(),
               'time' => date("H:i:s"),
           ]);
        }
        else{
            return User::create([
             'name' => $request['name'],
             'user_code' => strtotime("now"),
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'phone' => $request['phone'],
             'address' => $request['address'],
             'is_active' => '1',
             'user_type' => '2',
             'date' => date("Y-m-d"),
             'date_np' => $this->helper->date_np_con(),
             'time' => date("H:i:s"),
         ]);
        }
    }

    public function edit($id){
        $managers = User::findOrFail($id);
        return response()->json([
            'managers'=>$managers
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = User::findOrFail($id);
        $name = User::where('id',$id)->value('image');
        $name_enc = User::where('id',$id)->value('image_enc');
        if($request->hasFile('photo')){
            $this->validate($request, [
                'photo' => 'required|mimes:jpg,jpeg,png|max:1024',
            ]);
            $path_old_file = "image/manager/".$name_enc;
            $path_old_file_thumb = "image/manager/thumbnail/".$name_enc;

            $file = $request->file('photo');
            $destinationPath = 'image/manager';
            $name_enc = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $destinationThumbPath = 'image/manager/thumbnail/'.$name_enc;
            Image::make($file->getRealPath())->save($destinationThumbPath);
            $file->move($destinationPath, $name_enc);
            if(File::exists($path_old_file)) {
                File::delete($path_old_file);
            }
            if(File::exists($path_old_file_thumb)) {
                File::delete($path_old_file_thumb);
            }
        }
        $user->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'image' => $name,
            'image_enc' => $name_enc,
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Manager Updated'];
    }

    public function destroy($id){
        $usertype = User::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $user = User::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }
    public function getAllManager(Request $request){
        $managers = User::orderBy('name','ASC')
                                ->where('is_active','1')
                                ->where('user_type','2')
                                ->get();
        return response()->json([
          'selectmanagers'=>$managers
        ],200);
    }

    public function changePassword(PasswordField $request)
    {
        // dd($request->manager_id);
        try{
            User::find($request->manager_id)->update(['password'=> Hash::make($request->new_password)]);
            $response = [
                            'status' => true,
                            'message' =>'password is changed !'
                        ];
        }
        catch(Exception $e)
        {
            // dd($e->getMessage());
            $response = [
                            'status' => false,
                            'message' => 'Something went wrong'
                        ];
        }
        // Auth::logout();
        return $response;
    }
}
