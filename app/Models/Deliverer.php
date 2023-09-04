<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Deliverer extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;

    // protected $hidden = [
    //     'otp',
    //     'active'
    // ];

    // protected $guard = 'deliverer';
    protected $guarded = [];
    protected $table = 'deliveries';
    public $timestamps = false;
    use HasFactory;

    public static function validateDeliverer(Request $request){
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

  /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return ['role' => 'deliverer'];
    }

    public function orders()
{
    return $this->hasMany(Order::class,'deliverie_id');
}
}
