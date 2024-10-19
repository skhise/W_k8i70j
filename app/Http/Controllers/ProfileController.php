<?php
namespace App\Http\Controllers;

use App\Models\Generate;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


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
        $generate = Generate::find(1);
       
        $users = Crypt::decrypt($generate->product_key);
        // dd($profile['comapny_name']);
        return view('profile.edit', ["user" => $user,'profile'=>$profile,"users"=>$users]);
    }
    public function limit(Request $request){
        return view('auth.limit');
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
    public function master_setup(Request $request)
    {
        $encrypted = "";
        if(isset($request->number)){
            
            $encrypted = Crypt::encrypt($request->number);
        }
        return view('setup.password-protected', ['encrypted' => $encrypted,"number"=>$request->number]);
    }
}
