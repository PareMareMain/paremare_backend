<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PromoCode,UserRequest,User, PromoUser};
use Validator;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=PromoCode::get();
        $pages='promo';
        $subPages='list';
        // dd($data);
        return view('admin.promo.index',compact('data','pages','subPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages='promo';
        $subPages='create';
        // dd(7877);
        $users=User::role('vendor')->get();
        return view('admin.promo.create',compact('pages','subPages','users'));
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
        $rules=[
            'tag_title_en' => 'required',
            'promo_code' => 'required|unique:promo_codes,promo_code',
            'discount' => 'required',
            'offer_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }
        try {
            $promo=new PromoCode;
            $promo
            ->setTranslation('tag_title', 'en', $request->tag_title_en)
            ->setTranslation('tag_title', 'ar', $request->tag_title_ar);
            // $promo->tag_title          =$request->tag_title;

            $promo->offer_type          =$request->offer_type;
            $promo->discount            =$request->discount;
            $promo->promo_code          =$request->promo_code;
            
            $promo
            ->setTranslation('promo_description', 'en', $request->promo_description_en)
            ->setTranslation('promo_description', 'ar', $request->promo_description_ar);

            if($promo->save()){
                return redirect()->route('admin.promo.index')->with('success','Promo Created Successfully');
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
    public function edit(Request $request)
    {
        $pages='promo';
        $subPages='edit';
        $data=PromoCode::where('id',$request->id)->first();
        return view('admin.promo.edit',compact('data','pages','subPages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePromo(Request $request)
    {
        $rules=[
            'tag_title_en' => 'required',
            'discount' => 'required',
            'offer_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->messages()->first());
        }
        try{
            $promo=PromoCode::where('id',$request->id)->first();
            if($promo){
                $promo
                ->setTranslation('tag_title', 'en', $request->tag_title_en)
                ->setTranslation('tag_title', 'ar', $request->tag_title_ar);

                $promo->offer_type          =$request->offer_type;
                $promo->discount            =$request->discount;
                
                $promo
                ->setTranslation('promo_description', 'en', $request->promo_description_en)
                ->setTranslation('promo_description', 'ar', $request->promo_description_ar);
    
                if($promo->save()){
                    return redirect()->route('admin.promo.index')->with('success','Promo Update Successfully');
                }
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
    public function deletePromo(Request $request){
        PromoCode::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Coupon deleted sucessfully');
    }

    public function userPromo(Request $request){
        $pages='promo';
        $subPages='promo';
        $data=PromoUser::with(['user','promo'])->where('status',1)->get(); // where('status',1)->
        // dd($data);
        return view('admin.promo.user-promo',compact('data','pages','subPages'));
    }
    
}
