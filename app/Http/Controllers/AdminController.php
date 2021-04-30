<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function updateuser(User $user){
        
        if(isset($_POST['confirm'])){
            $user->confirmed = true;
            $user->save();
            session()->flash('success','User confirmed successfuly');
        }

        else if(isset($_POST['ban'])){
            $user->confirmed = false;
            $user->save();
            session()->flash('success','User banned successfuly');
        }

        else {
            $user->delete();
            session()->flash('success','User removed successfuly');
        }


        return redirect(route('home'));

  }

  public function autoconfirm(){
      
        $message = 'Auto-Confirm  is disabled';
        $admin = auth()->user();
        if($admin->auto_confirm = 1 - $admin->auto_confirm)
            $message = 'Auto-Confirm  is allowed';
        $admin->save();
        
        session()->flash('success',$message);

        return redirect(route('home'));

  }


}