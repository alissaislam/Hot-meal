<?php

namespace App\Models;




use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable implements JWTSubject
{
    protected $guarded=[];

    public $timestamps = false;

    use HasFactory ,HasApiTokens;


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['role' => 'customer',];
    }

    public static function validateCustomer(Request $request){

           $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:45|string',
            'address'=>'required|min:2|max:255|string',
            'email'=>['required','min:5','max:255','email',Rule::unique('restaurants','email'),Rule::unique('deliveries','email'),Rule::unique('customers','email')],
            'phone'=>['required','min:10','max:45','string',Rule::unique('restaurants','phone'),Rule::unique('deliveries','phone'),Rule::unique('customers','phone')],
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}
}
