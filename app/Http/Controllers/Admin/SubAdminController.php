<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Admin,AdminMenu,AdminSubMenu,Menu,SubMenu};
use Hash;
class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::where('admin_type','Admin')->get();
        $pages='admin';
        return view('admin.sub-admin.index',compact('data','pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages='admin';
        return view('admin.sub-admin.create',compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $add = new Admin;
            $add->name = $request->name;
            if($request->hasFile('image')){
                $upload=uploadImage($request->image);
                $add->profile_image=$upload['orig_path_url'];
            }
            $add->email = $request->email;
            $add->password = Hash::make($request->password ?? '12345678');
            $add->decoded_password = $request->password ?? '12345678';
            if($add->save()){
                $menu=Menu::get();
                if(isset($menu)){
                    foreach($menu as $key=>$value){
                        $menu_add           = new AdminMenu;
                        $menu_add->admin_id = $add->id;
                        $menu_add->menu_id  = $value->id;
                        if($menu_add->save()){
                            $subMenu=SubMenu::where('menu_id',$value->id)->get();
                            if(isset($subMenu)){
                                foreach ($subMenu as $k => $val) {
                                    $sub_menu_add = new AdminSubMenu;
                                    $sub_menu_add->admin_id         =   $add->id;
                                    $sub_menu_add->menu_id          =   $value->id;
                                    $sub_menu_add->admin_menu_id    =   $menu_add->id;
                                    $sub_menu_add->sub_menu_id      =   $val->id;
                                    $sub_menu_add->save();
                                }
                            }
                        }
                    }
                }
                return redirect()->route('sub-admin.index')->with('success','Record added successfully');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
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
        $data=Admin::where('id',$id)->first();
        $pages='admin';
        return view('admin.sub-admin.edit',compact('pages','data'));
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
        try {
            $data=Admin::where('id',$id)->first();
            $data->name = $request->name;
            if($request->hasFile('image')){
                $upload=uploadImage($request->image);
                $data->profile_image=$upload['orig_path_url'];
            }
            if($data->save()){
                return redirect()->route('sub-admin.index')->with('success','Record updated successfully');
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
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
    public function getDeleted($id)
    {
        Admin::where('id',$id)->delete();
        return redirect()->back()->with('success','Record deleted sucessfully');
    }
    public function getPermissionList(Request $request,$id){
        $data=AdminMenu::where('admin_id',$id)->with('children','menu')->get();
        $pages='admin';

        if($request->isMethod('post')){
            AdminMenu::where('admin_id',$id)->update(['permission'=>false]);
            AdminSubMenu::where('admin_id',$id)->update(['permission'=>false]);
            if(isset($request->category)){

                $arr=[];
                foreach($request->category as $ky=>$value){
                    $menu=AdminMenu::where('id',$value[0])->first();
                    if($menu){
                        $menu->permission = true;
                        if($menu->save()){
                                if(isset($value['children'])){
                                    foreach($value['children'] as $kt=>$val){
                                        $submenu=AdminSubMenu::where('id',$val)->first();
                                        if($submenu){
                                            $submenu->permission = true;
                                            $submenu->save();
                                        }
                                    }
                                }
                            // }
                        }
                    }
                }
                return redirect()->back();

            }
        }
        return view('admin.sub-admin.permission',compact('pages','data','id'));
    }

}
