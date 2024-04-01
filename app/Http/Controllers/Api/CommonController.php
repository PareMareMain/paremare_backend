<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\{SubCategory,Faq,Setting,ContactUs, FaqCategory};
class CommonController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/get-sub-categories",
     *   tags={"Common Api"},
     *   summary="get sub-categories",
     *   operationId="getSubCategories",
     *   @OA\Parameter(
     *      name="category_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
    public function getSubCategories(Request $request,String $locale){
        $rules=[
            'category_id'          =>'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $data=SubCategory::isActive()->where('category_id',$request->category_id)->get();
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }
    }
    /**
     * @OA\Get(
     ** path="/api/get-faq",
     *   tags={"Common Api"},
     *   summary="get FAQ",
     *   operationId="getfaq",
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
    public function getfaq(Request $request,String $locale){
        try {
            $data = Faq::get();
            if($request->cid){
                $data = $data->where('category_id',$request->cid);
            }
            $data = array_values($data->toArray());
            $categories = FaqCategory::isActive()->get();
            return $this->sendSuccessResponse(trans('common.found',[],$locale),['faqs'=>$data,'categories'=>$categories]);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }
    }
    /**
     * @OA\Get(
     ** path="/api/get-settings",
     *   tags={"Common Api"},
     *   summary="setting contains cms contents like terms,privacy,aboutus",
     *   operationId="getSettings",
     *   @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"terms", "privacy","aboutus"}
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
    public function getSettings(Request $request,String $locale){
        try {
            $data=Setting::where('type',$request->type)->first();
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }

    }
    /**
     * @OA\Get(
     ** path="/api/get-contact-us",
     *   tags={"Common Api"},
     *   summary="contact-us details",
     *   operationId="getContactUs",
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
    public function getContactUs(Request $request,String $locale){
        try {
            $data=ContactUs::find(1);
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }

    }


}
