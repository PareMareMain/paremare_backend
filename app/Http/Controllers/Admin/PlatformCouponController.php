<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Coupon,CouponReason,UserRequest,User};
use Validator;

class PlatformCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Coupon::isAdminCoupons()->with('vendorDetail')->get();
        $pages='coupon';
        $subPages='platform';
        // dd($data);
        return view('admin.coupons.platformcoupon.index',compact('data','pages','subPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages='coupon';
        $subPages='couponRequest';
        $users=User::role('vendor')->get();
        // dd($users);
        return view('admin.coupons.platformcoupon.create',compact('pages','subPages','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules=[
            'tag_title_en' => 'required',
            'vendor_id' => 'required|nullable',
            'what_inside_en' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }
        try {
            $coupon=new Coupon;
            $coupon
            ->setTranslation('tag_title', 'en', $request->tag_title_en)
            ->setTranslation('tag_title', 'ar', $request->tag_title_ar);
            // $coupon->tag_title          =$request->tag_title;
            $coupon
            ->setTranslation('tag_name', 'en', $request->tag_name_en)
            ->setTranslation('tag_name', 'ar', $request->tag_name_ar);
            // $coupon->tag_name           =$request->tag_name;
            $coupon->vendor_id          = $request->vendor_id;
            $coupon->coupon_code        =$request->coupon_code;
            $coupon->total_limit        =$request->total_limit;
            $coupon->limit_per_user      =$request->limit_per_user;
            $coupon->share_limit         =$request->share_limit ?? 0;
            $coupon->offer_type          =$request->offer_type;
            $coupon->end_date           =$request->end_date;
            $coupon->is_hidden           =$request->is_hidden;
            $coupon->discount        =$request->discount;
            $coupon->redeem_type        =$request->redeem_type;
            $coupon->admin_approval      ='Approved';
            $coupon
            ->setTranslation('what_inside', 'en', $request->what_inside_en)
            ->setTranslation('what_inside', 'ar', $request->what_inside_ar);
            // $coupon->what_inside        =$request->what_inside;
            $coupon
            ->setTranslation('how_to_redeem', 'en', $request->how_to_redeem_en)
            ->setTranslation('how_to_redeem', 'ar', $request->how_to_redeem_ar);
            // $coupon->how_to_redeem      =$request->how_to_redeem;
            // $coupon->user_type          ='admin';
            $coupon->coupon_type        ='general'; // 'individual';
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
                return redirect()->back()->with('success','Coupon Created Successfully');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
            // return redirect()->back()->with('error','Something went wrong.Try again after sometimes');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pages='coupon';
        $subPages='platform';
        $data=Coupon::where('id',$id)->first();
        $users=User::role('vendor')->get();
        return view('admin.coupons.platformcoupon.edit',compact('data','pages','subPages','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon=Coupon::where('id',$id)->first();
            if($coupon){
                $coupon
                ->setTranslation('tag_title', 'en', $request->tag_title_en)
                ->setTranslation('tag_title', 'ar', $request->tag_title_ar);
                $coupon
                ->setTranslation('tag_name', 'en', $request->tag_name_en)
                ->setTranslation('tag_name', 'ar', $request->tag_name_ar);
                // $coupon->tag_title           =$request->tag_title;
                // $coupon->tag_name            =$request->tag_name ;
                $coupon->vendor_id          = $request->vendor_id;
                $coupon->coupon_code         =$request->coupon_code;
                $coupon->total_limit         =$request->total_limit;
                $coupon->limit_per_user      =$request->limit_per_user ;
                $coupon->share_limit         =$request->share_limit ?? 0;
                $coupon->offer_type          =$request->offer_type;
                $coupon->end_date            =$request->end_date;
                $coupon->is_hidden           =$request->is_hidden;
                $coupon->discount           =$request->discount;
                $coupon->redeem_type           =$request->redeem_type;
                // $coupon->what_inside         =$request->what_inside;
                $coupon
                ->setTranslation('what_inside', 'en', $request->what_inside_en)
                ->setTranslation('what_inside', 'ar', $request->what_inside_ar);
                $coupon
                ->setTranslation('how_to_redeem', 'en', $request->how_to_redeem_en)
                ->setTranslation('how_to_redeem', 'ar', $request->how_to_redeem_ar);
                // $coupon->how_to_redeem       =$request->how_to_redeem;
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
                    // return redirect()->route('platform.index')->with('success','Coupon Updated Successfully');
                    return redirect()->back()->with('success','Coupon Updated Successfully');
                }
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function deleteCoupon($id){
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('success','Coupon deleted sucessfully');
    }
    public function getVendorCouponList(){
        try {
            $pages='coupon';
            $subPages='couponRequest';
            $data=Coupon::whereNotNull('vendor_id')->get();

            return view('admin.coupons.coupon-request.index',compact('pages','subPages','data'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function rejectVendorCouponStatus(Request $request){
        try {
            $data=Coupon::where('id',$request->id)->first();
            if($data){
                $data->admin_approval='Rejected';
                $data->reason=$request->reason;
                if($data->save()){
                   $add=new CouponReason;
                   $add->coupon_id = $request->id;
                   $add->vendor_id = $request->vendor_id;
                   $add->reason = $request->reason;
                   if($add->save()){
                        return redirect()->back()->with('success','Status changed successfully');
                   }
                }
            }else{
                return redirect()->back()->with('error','Records not found.');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function approveVendorCouponStatus($id,$status){
        try {
            $data=Coupon::where('id',$id)->first();
            if($data){
                $data->admin_approval=$status;
                if($data->save()){
                    return redirect()->back()->with('success','Status changed successfully');
                }
            }else{
                return redirect()->back()->with('error','Records not found.');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function getCouponRequestDetails($id){
        $data=Coupon::where('id',$id)->first();
        $pages='coupon';
        $subPages='couponRequest';
        return view('admin.coupons.coupon-request.show',compact('data','pages','subPages'));
    }
    public function getCouponRedeemedList(){
        $data=UserRequest::whereHas('coupons',function($query){
            return $query->where('coupon_type','general')
                        ->where('user_type','vendor');
        })->orderBy('id','DESC')->get();
        $pages='coupon';
        $subPages='coupon';
        return view('admin.coupons.index',compact('data','pages','subPages'));
    }
    public function getCouponDetails($id){
        $data=UserRequest::with('coupons','vendorDetails')->where('id',$id)->first();
        $pages='coupon';
        $subPages='coupon';
        return view('admin.coupons.show',compact('data','pages','subPages'));
    }
}
