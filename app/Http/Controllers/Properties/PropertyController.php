<?php

namespace App\Http\Controllers\Properties;

use App\Models\city;
use App\Models\country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('properties.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = country::all();
        return view('properties.create', compact('countries'));
    }

    // api pour recuperer la liste des ville par pays
    public function getCities(Request $request)
    {
        $countryCode = $request->input('country');
        $cities = city::where('country_code', $countryCode)->get();
        return response()->json($cities);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
