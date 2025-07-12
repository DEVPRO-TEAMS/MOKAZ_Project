<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Models\PartnershipRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('partners.pages.index');
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

        DB::beginTransaction();
        try{


            $partnership = PartnershipRequest::create(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'company' => $request->company,
                    'property_type' => $request->property_type,
                    'activity_zone' => $request->activity_zone,
                    'experience' => $request->experience,
                    'portfolio_size' => $request->portfolio_size,
                    'website' => $request->website,
                    'message' => $request->message,
                    'accepts_newsletter' => $request->accepts_newsletter,
                    'etat' => 'pending'
                ]
            );

            DB::commit();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Partnership request created successfully.',
                    'partnership' => $partnership
                ],
                201
            );

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Une erreur s’est produite lors de la création de la partenariat.' . $e], 500);
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
