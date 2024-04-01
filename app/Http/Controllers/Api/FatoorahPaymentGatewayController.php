<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\{UserSubscription,User};
use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use Auth;
use Carbon;
use PhpParser\Node\Expr\Cast\Object_;

class FatoorahPaymentGatewayController extends Controller
{
	//Web-View Payment gateway Integration

	public $mfObj,$apiURL, $apiKey;

	
	public function __construct() {
		$this->mfObj = new PaymentMyfatoorahApiV2(env('MYFATOORAH_API_KEY'),env('MYFATOORAH_API_URL'),env('MYFATOORAH_COUNTRY_ISO'), env('MYFATOORAH_TEST_MODE'));
		$this->apiURL = env('MYFATOORAH_API_URL');
		$this->apiKey = env('MYFATOORAH_API_KEY');
	}

	 /**
     * @OA\GET(
     ** path="/api/make-subscription-payment",
     *   tags={"Subscription"},
     *   summary="use as get to return payment url",
     *   operationId="index",
     *   security={ {"bearer": {} }},
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
	public function index(String $locale) {
		try {
			$users = Auth::user();
			$plan=Subscription::where('type',0)->where('status',1)->first();
			if($users){
				$paymentMethodId = 0; // 0 for MyFatoorah invoice or 1 for Knet in test mode
				$data            = $this->mfObj->getInvoiceURL($this->getPayLoadData($users,$plan), $paymentMethodId);
				// dd($data);

				if($data){
					$tran = new Transaction;
					$tran->user_id = $users->id ?? 1; 
					$tran->invoice_id = $data['invoiceId'];
					$tran->value_id = $plan->id;
					$tran->save();
					return $this->sendSuccessResponse(trans('common.payment_success',[],$locale),$data);
				}
			}
		} catch (\Exception $e) {
			return $this->sendResponse(422, $e->getMessage());
		}
	}

	/**
	 * 
	 * @param int|string $orderId
	 * @return array
	 */
	private function getPayLoadData($users,$plan) {
		// dd($users);
		$callbackFailedURL = url('').'/payment_failed';
		$callbackURL = url('').'/payment_success';
		// dd($callbackFailedURL,$callbackURL);
		$UserDefinedField=30;
		if($plan->plan_type==3){
			$UserDefinedField  = 365;
		}else if($plan->plan_type==2){
			$UserDefinedField  = 30;
		}else{
			$UserDefinedField  = 30;
		}
		// dd($invoiceItems);
		return [
			'CustomerName'       => $users->name ?? '',
			'InvoiceValue'       => $plan->amount ?? 0,
			'DisplayCurrencyIso' => 'SAR',
			'CustomerEmail'      => $users->email ?? '',
			'CallBackUrl'        => $callbackURL,
			'ErrorUrl'           => $callbackFailedURL,
			'MobileCountryCode'  => $users->country_code ?? '+966',
			'CustomerMobile'     => '784512547',
			'Language'           => 'en',
			'CustomerReference'  => $plan->plan_type ?? 1,
			'CustomerCivilId'    => $plan->id ?? 1,
			'UserDefinedField'   => $UserDefinedField,
			'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
		];
	}

	/**
     * @OA\Post(
     ** path="/api/save-subscription-payment",
     *   tags={"Subscription"},
     *   summary="get subscription information",
     *   operationId="callback",
	 * 	security={ {"bearer": {} }},
	 * *  @OA\Parameter(
     *      name="paymentId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
	public function callback(Request $request,String $locale) {
		try {
			
			$data = $this->mfObj->getPaymentStatus($request['paymentId'], 'PaymentId');
			// dd($data);
			$tran=Transaction::where('user_id',Auth::user()->id)->where('invoice_id',$data->InvoiceId)->first();
			if ($data->InvoiceStatus == 'Paid') {
				if($tran){
					$tran->status = 'success';
					$tran->txn_no =$data->focusTransaction->TransactionId ?? null;
					$tran->amount = $data->InvoiceDisplayValue;
					$tran->save();
					$add=new UserSubscription;
					$add->user_id=Auth::user()->id;
					$add->transaction_id=$tran->id;
					$add->subscription_id=$tran->value_id;
					$add->amount = $data->InvoiceDisplayValue;
					$add->start_date=\Carbon\Carbon::now()->format('Y-m-d');
					$add->end_date=\Carbon\Carbon::now()->addDay($data->UserDefinedField ?? 2)->format('Y-m-d');
					if($add->save()){
						$sub=array(
							"is_subscription_active"=>true
						);
						$sub['']=true;
						return $this->sendSuccessResponse(trans('common.payment_success',[],$locale),$sub);
					}
				}
			} else if ($data->InvoiceStatus == 'Failed') {
				if($tran){
					$tran->status = 'failed';
					$tran->txn_no =$data->focusTransaction->TransactionId ?? null;
					$tran->amount = $data->InvoiceDisplayValue;
					$tran->save();
					return $this->sendResponse(422, trans('common.payment_failed',[],$locale));
					// return $this->sendResponse(422, 'Payment Failed');
				}
			} else if ($data->InvoiceStatus == 'Expired') {
				if($tran){
					$tran->status = 'failed';
					$tran->txn_no =$data->focusTransaction->TransactionId ?? null;
					$tran->amount = $data->InvoiceDisplayValue;
					$tran->save();
					
					return $this->sendResponse(422, trans('common.payment_failed',[],$locale));
				}
			}   
		} catch (\Exception $e) {
			return $this->sendResponse(422, $e->getMessage());
		}
	}

	/**
     * @OA\GET(
     ** path="/api/get-payment-history",
     *   tags={"Subscription"},
     *   summary="use as get to return payment history",
     *   operationId="getPaymentHistory",
     *   security={ {"bearer": {} }},
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

	public function getPaymentHistory(String $locale){
		try {
			$transaction = Transaction::where('user_id',Auth::user()->id)->get();
			return $this->sendSuccessResponse(trans('common.payment_success',[],$locale),$transaction);
		} catch (\Throwable $th) {
			return $this->sendResponse(422, $th->getMessage());
		}
	}

}
