<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product,UserRequest};
use Auth;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProducts()
    {
        $data = Product::where('vendor_id',Auth::user()->id)->get();
        return view('facilities.products.index',compact('data'));
    }
    public function storeProducts(Request $request){
        $add=new Product;
        $add->vendor_id =   Auth::user()->id;
        $add->name      =   $request->name;
        $add->amount    =   $request->amount;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $add->image=$upload['orig_path_url'];
        }
        if($add->save()){
            return redirect()->back()->with('success',__('Products added successfully'));
        }
    }
    public function updateProducts(Request $request){
        $add=Product::where('id',$request->id)->first();
        if($add){
            $add->name      =   $request->name;
            $add->amount    =   $request->amount;
            if($request->hasFile('image')){
                $upload=uploadImage($request->image);
                $add->image=$upload['orig_path_url'];
            }
            if($add->save()){
                return redirect()->back()->with('success',__('Products updated successfully'));
            }
        }
    }
    public function deleteProducts($id){
        Product::where('id',$id)->delete();
        return redirect()->back()->with('success',__('Products deleted successfully'));
    }

    public function getCouponList(){
        $data=UserRequest::whereHas('coupons',function($query){
            return $query->where('coupon_type','general')
                        ->where('user_type','vendor');
        })->orderBy('id','DESC')->get();
        $pages='coupon';
        $subPages='coupon';
        return view('admin.coupons.index',compact('data','pages','subPages'));
    }
    public function getCouponDetails($id){
        $data=UserRequest::where('id',$id)->first();
        $pages='coupon';
        $subPages='coupon';
        return view('admin.coupons.show',compact('data','pages','subPages'));
    }
}
