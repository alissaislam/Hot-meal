<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MealController extends Controller
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
        Meal::validateMeal($request);

        $fields = $request->all();

      if($request->hasFile('image'))
    {
        $filenameToStore = time() . '_' . uniqid() . '.' . $request->image->extension();

        $path = $request->image->storeAs('images', $filenameToStore, 'public');
        $fields['image'] = URL::asset('storage/images/'.$filenameToStore);
    } else {
        $fileds['image'] = null;
    }

        $meal = Meal::create([
            'name' => $request->name,
            'description'=>$request->description,
            'cost'=>$request->cost,
            'restaurant_id'=>$request->userId,
            'image'=> $fields['image'],
        ]);

        return response()->json($meal, 201);

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
        return Meal::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
