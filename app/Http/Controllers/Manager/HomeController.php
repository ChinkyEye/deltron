<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Rules\PasswordField2;
use Exception;
use Validator;
use File;
use App\User;
use App\Manager;
use Image;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('manager.main');
    }

    public function changePassword(PasswordField2 $request)
    {
        try{
            User::find(Auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
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
        Auth::logout();
        return $response;
    }
    public function currentuser()
    {
        $response = [
            'currentuser' => Auth::user(),
        ];
        return $response;
    }

    // public function changePassword(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'current_password' => ['required', new MatchOldPassword],
    //         'new_password' => ['required'],
    //         'new_confirm_password' => ['same:new_password'],
    //     ]);
    //     try{
    //         User::find(Auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
    //         $response = [
    //                         'status' => true,
    //                         'message' =>'password is changed !'
    //                     ];
    //     }
    //     catch(Exception $e)
    //     {
    //         // dd($e->getMessage());
    //         $response = [
    //                         'status' => false,
    //                         'message' => 'Something went wrong'
    //                     ];
    //     }
    //     Auth::logout();
    //     return $response;
    // }
}
