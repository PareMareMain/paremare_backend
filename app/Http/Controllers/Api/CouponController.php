<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserSubscription,Coupon,UserRequest,Wishlist,User};
use Carbon;
use Auth;
use Validator;
class CouponController extends Controller
{
    /**
     * @OA\GET(
     ** path="/api/check-subscription",
     *   tags={"Coupon Api"},
     *   summary="check subscription for process for use coupon",
     *   operationId="checkSubscription",
     *   security={ {"bearer": {} }},
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function checkSubscription(String $locale){
        try {
            $subs=UserSubscription::where('user_id',Auth::user()->id)
                        ->where(function($query){
                            return $query->where('end_date','>=',\Carbon\Carbon::now()->format('Y-m-d'))
                            ->where('start_date','<=',\Carbon\Carbon::now()->format('Y-m-d'));
                        })
                        ->latest()->first();
            if($subs){
                $data=array(
                    "subscription"=>true
                );
                return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
            }else{
                $data=array(
                    "subscription"=>true
                );
                return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }


    }
    /**
     * @OA\POST(
     ** path="/api/claim-coupon",
     *   tags={"Coupon Api"},
     *   summary="claim and share coupon for redeem",
     *   operationId="applyCoupon",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="vendor_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="coupon_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="claim_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"claimed", "shared"}
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function applyCoupon(Request $request,String $locale){
        $rules=[
            'vendor_id'          =>'bail|required',
            'coupon_id'          =>'bail|required',
            'claim_type'         =>'bail|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $user_id=Auth::user()->id;
            $coupon = Coupon::where('vendor_id',$request->vendor_id)->where('id',$request->coupon_id)->first();
            if($coupon){
                $limit_1=UserRequest::where('coupon_id',$coupon->id)->count();
                $limit_2=UserRequest::where('user_id',Auth::user()->id)->where('coupon_id',$coupon->id)->where('claim_type',$request->claim_type)->count();
                if($request->claim_type=='shared'){
                    if($coupon->share_limit>$limit_2){
                        $newItem=$this->applyCouponRedeem($request);
                        return $this->sendSuccessResponse(trans('common.add_coupon'),[],$locale);
                    }else{
                        return $this->sendResponse(422, trans('common.coupon_shared_limit_exceed',[],$locale));
                    }
                }else{
                    if($coupon->total_limit > $limit_1){

                        if($limit_2 < $coupon->limit_per_user){
                            $newItem=$this->applyCouponRedeem($request);
                            return $this->sendSuccessResponse(trans('common.add_coupon'),[],$locale);
                        }else{
                            return $this->sendResponse(422, trans('common.coupon_limit_exceed',[],$locale));
                        }
                    }else{
                        return $this->sendResponse(422, trans('common.coupon_expired',[],$locale));
                    }
                }
            }else{
                return $this->sendResponse(404, trans('common.coupon_not_exist',[],$locale));
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }

    }
    private function applyCouponRedeem($request){
        $newCoupon                  =   new UserRequest;
        $newCoupon->vendor_id       =   $request->vendor_id;
        $newCoupon->user_id         =   Auth::user()->id;
        $newCoupon->claim_type      =   $request->claim_type;
        $newCoupon->coupon_id       =   $request->coupon_id;
        if($newCoupon->save()){
            return $newCoupon;
        }

    }
    /**
     * @OA\GET(
     ** path="/api/get-redeemed-coupon-list",
     *   tags={"Coupon Api"},
     *   summary="get shared and claimed coupon list related to current user",
     *   operationId="getRedeemedCouponList",
     *   security={ {"bearer": {} }},
     *   @OA\Parameter(
     *      name="claim_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"claimed", "shared"}
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function getRedeemedCouponList(Request $request,String $locale){
        // $rules=[
        //     'claim_type'          =>'bail|required',
        // ];
        // $validator = Validator::make($request->all(), $rules);

        // if($validator->fails()) {
        //     return $this->sendResponse(400, $validator->messages()->first());
        // }
        try {
            // $data = UserRequest::where('user_id',Auth::user()->id)->where('claim_type',$request->claim_type)->has('coupons')->with('coupons','vendorDetails')->get();
            $data = UserRequest::where('user_id',Auth::user()->id)->has('coupons')->with('coupons','vendorDetails')->get();
            // dd($data);
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
            
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }
    }
    /**
     * @OA\GET(
     ** path="/api/add-remove-from-wishlist",
     *   tags={"Coupon Api"},
     *   summary="add in wishlist and remove from wishlist",
     *   operationId="addToWishList",
     *   security={ {"bearer": {} }},
     *   @OA\Parameter(
     *      name="vendor_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="coupon_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function addToWishList(Request $request,String $locale){
        $rules=[
            'vendor_id'          =>'sometimes|required',
            'coupon_id'          =>'sometimes|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $name='';
            $data=Wishlist::where('user_id',Auth::user()->id);
            if($request->has('vendor_id')){
                $name='Vendor';
                $data=$data->where('vendor_id',$request->vendor_id);
            }
            if($request->has('coupon_id')){
                $name='Coupon';
                $data=$data->where('coupon_id',$request->coupon_id);
            }
            $data=$data->first();
            if($data){
                $data->delete();
                return $this->sendSuccessResponse(trans('common.delete_coupon',[],$locale),[]);
            }else{
                $add = new Wishlist;

                if($request->has('vendor_id')){
                    $add->vendor_id = $request->vendor_id;
                }
                if($request->has('coupon_id')){
                    $add->coupon_id = $request->coupon_id;
                }
                $add->user_id = Auth::user()->id;
                if($add->save()){
                    return $this->sendSuccessResponse(trans('common.saved_coupon',[],$locale),[]);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }
    }

    /**
     * @OA\GET(
     ** path="/api/get-saved-wishlist",
     *   tags={"Coupon Api"},
     *   summary="get coupon and vendor wishlist",
     *   operationId="getWishlistCouponList",
     *   security={ {"bearer": {} }},
     *   @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"vendor", "coupon"}
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function getWishlistCouponList(Request $request,String $locale){
        $rules=[
            'type'          =>'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $data = Wishlist::where('user_id',Auth::user()->id);
            if($request->type=='vendor'){
                $data=$data->whereNotNull('vendor_id')->has('vendor')->with('vendor');
            }
            if($request->type=='coupon'){
                $data=$data->whereNotNull('coupon_id')->with('coupon');
            }
            $data=$data->get();
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }
    }

    /**
     * @OA\POST(
     ** path="/api/claim-coupon-pin-verification",
     *   tags={"Coupon Api"},
     *   summary="claim coupon with pin verification for redeem",
     *   operationId="claimCouponPinVerification",
     *   security={ {"bearer": {} }},
     *  @OA\Parameter(
     *      name="vendor_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="coupon_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="claim_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"claimed", "shared"}
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function claimCouponPinVerification(Request $request,String $locale){
        $rules=[
            'vendor_id'          =>'bail|required',
            'coupon_id'          =>'bail|required',
            'claim_type'         =>'bail|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        
        try {
            // --------------------------------- without conditions ----------------------------------
            $vendor = User::findOrFail($request->vendor_id);
            if(Auth::user()->is_subscription_active){

// -------------------------------------------------
                switch($request->claim_type) {
                    case('shared'):
                        $coupon = Coupon::where('vendor_id',$request->vendor_id)->where('id',$request->coupon_id)->first();
                        if($coupon){
                            if ($vendor->pin === (int)$request->pin) {
                                $newItem=$this->applyCouponRedeem($request);
                                return $this->sendSuccessResponse(trans('common.add_coupon'),[],$locale);
                            } else {
                                return $this->sendResponse(422, trans('common.incorrect_pin', [], $locale));
                            }
                        }else{
                            return $this->sendResponse(404, trans('common.coupon_not_exist',[],$locale));
                        }

                        break;

                    case('claimed'):
                            $newItem=$this->applyCouponRedeem($request);
                            return $this->sendSuccessResponse(trans('common.add_coupon'),[],$locale);
                        break;

                    default:
                    return $this->sendResponse(422, "Please specifie claim type");
                }

// -------------------------------------------------

            }else{
                return $this->sendSuccessResponse(422,trans('common.need_subscribe'),[],$locale);
            }
            // --------------------------------- with conditions ----------------------------------
            // if ($vendor->pin === (int)$request->pin) {
            //     // return $this->sendSuccessResponse(trans('common.verify_pin', [], $locale), ["pin" => "verified"]);
            //     if($coupon){
            //         $limit_1=UserRequest::where('coupon_id',$coupon->id)->count();
            //         $limit_2=UserRequest::where('user_id',Auth::user()->id)->where('coupon_id',$coupon->id)->count(); //->where('claim_type',$request->claim_type)

            //             if($coupon->total_limit > $limit_1){
    
            //                 if($limit_2 < $coupon->limit_per_user){
            //                     $newItem=$this->applyCouponRedeem($request);
            //                     return $this->sendSuccessResponse(trans('common.add_coupon'),[],$locale);
            //                 }else{
            //                     return $this->sendResponse(422, trans('common.coupon_limit_exceed',[],$locale));
            //                 }
            //             }else{
            //                 return $this->sendResponse(422, trans('common.coupon_expired',[],$locale));
            //             }
            //         // }
            //     }else{
            //         return $this->sendResponse(404, trans('common.coupon_not_exist',[],$locale));
            //     }
            // } else {
            //     return $this->sendResponse(422, trans('common.incorrect_pin', [], $locale));
            // }

        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }

    }
}
