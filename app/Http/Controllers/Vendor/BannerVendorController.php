<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Banner};
use Auth;
class BannerVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages='banner';
        $data=Banner::where('vendor_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('facilities.banner.index',compact('data','pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages='banner';
        if(!Auth::user()->is_subscription_active){
            return redirect()->back()->with('error','Buy Plan to add banners');
        }
        return view('facilities.banner.create',compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add = new Banner;
        $add
            ->setTranslation('name', 'en', $request->name_en)
            ->setTranslation('name', 'ar', $request->name_ar);
        // $add->name = $request->name;
        $add->vendor_id = Auth::user()->id;
        $add->is_redirection_available= $request->is_redirection_available;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $add->image=$upload['orig_path_url'];
        }
        if($add->save()){
            return redirect()->route('vendor-banner.index')->with('success',__('Records added successfully'));
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
        $pages='banner';
        $data=Banner::where('id',$id)->first();
        return view('facilities.banner.edit',compact('data','pages'));
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
        $data=Banner::where('id',$id)->first();
        if($data){
            $data
            ->setTranslation('name', 'en', $request->name_en)
            ->setTranslation('name', 'ar', $request->name_ar);
            // $data->name = $request->name;
            $data->is_redirection_available= $request->is_redirection_available;
            if($request->hasFile('image')){
                $upload=uploadImage($request->image);
                $data->image=$upload['orig_path_url'];
            }
            if($data->save()){
                return redirect()->route('vendor-banner.index')->with('success',__('Records updated successfully'));
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
    public function deleteBanner($id){
        Banner::where('id',$id)->delete();
        return redirect()->back()->with('success',__('Banner deleted successfully'));
    }
}
