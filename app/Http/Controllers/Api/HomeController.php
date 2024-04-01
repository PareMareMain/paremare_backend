<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Category,Product,Banner};
use Validator;
class HomeController extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/home",
     *   tags={"Home"},
     *   summary="use as get/post method to get list",
     *   operationId="homeScreen",
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
    public function homeScreen(Request $request,String $locale){
        try {
            $rules=[
                'latitude'          =>'sometimes|required',
                'longitude'         =>'sometimes|required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->sendResponse(400, $validator->messages()->first());
            }
            $limit = $request->category_limit ?? 6;
            $category = Category::isActive()->withCount('subcategory')->limit($limit)->get();
            $data = User::role('vendor')->whereNull('deleted_at')->has('getCoupon')->pluck('id')->toArray();
            // dd($data);
            $banners =Banner::whereIn('vendor_id',$data )->where('status','approved')->get();
            $allObject=array(
                'banners'=>$banners,
                'categories'=>$category,

            );

            return $this->sendSuccessResponse(trans('common.found',[],$locale),$allObject);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }

    }
        /**
     * @OA\Post(
     ** path="/api/get-vendor-list",
     *   tags={"Vendor"},
     *   summary="use as get(without Token)/post(With token) method to get vendor list or filter",
     *   operationId="getVendorList",
      *   @OA\Parameter(
     *      name="category_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  *   @OA\Parameter(
     *      name="sub_category_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *   @OA\Parameter(
     *      name="latitude",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="longitude",
     *      in="query",
     *      required=false,
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
    public function getVendorList(Request $request,String $locale){
        // return $request->all();
        $rules=[
            'category_id'          =>'sometimes|required',
            'sub_category_id'      =>'sometimes|required',
            'latitude'             =>'sometimes|required',
            'longitude'            =>'sometimes|required',
            'filter_rating'        =>'sometimes|required',
            'min_distance'         =>'sometimes|required',
            'max_distance'         =>'sometimes|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {

            $vendor=User::role('vendor')->has('getCoupon')->whereNull('deleted_at')
            ->with('getCoupon', 'Category', 'SubCategory','coverImages');
            
            if($request->has('category_id') && $request->category_id !=0){
                $vendor = $vendor->whereHas('Category',function($query) use($request){

                    return $query->where('category_id',$request->category_id);
                });
            }
            if($request->has('sub_category_id') && $request->sub_category_id !=0){
                $vendor = $vendor->whereHas('SubCategory',function($query) use($request){
                    return $query->where('sub_category_id',$request->sub_category_id);
                });
            }
            if($request->has('filter_rating')){
                $vendor=$vendor->where('total_rating',$request->filter_rating);
            }
            if($request->has('keyword')){
                $keyword = $request->keyword;
                $vendor=$vendor->where(function ($query) use ($keyword) {
                    $query->where('users.name', 'LIKE', '%' . $keyword . '%');
                });
            }
            if($request->has('is_top')){
                $vendor=$vendor->Where('is_top', $request->is_top);
            }
            if($request->has('is_featured')){
                $vendor=$vendor->where('is_featured',$request->is_featured);
            }
            if($request->has('sort_by') && $request->sort_by =='AZ'){
                $vendor=$vendor->orderBy('name','ASC');
            }
            if($request->has('sort_by') && $request->sort_by =='ZA'){
                $vendor=$vendor->orderBy('name','DESC');
            }
            if($request->has('sort_by') && $request->sort_by =='rating_HL'){
                $vendor=$vendor->orderBy('total_rating','ASC');
            }
            if($request->has('sort_by') && $request->sort_by =='rating_LH'){
                $vendor=$vendor->orderBy('total_rating','DESC');
            }
            if ($request->sort_by == 'distance') {
                     
                if ($request->has('latitude') && $request->has('longitude') && $request->has('min_distance') && $request->has('max_distance')) {
                    $latitude = $request->latitude;
                    $longitude = $request->longitude;
                    $minDistance = $request->min_distance;
                    $maxDistance = $request->max_distance;
            
                    $vendor->selectRaw("*, 6371 * ACOS(
                        SIN(RADIANS(latitude)) * SIN(RADIANS($latitude)) +
                        COS(RADIANS(latitude)) * COS(RADIANS($latitude)) * COS(RADIANS(longitude) - RADIANS($longitude))
                    ) as distance");
            
                    $vendor->havingRaw("distance >= $minDistance AND distance <= $maxDistance");
                    $vendor->orderBy('distance', 'ASC');
                }
        
            }
            if($request->has('limit')){
                $vendor=$vendor->limit($request->limit);
            }

            $vendor = $vendor->paginate(10);

            // if($request->has('latitude') && $request->has('longitude') && $request->has('min_distance') && $request->has('max_distance')){
            //     $vendor = $vendor->map(function($name, $key) use($request){
            //         $distance=getCalculatedDistance($name->latitude,$name->longitude,$request->latitude,$request->longitude);
            //         if(($distance >= $request->min_distance) && ($distance <= $request->max_distance)){
            //             $name->distance=$distance;
            //             return $name;
            //         }else{
            //             return ;
            //         }
            //     });
                
            // }
            
            // if($request->has('sort_by') && $request->sort_by =='distance'){
            //     $vendor = $vendor->sortBy('distance')->values()->all();
            // }
            // ------------------------------------------------------------------------------------------------
                // $vendor = User::role('vendor')
                //     ->has('getCoupon')
                //     ->whereNull('deleted_at')
                //     ->with('getCoupon', 'Category', 'SubCategory', 'coverImages');

                // if ($request->has('category_id') && $request->category_id != 0) {
                //     $vendor->whereHas('Category', function ($query) use ($request) {
                //         $query->where('category_id', $request->category_id);
                //     });
                // }

                // // Add other conditions...

                // if ($request->has('sort_by')) {
                //     if ($request->sort_by == 'AZ') {
                //         $vendor->orderBy('name', 'ASC');
                //     } elseif ($request->sort_by == 'ZA') {
                //         $vendor->orderBy('name', 'DESC');
                //     } elseif ($request->sort_by == 'rating_HL') {
                //         $vendor->orderBy('total_rating', 'ASC');
                //     } elseif ($request->sort_by == 'rating_LH') {
                //         $vendor->orderBy('total_rating', 'DESC');
                //     } elseif ($request->sort_by == 'distance') {
                     
                //             if ($request->has('latitude') && $request->has('longitude') && $request->has('min_distance') && $request->has('max_distance')) {
                //                 $latitude = $request->latitude;
                //                 $longitude = $request->longitude;
                //                 $minDistance = $request->min_distance;
                //                 $maxDistance = $request->max_distance;
                        
                //                 $vendor->selectRaw("*, 6371 * ACOS(
                //                     SIN(RADIANS(latitude)) * SIN(RADIANS($latitude)) +
                //                     COS(RADIANS(latitude)) * COS(RADIANS($latitude)) * COS(RADIANS(longitude) - RADIANS($longitude))
                //                 ) as distance");
                        
                //                 $vendor->havingRaw("distance >= $minDistance AND distance <= $maxDistance");
                //                 $vendor->orderBy('distance', 'ASC');
                //             }
                    
                //     }
                // }

                // // Set limit if needed
                // if ($request->has('limit')) {
                //     $vendor->limit($request->limit);
                // }

                // // Paginate the results
                // $perPage = 10; // You can adjust this as needed
                // $vendor = $vendor->paginate($perPage);
            // ------------------------------------------------------------------------------------------------
            
            return $this->sendSuccessResponse(trans('common.found',[],$locale),$vendor);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }

    }
    /**
     * @OA\GET(
     ** path="/api/get-product-list",
     *   tags={"Product"},
     *   summary="get coupon related vendor product list",
     *   operationId="getProduct",
     *   security={ {"bearer": {} }},
     *   @OA\Parameter(
     *      name="vendor_id",
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
    public function getProduct(Request $request,String $locale){
        $rules=[
            'vendor_id'          =>'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        $data=Product::where('vendor_id',$request->vendor_id)->get();
        return $this->sendSuccessResponse(trans('common.found',[],$locale),$data);
    }
}
