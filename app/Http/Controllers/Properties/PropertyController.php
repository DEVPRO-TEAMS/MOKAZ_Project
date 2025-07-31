<?php

namespace App\Http\Controllers\Properties;

use App\Models\city;
use App\Models\country;
use App\Models\Property;
use App\Models\Variable;
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
    public function index(Request $request)
    {
        $query = Property::query();

        if($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('partner_uuid', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');
        }

        // Filtre par date
        if($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('created_at', [
                $request->date_debut . ' 00:00:00', 
                $request->date_fin . ' 23:59:59'
            ]);
        } elseif ($request->filled('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut . ' 00:00:00');
        } elseif ($request->filled('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin . ' 23:59:59');
        }

        // Filtre par état
        if($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $properties = $query->where('partner_uuid', Auth::user()->partner_uuid)->orderBy('created_at', 'desc')->get();
        // $properties = Property::where('partner_code', Auth::user()->email)->get();
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = country::all();
        $variables = Variable::where(['type'=> 'type_of_property','etat' => 'actif'])->get();
        return view('properties.create', compact('countries', 'variables'));
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
            $externalUploadDir = base_path(env('STORAGE_FILES'));
                
            if (!is_dir($externalUploadDir)) {
                mkdir($externalUploadDir, 0777, true);
            }

            $code = RefgenerateCode(Property::class, 'PROP-', 'code');
            $uuid = Str::uuid();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $code. now()->format('YmdHis').$uuid.'.'.$file->extension();

                $fileDirectory = 'properties_'.$code.'/';

                $file->move($externalUploadDir.$fileDirectory, $imageName);
                // $file->move(public_path('media/properties_'.$code), $imageName);
            }
            $fileUrl = "storage/files/" . $fileDirectory. $imageName;
            $property = Property::create(
                [ 
                    'uuid' => $uuid,
                    'code' => $code,
                    'partner_uuid' => $request->partner_uuid,
                    'image' => $fileUrl,
                    'title' => $request->title,
                    'type_uuid' => $request->type_uuid,
                    'address' => $request->address,
                    'country' => $request->country,
                    'city' => $request->city,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'description' => $request->description,
                    'created_by' => $request->user_uuid,
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
    public function show(string $uuid)
    {
        // $demandePartenariat = Property::find($property_code);
        $property = Property::where('uuid', $uuid)->first();
        return view('properties.show', compact('property'));
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
        
    }
}
