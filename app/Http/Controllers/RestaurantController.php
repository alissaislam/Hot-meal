<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use Ramsey\Uuid\Type\Time;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Validator;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $restaurants = Restaurant::all();
        if(!$restaurants)
        return response('There are no restaurants.');
        return response($restaurants);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Restaurant::validateRestaurant($request);

    $fileds = $request->all();
    if($request->hasFile('image'))
    {
        $filenameToStore = time() . '_' . uniqid() . '.' . $request->image->extension();

        $path = $request->image->storeAs('images', $filenameToStore, 'public');
        $fileds['image'] = URL::asset('storage/images/'.$filenameToStore);
    } else {
        $fileds['image'] = null;
    }
$restaurant = Restaurant::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'address'=>$request->address,
        'phone'=>$request->phone,
        'openTime'=>$request->openTime,
        'closeTime'=>$request->closeTime,
        'location'=>$request->location,
        'otp'=>111,
        'active'=>1,
        'image' =>$fileds['image'],
]);


    return response()->json($restaurant, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant)
            return response()->json(['error'=>'The restaurant with the given id was not found.'],400);
        return response()->json($restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant)
        return response()->json(['error'=>'The restaurant with the given id was not found.']);

        Restaurant::validateEditRestaurant($request);
        $restaurant->forceFill($request->all());
        if($request->hasFile('image')){
            $filenameToStore = Time().'_'.uniqid().'.'.$request->image->extension();
            $path = $request->image->storeAs('images',$filenameToStore,'public');
            $input['image']=URL::asset('storage/images'.$filenameToStore);
        }
        $restaurant->save();
        return response()->json($restaurant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant)
        return response('The restaurant with the given id was not found.');
        $restaurant->delete();
        return response('Deleted successfully.');
    }

    // public function createMeal(Request $request){
    //     Meal::validateMeal($request);
    //     $request['restaurant_id'] = $request->userId;
    //     $meal = Meal::create($request->all());
    //     return response($meal);
    // }

    public function myMeals(Request $request){

        $restaurant = Restaurant::find($request->userId);
        return $restaurant->meals()->get();

    }
}
