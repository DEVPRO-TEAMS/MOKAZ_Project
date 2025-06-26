<?php

namespace App\Http\Controllers\Admin;

use App\Models\Commodity;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.pages.index');
    }
    


    // Commodity

    public function listCommodity()
    {
       
        $commodities = Commodity::all();
        return response()->json([
            'status' => true,
            'message' => 'Liste des commodités',
            'commodities' => $commodities], 200);
    }

    public function store(Request $request)
    {

        // var_dump($request->all());

        DB::beginTransaction();
        try{

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'etat' => 'nullable|string|in:actif,inactif',
            ]);

            $commodity = Commodity::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'etat' => "actif",
            ]);

            DB::commit();
            return response()->json(['message' => 'Commodity créée avec succès', 'commodity' => $commodity], 201);

        }catch(\Exception $e){
            DB::rollBack();

            return response()->json(['message' => 'Une erreur s’est produite lors de la création de la commodité.' . $e], 500);
        }
        
    }

     public function update(Request $request, $id)
    {

        try{
            DB::beginTransaction();

             $commodity = Commodity::findOrFail($id);

            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:500',
            ]);

            

            $commodity->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Commodity mise à jour avec succès', 'commodity' => $commodity], 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Une erreur s’est produite lors de la mise à jour de la commodité.' . $e], 500);
        }
       
    }

    public function destroy($id)
    {

        try{
            DB::beginTransaction();

            $commodity = Commodity::findOrFail($id);
            $commodity->delete();

            DB::commit();

            return response()->json(['message' => 'Commodity supprimée avec succès', 'commodity' => $commodity], 201);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Une erreur s’est produite lors de la suppression de la commodité.' . $e], 500);
        }
       

    }

    // End Commodity


    // property type

    public function propertiesTypes()
    {
       
        $propertiesTypes = PropertyType::all();
        return response()->json([
            'status' => true,
            'message' => 'Liste des type de propriété',
            'propertiesTypes' => $propertiesTypes], 200);
    }

    public function storePropertyType(Request $request)
    {

        // var_dump($request->all());

        DB::beginTransaction();
        try{

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'etat' => 'nullable|string|in:actif,inactif',
            ]);

            $propertyType = PropertyType::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'etat' => "actif",
            ]);

            DB::commit();
            return response()->json(['message' => 'Type de propriété créée avec succès', 'commodity' => $propertyType], 201);

        }catch(\Exception $e){
            DB::rollBack();

            return response()->json(['message' => 'Une erreur s’est produite lors de la création de la commodité.' . $e], 500);
        }
        
    }

     public function updatePropertyType(Request $request, $id)
    {

        try{
            DB::beginTransaction();

             $propertyType = PropertyType::findOrFail($id);

            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:500',
            ]);

            

            $propertyType->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Commodity mise à jour avec succès', 'propertyType' => $propertyType], 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Une erreur s’est produite lors de la mise à jour du type de propriété.' . $e], 500);
        }
       
    }

    public function destroyPropertyType($id)
    {

        try{
            DB::beginTransaction();

            $propertiesType = PropertyType::findOrFail($id);
            $propertiesType->delete();

            DB::commit();

            return response()->json(['message' => 'Type de propriété supprimée avec succès', 'propertiesType' => $propertiesType], 201);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Une erreur s’est produite lors de la suppression de la commodité.' . $e], 500);
        }
       

    }


}
