<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\OfferController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {



        Order::validateOrder($request);

        $request['customer_id'] = $request->userId;
        $order = Order::create($request->except('meals','offers'));

        $MealController = new MealController();
        foreach ($request -> meals as $mealId){

            $meal = $MealController->show($mealId);

            $order->meals()->attach($meal);

        }

        $OfferController = new OfferController();
        foreach ($request -> offers as $offerId){

            $offer = $OfferController->show($offerId);

            $order->offers()->attach($offer);

        }
        return $order;
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function myOffers($id){
        $order = Order::with('offers')->find($id);
       return $order->offers()->get();
    }

    public function myMeals($id){
        $order = Order::with('meals')->find($id);
       return $order->meals()->get();
    }
}
