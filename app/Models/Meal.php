<?php

namespace App\Models;

use App\Models\Offer;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{


    protected $guarded = [];
    // protected $table = 'meals';
    public $timestamps = false;
    use HasFactory;
    public static function validateMeal(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'description'=>'required|string',
            'image' =>'image|mimes:jpeg,png,jpg',
            'cost'=>'required|integer'
        ]);
        if($validator->fails()){
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    public function offers()
{
    return $this->belongsToMany(Offer::class);
}

public function orders()
{
    return $this->belongsToMany(Order::class);
}
}
