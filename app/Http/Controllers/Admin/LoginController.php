<?php

namespace App\Http\Controllers\Admin;

use Auth,Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\{User,VendorPartnerType,vendorPartner};

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }  
 
    public function register()
    {
        $allvendortype = VendorPartnerType::all();
        return view('admin.register',['allvendortype'=>$allvendortype]);
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
            return Redirect::to("admin/login")->withError('Oppes! You have entered invalid credentials');
        }

        if(!Hash::check($request->password, $user->pin)){
            return Redirect::to("admin/login")->withError('Opps! password Error');
        }

        if(Auth::attempt(['user_name' => $request->email,'password' => $request->password], false))
        {
            return Redirect::to("admin/dashboard")->withSuccess('Great! You have Successfully loggedin');
        }
        
        return Redirect::to("admin/login")->withSuccess('Oppes! You have entered invalid credentials');
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
       
        return Redirect::to("admin/dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
     
    public function dashboard()
    {
 
      if(Auth::check()){
        return view('dashboard');
      }
       return Redirect::to("login")->withSuccess('Opps! You do not have access');
    }
 
    public function create(array $data)
    {
        $user = new User;
        $user->user_name = $data['email'];
        $user->phone_number = $data['mobile'];
        $user->pin = Hash::make($data['password']);
        $user->save();
        $vpt = new vendorPartner;
        $vpt->ngologo = $data['ngologo'];
        $vpt->email = $data['email'];
        $vpt->regno = $data['regno'];
        $vpt->vendor_partner_type_id = $data['vendor_type'];
        $user->vendorPartner()->save($vpt);
        return $user;

    }
     
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('admin/login');
    }
}
