<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,VendorPlan,Category, Country, UserCategory,SubCategory,UserSubCategory, VendorTag, CategoryTag, Tag,Image};
use Hash;
use Mail;
use DB;
use Validator;

class VenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::role('vendor')->select('id','name','email','phone_number','profile_image','location','latitude','longitude')->get();
        $pages='user';
        $subPages='vendor';
        return view('admin.vendor.index',compact('data','pages','subPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();
        $countries=Country::get();
        $pages='user';
        $subPages='vendor';
        return view('admin.vendor.create',compact('category','pages','subPages','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'email' => 'required|email',
            'name_en' => 'required',
            'address' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'pin' => 'numeric',
            'menu_image' => 'nullable|mimes:pdf'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }

        $user=User::where('email',$request->email)->exists();
        if($user){
            return redirect()->back()->with('error','Email already exist');
        }else{
            try {
                DB::beginTransaction();
                $rand   =   rand('10000000','99999999');
                $vendor =   new User;
                $vendor
                    ->setTranslation('name', 'en', $request->name_en)
                    ->setTranslation('name', 'ar', $request->name_ar);
                $vendor->location       =   $request->address;
                $vendor->email          =   $request->email;
                $vendor->phone_number   =   $request->phone;
                $vendor->country_code   =   $request->country_code;
                $vendor->latitude       =   $request->latitude;
                $vendor->longitude      =   $request->longitude;
                $vendor->website        =   $request->website;
                $vendor->getlink        =   $request->getlink;
                $vendor->instagram      =   $request->instagram;
                $vendor->pin            =   $request->pin;
                $vendor->description    =   $request->about;
                $vendor->is_top         =   $request->is_top ? true : false;
                $vendor->is_featured    =   $request->is_featured ? true : false;
                $vendor->password       =   Hash::make($rand);
                $vendor->assignRole('vendor');
                // $vendor->decoded_password=$rand;
                if($request->hasFile('image')){
                    $upload=uploadImage($request->image);
                    $vendor->profile_image=$upload['orig_path_url'];
                }
                if($request->hasFile('image_b')){
                    $upload=uploadImage($request->image_b);
                    $vendor->cover_image=$upload['orig_path_url'];
                }
                if($vendor->save()){
                    if($request->has('category')){
                        $cat=Category::where('id',$request->category)->first();
                        $new_cat=new UserCategory;
                        $new_cat->vendor_id=$vendor->id;
                        $new_cat->category_id=$cat->id;
                        $new_cat->category_name=$cat->name;
                        if($new_cat->save()){

                            if($request->has('subcategory')){
                                $subcat=SubCategory::where('id',$request->subcategory)->first();
                                $new_Subcat=new UserSubCategory;
                                $new_Subcat->vendor_id=$vendor->id;
                                $new_Subcat->category_id=$cat->id;
                                $new_Subcat->sub_category_id=$subcat->id;
                                $new_Subcat->user_category_id=$new_cat->id;
                                $new_Subcat->sub_category_name=$subcat->name;
                                $new_Subcat->save();
                            }
                        }
                    }
                    if($request->has('vendortag')){
                        $vendorTags = [];
                        foreach ($request->vendortag as $tagId) {
                            $vendorTags[] = [
                                'vendor_id' => $vendor->id,
                                'tag_id' => $tagId,
                            ];
                        }
                        VendorTag::insert($vendorTags);
                    }
                    $to_name = '';
                    $to_email = $vendor->email;
                    // if($to_email!=null && $to_email!=''){
                    //     $dataa = array('name'=>$to_name,'password'=>$rand ,'email' => $to_email);
                    //     Mail::send('email.vender_register', $dataa, function($message) use ($to_email, $to_name){
                    //         $message->from(env('MAIL_FROM_ADDRESS'), "Pare Mare");
                    //         $message->to($to_email, $to_name);
                    //     $message->subject('Pare Mare Credentials');
                    //     });
                    // }
                    if($request->hasFile('menu_image')){
                        $data=new Image;
                        $data->vendor_id=$vendor->id;
                        $upload=uploadImage($request->menu_image);
                        $data->image=$upload['orig_path_url'];
                        $data->description= '';
                        $data->status=1;
                        $data->save();
                    }
    
                    if($request->hasFile('images')){
                        foreach ($request->file('images') as $image) {
                            $add = new Image;
                            $add->vendor_id = $vendor->id;   
                            $add->type = 2;
                            $upload=fixSizeImageUpload($image);
                            $add->image=$upload;
                            $add->save();
                        }
                    }
                }
                DB::commit();
                $msg = "You have been successfully registered with PareMare. Here are your login credentials. UserID = $request->email, Password = $rand";
                $receiverNumber = $request->country_code.$request->phone;
                sendCustomMessage($receiverNumber, $msg);

                return redirect()->route('vendor.index')->with('success','Vendor created successfully');
            } catch (\Throwable $th) {
                DB::rollback();
                return $th->getMessage();
            }

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
        $pages='user';
        $subPages='vendor';
        $sub_category = [];
        $getTag = '';
        $data=User::find($id);
        $countries=Country::get();
        $category = Category::get();
        $existCategory = UserCategory::where('vendor_id',$id)->pluck('category_id')->toArray();
        $getTag = $existCategory;
        $existSubCategory = UserSubCategory::where('vendor_id',$id)->pluck('sub_category_id')->toArray();
        if(count($existSubCategory) > 0){
            $sub_category = SubCategory::whereIn('category_id',$existCategory)->get();
            $getTag = [...$existCategory, ...$existSubCategory];
        }
        $tagIds = CategoryTag::whereIn('category_id',$getTag)->pluck('tag_id')->toArray();
        $tags = Tag::whereIn('id',$tagIds)->select('id', 'name')->get();
        $vendorSelectedTags = VendorTag::where('vendor_id',$id)->pluck('tag_id')->toArray();
        $menu = Image::where('vendor_id',$id)->where('type',1)->orderBy('id','DESC')->get();
        $cover_image = Image::where('vendor_id',$id)->where('type',2)->orderBy('id','DESC')->get();
// dd($menu);
        return view('admin.vendor.edit',compact('data','pages','subPages','category','existCategory', 'sub_category', 'tags','vendorSelectedTags', 'countries', 'menu','cover_image'));
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

        $rules=[
            'name_en' => 'required',
            'address' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'pin' => 'numeric',
            'menu_image' => 'nullable|mimes:pdf'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }
        try {
            DB::beginTransaction();
            $data=User::find($id);
            if($data){
                $data
                        ->setTranslation('name', 'en', $request->name_en)
                        ->setTranslation('name', 'ar', $request->name_ar);
                $data->location = $request->address;
                $data->phone_number     =   $request->phone;
                $data->country_code     =   $request->country_code;
                $data->latitude         =   $request->latitude;
                $data->longitude        =   $request->longitude;
                $data->is_top           =   $request->is_top ? true : false;
                $data->is_featured      =   $request->is_featured ? true : false;
                $data->website          =   $request->website;
                $data->getlink          =   $request->getlink;
                $data->instagram        =   $request->instagram;
                $data->pin              =   $request->pin;
                $data->description      =   $request->about;
                if($request->has('email')){
                    $data->email = $request->email;
                }
                if($request->hasFile('image')){
                    $upload=uploadImage($request->image);
                    $data->profile_image=$upload['orig_path_url'];
                }
                if($request->hasFile('image_b')){
                    $upload=uploadImage($request->image_b);
                    $data->cover_image=$upload['orig_path_url'];
                }
                $data->save();
                if($request->has('category')){
                    $cat=Category::where('id',$request->category)->first();
                        $userCategory = UserCategory::where('vendor_id', $id)->first();

                        if ($userCategory) {
                            $userCategory->category_id = $cat->id;
                            $userCategory->category_name = $cat->name;
                            $userCategory->save();
                            $updatedId = $userCategory->id;
                        }

                        if($request->has('subcategory')){
                            $subcat=SubCategory::where('id',$request->subcategory)->first();
                            $UserSubCategory = UserSubCategory::updateOrCreate(
                                ['vendor_id' => $id],
                                ['category_id'=> $cat->id,'sub_category_id' => $subcat->id,'sub_category_name' => $subcat->name,'user_category_id'=> $updatedId]
                            );

                        }else{
                            UserSubCategory::where('vendor_id',$id)->delete();
                        }

                        if($request->has('vendortag')){
                            VendorTag::where('vendor_id',$id)->delete();
                            $vendorTags = [];
                            foreach ($request->vendortag as $tagId) {
                                $vendorTags[] = [
                                    'vendor_id' => $id,
                                    'tag_id' => $tagId,
                                ];
                            }
                        
                            VendorTag::insert($vendorTags);
                        }else{
                            VendorTag::where('vendor_id',$id)->delete();
                        }
                
                }
                if($request->hasFile('menu_image')){
                    $data= Image::where('vendor_id', $id)->where('status',1)->first();
                    if (!is_null($data)) {
                        $upload=uploadImage($request->menu_image);
                        $data->image=$upload['orig_path_url'];
                        $data->description= '';
                        $data->status=1;
                        $data->save();
                    }else{
                        $data=new Image;
                        $data->vendor_id=$id;
                        $upload=uploadImage($request->menu_image);
                        $data->image=$upload['orig_path_url'];
                        $data->description= '';
                        $data->status=1;
                        $data->save();
                    }

                }
                    
                if($request->hasFile('images')){
                    foreach ($request->file('images') as $image) {
                        $add = new Image;
                        $add->vendor_id = $id;   
                        $add->type = 2;
                        $upload=fixSizeImageUpload($image);
                        $add->image=$upload;
                        $add->save();
                    }
                }
            }
            DB::commit();
            return redirect()->route('vendor.index')->with('success','Vendor updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::info($th);
            return redirect()->back()->with('error',__('Something went wrong.Try Again!'));
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
    public function delBanner(Request $request)
    {
        try {        
            Image::where('id',$request->id)->delete();
            return $this->sendResponse(200,'detele',$request->id );
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }
    }
    public function getDeleted($id){
        User::where('id',$id)->delete();
        return redirect()->back()->with('success','Record Deleted Successfully');
    }
}
