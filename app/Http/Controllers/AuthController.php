<?php

namespace App\Http\Controllers;

use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signup(Request $request){
        try{
            if(!User::where('email', $request->email)->exists()){
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = md5($request->password);
                $result = $user->save();
                Session::put('userId', $user->id);
                return redirect('home');
            }else{
                return redirect()->back()->withErrors(['Email Already Exists!']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(["Invalid inputs!"]);
        }
    }

    public function login(Request $request){
        try{
            if(User::where('email', $request->email)->exists()){
                $user = User::where('email', $request->email)->first();
                if($user->password == md5($request->password)){
                    Session::put('userId', $user->id);
                    return redirect('home');
                }else{
                    return redirect()->back()->withErrors(['Invalid email or password!']);
                }
            }else{
                return redirect()->back()->withErrors(['Invalid email or password!']);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['Invalid email or password!']);
        }
    }

    public function logout(){
        try{
            Session::remove('userId');
            return json_encode(['status' => true]);
        }catch (\Exception $exception){
            return json_encode(['status'=> false]);
        }
    }
}
