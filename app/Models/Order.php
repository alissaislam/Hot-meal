<?php

namespace App\Models;

use Exception;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Customer;
use App\Models\Deliverer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{

    protected $guarded=[];

    public $timestamps = false;

    use HasFactory;


    public static function validateOrder(Request $request){

        $orders['orders']= array_merge($request['offers'],$request['meals']);
        $validator = Validator::make($orders, [
            'orders' => 'required|array|min:1'
        ]);

        if($validator->fails()){

            throw new Exception('order should has at least one meal or offer');
        }
    }

    public function meals()
{
    return $this->belongsToMany(Meal::class);
}

public function offers()
{
    return $this->belongsToMany(Offer::class);
}

public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function deliverers()
{
    return $this->belongsTo(Deliverer::class);
}
}
