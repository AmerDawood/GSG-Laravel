<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {


        // dd(Auth::user());


        // dd(Auth::guard('admin')->user());


        // dd($request->user());



        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);


       $creditials =[
            'email'=>$request->email,
            'password'=>$request->password
        ];



        $result = Auth::attempt($creditials,$request->boolean('remmember'));






        if($result){
        return redirect()->route('classroom.index');

        }

    //   $user =  User::where('emai','=',$request->email)->first();

    //   if($user && Hash::check($request->password,$user->password)){

    //     // here  make create to session for user
    //     Auth::login($user);


    //     Auth::login($user,$request->boolean('remmember'));


    //     return redirect()->route('classroom.index');

    //   }

      return back()->withInput()->withErrors('email','Invalid credientials');

    }
}
