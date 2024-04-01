<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Auth;
use App\Models\{User,Setting,Faq,ContactUs,Coupon, FaqCategory, FaqCategoryRelation, UserRequest};
class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $email=$request->email;
            $password=$request->password;
            if(Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])){
                return redirect()->route('dashboard')->with('success','Login Success');
                // return response()->json([
                //     'status'=>true,
                // ]);
            }else{
                return redirect()->back()->with('error','Email or password Incorrect');
            }
        }
        return view('admin.login');
    }
    public function dashoard(){
        $pages='dashboard';
        $subPages='dashboard';
        $totalUser=User::role('user')->count();
        $totalVendor=User::role('vendor')->count();
        $totalCoupon=Coupon::count();
        $totalRedeemed=UserRequest::where('status','vendor_redeem')->where('claim_type','claimed')->count();
        $totalPending=UserRequest::where('status','user_redeem')->where('claim_type','claimed')->count();
        $totalShared=UserRequest::where('claim_type','shared')->count();
        $totalEarning=UserRequest::where('claim_type','claimed')->sum('total_paid');
        $totalDiscount=UserRequest::where('claim_type','claimed')->sum('total_discount');

        $totalCount=$totalRedeemed+$totalPending+$totalShared;
        $totalCount=$totalCount==0?1:$totalCount;
        $sharedPercentage=($totalShared*100)/$totalCount;
        $pendingPercentage=($totalPending*100)/$totalCount;
        $redeemPercentage=($totalRedeemed*100)/$totalCount;

        $totalAmount=$totalEarning+$totalDiscount;
        $totalAmount=$totalAmount==0?1:$totalAmount;
        $perE=($totalEarning*100)/$totalAmount;
        $perD=($totalDiscount*100)/$totalAmount;
        return view('admin.dashboard',compact('pages','subPages','perE','perD','totalUser','totalVendor','totalCoupon','totalRedeemed','totalShared','totalEarning','totalDiscount','totalPending','sharedPercentage','pendingPercentage','redeemPercentage'));
    }
    public function logout(Request $request) {
        // dd('hii');
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success',"Logout Successfully");
    }
    public function checkEmailExist(Request $request){
        $user = User::where('email',$request->email)->exists();
        $msg='';
        if($user===true){
            $msg='Email already exist!';
        }
        return response()->json([
            "status"=>$user,
            "msg"=>$msg
        ]);
    }
    public function setting(Request $request,$type){
        $data = Setting::where('type',$type)->first();
        $pages='setting';
        $subPages=$type;
        if($request->isMethod('post')){
            if($data){
                // $data->title = $request->title;

                $data
                ->setTranslation('description', 'en', $request->description_en)
                ->setTranslation('description', 'ar', $request->description_ar);
                // $data->description = $request->description;
                if($data->save()){
                    return redirect()->back()->with('success','Records updated successfully');
                }
            }else{
                $data = new Setting;
                // $data->title = $request->title;
                // $data
                // ->setTranslation('title', 'en', $request->title_en)
                // ->setTranslation('title', 'ar', $request->title_ar);
                $data
                ->setTranslation('description', 'en', $request->description_en)
                ->setTranslation('description', 'ar', $request->description_ar);
                if($data->save()){
                    return redirect()->back()->with('success','Records created successfully');
                }
            }
        }
        return view('admin.setting',compact('data','type','pages','subPages'));
    }
    public function faq(){
        $pages='setting';
        $subPages='faq';
        $data = Faq::with(['category'])->get();

        $categories = FaqCategory::isActive()->get();
        return view('admin.faq',compact('data','pages','subPages','categories'));
    }
    public function addFaq(Request $request){
        try {
            $add=new Faq;
            $add->question=$request->question;
            $add->answer=$request->answer;
            if($add->save()){
                FaqCategoryRelation::updateOrCreate(['faq_id'=>$add->id],['faq_id'=>$add->id,'category_id'=>$request->category]);
                return redirect()->back()->with('success','Records added successfully');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function editFaq(Request $request){
        try {
            $data=Faq::where('id',$request->id)->first();
            if($data){
                $data->question=$request->question;
                $data->answer=$request->answer;
                if($data->save()){
                    FaqCategoryRelation::updateOrCreate(['faq_id'=>$data->id],['faq_id'=>$data->id,'category_id'=>$request->category]);
                    return redirect()->back()->with('success','Records updated successfully');
                }
            }


        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function deleteFaq($id){
        try {
            Faq::where('id',$id)->delete();
            return redirect()->back()->with('success','Record Deleted Successfully');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function contactUs(Request $request){
        $data = ContactUs::find(1);
        $pages='setting';
        $subPages='contactus';
        if($request->isMethod('post')){
            if($data){
                $data->phone = $request->phone;
                $data->email = $request->email;
                if($data->save()){
                    return redirect()->back()->with('success','Record updated successfully');
                }
            }else{
                $add = new ContactUs;
                $add->phone = $request->phone;
                $add->email = $request->email;
                if($add->save()){
                    return redirect()->back()->with('success','Record created successfully');
                }
            }
        }
        return view('admin.contact-us',compact('data','pages','subPages'));
    }
    public function privacyPol(Request $request){
        $data = Setting::where('title', 'Privacy & Policy')->get();
        $description = $data[0]->getTranslation('description', 'en');
        return view('privacy-policy', compact('description'));
    }
}
