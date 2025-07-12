<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\CityCountryImport;
use App\Models\PartnershipRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('admins.pages.index');
    }

    public function importCityCountry(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        

        Excel::import(new CityCountryImport, $request->file('file'));

        return back()->with('success', 'Importation réussie.');
    }

    public function viewDemande()
    {

        $demandePartenariats = PartnershipRequest::orderBy('created_at', 'ASC')->get();

        return view('admins.pages.demandesPartenariat.validationDemande', compact('demandePartenariats'));
    }

    public function accepterDemande($id)
    {
        DB::beginTransaction();
        try {
            // Validation de l'ID
            if (!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'ID invalide'
                ], 400);
            }

            $demande = PartnershipRequest::find($id);
            
            // Vérification si la demande existe
            if (!$demande) {
                return response()->json([
                    'status' => false,
                    'message' => 'Demande non trouvée'
                ], 404);
            }

            // Vérification si la demande n'est pas déjà approuvée
            if ($demande->etat === 'actif') {
                return response()->json([
                    'status' => false,
                    'message' => 'Cette demande a déjà été approuvée'
                ], 400);
            }

            // Mise à jour de l'état
            $demande->etat = 'actif';
            // $demande->date_approbation = now();
            $demande->save();

            DB::commit();
            
            return response()->json([
                'status' => true,
                'message' => 'Demande acceptée avec succès',
                'data' => $demande
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Une erreur s'est produite lors de la validation de la demande",
                'error_details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function rejetDemande(Request $request)
    {

        dd($request->all());


        // DB::beginTransaction();
        // try {

        //     $id = request()->input('id');
        //     $demande = PartnershipRequest::findOrFail($id);
                
        //     if ($demande->etat === 'inactif') {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Cette demande a déjà été rejetée'
        //         ], 400);
        //     }

        //     $demande->etat = 'inactif';
        //     // $demande->date_rejet = now(); // Ajout d'une date de rejet
        //     $demande->save();

        //     DB::commit();
            
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Demande rejetée avec succès',
        //         'data' => $demande
        //     ], 200);

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'status' => false,
        //         'message' => "Une erreur s'est produite lors du rejet de la demande",
        //         'error_details' => env('APP_DEBUG') ? $e->getMessage() : null
        //     ], 500);
        // }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
