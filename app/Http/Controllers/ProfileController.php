<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ProfileSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        $profile = ProfileSetup::where(['id'=>1])->first();
        // dd($profile['comapny_name']);
        return view('profile.edit', ["user" => $user,'profile'=>$profile]);
    }
    public function update(Request $request)   {
        $user = Auth::user();
        // dd($request);
        $profile = ProfileSetup::where(['id'=> 1])->first();
        $profile->wp_user_name = $request->wp_user_name;
        $profile->wp_api_key = $request->wp_api_key;
        $profile->contact_number = $request->contact_number;
        $profile->address = $request->address;
       $save = $profile->save();
       if ($save) {
        return redirect()->route('profile.edit')->with('success','Changes Saved ');
       }
       return redirect()->route('profile.edit')->with('error','Failed, Try again');

    }
    public function change_password(Request $request) {
        $user = Auth::user();
        $password = Hash::make($request->password);
        $user->password = $password;
        $changed = $user->save();
        if ($changed) {
            return response()->json(['success'=> true]);
        }
        return response()->json(['success'=> false]);

    }
}
