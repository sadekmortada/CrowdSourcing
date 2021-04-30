<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() {
        if(!Auth::check())
            return view('auth.login');
        else
            return redirect('/home');
    }

    public function register(){
        if(Auth::check())
            return redirect('/home');
        return view('auth.register');
    }

    public function store() {
        $user = request()->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string',
        'role' => 'integer|required|min:1|max:2'
         ]);
        $user['password'] = Hash::make($user['password']);
        if(User::find(1)){
            $user['confirmed'] = User::find(1)->auto_confirm;
        }
        else 
            $user['confirmed'] = 0;
        User::create($user);
        return redirect('/login');
    }


    public function postlogin(){
        $account=request()->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email',request('email'))->first();
        
        if($user == null){
            return view('auth.login')->with('error' , 'Account not found !');
        }

        if( ! Hash::check($account['password'],$user->password)){
            return view('auth.login')->with('error' , 'Wrong Password !');
        }
        
        if(!$user->confirmed){
            return view('auth.login')->with('error' , 'You are not confirmed yet , Please contact the Administrator !');
        }
        // Authinticating user 
        Auth::attempt($account);


        return redirect('/home');

    }

    public function index(){
        $allusers = User::all();
            switch(Auth::user()->role){
                case 0: return view('admin.home')->with('users',$allusers);
                case 1: return view('monitor.home');
                case 2: return view('participant.home');
                default : return view(route('home'));
            }
    }

    public function logout(){
            Auth::logout();
            return redirect(route('welcome'));
    }
}
