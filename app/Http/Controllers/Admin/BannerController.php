<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Banner,User};
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Banner::get();
        $pages='banner';
        return view('admin.banner.index',compact('data','pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages='banner';
        $users=User::role('vendor')->get();
        return view('admin.banner.create',compact('users','pages'));
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
        if($request->hasFile('images')){
            foreach ($request->file('images') as $image) {
                $add = new Banner;

                $add->setTranslation('name', 'en', $request->name_en)->setTranslation('name', 'ar', $request->name_ar);
                if($request->vendor_id=='null'){
                    $add->vendor_id = null;
                    $add->is_redirection_available='no';
                    // $add->status = 'approved';
                }else{
                    $add->vendor_id = $request->vendor_id;
                    $add->is_redirection_available = $request->is_redirection_available;
                }

                $add->status ='approved';
                $upload=fixSizeImageUpload($image, $height = 440, $width = 660);
                $add->image=$upload;
                $add->save();
            }
        }
        // if($request->hasFile('image')){
        //     $upload=uploadImage($request->image);
        //     $add->image=$upload['orig_path_url'];
        // }
        // if($add->save()){
            return redirect()->route('banner.index')->with('success','Records add successfully');
        // }
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
        $users=User::role('vendor')->get();
        return view('admin.banner.edit',compact('data','users','pages'));
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
            if($request->vendor_id=='null'){
                $data->vendor_id = null;
                $data->is_redirection_available= 'no';
            }else{
                $data->vendor_id = $request->vendor_id;
                $data->is_redirection_available= $request->is_redirection_available;
            }
            
            if($request->hasFile('image')){
                $upload=fixSizeImageUpload($request->image, $height = 440, $width = 660);
                $data->image=$upload;
            }
            if($data->save()){
                return redirect()->route('banner.index')->with('success','Records updated successfully');
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
        return redirect()->back()->with('success','Record deleted successfully');
    }
    public function approveBannarStatus($id,$status){
        try {
            $data=Banner::where('id',$id)->first();
            if($data){
                $data->status=$status;
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
}
