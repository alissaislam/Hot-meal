<?php

namespace App\Http\Controllers;

use App\Models\Deliverer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DelivererController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliverer = Deliverer::all();
        if(!$deliverer)
        return response('No deliverers found.',404);
        return response($deliverer);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|min:3|max:50',
            'address'=>'required|string|min:5|max:255',
            'email'=>'required|min:5|max:255|email',
            'phone'=>['required','string','min:10','max:10',Rule::unique('restaurants','phone'),Rule::unique('customers','phone'),Rule::unique('deliveries','phone')],
        ]);
        if($validator->fails())
        return response()->json(['error'=>$validator->errors()->all()]);

        $input = $request->all();
        $deliverer = Deliverer::create($input);
        // $token = $deliverer->createToken('My token',['deliverer'])->accessToken;
        return response($deliverer);
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
        $deliverer = Deliverer::find($id);
        if(!$deliverer)
        return response('The deliverer requested by the gived id was not found.',404);
        return response($deliverer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $deliverer = Deliverer::find($id);
        if(!$deliverer)
        return response('The deliverer requested with the given id was not found.',404);

        $validator = Validator::make($request->all(),[
            'name'=>'string|min:3|max:20',
            'address'=>'string|min:5|max:255',
            'phone'=>'string|min:10|max:10'
        ]);
        if($validator->fails())
        return response($validator->errors()->all());
        $deliverer->forcefill($request->all());
        $deliverer->save();
        return response($deliverer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deliverer $deliverer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deliverer= Deliverer::find($id);
        if(!$deliverer)
        return response('The deliverer with the given id was not found.',404);
        $deliverer->delete();
        return response('Deliverer destroyed.');
    }

    public function myOrders(Request $request){
        
        $deliverer = Deliverer::find($request->userId);
        return $deliverer->orders()->get();

    }
}
