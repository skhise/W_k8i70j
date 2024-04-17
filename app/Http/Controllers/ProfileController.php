<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Request;


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
        return view('profile.edit', ["user" => $user]);
    }
}
