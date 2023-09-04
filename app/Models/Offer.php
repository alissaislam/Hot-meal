<?php

namespace App\Models;

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $guarded=[];

    public $timestamps = false;

    public static function validateOffer(Request $request){

        $validator = Validator::make($request->all(), [
        'description'=>'string|min:3|max:255|required',
        'cost'=>'integer|required|max:1000000',
        'meals'=>'array|min:1|required',
     ]);

     if ($validator->fails()) {
         throw new \Illuminate\Validation\ValidationException($validator);
     }
 }

    public static function validateOfferEdit(Request $request){

    $validator = Validator::make($request->all(), [
    'description'=>'string|min:3|max:255',
    'cost'=>'integer|max:1000000',
    'meals'=>'array|min:1'
    ]);

    if ($validator->fails()) {
        throw new \Illuminate\Validation\ValidationException($validator);
    }
    }

    public function meals()
{
    return $this->belongsToMany(Meal::class);
}

public function orders()
{
    return $this->belongsToMany(Order::class);
}
}
