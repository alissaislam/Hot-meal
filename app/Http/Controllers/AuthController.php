<?php

namespace App\Http\Controllers;

use Ichtrojan\Otp\Otp;
use function Psy\debug;
use App\Models\Customer;


use App\Models\Deliverer;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
   public function register(Request $request){

       $generatedCode = rand(100000, 999999);


       $request['otp']=$generatedCode;
       $request['active']=false;


       if($request->role === 'customer'){
       Customer::validateCustomer($request);
        $user = Customer::create($request->except('role'));
       }
       else if($request->role==='deliverer'){
        Deliverer::validateDeliverer($request);
        $user = Deliverer::create($request->except('role'));
       }
       else if($request->role==='restaurant'){
        Restaurant::validateRestaurant($request);
        $user = Restaurant::create($request->except('role'));
       }

        MailController::sendMail($request['email'],$generatedCode);
        $encodedId = encrypt($user->id);

        $response=[
            'msg'=>'check your email and enter your code',
            'userId'=>$encodedId
        ];

       return response()->json($response);
   }


   public function verification(Request $request){

    $decodedId = decrypt($request->userId);

        if ($decodedId === null) {
           return response()->json('wrong id');
        } else {

            if($request->role==='customer')
            $user = Customer::find($decodedId);

            if($request->role==='deliverer')
            $user = Deliverer::find($decodedId);

            if($request->role==='restaurant')
            $user = Restaurant::find($decodedId);

            if($user->otp === $request->otp){
                $token = JWTAuth::fromUser($user);
                $response=[
                    'msg'=>'welcome',
                    'token'=>$token
                ];
                return response()->json($response);
            }
            else{
                return response()->json('wrong otp');
            }
        }
   }

   public function signin(Request $request){
    if($request->role === 'customer')
    $user = Customer::where('email', $request->email)->first();

    if($request->role==='deliverer')
    $user = Deliverer::where('email', $request->email)->first();

    if($request->role==='restaurant')
    $user = Restaurant::where('email', $request->email)->first();

    if(!$user)
    return response()->json(['msg'=>'email not found',400]);
    return JWTAuth::fromUser($user);
   }


}
