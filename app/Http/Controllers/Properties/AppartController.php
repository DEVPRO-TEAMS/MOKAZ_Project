<?php

namespace App\Http\Controllers\Properties;

use App\Models\Property;
use App\Models\AppartDoc;
use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AppartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($property_code)
    {
        $property = Property::where('property_code', $property_code)->first();
        return view('properties.apparts.create', compact('property', 'property_code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $appartement_code = RefgenerateCode(Appartement::class, 'APPART-', 'appartement_code');
            $property_code = $request->property_code;

            if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $imageName = $appartement_code. now()->format('Y-m-d_H-i-s').'.'.$file->extension();
            $file->move(public_path('media/properties_'.$property_code.'/apparts_'.$appartement_code), $imageName);
        }
            $appartement = Appartement::create(
                [ 
                    'appartement_code' => $appartement_code,
                    'property_code' => $property_code,
                    'title' => $request->title,
                    'price' => $request->price,
                    'available' => $request->available,
                    'appartType' => $request->appartType,
                    'bedroomsNumber' => $request->bedroomsNumber,
                    'bathroomsNumber' => $request->bathroomsNumber,
                    'CommoditiesHomesafety' => $request->CommoditiesHomesafety,
                    'CommoditiesBedroom' => $request->CommoditiesBedroom,
                    'CommoditiesKitchen' => $request->CommoditiesKitchen,
                    'video_url' => $request->video_url,
                    'main_image' => $imageName,
                    'description' => $request->description,
                    'created_by' => $request->property_code,
                ]
            );
            if($appartement){
                AppartDoc::create([
                    'appartement_code' => $appartement_code,
                    'doc_name' => $imageName,
                    'doc_url' => 'media/properties_'.$property_code.'/apparts_'.$appartement_code . '/' . $imageName
                ]);

                if ($request->hasFile('images_appart')) {
                    $files = $request->file('images_appart');
                    foreach ($files as $file) {
                        $image = $appartement_code. now()->format('Y-m-d_H-i-s').'.'.$file->extension();
                        $file->move(public_path('media/properties_'.$property_code.'/apparts'.$appartement_code), $image);
                        AppartDoc::create([
                            'appartement_code' => $appartement_code,
                            'doc_name' => $image,
                            'doc_url' => 'media/properties_'.$property_code.'/apparts_'.$appartement_code . '/' . $image
                        ]);
                    }
                }
            }
            DB::commit();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Appartement créee avec succès.',
                    'appartement' => $appartement
                ],
                201
            );

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Une erreur s’est produite lors de la création de l'appartement." . $e], 500);
        }
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
