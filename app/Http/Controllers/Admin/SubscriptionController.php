<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Subscription, UserSubscription};
use Exception;

class SubscriptionController extends Controller
{
	public function index(Request $request)
	{
		$pages = 'subscription';
		$subPages = 'plan';
		$data = Subscription::where('type',0)->get();
		$vendordata = Subscription::where('type',1)->get();
		return view('admin.subscription.plans.index', compact('pages', 'subPages', 'data','vendordata'));
	}

	public function detail(Request $request, $id)
	{
		try {
			$data = Subscription::find($request->id);
			return response()->json(['data' => $data]);
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}

	public function create(Request $request)
	{
		try {
			$subscription = Subscription::create(['name' => $request->name, 'amount' => $request->amount, 'plan_type' => $request->plan_type, 'status' => ($request->status ? $request->status : 0), 'description' => $request->description]);
			if ($subscription->save()) {
				return redirect()->back()->with('success', 'Record  added Successfully');
			}
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}
	public function edit(Request $request)
	{
		$data = Subscription::where('id', $request->id)->update(['name' => $request->name, 'amount' => $request->amount, 'plan_type' => $request->plan_type, 'status' => ($request->status ? $request->status : 0), 'description' => $request->description]);
		if ($data) {
			return redirect()->back()->with('success', 'Record Updated Successfully');
		}
	}
	public function paymentIndex()
	{
		$pages = 'subscription';
		$subPages = 'subscribed';
		$data = UserSubscription::get();
		return view('admin.subscription.payments.index', compact('pages', 'subPages', 'data'));
	}

	public function check(Request $request)
	{
		try {
			$data = Subscription::select('name', 'status')->where('status', 1)->where('id', '!=', $request->id)->where('type', $request->type)->first();
			return response()->json(['data' => $data]);
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}


	public function delete(Request $request, $id)
	{
		try {

			$data = Subscription::where('id', $request->id)->delete();
			return redirect()->back()->with('success', 'Record Deleted Successfully');
		} catch (Exception $ex) {
			return redirect()->back()->with('error', $ex->getMessage());
		}
	}

	public function changestatus(Request $request)
	{
		try {
			$data = Subscription::select('name', 'status')->where('status', 1)->where('id', '!=', $request->id)->where('type', $request->type)->first();
			// if (!$data) { // if only one plan want active 
				Subscription::where('id',$request->id)->update(['status' => $request->status]);
				$data = Subscription::find($request->id);
			// }
			return response()->json(['data' => $data]);
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}

	public function DelFreeUserPlan(Request $request)
	{
		// dd($request->id);
		try {
			$data = UserSubscription::where('id', $request->id)->delete();
			// $data = Subscription::where('id', $request->id)->delete();
			return redirect()->back()->with('success', 'Record Deleted Successfully');
		} catch (Exception $ex) {
			return redirect()->back()->with('error', $ex->getMessage());
		}
	}

	
}
