<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\{User,VendorPartnerType,vendorPartner};

class DashBoardController extends Controller
{
    public function dashboard()
    {
      $all_vendor = VendorPartner::all();
      if(Auth::check()){
        return view('admin.home',['all_vendor'=>$all_vendor]);
      }
       return Redirect::to("admin/login")->withSuccess('Opps! You do not have access');
    }
    public function addngo()
    {
      $allvendortype = VendorPartnerType::all();
 
        return view('admin.addngo',['allvendortype'=>$allvendortype]);
    }
    public function getpostngo(Request $request)
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
    public function create(array $data)
    {
        $user = new User;
        $user->user_name = $data['email'];
        $user->phone_number = $data['mobile'];
        $user->pin = Hash::make($data['password']);
        $user->save();
        $vpt = new vendorPartner;
        $vpt->ngologo = $data['ngologo'];
        $vpt->regno = $data['regno'];
        $vpt->email = $data['email'];
        $vpt->vendor_partner_type_id = $data['vendor_type'];
        $user->vendorPartner()->save($vpt);
        return $user;

    }

}
