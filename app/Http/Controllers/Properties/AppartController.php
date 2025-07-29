<?php

namespace App\Http\Controllers\Properties;

use App\Models\Property;
use App\Models\AppartDoc;
use App\Models\Appartement;
use Illuminate\Support\Str;
use App\Models\Tarification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create($uuid)
    {
        $property = Property::where('uuid', $uuid)->first();
        return view('properties.apparts.create', compact('property', 'uuid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $externalUploadDir = base_path(env('STORAGE_FILES'));
                
            if (!is_dir($externalUploadDir)) {
                mkdir($externalUploadDir, 0777, true);
            }

            $code = RefgenerateCode(Appartement::class, 'APPART-', 'code');
            $uuid = Str::uuid();
            $property_uuid = $request->property_uuid;
            $property = Property::where('uuid', $property_uuid)->first();
            $property_code = $property->code;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $code . now()->format('YmdHis') . '.' . $file->extension();
                $mainFileDirectory = 'properties_' . $property_code . '/apparts_' . $code . '/';
                $file->move($externalUploadDir . $mainFileDirectory, $imageName);
                // $file->move(public_path('media/properties_' . $property_code . '/apparts_' . $code), $imageName);
            }
            $mainFileUrl = "storage/files/" . $mainFileDirectory. $imageName;
            $appartement = Appartement::create(
                [
                    'uuid' => $uuid,
                    'code' => $code,
                    'property_uuid' => $property_uuid,
                    'title' => $request->title,
                    'nbr_available' => $request->nbr_available,
                    'type_uuid' => $request->type_uuid,
                    'commodity_uuid' => $request->commodity_uuid,
                    'nbr_room' => $request->nbr_room,
                    'nbr_bathroom' => $request->nbr_bathroom,
                    'video_url' => $request->video_url,
                    'image' => $mainFileUrl,
                    'description' => $request->description,
                    'created_by' => $request->partner_uuid
                ]
            );

            if ($appartement) {

                AppartDoc::create([
                    'uuid' => Str::uuid(),
                    'appartement_uuid' => $uuid,
                    'doc_name' => $imageName,
                    'doc_url' => $mainFileUrl
                ]);

                //Enregistrer les tarifs
                if ($request->has('sejour_en') && $request->has('temps') && $request->has('prix')) {
                    $sejours = $request->input('sejour_en');
                    $temps = $request->input('temps');
                    $prix = $request->input('prix');

                    for ($i = 0; $i < count($sejours); $i++) {
                        if (!empty($sejours[$i]) && !empty($temps[$i]) && !empty($prix[$i])) {
                            Tarification::create([
                                'uuid' => Str::uuid(),
                                'code' => 'TARIF-' . now()->format('YmdHis') . '-' . $i,
                                'appart_uuid' => $uuid,
                                'sejour' => $sejours[$i],
                                'nbr_of_sejour' => $temps[$i],
                                'price' => $prix[$i],
                                'created_by' => $request->partner_uuid
                            ]);
                        }
                    }
                }

                if ($request->hasFile('images_appart')) {
                    $files = $request->file('images_appart');
                    foreach ($files as $file) {
                        $image = $code . now()->format('YmdHis') . '.' . $file->extension();
                        $fileDirectory = 'properties_' . $property_code . '/apparts_' . $code . '/';
                        $file->move($externalUploadDir . $fileDirectory, $image);

                        $fileUrl = "storage/files/" . $fileDirectory. $image;
                        // $file->move(public_path('media/properties_' . $property_code . '/apparts' . $appartement_code), $image);
                        AppartDoc::create([
                            'uuid' => Str::uuid(),
                            'appartement_uuid' => $uuid,
                            'doc_name' => $image,
                            'doc_url' => $fileUrl
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
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Une erreur s’est produite lors de la création de l'appartement." . $e
            ], 500);
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
