<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\{Category, SubCategory, Tag, CategoryTag};

class TagsController extends Controller
{
    public function index(){
        $pages='category';
        $subPages='tag';
        $data=Tag::orderBy('id','DESC')->get();

        return view('admin.tags.index',compact('data','pages','subPages'));
    }
    public function create(){
        $pages='category';
        $subPages='tag';
        $categories=Category::orderBy('id','DESC')->get();
        return view('admin.tags.create',compact('pages','subPages','categories'));
    }
    public function store(Request $request){
        $rules=[
            'name_en'=>'required',
            'category_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }

        $tag =new Tag;
        $tag
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);

        if($tag->save()){
            $categoryTags = [];
            foreach ($request->category_id as $categoryId) {
                $categoryTags[] = [
                    'category_id' => $categoryId,
                    'tag_id' => $tag->id,
                ];
            }
        
            CategoryTag::insert($categoryTags);
            return redirect()->route('tag.index')->with('success','Tag created successfully');
        }
    }
    public function tagEdit(Request $request){

        $pages='category';
        $subPages='tag';

        $tag = Tag::find($request->id);
        $categoryIds = $tag->category->pluck('category_id')->toArray();
        $categories=Category::orderBy('id','DESC')->get();

        return view('admin.tags.edit',compact('tag','pages','subPages','categoryIds','categories'));
    }
    public function update(Request $request){
        $tag=Tag::find($request->id);
        $tag
        ->setTranslation('name', 'en', $request->name_en)
        ->setTranslation('name', 'ar', $request->name_ar);
        // $data->name = $request->name;
        CategoryTag::where('tag_id', $request->id)->delete();
        if($tag->save()){
            $categoryTags = [];
            foreach ($request->vendor_id as $categoryId) {
                $categoryTags[] = [
                    'category_id' => $categoryId,
                    'tag_id' => $tag->id,
                ];
            }
        
            CategoryTag::insert($categoryTags);
            return redirect()->route('tag.index')->with('success','Tag Updated successfully');
        }

    }
    public function destroy(Request $request){
        $delete=Tag::where('id',$request->id)->delete();
        CategoryTag::where('tag_id', $request->id)->delete();
        return redirect()->back()->with('success','Tag deleted successfully');
    }

    public function getCategoryTags(Request $request){
        $tagsId = CategoryTag::where('category_id',$request->id)->pluck('tag_id')->toArray();
        $tags = Tag::whereIn('id', $tagsId)->select('id', 'name')->get();
        // dd($tags);

        $html='';
        if(isset($tags) && ($tags->count()>0)){
            $html .='<label>Categories Tags</label>';
            $html .='<select class="form-control input-default" name="vendortag[]" id="vendortag" multiple>';
            foreach($tags as $key=>$value){
                $html .= '<option value="'.$value->id.'">'.$value->name.'</option>';
            }
            $html .='</select>';
        }
        return response()->json([
            'status'=>true,
            'data'=>$html
        ]);
    }

    public function getTagBaseSearch(Request $request){
        $keyword = $request->keyword;
        $tags = Tag::where('name', 'LIKE', '%' . $keyword . '%')->select('id', 'name')->get();
    }
}
