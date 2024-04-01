<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\{UserRequest, UserSubscription, Subscription};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=User::role('user')->orderBy('id','DESC')->get();
        $pages='user';
        $subPages='user';
        return view('admin.users.index',compact('data','pages','subPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pages='user';
        $subPages='user';
        $user=User::find($id);
        $userSharedCoupon=UserRequest::where('user_id',$user->id)->where('claim_type','shared')->count();
        $userClaimedCoupon=UserRequest::where('user_id',$user->id)->where('claim_type','claimed')->count();
        $userTotalSaving=UserRequest::where('user_id',$user->id)->where('claim_type','claimed')->where('status','vendor_redeem')->pluck('total_discount')->toArray();
        $userTotalSaving=array_sum($userTotalSaving);
        $plan=Subscription::where('type',0)->where('status',1)->where('amount',0)->get();
        // UserSubscription::with('')->where('user_id',$this->id)->get();
        $subscription_list = UserSubscription::with('plan')->where(['user_id'=>$user->id, 'status'=> 1])->get();
        // dd($subscription_list);
        return view('admin.users.show',compact('user','pages','subPages','userSharedCoupon','userClaimedCoupon','userTotalSaving','plan', 'subscription_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        $pages='user';
        $subPages='user';
        return view('admin.users.edit',compact('user','pages','subPages'));
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
        $user=User::find($id);
        if($user){
            $user->name=$request->name;
            // $user->email=$request->email;
            $user->address_one=$request->address_one;
            $user->address_two=$request->address_two;
            if($request->hasFile('image')){
                $upload =uploadImage($request->image);
                $user->profile_image=$upload['orig_path_url'];
            }
            if($user->save()){
                return redirect()->route('user.index')->with('success','Record updated Successfully');
            }
        }
    }

    public function updateProfile(Request $request)
    {
        $user=User::find($request->id);
        if($user){
            // $user->name=$request->name;
            $user->email=$request->email;
            $user->country_code=$request->country_code;
            $user->phone_number=$request->phone_number;
            if($user->save()){
                return redirect()->back()->with('success','Record updated Successfully');
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
    public function deletedUser(Request $request){
        $user=User::find($request->id);
        if($user){
            $user->email= $user->email."-del";
            $user->phone_number=$user->phone_number."-del";
            if($user->save()){
                User::where('id',$request->id)->delete();
                return redirect()->back()->with('success','Record Deleted Successfully');
            }
        }
    }

    public function blockUser(Request $request, $id)
    {
            // dd($request->all(),$id);
        $user = User::where('id',$id)->first();
        if($user->status == 'inactive'){
            $user->status = 'active';
            $msg = "Unblock";
        }else{
            $user->status = 'inactive';
            $msg = "Block";
        }
        $user->save();
        if($user->save()){
        return redirect()->route('user.index')->with('success', "User ".$msg." Successfully'");
        }
    }
}
