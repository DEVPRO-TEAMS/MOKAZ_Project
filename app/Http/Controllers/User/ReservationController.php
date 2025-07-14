<?php

namespace App\Http\Controllers\User;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    // Liste des réservations
    public function index()
    {
        $reservations = Reservation::all();

        return view('reservations.index', compact('reservations'));
    }

    // Créer une réservation
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'room_id' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'unit_price' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $reservation = Reservation::create($request->all());

        return response()->json(['success' => true, 'message' => 'Réservation créée avec succès', 'data' => $reservation]);
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
