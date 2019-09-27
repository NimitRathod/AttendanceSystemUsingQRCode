<?php

namespace App\Http\Controllers\Auth\Custom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Hash; // Password Encription

class CustomController extends Controller
{

    public function reset(Request $request)
    {

    	$this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);

        $user = User::find(Auth::id());
        if (!Hash::check($request->current, $user->password))
        {
        	return redirect()->back()->withErrors(['error'=>'Current password does not match']);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('change_password')->with('success','Your Password Changed');
        dd("Ok");
        return redirect()->route('logout');

    	dd($user,$request->all());
    }
}
