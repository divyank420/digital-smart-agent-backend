<?php

namespace App\Http\Controllers\Agent;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            return redirect()->route('agent.dashboard');
        }
        if($request->isMethod('POST')){
            $user = User::find(1);
            Auth::login($user);
            $req = ['mobile'=>$request->mobile,'password'=>$request->password];
            if(Auth::attempt($req,true)){
                $members = Helper::getTeamMember();
                $request->session()->put('members', $members);
                $request->session()->flash('success','Logged In successful');
                return redirect()->route('agent.dashboard');
            }else{
                $request->session()->flash('error','Invalid Creditional');
            }
        }
        return view('agents.auth.login');
    }
}
