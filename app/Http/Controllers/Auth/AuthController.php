<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function index(){
//        dd(1);
        if(Auth::check())
        {
            $user_id=Auth::user()->id;
            if(Auth::user()->hasUserRole('admin'))
            {
                return redirect()->route('admin.home');
            }
            if (Auth::user()->hasCompany()) {
                Session::put('company_id', auth()->user()->companyId($user_id));
//                return Session::get('company_id');
//                return redirect()->route('company.home',Auth::user()->companyId($user_id));

                return redirect()->route('company.home',Session::get('company_id'));
            }
            Session::flush();
            Auth::logout();
            return redirect()->route('auth.home')->with('error',"Sorry! You don't have any role");
        }
        return view('auth.login');
    }
    public function login(Request $request){
//        dd(12);
        if(!Auth::check()) {
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required|string'
            ]);
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials, true)) {
                if ($request->user()->hasUserRole('admin')) {
                    return redirect()->route('admin.home')->with('success', 'Signed in');
                }
                if ($request->user()->hasCompany()) {
                    Session::put('company_id', $request->user()->companyId($request->user()->id));
                    return redirect()->route('company.home', Session::get('company_id'))->with('success', 'Signed in');
                }
                Session::flush();
                Auth::logout();
                return redirect()->route('auth.home')->with('error', "Sorry! You do not have any role");

            }
//        dd($request);
            return redirect()->route('auth.home')->with('error', 'Your credentials are invalid');
        }
        return redirect()->route('auth.home');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('auth.home')->with('success',"Logged Out!");
    }

    public function password_verify(Request $request){
        if(password_verify($request->old_password,auth()->user()->password)){
            return response()->json(['msg'=>'1','status'=>true]);
        }
        return response()->json(['msg'=>'0','status'=>true]);
    }
    public function change_password(Request $request){
        if(Session::get('company_id')){
            if(password_verify($request->old_password,auth()->user()->password)){
                $this->validate($request,[
                    'password' => 'required|confirmed|min:4'
                ]);
                User::ChangePassword($request,auth()->user()->id);
                return redirect()->back()->with('success','Successfully Password Changed');
            }else{
                return redirect()->back()->with('error','Old password does not match');
            }
        }
        else{
            $this->validate($request,[
                'password' => 'required|confirmed|min:4'
            ]);
            User::ChangePassword($request,auth()->user()->id);
            return redirect()->back()->with('success','Successfully Password Changed');
        }
    }
    public function change_user_password(Request $request, string $id){
        $this->validate($request,[
            'password' => 'required|confirmed|min:4'
        ]);
        User::ChangePassword($request,$id);
        return redirect()->back()->with('success','Successfully Password Changed');
    }
}
