<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserSubscription,Coupon,UserRequest,Wishlist,User};
use Carbon;
use Auth;
use Validator;
class PromoCodeController extends Controller
{


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
    public function getPromoCodeList(Request $request,String $locale){
        $rules=[
            'type'          =>'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {

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
    public function claimPromoCodeVerification(Request $request,String $locale){
        $rules=[
            'pin'                =>'bail|required',
            'vendor_id'          =>'bail|required',
            'coupon_id'          =>'bail|required',
            // 'claim_type'         =>'bail|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        
        try {
            // --------------------------------- without conditions ----------------------------------
            $vendor = User::findOrFail($request->vendor_id);
            if(Auth::user()->is_subscription_active){
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
