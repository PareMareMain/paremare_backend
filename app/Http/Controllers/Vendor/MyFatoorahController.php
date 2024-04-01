<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
// use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use Auth;
use Carbon;
class MyFatoorahController extends Controller
{
    // public $mfObj,$apiURL, $apiKey;

    /**
     * create MyFatoorah object
     */
    public function __construct() {
        // $this->mfObj = new PaymentMyfatoorahApiV2(env('MYFATOORAH_API_KEY'),env('MYFATOORAH_API_URL'),env('MYFATOORAH_COUNTRY_ISO'), env('MYFATOORAH_TEST_MODE'));
        // $this->apiURL = env('MYFATOORAH_API_URL');
		// $this->apiKey = env('MYFATOORAH_API_KEY');
    }

    /**
     * Create MyFatoorah invoice
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // try {
        //     $users = Auth::user();
        //     $plan=Subscription::where('type',0)->where('status',1)->first();
        //     if($users){
        //         $paymentMethodId = 0; // 0 for MyFatoorah invoice or 1 for Knet in test mode
        //         $data            = $this->mfObj->getInvoiceURL($this->getPayLoadData($users,$plan), $paymentMethodId);
        //         // dd($data);

        //         if($data){
        //             $tran = new Transaction;
        //             $tran->user_id = $users->id;
        //             $tran->invoice_id = $data['invoiceId'];
        //             $tran->value_id = $plan->id;
        //             $tran->save();
        //             return redirect($data['invoiceURL']);
        //         }

        //     }

        //     // return response()->json(['IsSuccess' => 'true', 'Message' => 'Invoice created successfully.', 'Data' => $data]);
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error',$e->getMessage());
        // }
    }

    /**
     *
     * @param int|string $orderId
     * @return array
     */
    private function getPayLoadData($users,$plan) {
        // dd($users);
        $callbackURL = route('vendor.callback');
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
            'ErrorUrl'           => $callbackURL,
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
     * Get MyFatoorah payment information
     *
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request) {
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
                        return redirect()->route('vendor-banner.index')->with('success',__('Payment Successfully done.Be continue with adding banners'));
                    }
                }
            } else if ($data->InvoiceStatus == 'Failed') {
                if($tran){
                    $tran->status = 'failed';
                    $tran->txn_no =$data->focusTransaction->TransactionId ?? null;
                    $tran->amount = $data->InvoiceDisplayValue;
                    $tran->save();

                    return redirect()->route('vendor-banner.index')->with('error',__('Payment failed'));
                }
            } else if ($data->InvoiceStatus == 'Expired') {
                if($tran){
                    $tran->status = 'failed';
                    $tran->txn_no =$data->focusTransaction->TransactionId ?? null;
                    $tran->amount = $data->InvoiceDisplayValue;
                    $tran->save();

                    return redirect()->route('vendor-banner.index')->with('error','Payment failed');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('vendor-banner.index')->with('error',__('Something went wrong.Try Again!'));
        }
    }
    public function getSubscriptionPlan(){
        $data=[];
        $pages='profile';
        return view('facilities.subscription.index',compact('data','pages'));
    }
    public function getPaymentError(Request $request){
        return response()->json([
            "status"=>422,
            "data"=>$request->all(),
        ]);
    }
    public function getPaymentSuccess(Request $request){
        return response()->json([
            "status"=>200,
            "data"=>$request->all()
        ]);
    }
}
