<?php

namespace App\Http\Controllers\User;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    // Liste des réservations
    public function index()
    {
        $reservations = Reservation::where('etat', 'actif')->get();

        return view('reservations.index', compact('reservations'));
    }
    

    // Créer une réservation
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:50',
                'appart_uuid' => 'required|string',
                'sejour' => 'nullable|string|max:255',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
                'nbr_of_sejour' => 'nullable|integer|min:1',
                'total_price' => 'nullable|numeric|min:0',
                'unit_price' => 'nullable|numeric|min:0',
                'statut_paiement' => 'nullable|in:pending,paid',
                'status' => 'nullable|in:pending,confirmed,cancelled,reconducted',
                'notes' => 'nullable|string',
                'traited_by' => 'nullable|string|max:255',
                'traited_at' => 'nullable|date',
            ]);

            $saving = Reservation::create([
                'uuid' => Str::uuid(),
                'code' => Refgenerate(Reservation::class, 'RES', 'code'),
                'nom' => $validated['nom'],
                'prenoms' => $validated['prenoms'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'appart_uuid' => $validated['appart_uuid'],
                'sejour' => $validated['sejour'] ?? null,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'nbr_of_sejour' => $validated['nbr_of_sejour'] ?? null,
                'total_price' => $validated['total_price'] ?? null,
                'unit_price' => $validated['unit_price'] ?? null,
                'statut_paiement' => $validated['statut_paiement'] ?? 'pending',
                'status' => $validated['status'] ?? 'pending',
                'notes' => $validated['notes'] ?? null,
                'traited_by' => Auth::user()->uuid ?? null,
                'traited_at' => $validated['traited_at'] ?? null,
                'etat' => 'actif',
            ]);

            if ($saving) {
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => 'back',
                    'message' => 'Réservation enregistrée avec succès !',
                    'data' => $saving,
                    'code' => 200,
                ];
                DB::commit();
            } else {
                DB::rollBack();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de l'enregistrement !",
                    'data' => $saving,
                    'code' => 500,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système ! $th",
                'code' => 500,
            ];
        }

        return response()->json($dataResponse);
    }

    // Afficher une réservation
    public function show($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        return response()->json(['success' => true, 'data' => $reservation]);
    }

    // Mettre à jour une réservation
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        $reservation->update($request->all());

        return response()->json(['success' => true, 'message' => 'Réservation mise à jour', 'data' => $reservation]);
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        $reservation->delete();
        return response()->json(['success' => true, 'message' => 'Réservation supprimée avec succès']);
    }

    // ✅ Fonction de traitement/validation par l’admin
    public function traiter($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        $reservation->update([
            'status' => 'confirmed',
            'traited_by' => Auth::id(),
            'traited_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Réservation validée', 'data' => $reservation]);
    }
}
