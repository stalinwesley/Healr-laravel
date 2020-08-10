<?php

namespace App\Http\Controllers\NGO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\{User,VendorPartnerType,vendorPartner};

class NGOController extends Controller
{
    public function index()
    {
        return view('ngo.login');
    }  
     
    public function postLogin(Request $request)
    {
        request()->validate([
        'email' => 'required',
        'password' => 'required',
        ]);
        
        $user = User::where('user_name',$request->email)->first();
        if(!$user)
        {
            return Redirect::to("ngo/login")->withError('Oppes! You have entered invalid credentials');
        }

        if(!Hash::check($request->password, $user->pin)){
            return Redirect::to("ngo/login")->withError('Opps! password Error');
        }

        if(Auth::attempt(['user_name' => $request->email,'password' => $request->password], false))
        {
            return Redirect::to("ngo/dashboard")->withSuccess('Great! You have Successfully loggedin');
        }
        
        return Redirect::to("ngo/login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function username()
    {
        return 'user_name';
    }
 
    public function postRegister(Request $request)
    {  
        request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:vendor_partner',
        'password' => 'required|min:6',
        'mobile' => 'required',
        'vendor_type' => 'required',
        'ngologo' => 'required',
        ]);
         
        $file = $request->file('ngologo');
        $data = $request->except('ngologo')+['ngologo'=>$file->getClientOriginalName()];
        $destinationPath = 'uploads';
        $file->move($destinationPath,$file->getClientOriginalName());     
        $check = $this->create($data);
       
        return Redirect::to("ngo/dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
     
    public function dashboard()
    {
 
      if(Auth::check()){
        return view('ngo.dashboard');
      }
       return Redirect::to("ngo/login")->withSuccess('Opps! You do not have access');
    }
     
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('ngo/login');
    }
}
