<?php

namespace App\Http\Controllers;


use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\MealController;



class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::all();
        return $offers;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
        Offer::validateOffer($request);
        $offer = Offer::create($request->except('meals'));

        $MealController = new MealController();
        foreach ($request -> meals as $mealId) {
            $meal = $MealController->show($mealId);

            if($meal->restaurant_id == $request->userId)
            $offer->meals()->attach($meal);
            else{
                return response()->json(['error' => 'Forbidden ,not your meal'], 403);
            }
        }
        return $offer;
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
        $offer = Offer::find($id);
        return $offer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {

    Offer::validateOfferEdit($request);

    $offer = Offer::find($id);

    if ($offer) {
        $offer->update($request->all());
    }

    return $offer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $offer = Offer::find($id);
        $offer->delete();
    }
}
