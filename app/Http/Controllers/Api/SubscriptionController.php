<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User, Plan, Transaction, UserSubscription, PromoCode, PromoUser};
use Exception;
use Illuminate\Http\Request;
use Auth;
use App\Http\Traits\NotificationTraits;

class SubscriptionController extends Controller
{
    use NotificationTraits;    

	public $secret_key,$publish_key;
    protected $promoData;
	
	public function __construct() {
		$this->secret_key = config('services.stripe.secret_key');
		$this->publish_key = config('services.stripe.publish_key');
	}
	/**
	 * @OA\Get(
	 ** path="/api/subscriptions",
	 *   tags={"Subscriptions"},
	 *   summary="get Subscriptions",
	 *   operationId="subscriptions",
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
	public function index()
	{
		try {
			$subscriptions = plan::all();
			return $this->sendSuccessResponse("Success", $subscriptions);
		} catch (Exception $ex) {
			return $this->sendResponse(422, $ex->getMessage());
		}
	}

    // For Stripe - To get Payment 

    public function subscriptionsPurchase(Request $request){

        $plan      = Plan::where('id',$request->id)->first();
        $user      = User::where('id',\Auth::id())->first();
        // start stripe creating a customer
        $stripe = new \Stripe\StripeClient(
            $this->secret_key
          );

        $this->creatCustomer($request);

        //create a card token
        if($request->cardCheck != 1){
        $token = $stripe->tokens->create([
                'card'      => [
                'number'    => $request->number,
                'exp_month' => $request->month, // month
                'exp_year'  => $request->year,  // year
                'cvc'       => $request->cvv,
                'name'      => $user->name,
                // 'currency'  => 'AED',
                ],
            ]);
        }

        // create a card added to stripe
            if($request->cardCheck == 1){
                $card =  $stripe->customers->retrieveSource(
                    $user->stripe_id,
                    $request->card_id,
                    []
                  );
            }else{
                $card = $stripe->customers->createSource(
                    $user->stripe_id,
                    ['source' => $token->id]
                );
            }
        // }

        if($card){
        $charge = $stripe->charges->create([
                'amount'        => $plan->price * 100,
                'currency'      => 'AED',
                'source'        => $card->id,
                'description'   => 'Stripe Payment Charge',
                'customer'      => $user->stripe_id,
            ]);
        }

        if($charge->status = 'succeeded'){

            $tran= new Transaction;
            $tran->user_id = $user->id;
            $tran->status = 'success';
            $tran->txn_no = $charge->id ?? null;
            $tran->amount = $plan->price;
            $tran->value_id = $plan->id;
            $tran->save();

            $add=new UserSubscription;
            $add->user_id = Auth::user()->id;
            $add->transaction_id = $tran->id;
            $add->subscription_id=$tran->value_id;
            $add->amount = $plan->price;
            $add->start_date= \Carbon\Carbon::now()->format('Y-m-d');
            $add->end_date= \Carbon\Carbon::now()->addDay(2)->format('Y-m-d');
            $add->save();
            // if($add->save()){

            //     return redirect()->route('vendor-banner.index')->with('success',__('Payment Successfully done.Be continue with adding banners'));
            // }
            return $this->sendSuccessResponse("Success", $charge);
        }
        return redirect()->route('subscriptions.index')->with('error', 'Payment Cancelled!');
    }


    /**
     * @OA\Post(
     *      path="/api/v1/creat/customer",
     *      operationId="creat.customer",
     *      tags={"Card"},
     *      summary="Creat a stripe customer",
     *      description="Creat a stripe customer",
     *      @OA\Parameter(ref="#/components/parameters/X-localization"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ApiModel")
     *       ),
     *      security={
     *         {"Bearer": {}}
     *     }
     *     )
     */
    public function creatCustomer(Request $request) {
        $stripe = new \Stripe\StripeClient($this->secret_key);
        $user = User::find(Auth::user()->id);

        if(Auth::user()->stripe_id == NULL){
            $cusId = $stripe->customers->create([
            'description'   => 'Creating a Stripe Payment',
            'email'         => $user->email,
            'name'          => $user->name,
            'phone'         => $user->phone_number,
            ]);
            $user->stripe_id = $cusId->id;
            $user->save();
            return $this->sendSuccessResponse(__("success"));
        }
        return $this->sendSuccessResponse(__("already created"));
    }

	public function createSubscription(Request $request){

        $this->creatCustomer($request);
            $user = User::find(Auth::user()->id);
            $customer_id = $user->stripe_id;
            $price_id = $request->price_id;
            $product_id = $request->product_id;

        try{
            // connect with stripe account.
            $stripe = new \Stripe\StripeClient(
                $this->secret_key
              );

			//   dd($stripe);
            // create subscription with unit amount
            $subscription_detail = $stripe->subscriptions->create([
                    'customer' => $customer_id,
                    'items' => [
                        ['price' => $price_id,"quantity"=>2]
                    ],
                ]);
            return $subscription_detail;
        }catch(\Exception $e){
            return $e;
        }
    }

    public function createProduct(Request $request){
        try{
            // connect with stripe account.
            $stripe = new \Stripe\StripeClient(
                $this->secret_key
              );

            // Create a product over stripe
            $product_detail = $stripe->products->create([
                'name' => $request->product_name,
            ]);

            // create prices for the product
            $product_id = $product_detail->id;
            $monthly_price = $stripe->prices->create([
                'unit_amount' => $request->monthly_price*100,
                'currency' => 'aed',
                'recurring' => ['interval' => 'month'], // it defines the recurring interval
                'product' => $product_id,
            ]);

            $yearly_price = $stripe->prices->create([
                'unit_amount' => $request->yearly_price*100,
                'currency' => 'aed',
                'recurring' => ['interval' => 'year'],
                'product' => $product_id,
            ]);
            return [$product_detail,$monthly_price,$yearly_price];
        }catch(\Exception $e){
            return false;
        }
    }

    // ------------------------------------------------------------------------------------------------------------------

    public function saveSubscriptionRecord(Request $request, $paymentIntent = ''){
        $uid =  isset($request->description['uid'])? $request->description['uid']:Auth::user()->id;
        $dateDiff = 0;
        $subscribedPlans = UserSubscription::where('user_id', $uid)->where('end_date', '>', \Carbon\Carbon::now()->format('Y-m-d'))->where('status', 1)->orderBy('id', 'desc')->first();

        if(isset($subscribedPlans)){
                if ($request->description['plan_type'] == 1){
                    $startDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->format('Y-m-d');
                    $endDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(2)->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 2){
                    $startDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->format('Y-m-d');
                    $endDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->addMonth()->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 3){
                    $startDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->format('Y-m-d');
                    $endDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->addMonth(12)->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 4){
                    $startDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->format('Y-m-d');
                    $endDate = \Carbon\Carbon::parse($subscribedPlans->end_date)->addDay(1)->addMonth(6)->format('Y-m-d');
                }
        }else{
                if ($request->description['plan_type'] == 1){
                    $startDate = \Carbon\Carbon::now()->format('Y-m-d');
                    $endDate = \Carbon\Carbon::now()->addDay(1)->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 2){
                    $startDate = \Carbon\Carbon::now()->format('Y-m-d');
                    $endDate = \Carbon\Carbon::now()->addMonth()->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 3){
                    $startDate = \Carbon\Carbon::now()->format('Y-m-d');
                    $endDate = \Carbon\Carbon::now()->addMonths(12)->format('Y-m-d');
                }
                if ($request->description['plan_type'] == 4){
                    $startDate = \Carbon\Carbon::now()->format('Y-m-d');
                    $endDate = \Carbon\Carbon::now()->addMonths(6)->format('Y-m-d');
                }
        }

        $user               =   User::find($uid);
        $tran               =   new Transaction;
        $tran->user_id      =   $user->id;
        $tran->amount       =   $request->amount;
        $tran->txn_no       =   empty($paymentIntent) ? 'Free Plan': $paymentIntent->client_secret;
        $tran->status       =   'success';
        $tran->invoice_id   =   'Free Plan';
        $tran->value_id     =   $request->description['id'];
        $tran->save();

        $add                    =   new UserSubscription;
        $add->user_id           =   $uid;
        $add->transaction_id    =   $tran->id;
        $add->start_date        =   $startDate;
        $add->end_date          =   $endDate;
        $add->amount            =   $request->amount;
        $add->subscription_id   =   $request->description['id'];
        $add->status            =   empty($paymentIntent) ? 1 : 0;
        $add->save();


        if( isset($request->description['promo'])){
            $promoUser              =   new PromoUser;
            $promoUser->user_id     =   $uid;
            $promoUser->promo_id    =   $this->promoData->id;
            $promoUser->transaction_id     =  $tran->id; 
            $promoUser->price       =   $request->actualPrice;
            $promoUser->discount    =   $this->promoData->discount;
            $promoUser->status      =   0;
            $promoUser->save(); 
        }

    }

    public function stripeEndpoint(Request $request) {
        try {

            if($request->amount == 0){
                $userid =  isset($request->description['uid'])? $request->description['uid']:Auth::user()->id;
                $this->saveSubscriptionRecord($request);
                $data = ['paymentIntent' => 'Free Plan'];
                $this->sendNotification( $userid);
                return response()->json(['status'=>true, 'message'=> 'Subscription success', 'data' => $data,'statusCode'=> 200], 200);
            }

            if( isset($request->description['promo'])){
                $promo = PromoCode::where([
                            ['promo_code', '=', $request->description['promo']],
                            ['status', '=', 'active'],
                        ])->first();
                if(empty($promo)){
                    return $this->sendResponse(422, trans('common.invalid_promo',[$request->description['promo']]));  
                }

                $this->promoData = $promo;

                if ($promo && $promo->offer_type === 'fixed') {
                    $request->actualPrice = $request->amount;
                    $request->amount -= $promo->discount;
                } elseif ($promo && $promo->offer_type === 'percentage') {
                    $request->actualPrice = $request->amount;
                    $request->amount *= (1 - ($promo->discount / 100));
                }
            }

            $stripe = new \Stripe\StripeClient($this->secret_key);
            
            $customer = $stripe->customers->create();
            
            $ephemeralKey = $stripe->ephemeralKeys->create([
            'customer' => Auth::user()->stripe_id ?? $customer->id,
            ], [
            'stripe_version' => '2022-08-01',
            ]);
            
            $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $request->amount * 100,
            'currency' => 'aed',
            'customer' => Auth::user()->stripe_id ?? $customer->id,
            'setup_future_usage' => 'off_session',
            'automatic_payment_methods' => [
            'enabled' => 'true',
            ],
            ]);

            $data = [
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => Auth::user()->stripe_id ?? $customer->id,
            'publishableKey' => $this->publish_key,
            'secretKey' => $this->secret_key
            ];
            
            User::whereId(Auth::id())->update([
            'stripe_id' => Auth::user()->stripe_id ?? $customer->id
            ]);
            

            // ----------------------------------------------------------

            $this->saveSubscriptionRecord($request, $paymentIntent);

            // ----------------------------------------------------------

            return response()->json(['status'=>true, 'message'=> 'success', 'data' => $data,'statusCode'=> 200], 200);
        } catch (\Throwable $th) {
            return $this->sendResponse(422, $th->getMessage());
        }
    }
        
    public function stripeIntentSucceededResponse(Request $request) {

        // \Log::info('intSucc');

    }

    public function stripeIntentFailedResponse(Request $request) {
        // \Log::info('intFail');
        // \Log::info($request->all());
    }
    public function stripeChargeSucceededResponse(Request $request) {
        // \Log::info('charSucc');
        // \Log::info($request);
        $tran = Transaction::where('txn_no', 'LIKE', $request->data['object']['payment_intent'].'%');
        $tran->update([
                'invoice_id'=>  $request->data['object']['receipt_url']
            ]);
        $id = $tran->pluck('id');

        $add = UserSubscription::where('transaction_id', $id[0])->update([
            'status'=> 1
        ]);
        PromoUser::where('transaction_id', $id[0])->update([
            'status'=> 1
        ]);

    }
    public function stripechargeFailedResponse(Request $request) {
        \Log::info('stripe charge Fail');
        \Log::info($request->all());
    }
}
