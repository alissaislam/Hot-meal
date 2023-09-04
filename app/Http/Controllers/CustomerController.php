<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return $customers;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       $fields = $request->validate([
        'name'=>'required|min:2|max:45|string',
        'address'=>'required|min:2|max:255|string',
        'email'=>'required|min:5|max:255|email',
        'phone'=>'required|min:10|max:45|string',
       ]);
       $customer = Customer::create($fields);
       return $customer;
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
        $customer = Customer::find($id);
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
{


    $fields = $request->validate([
        'name'=>'nullable|min:2|max:45|string',
        'address'=>'nullable|min:2|max:255|string',
        'email'=>'nullable|min:5|max:255|email',
        'phone'=>'nullable|min:10|max:45|string',
    ]);


    $customer = Customer::find($id);

    if ($customer) {
        $customer->update($fields);
    }

    return $customer;
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        //
    }

    public function myOrders(Request $request){
        $customer = Customer::with('orders.offers', 'orders.meals')->find($request->userId);
        return $customer->orders;
    }
}
