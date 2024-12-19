<?php
namespace App\Http\Controllers;

use Some\Other\Class;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController {

    public function Index(){

        return view('frontend.index');
    } //End Method

    public function UserProfile(){

        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.dashboard.edit_profile',compact('userData'));


    }//End Method
}











