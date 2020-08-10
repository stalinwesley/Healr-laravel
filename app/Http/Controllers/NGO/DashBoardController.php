<?php

namespace App\Http\Controllers\NGO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\{User,VendorPartnerType,vendorPartner,vendorPartnerRep};


class DashBoardController extends Controller
{
    public function dashboard()
    {
      $all_vendor = vendorPartnerRep::all();
      if(Auth::check()){
        return view('ngo.home',['all_vendor'=>$all_vendor]);
      }
       return Redirect::to("admin/login")->withSuccess('Opps! You do not have access');
    }
    public function healthworker()
    {
 
        return view('ngo.healthworker');
    }
    public function posthealthworker(Request $request)
    {  
        request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:vendor_partner',
        'password' => 'required|min:6',
        'mobile' => 'required',
        'notes' => 'required',
        ]);
        $data = $request->all();
        $check = $this->create($data);
       
        return Redirect::to("ngo/dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    public function create(array $data)
    {
        $user = new User;
        $user->user_name = $data['email'];
        $user->phone_number = $data['mobile'];
        $user->pin = Hash::make($data['password']);
        $user->save();
        $vpt = new vendorPartnerRep;
        $vpt->notes = $data['notes'];
        // dd(auth()->user()->vendorPartner);
        $vpt->vendor_partner_id = auth()->user()->vendorPartner->vendor_partner_id;
        $user->vendorPartnerRep()->save($vpt);
        return $user;

    }
    
}
