<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Category, SubCategory, Tag, CategoryTag, VendorTag};

class TagsController extends Controller
{
   
    public function getTagBaseSearch(Request $request,String $locale){
        $keyword = $request->keyword;  
        try {
            if(!$request->filled('keyword')){
                return $this->sendSuccessResponse(trans('common.not_found',[],$locale));
            }
            // $tagIds = Tag::where('name', 'LIKE', '%' . $keyword . '%')->pluck('id')->toArray();
            // $vendorIds = VendorTag::whereIn('tag_id', $tagIds)->pluck('vendor_id')->toArray();
            // $vendor=User::role('vendor')->has('getCoupon')->whereIn('id', $vendorIds)->with('getCoupon', 'Category', 'SubCategory')->orderBy('name','DESC')->get();
                
            $vendor = User::select('users.*')->role('vendor')->has('getCoupon')
                ->with('getCoupon', 'Category', 'SubCategory','coverImages')
                ->join('vendor_tags', 'users.id', '=', 'vendor_tags.vendor_id')
                ->join('tags', 'vendor_tags.tag_id', '=', 'tags.id')
                // ->where('tags.name', 'LIKE', '%' . $keyword . '%')
                ->where(function ($query) use ($keyword) {
                    $query->where('tags.name', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('users.name', 'LIKE', '%' . $keyword . '%');
                })
                ->distinct();
            $vendor = $vendor->paginate(10);
            
                // if($request->has('latitude') && $request->has('longitude') && $request->has('min_distance') && $request->has('max_distance')){
                //     $vendor = $vendor->map(function($name, $key) use($request){
                //         $distance=getCalculatedDistance($name->latitude,$name->longitude,$request->latitude,$request->longitude);
                //         // dd($distance >= $request->min_distance);
                //         if(($distance >= $request->min_distance) && ($distance <= $request->max_distance)){
                //             $name->distance=$distance;
                //             return $name;
                //         }else{
                //             return ;
                //         }
                //     });
                // }

                // $vendor = $vendor->get();

                if($vendor->count() > 0){
                    return $this->sendSuccessResponse(trans('common.found',[],$locale),$vendor);
                }else{
                    return $this->sendSuccessResponse(trans('common.not_found',[],$locale));
                }

        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
