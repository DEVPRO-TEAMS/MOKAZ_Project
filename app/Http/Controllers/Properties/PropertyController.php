<?php

namespace App\Http\Controllers\Properties;

use App\Models\city;
use App\Models\country;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::where('partner_code', Auth::user()->email)->get();
        return view('properties.index', compact('properties'));
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
        DB::beginTransaction();
        try{
            $property_code = RefgenerateCode(Property::class, 'PROP-', 'property_code');

            if ($request->hasFile('image_property')) {
            $file = $request->file('image_property');
            $imageName = $property_code. now()->format('Y-m-d_H-i-s').'.'.$file->extension();
            $file->move(public_path('media/properties_/'.$property_code), $imageName);
        }
            $property = Property::create(
                [ 
                    'property_code' => $property_code,
                    'partner_code' => $request->partner_code,
                    'image_property' => $imageName,
                    'title' => $request->title,
                    'address' => $request->address,
                    'zipCode' => $request->zipCode,
                    'country' => $request->country,
                    'city' => $request->city,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'description' => $request->description,
                    'created_by' => $request->partner_code,
                ]
            );
            DB::commit();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Propriété créee avec succès.',
                    'property' => $property
                ],
                201
            );

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Une erreur s’est produite lors de la création de la propriété.' . $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $property_code)
    {
        $demandePartenariat = Property::find($property_code);
        $property = Property::where('property_code', $property_code)->first();
        return view('properties.show', compact('demandePartenariat', 'property'));
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
