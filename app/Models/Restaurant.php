<?php

namespace App\Models;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable implements JWTSubject
{
    protected $guarded = [];
    public $timestamps = false;
    use HasApiTokens,HasFactory;

    public static function validateRestaurant(Request $request){
        $validator = Validator::make($request->all(), [
        'name'=>'string',
        'email'=>['required','email',Rule::unique('restaurants','email'),Rule::unique('deliveries','email'),Rule::unique('customers','email')],
        'phone'=>['required','min:10','max:10','string',Rule::unique('restaurants','phone'),Rule::unique('deliveries','phone'),Rule::unique('customers','phone')],
        'address'=>'required|string',
        'openTime'=>'date_format:H:i|required',
        'closeTime'=>'date_format:H:i|required',
        'location'=>'required|string',
        'image' =>'image|mimes:jpeg,png,jpg',
     ]);

     if ($validator->fails()) {
         throw new \Illuminate\Validation\ValidationException($validator);
     }
 }

    public static function validateEditRestaurant(Request $request){
        $validator = Validator::make($request->all(), [
        'name'=>'string',
        'email'=>['email',Rule::unique('restaurants','email'),Rule::unique('deliveries','email'),Rule::unique('customers','email')],
        'phone'=>['min:10','max:10','string',Rule::unique('restaurants','phone'),Rule::unique('deliveries','phone'),Rule::unique('customers','phone')],
        'address'=>'string',
        'openTime'=>'date_format:H:i',
        'closeTime'=>'date_format:H:i',
        'location'=>'string',
        'image' =>'image|mimes:jpeg,png,jpg',
     ]);

     if ($validator->fails()) {
         throw new \Illuminate\Validation\ValidationException($validator);
     }
 }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['role' => 'restaurant',];
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
