<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category, FaqCategory, SubCategory};

class CategoryController extends Controller
{
// category list/index
    public function categoryIndex(){
        $pages='category';
        $subPages='category';
        $data=Category::orderBy('id','DESC')->get();
        return view('admin.category.index',compact('data','pages','subPages'));
    }
    public function categoryCreate(){
        $pages='category';
        $subPages='category';
        return view('admin.category.create',compact('pages','subPages'));
    }
    public function categoryStore(Request $request){
        $add =new Category;
        $add
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $add->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $add->image=$upload['orig_path_url'];
        }
        if($add->save()){
            return redirect()->route('category.index')->with('success','Category created successfully');
        }
    }
    public function categoryEdit($id){
        $data=Category::find($id);
        $pages='category';
        $subPages='category';
        return view('admin.category.edit',compact('data','pages','subPages'));
    }
    public function categoryUpdate(Request $request,$id){
        $data=Category::find($id);
        $data
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $data->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $data->image=$upload['orig_path_url'];
        }
        if($data->save()){
            return redirect()->route('category.index')->with('success','Category Updated successfully');
        }
    }
    public function categoryDestroy($id){
        $delete=Category::where('id',$id)->delete();
        return redirect()->back()->with('success','Category deleted successfully');
    }
    public function changeCategoryStatus(Request $request,$id,$status){
        $change=Category::where('id',$id)->first();
        if($change){
            $change->status=$status;
            $change->save();
            return redirect()->back()->with('success','Category status changes');
        }

    }
//end category
//start sub-category

    public function subCategoryIndex($id){
        $pages='category';
        $subPages='category';
        $data=SubCategory::where('category_id',$id)->with('category')->orderBy('id','DESC')->get();
        return view('admin.sub-category.index',compact('data','id','pages','subPages'));
    }
    public function subCategoryCreate($id){
        $pages='category';
        $subPages='category';
        return view('admin.sub-category.create',compact('id','pages','subPages'));
    }
    public function subCategoryStore(Request $request,$cat_id){
        $add =new SubCategory;
        $add->category_id=$cat_id;
        $add
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $add->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $add->image=$upload['orig_path_url'];
        }
        if($add->save()){
            return redirect()->route('subcategory.index',$cat_id)->with('success','Sub-Category created successfully');
        }
    }
    public function subCategoryEdit($catId,$id){
        $pages='category';
        $subPages='category';
        $data=SubCategory::find($id);
        return view('admin.sub-category.edit',compact('data','catId','pages','subPages'));
    }
    public function subCategoryUpdate(Request $request,$catId,$id){
        $data=SubCategory::find($id);
        $data
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $data->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $data->image=$upload['orig_path_url'];
        }
        if($data->save()){
            return redirect()->route('subcategory.index',$catId)->with('success','Category Updated successfully');
        }
    }
    public function subCategoryDestroy($id){
        $delete=SubCategory::where('id',$id)->delete();
        return redirect()->back()->with('success','Category deleted successfully');
    }
    public function changeSubCategoryStatus(Request $request,$id,$status){
        $change=SubCategory::where('id',$id)->first();
        if($change){
            $change->status=$status;
            $change->save();
            return redirect()->back()->with('success','Sub-category status changes');
        }
    }
    //end sub-category
    public function getSubCategories(Request $request){
        $sub_category = SubCategory::where('category_id',$request->id)->get();

        $html='';
        if(isset($sub_category) && ($sub_category->count()>0)){
            $html .='<label>Sub-Categories</label>';
            $html .='<select class="form-control input-default" name="subcategory" id="subcategory">
                    <option value="" selected hidden disabled>Select Sub-Category</option>';
            foreach($sub_category as $key=>$value){
                $html .= '<option value="'.$value->id.'">'.$value->name.'</option>';
            }
            $html .='</select>';
        }
        return response()->json([
            'status'=>true,
            'data'=>$html
        ]);
    }


    public function faqcategoryIndex(Request $request){
        $pages='setting';
        $subPages='faq';
        $data=FaqCategory::find($request->idd);
        if($data && $request->id == "update"){
            return $this->categoryFaqUpdate($request,$request->idd);
        }else if($data && $request->id == "edit"){
            return view('admin.faq.category.edit',compact('data','pages','subPages'));
        }else if($request->id == "create"){
            return view('admin.faq.category.create',compact('pages','subPages'));
        }else if($request->id == "store"){
            return $this->createFaqCategory($request);
        }else if($data && $request->id == "delete"){
            return $this->categoryFaqDestroy($request->idd);
        }else if($data && ($request->id == "active" || $request->id == "inactive")){
            return $this->changeFaqCategoryStatus($request->idd,$request->id);
        }
        $data=FaqCategory::orderBy('id','DESC')->get();
        return view('admin.faq.category.index',compact('data','pages','subPages'));
    }



    public function createFaqCategory(Request $request){
        $add =new FaqCategory;
        $add
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $add->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $add->image=$upload['orig_path_url'];
        }
        if($add->save()){
            return redirect()->route('faq.category')->with('success','Category created successfully');
        }
    }


    public function categoryFaqUpdate(Request $request,$id){
        $data=FaqCategory::find($id);
        $data
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $data->name = $request->name;
        if($request->hasFile('image')){
            $upload=uploadImage($request->image);
            $data->image=$upload['orig_path_url'];
        }
        if($data->save()){
            return redirect()->route('faq.category')->with('success','Category Updated successfully');
        }
    }


    public function categoryFaqDestroy($id){
        $delete=FaqCategory::where('id',$id)->delete();
        return redirect()->back()->with('success','Category deleted successfully');
    }


    public function changeFaqCategoryStatus($id,$status){
        $change=FaqCategory::where('id',$id)->first();
        if($change){
            $change->status=$status;
            $change->save();
            return redirect()->back()->with('success','Category status changes');
        }

    }
}
