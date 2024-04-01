<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\{User,VendorPlan,Coupon,UserRequest};
class LoginController extends Controller
{
    public function login(Request $request){
        // dd($request->all());
        if($request->isMethod('post')){
            $email=$request->email;
            $user=User::where('email',$email)->first();
            // dd($user);
            if($user){
                $password=$request->password ?? $user->decoded_password;
                // dd($password);
                if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password])){

                    return redirect()->route('vendor.dashboard')->with('success',__('Login Success'));
                    // return response()->json([
                    //     'status'=>true,
                    // ]);
                }else{
                    return redirect()->route('vendor.login')->with('error',__('Email or Password incorrect'));
                }
            }else{
                return redirect()->route('vendor.login')->with('error',__('Email not registered'));
            }

        }
        return view('facilities.login');
    }
    public function dashoard(){
        $pages='dashboard';
        $totalCoupon=Coupon::where('vendor_id',Auth::user()->id)->count();
        $totalRedeemed=UserRequest::where('vendor_id',Auth::user()->id)->where('status','vendor_redeem')->where('claim_type','claimed')->count();
        $totalPending=UserRequest::where('vendor_id',Auth::user()->id)->where('status','user_redeem')->where('claim_type','claimed')->count();
        $totalShared=UserRequest::where('vendor_id',Auth::user()->id)->where('claim_type','shared')->count();
        $totalEarning=UserRequest::where('vendor_id',Auth::user()->id)->where('claim_type','claimed')->sum('total_paid');
        $totalDiscount=UserRequest::where('vendor_id',Auth::user()->id)->where('claim_type','claimed')->sum('total_discount');
        $totalCount=$totalRedeemed+$totalPending+$totalShared;
        $totalCount=$totalCount==0?1:$totalCount;
        $sharedPercentage=($totalShared*100)/$totalCount;
        $pendingPercentage=($totalPending*100)/$totalCount;
        $redeemPercentage=($totalRedeemed*100)/$totalCount;
        return view('facilities.dashboard',compact('pages','totalCoupon','totalRedeemed','totalShared','totalEarning','totalDiscount','totalPending','sharedPercentage','pendingPercentage','redeemPercentage'));
    }
    public function logout(Request $request) {
        // dd('hii');
        Auth::guard('web')->logout();
        return redirect()->route('vendor.login')->with('success',__("Logout Successfully"));
    }
    public function QRCode(){
        return view('facilities.myqr');
    }
    public function planIndex(){
        $data=VendorPlan::where('user_id',Auth::user()->id)->get();
        return view('facilities.plan_index',compact('data'));
    }
    public function changePassword(Request $request){
        $pages='password';
        $user=Auth::user();
        if($request->isMethod('post')){
            if (Hash::check($request->oldpassword, $user->password)) {
                $user->password=Hash::make($request->newpassword);
                if($user->save()){
                    return redirect()->back()->with('success',__("Password Changed Successfully"));
                }
            }else{
                return redirect()->back()->with('error',__('Old password mismatch'));
            }
        }
        return view('facilities.change-password',compact('pages'));

    }
    public function editVendorProfile(Request $request){
        try {
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',__('Something went wrong.Try Again!'));
        }
    }
}
