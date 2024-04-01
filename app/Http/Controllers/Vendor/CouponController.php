<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Coupon,UserRequest,User,CouponReason};
use Auth;

class CouponController extends Controller
{
    public function index(){
        $data=Coupon::isVendorsCoupons()->where('vendor_id',Auth::user()->id)->get();
        // dd($data,Auth::user()->id);
        $pages='coupon';
        return view('facilities.coupon.index',compact('data','pages'));
    }
    public function create(){
        $userData=User::where('id',Auth::user()->id)->select('getlink','pin')->first();
        $pages='coupon';
        return view('facilities.coupon.create',compact('pages', 'userData'));
    }
    public function store(Request $request){
        //  dd($request->all());
        try {
            $coupon=new Coupon;
            $coupon->vendor_id          =Auth::user()->id;
            $coupon
                ->setTranslation('tag_title', 'en', $request->tag_title_en)
                ->setTranslation('tag_title', 'ar', $request->tag_title_ar);
            $coupon
                ->setTranslation('tag_name', 'en', $request->tag_name_en)
                ->setTranslation('tag_name', 'ar', $request->tag_name_ar);
            // $coupon->tag_title          =$request->tag_title;
            // $coupon->tag_name           =$request->tag_name;
            $coupon->coupon_code        =$request->coupon_code;
            // ---------------- changes --------------------
            $coupon->discount        =$request->discount;
            $coupon->total_limit        =$request->total_limit;
            $coupon->limit_per_user      =$request->limit_per_user;
            $coupon->end_date           =$request->end_date;
            $coupon->admin_approval      ='Approved';
            // ----------------------------------------------
            $coupon->share_limit         = 0;
            $coupon->offer_type          =$request->offer_type;

            $coupon->redeem_type        =$request->redeem_type;

            $coupon
                ->setTranslation('what_inside', 'en', $request->what_inside_en)
                ->setTranslation('what_inside', 'ar', $request->what_inside_ar);
            $coupon
                ->setTranslation('how_to_redeem', 'en', $request->how_to_redeem_en)
                ->setTranslation('how_to_redeem', 'ar', $request->how_to_redeem_ar);
            // $coupon->what_inside        =$request->what_inside;
            // $coupon->how_to_redeem      =$request->how_to_redeem;
            if($request->has('offer_type') && $request->offer_type==='buy-get'){
                $coupon->buy_items       =$request->buy_items;
                $coupon->free_items      =$request->free_items;

            }
            if($request->has('offer_type') && $request->offer_type==='buy-get-percentage'){
                $coupon->discount        =$request->discount;
                $coupon->buy_items       =$request->buy_items;

            }
            if($request->has('offer_type') && ($request->offer_type==='amount' || $request->offer_type==='percentage')){
                $coupon->discount        =$request->discount;
            }

            if($coupon->save()){
                return redirect()->route('coupon.index')->with('success',__('Coupon Created Successfully'));
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
            // return redirect()->back()->with('error','Something went wrong.Try again after sometimes');
        }

    }
    public function edit($id){
        $data=Coupon::where('id',$id)->first();
        $pages='coupon';
        return view('facilities.coupon.edit',compact('data'));
    }
    public function update(Request $request,$id){
        try {
            // dd($request->all());
            $static=null;
            $coupon=Coupon::where('id',$id)->first();
            if($coupon){
                if($coupon->approval=='Rejected'){
                    $static='Resolved';
                }
                $coupon
                    ->setTranslation('tag_title', 'en', $request->tag_title_en)
                    ->setTranslation('tag_title', 'ar', $request->tag_title_ar);
                $coupon
                    ->setTranslation('tag_name', 'en', $request->tag_name_en)
                    ->setTranslation('tag_name', 'ar', $request->tag_name_ar);
                // $coupon->tag_title           =$request->tag_title;
                // $coupon->tag_name            =$request->tag_name ;
                $coupon->coupon_code         =$request->coupon_code;
                $coupon->share_limit         = 0;
                $coupon->offer_type          =$request->offer_type;
                $coupon->redeem_type        =$request->redeem_type;

                $coupon
                    ->setTranslation('what_inside', 'en', $request->what_inside_en)
                    ->setTranslation('what_inside', 'ar', $request->what_inside_ar);
                $coupon
                    ->setTranslation('how_to_redeem', 'en', $request->how_to_redeem_en)
                    ->setTranslation('how_to_redeem', 'ar', $request->how_to_redeem_ar);
                // $coupon->what_inside         =$request->what_inside;
                // $coupon->how_to_redeem       =$request->how_to_redeem;
                // ----------------- changes --------------------
                $coupon->discount        =$request->discount;
                $coupon->end_date            =$request->end_date;
                $coupon->total_limit         =$request->total_limit;
                $coupon->limit_per_user      =$request->limit_per_user ;
                // $coupon->admin_approval      ='Pending';
                // ----------------------------------------------
                if($request->has('offer_type') && $request->offer_type==='buy-get'){
                    $coupon->buy_items       =$request->buy_items;
                    $coupon->free_items      =$request->free_items;
                    $coupon->discount        =null;
                }
                if($request->has('offer_type') && $request->offer_type==='buy-get-percentage'){
                    $coupon->discount        =$request->discount;
                    $coupon->buy_items       =$request->buy_items;
                    $coupon->free_items      =null;
                }
                if($request->has('offer_type') && ($request->offer_type==='amount' || $request->offer_type==='percentage')){
                    $coupon->discount        =$request->discount;
                    $coupon->buy_items       =null;
                    $coupon->free_items      =null;
                }

                if($coupon->save()){
                    $reason=CouponReason::where('coupon_id',$id)->where('vendor_id',Auth::user()->id)->latest()->first();
                    if($reason){
                        $reason->resolve_answer = 'Resolved';
                        $reason->save();
                    }
                    return redirect()->route('coupon.index')->with('success',__('Coupon Updated Successfully'));
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
            // return redirect()->back()->with('error','Something went wrong.Try again after sometimes');
        }
    }
    public function deleteCoupon($id){
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('success','Coupon deleted sucessfully');
    }
    public function couponApplyedList(){
        $pages='redeem';
        $subPages='redeem';
        $data=UserRequest::where('vendor_id',Auth::user()->id)->where('status','user_redeem')->with('users','coupons')->orderBy('id','DESC')->paginate(6);

        return view('facilities.coupon.coupon-request',compact('data','pages','subPages'));
    }
    public function couponRequestdetail(Request $request,$id){
        $data = UserRequest::where('id',$id)->with('users','coupons')->first();
        if($request->isMethod('post')){
            // dd($request->all());
            $amount=implode(",",$request->amount);
            $amount_free=implode(",",$request->amount_free);
            $amount_discount=$request->amount_discount;
            $amount_paid=$request->amount_paid;
            if($data){
                $data->mrp_price=$amount;
                $data->offer_price=$amount_free;
                $data->total_discount=$amount_discount;
                $data->total_paid=$amount_paid;
                $data->status = $request->status;
                if($data->save()){
                    return redirect()->route('coupon.couponApplyedList')->with('success',__('Vendor Redeem Successfully'));
                    // return response()->json([
                    //     "status"=>true
                    // ]);
                }else{
                    return redirect()->back()->with('error',__('Something went wrong!'));
                }


            }
        }
        $pages='redeem';
        $subPages='redeem';
        return view('facilities.coupon.coupon-request-detail',compact('data','pages','subPages'));
    }
    public function couponInvoice($id){
        $pages='redeem';
        $subPages='history';
        $data = UserRequest::where('id',$id)->with('users','coupons')->first();
        return view('facilities.coupon.coupon-redeemed',compact('data','pages','subPages'));
    }
    public function couponRedeemList(){
        $pages='redeem';
        $subPages='history';
        // $data=UserRequest::where('vendor_id',Auth::user()->id)->where('status','vendor_redeem')->with('users','coupons')->orderBy('id','DESC')->paginate(6);
        $data=UserRequest::where('vendor_id',Auth::user()->id)->where('status','user_redeem')->with('users','coupons')->orderBy('id','DESC')->paginate(6);
        return view('facilities.coupon.coupon-request',compact('data','pages','subPages'));
    }
    public function onShopRedeemCreate(Request $request){
        $users= User::role('user')->get();
        // dd($users);
        return view('facilities.coupon.shop-redeem',compact('users'));
    }
    public function checkCoupon(Request $request){
        $coupon = Coupon::where('vendor_id',Auth::user()->id)->where('coupon_code',$request->coupon)->first();
        if($coupon){
            $limit=UserRequest::where('coupon_id',$coupon->id)->count();
            if($coupon->total_limit > $limit){
                $requestCount=UserRequest::where('user_id',$request->user_id)->where('coupon_id',$coupon->id)->count();
                if($requestCount < $coupon->limit_per_user){
                    $html='';
                    return response()->json([
                        "status"=>true,
                        "message"=>__('Coupon successfully applied'),
                        "data"=>$html,
                        "data1"=>$coupon
                    ]);
                }else{
                    return response()->json([
                        "status"=>false,
                        "message"=>__('Consumer has been exhausted coupon limit')
                    ]);
                }
            }else{
                return response()->json([
                    "status"=>false,
                    "message"=>__('Coupon has expired')
                ]);
            }
        }else{
            return response()->json([
                "status"=>false,
                "message"=>__('Coupon does not exist')
            ]);
        }

    }


}
