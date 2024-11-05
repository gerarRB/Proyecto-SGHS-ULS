<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

use Inertia\Inertia;

class PlaceController extends Controller
{

    public function index()
    {
        $places = Place::all();
        return Inertia::render('Places/Index', ['places' => $places]);
    }

 
    public function create()
    {
        return Inertia::render('Places/Create');
    }


    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100']);
        $place = new Place($request->input());
        $place->save();
        return redirect('places');
    }


    public function show(Place $place)
    {
        //
    }

    public function edit(Place $place)
    {
        return Inertia::render('Places/Edit',['place' => $place]);
    }

    public function update(Request $request, Place $place)
    {
        $request->validate(['name' => 'required|max:100']);
        $place->update($request->all());
        return redirect('places');
    }

 
    public function destroy(Place $place)
    {
        $place->delete();
        return redirect('places');
    }
}
