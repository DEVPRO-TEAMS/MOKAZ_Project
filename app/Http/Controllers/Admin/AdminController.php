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

        $demandePartenariats = PartnershipRequest::all();

        return view('admins.pages.demandesPartenariat.validationDemande', compact('demandePartenariats'));
    }

    public function accepterDemande($id)
    {
        try {
            $resulta = PartnershipRequest::where('id', $id)->update(['etat' => 'actif']);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Demande accepté avec succès',
                'data' => $resulta

            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => " Une erreur s’est produite lors de la validation de la demande" . $e->getMessage(),

            ]);
        }
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
