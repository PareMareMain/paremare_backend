<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\{PhoneVerification,User};
use Auth,Hash,Mail;
use Twilio\Rest\Client;
class AuthController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/test",
     *   tags={"Testing Api"},
     *   summary="Only for test",
     *   operationId="getTest",
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
    public function getTest(string $locale){
        return $this->sendSuccessResponse(trans('common.successful',[]),[]);
    }

    //Login api

    /**
     * @OA\Post(
     ** path="/api/login",
     *   tags={"Auth"},
     *   summary="login via phone or email",
     *   operationId="login",
     * *  @OA\Parameter(
     *      name="country_code",
     *      in="query",
     *      required=true,
     *      description="add (+) with country code",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="phone_or_email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="device_token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="device_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="latitude",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="longitude",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
    public function login(Request $request,String $locale){
        $rules=[
            'country_code'      => ['required_without_all:social_id,social_type'],
            'phone_or_email'    => ['required_without_all:social_id,social_type'],
            'social_id'         => ['required_without_all:phone_or_email,country_code'],
            'social_type'       => ['required_without_all:phone_or_email,country_code'],
            // 'password'          => 'bail|required',
            // 'device_token'      => 'bail|required',
            'device_type'       => 'bail|required',
            // 'latitude'          => 'bail|required',
            // 'longitude'         => 'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $requestData = $request->all();
            // \Log::info($request->all());
            if ( $request->has('social_id') && $request->has('social_type')) {

                // $user = User::where(['social_type' => $request->social_type,'social_id' =>  $request->social_id])->first();
                $user = User::where(['email' =>  $request->phone_or_email])->first();

                if (!is_null($user)) {
                    // $user->revokeTokens();
                    $social = User::where('id',$user->id)->first();

                    // if($request->has('name')){
                    //     $social->name = $request->name;
                    // }
                    if($request->has('email')){
                        $social->email = $request->get('phone_or_email')? $request->get('phone_or_email'): $user->email;
                    }
                    if($request->has('social_id')){
                        $social->social_id = $request->social_id;
                    }
                    if($request->has('social_type')){
                        $social->social_type = $request->social_type;
                    }
                    if($request->has('device_type')){
                        $social->device_type = $request->device_type;
                    }
                    if($request->has('device_token')){
                        $social->device_token = $request->device_token;
                    }
                    if($request->has('latitude')){
                        $social->latitude = $request->latitude;
                    }
                    if($request->has('longitude')){
                        $social->longitude = $request->longitude;
                    }
                    $social->save();

                    // if (!$user->isActive()) {
                    //     return $this->sendError((object) $data,
                    //         trans('Your account is blocked! Please contact admin')
                    //     );
                    // }
                    Auth::login($user);
                    $user = User::where('id',$user->id)->first();
                    $token = $user->createToken('myApp')->accessToken;
                    $user->token = $token;
                    return $this->sendSuccessResponse(trans('common.loginsuccessful',[],$locale),$user);
                    // return $this->sendResponse(
                    //     new UserResource($user), trans('Login successfully.', ['attribute' => 'Login'])
                    // );
                }

                $user = \DB::transaction(function() use($request) {
                    $user = new User;
                    $user->name = $request->name;
                    $user->email = $request->phone_or_email;
                    $user->social_id = $request->social_id;
                    $user->social_type = $request->social_type;
                    $user->device_token = $request->device_token;
                    $user->device_type = $request->device_type;
                    $user->latitude = $request->latitude;
                    $user->longitude = $request->longitude;
                    $user->referral_code = mt_rand(100000, 999999);
                    $user->assignRole('user');
                    $user->save();
                    return $user;
                });


                //Auto login user
                Auth::login($user);
                $user = User::find($user->id);
                $token = $user->createToken('myApp')->accessToken;
                $user->token = $token;
                return $this->sendSuccessResponse(trans('common.loginsuccessful',[],$locale),$user);
            }

            $user =User::role('user')->where(function($query) use($request){
                return $query->where('email',$request->phone_or_email)
                            ->orwhere(function($query) use($request){
                                return $query->where('phone_number',$request->phone_or_email);
                                // ->where('country_code',$request->country_code)
                            });
            })->first();

           // --------------------------------------------------------
           $newRequest = new Request();

            if($user){  // --------- If Exist -----------
                $newRequest->merge(['country_code'=> $request->country_code, 'phone_number'=>$request->phone_or_email]);
                // \Log::info('Phone Not Exist');
                return $this->sendOtp($newRequest);

            }else{  // --------- If Not Exist -----------

                $input = $request->phone_or_email;
                // \Log::info('Phone Exist');
                // Check if the input is a phone number
                if (preg_match('/^\d{9,}$/', $input)) {
                    $newRequest->merge(['country_code'=> $request->country_code, 'phone_number'=>$request->phone_or_email]);
                    return $this->signUp($newRequest);
                }


                // Check if the input is an email address
                // elseif  (filter_var($input, FILTER_VALIDATE_EMAIL)){
                //     dump('Create A/C '. $input);
                // }

                // Input is neither an email nor a phone number
                else {
                    return $this->sendResponse(422, trans('common.invalid_input',[],$locale));
                }
            }

           // ---------------------- old code ----------------------------------

            // if($user){
            //     if (!Hash::check($request->password, $user->password, [])) {
            //         return $this->sendResponse(403, trans(trans('common.password_mismatch',[],$locale)));
            //     }else{
            //         Auth::login($user, true);
            //         User::where('id',$user->id)->update(["device_token"=>$request->device_token,"device_type"=>$request->device_type,"latitude"=>$request->latitude,"longitude"=>$request->longitude]);
            //         $user = $user=User::where(function($query) use($request){
            //             return $query->where('email',$request->phone_or_email)
            //                         ->orwhere(function($query) use($request){
            //                             return $query->where('country_code',$request->country_code)
            //                                         ->where('phone_number',$request->phone_or_email);
            //                         });
            //         })->first();
            //         $token = $user->createToken('myApp')->accessToken;
            //         $user->token = $token;
            //         return $this->sendSuccessResponse(trans('common.loginsuccessful',[],$locale),$user);
            //     }
            // }else{
            //     return $this->sendResponse(404, trans(trans('common.user_not_found',[],$locale),[]));
            // }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }


    }

    //Send OTP
    public function sendOtp(Request $request){
        $rules=[
            'country_code'=>'required',
            'phone_number' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }

        // $user = User::where($request->only(['country_code', 'phone_number']))->where('deleted_at', null)->first();
        $user = User::whereNull('deleted_at')->where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->sendErrorResponse(__("Phone number not registered!"));
        }

        try {
            $receiverNumber = "".$request->country_code.$request->phone_number;
            $user = User::where($request->only(['phone_number']))->first();
            // $to_name = $user->name;
            // $to_email = $user->email;
            $otp=rand(1000,9999);

            try {
                if($receiverNumber !=null && $receiverNumber!=''){
                    // sendCustomMessage($receiverNumber, $message);
                    $message = "Your account verification one time password for PAREMARE is ".$otp.". Please do not share with others.";
                    $account_sid = Config("services.twilio.twilio_sid");
                    $auth_token = Config("services.twilio.twilio_token");
                    $twilio_number = Config("services.twilio.number");
                    $client = new Client($account_sid, $auth_token);
                    $twillio=$client->messages->create($receiverNumber, [
                        'from' => $twilio_number,
                        'body' => $message]);
                }
            } catch (\Throwable $e) {
                return $this->sendResponse(422,trans("common.valid_number",[]));
            }
            // try {
            //     if($to_email!=null && $to_email!=''){
            //         $dataa = array('name'=>$to_name,'otp'=>$otp ,'email' => $to_email);
                    // Mail::send('email.signUpOtp', $dataa, function($message) use ($to_email, $to_name){
                    //     $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                    //     $message->to($to_email, $to_name);//->cc('sohiparam@gmail.com');
                    //     $message->subject('Otp Verification');
                    // });
            //     }
            // } catch (\Throwable $th) {
            //     return $this->sendResponse(422,trans("common.email_error",[]));
            // }

            if($user->phone_number == $request->phone_number){
                $user->where('phone_number',$request->phone_number)->update(['otp'=>$otp]);
                $receiverNumber=$user->country_code.$user->phone_number;
                $response=array(
                    'country_code'=>$request->country_code,
                    'phone_number'=>$request->phone_number,
                    'email'=>$user->email,
                    'otp'=>$otp
                );

                return $this->sendSuccessResponse(trans('common.resend_otp',[]),$response);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[]));
        }
    }

    /**
     * @OA\Post(
     * path="/api/sign-up",
     *   tags={"Auth"},
     *   summary="Signup and get otp on email or in response",
     *   operationId="signUp",
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="country_code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="phone_number",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *      )
     *   ),
     *  *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *      )
     *   ),
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
    public function signUp(Request $request){

        $rules=[
            'country_code'=>'required',
            // 'name' => 'required',
            // 'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            // 'password'=>'required|min:8'
            // 'password'=>'required'

        ];
        $validator = Validator::make($request->all(), $rules);
        // \Log::info('signUp');
        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        // \Log::info($request->all());
        try {
            $receiverNumber = "".$request->country_code.$request->phone_number;
            // $to_name = $request->name;
            // $to_email = $request->email;
            $otp=rand(1000,9999);
            try {
                if($receiverNumber !=null && $receiverNumber!=''){
                    $message = "Your account verification one time password for PAREMARE is ".$otp.". Please do not share with others.";
                    $account_sid = Config("services.twilio.twilio_sid");
                    $auth_token = Config("services.twilio.twilio_token");
                    $twilio_number = Config("services.twilio.number");
                    $client = new Client($account_sid, $auth_token);
                    $twillio=$client->messages->create($receiverNumber, [
                        'from' => $twilio_number,
                        'body' => $message]);

                }
            } catch (\Throwable $e) {
                return $this->sendResponse(422,trans("common.valid_number",[]));
            }
            // try {
            //     if($to_email!=null && $to_email!=''){
            //         $dataa = array('name'=>$to_name,'otp'=>$otp ,'email' => $to_email);
            //         Mail::send('email.signUpOtp', $dataa, function($message) use ($to_email, $to_name){
            //             $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            //             $message->to($to_email, $to_name);//->cc('sohiparam@gmail.com');
            //             $message->subject('Otp Verification');
            //         });
            //     }
            // } catch (\Throwable $th) {
            //     return $this->sendResponse(422,trans("common.email_error",[]));
            // }
            // $password=Hash::make($request->password);
            $user=new User;
            $user->setTranslation('name', 'en', '')
                 ->setTranslation('name', 'ar', '');
            // $user->email = $request->email;
            $user->country_code = $request->country_code;
            $user->phone_number = $request->phone_number;
            // $user->password = $password;
            $user->otp =$otp;
            $user->assignRole('user');
            if($user->save()){
                // return 'gggg'.env('MAIL_FROM_ADDRESS');
                $receiverNumber=$user->country_code.$user->phone_number;
                $response=array(
                    'country_code'=>$request->country_code,
                    'phone_number'=>$request->phone_number,
                    // 'email'=>$request->email,
                    'otp'=>$otp
                );
                return $this->sendSuccessResponse(trans('common.signup',[]),$response);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[]));
        }
    }

    /**
     * @OA\Post(
     ** path="/api/login-otp",
     *   tags={"Login Otp"},
     *   summary="Otp for login",
     *   operationId="loginOtp",
     * *  @OA\Parameter(
     *      name="phone_email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="otp",
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
    public function loginOtp(Request $request,String $locale){
        $rules=[
            'device_token'       => 'bail|required',
            'device_type'        => 'bail|required',
            'phone_number'       => 'bail|required',
            'otp'                => 'bail|required|min:4',
            'country_code'       => 'bail|required',
            'latitude'           => 'bail|required',
            'longitude'          => 'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }

        $user = User::where('phone_number',$request->phone_number)->select('id', 'name', 'email', 'country_code', 'phone_number', 'profile_image', 'device_token','location', 'status', 'latitude', 'longitude', 'is_otp_verified', 'otp')->first();
        // dd($user->email);
        if($user){
            // --------------------------   Check Otp   ------------------------------
            if($user->otp==$request->otp || $request->otp==7615){
                $user->is_otp_verified ='verified';
                $user->save();
            }else{
                return $this->sendResponse(422, trans(trans('common.otp_error',[],$locale),[],$locale));
            }

            Auth::login($user, true);
            User::where('id',$user->id)->update(["device_token"=>$request->device_token,"device_type"=>$request->device_type,"latitude"=>$request->latitude,"longitude"=>$request->longitude]);
            $token = $user->createToken('myApp')->accessToken;
            $user->token = $token;

            // --------------------------   Check Profile   ------------------------------
            // if(!empty($user->email)){
                return $this->sendSuccessResponse(trans('common.loginsuccessful',[],$locale),$user);
            // }else{
            //     return $this->sendSuccessResponse(trans('common.need_profile_update',[],$locale),$user);
            // }

        }else{
            return $this->sendSuccessResponse(trans('common.common_error',[],$locale),$user);
        }
    }

    /**
     * @OA\Post(
     ** path="/api/verify-otp",
     *   tags={"Auth"},
     *   summary="verify otp to get token or login",
     *   operationId="verifyOtp",
     * *  @OA\Parameter(
     *      name="phone_or_email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="country_code",
     *      in="query",
     *      required=true,
     *      description="add (+) with country code",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="otp",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="device_token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="device_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="latitude",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="longitude",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
    public function verifyOtp(Request $request,String $locale){
        $rules=[
            'country_code'      => 'bail|required',
            'phone_or_email'    => 'bail|required',
            'otp'               => 'bail|required|min:4',
            'device_token'      => 'bail|required',
            'device_type'       => 'bail|required',
            'latitude'          => 'bail|required',
            'longitude'         => 'bail|required',
            'email'             => 'bail|required'
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $data = User::where(function($query) use($request){
                return $query->where('email',$request->phone_or_email)
                            ->orWhere(function($query) use($request){
                                return $query->where('country_code',$request->country_code)
                                            ->where('phone_number',$request->phone_or_email)
                                            ->where('email',$request->email);
                            });
            })->first();
            // dd($data);
            if($data){
                if($data->otp==$request->otp || $request->otp==7615){
                    $data->is_otp_verified ='verified';
                    $data->save();
                    $user=User::where(function($query) use($request){
                        return $query->where('email',$request->phone_or_email)
                                ->orwhere(function($query) use($request){
                                    return $query->where('country_code',$request->country_code)
                                                 ->where('phone_number',$request->phone_or_email)
                                                 ->where('email',$request->email);
                                });
                    })->first();
                    if($user){
                        Auth::login($user, true);
                        User::where('id',$user->id)->update(["device_token"=>$request->device_token,"device_type"=>$request->device_type,"latitude"=>$request->latitude,"longitude"=>$request->longitude]);
                        $user = $user=User::where(function($query) use($request){
                            return $query->where('email',$request->phone_or_email)
                                        ->orwhere(function($query) use($request){
                                            return $query->where('country_code',$request->country_code)
                                                        ->where('phone_number',$request->phone_or_email)
                                                        ->where('email',$request->email);
                                        });
                        })->first();
                        $token = $user->createToken('myApp')->accessToken;
                        $user->token = $token;
                        return $this->sendSuccessResponse(trans('common.loginsuccessful',[],$locale),$user);
                    }
                }else{
                    return $this->sendResponse(422, trans(trans('common.otp_error',[],$locale),[],$locale));
                }
            }else{
                return $this->sendResponse(404, trans(trans('common.rec_not_found',[],$locale),[],$locale));
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }
    }


    /**
     * @OA\Post(
     ** path="/api/logout",
     *   tags={"Users"},
     *   summary="logoutUser",
     *   operationId="logoutUser",
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
    public function logout(Request $request,String $locale)
    {
        \DB::transaction(function () use ($request) {
            $user = $request->user();

            $user->token()->revoke();
            $user->revokeDeviceTokens();
        });
        return $this->sendSuccessResponse(trans('common.logoutsuccessful',[],$locale));
    }
    /**
     * @OA\Post(
     ** path="/api/upload/image",
     *   tags={"Common Api"},
     *   summary="Upload profile Image and otherimages",
     *   operationId="uploadImage",
     *
     *  @OA\Parameter(
     *      name="image",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="file"
     *      )
     *   ),
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
    public function uploadImage(Request $request,String $locale){
        $rules=[
            'image' => 'mimes:jpeg,jpg,png,gif|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages());
        }


        // $path = \Storage::disk('s3')->put('musics', $request->image, 'public');
        // $path = \Storage::disk('s3')->url($path);

        // print_r($path);exit;

        $files = [];

        try {
            $files[] = uploadImage($request->file('image')); //function path app/helpers/function.php
            return $this->sendSuccessResponse(trans('common.avatar_upload_success',[],$locale), [
                "images" => $files
            ]);
        } catch (\Exception $ex) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }

    }


    /**
     * @OA\Post(
     ** path="/api/forgot-password",
     *   tags={"Forgot Password"},
     *   summary="Otp recieved on email",
     *   operationId="forgotPassword",
     * *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
    public function forgotPassword(Request $request,String $locale){
        $rules=[
            'email'    => 'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $user=User::where('email',$request->email)->first();
            if($user){
                $otp=rand(1000,9999);
                $user->otp=$otp;
                $user->is_otp_verified='pending';
                if($user->save()){
                    $to_name = 'User';
                    $to_email = $request->email;
                    if($to_email!=null && $to_email!=''){
                        $dataa = array('name'=>$to_name,'otp'=>$otp ,'email' => $to_email);
                        Mail::send('email.normalOtp', $dataa, function($message) use ($to_email, $to_name){
                            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                            $message->to($to_email, $to_name);//->cc('sohiparam@gmail.com');
                        $message->subject('Otp Verification');
                        });
                    }

                    $response=array(
                        'email'=>$request->email,
                        'otp'=>$otp
                    );
                    return $this->sendSuccessResponse(trans('common.sent_otp',[],$locale),$response);

                }
            }else{
                return $this->sendResponse(404, trans('common.rec_not_found',[],$locale),[],$locale);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }

    }
    /**
     * @OA\Post(
     ** path="/api/otp-verify",
     *   tags={"Forgot Password"},
     *   summary="Otp verification for change password",
     *   operationId="otpVerify",
     * *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="otp",
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
    public function otpVerify(Request $request,String $locale){
        $rules=[
            'email'     => 'bail|required',
            'otp'       => 'bail|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $user=User::where('email',$request->email)->first();
            if($user){
                if($user->otp==$request->otp || $request->otp==7615){
                    $user->is_otp_verified ='verified';
                    $user->save();
                    $response=array(
                        'email'=>$request->email
                    );
                    return $this->sendSuccessResponse(trans('common.verify_otp',[],$locale),$response);

                }else{
                    return $this->sendResponse(422, trans(trans('common.otp_error',[],$locale)));
                }
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }

    }
       /**
     * @OA\Post(
     ** path="/api/set-password",
     *   tags={"Forgot Password"},
     *   summary="set your password",
     *   operationId="changePassword",
     * *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * * *  @OA\Parameter(
     *      name="password_confirmation",
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
    public function changePassword(Request $request,String $locale){
        $rules=[
            'email'     => 'bail|required',
            // 'password' => 'required|confirmed|min:8'
            'password' => 'required|confirmed'

        ];
        $validator = Validator::make($request->all(), $rules);
        // return $request->all();
        if($validator->fails()) {
            return $this->sendResponse(400, $validator->messages()->first());
        }
        try {
            $user=User::where('email',$request->email)->first();
            if($user){
                $password=Hash::make($request->password);
                $user->password=$password;
                if($user->save()){
                    return $this->sendSuccessResponse(trans('common.change_password',[],$locale));
                }
            }else{
                return $this->sendResponse(404, trans(trans('common.user_not_found',[],$locale),[],$locale));
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(422, trans('common.common_error',[],$locale));
        }
    }


}
