<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

use Inertia\Inertia;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = Year::all();
        return Inertia::render('Years/Index', ['years' => $years]);
    }

    public function create()
    {
        return Inertia::render('Years/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:4']);
        $year = new Year($request->input());
        $year->save();
        return redirect('years');
    }

    public function show(Year $year)
    {
        //
    }

    public function edit(Year $year)
    {
        return Inertia::render('Years/Edit',['year' => $year]);
    }

    public function update(Request $request, Year $year)
    {
        $request->validate(['name' => 'required|max:4']);
        $year->update($request->all());
        return redirect('years');
    }

    public function destroy(Year $year)
    {
        $year->delete();
        return redirect('years');
    }
}
