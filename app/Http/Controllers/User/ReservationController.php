<?php

namespace App\Http\Controllers\User;


use Carbon\Carbon;
use App\Models\receipt;
use App\Models\Appartement;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\reservatierNotifier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    // Liste des réservations
    public function index(Request $request)
    {
        // $reservations = Reservation::where('etat', 'actif')->where('partner_uuid', Auth::user()->partner_uuid)->get();

        $query = Reservation::query();

        if($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%')
                ->orWhere('nom', 'like', '%' . $request->search . '%')
                ->orWhere('prenoms', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
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

        // Filtre par statut
        if($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Filtre par sejour
        if($request->filled('sejour')) {
            $query->where('sejour', $request->sejour);
        }

        if(Auth::user()->user_type == 'admin') {
            $reservations = $query->where('etat', 'actif')->orderBy('created_at', 'desc')->get();
        }else {
            
            $reservations = $query->where('etat', 'actif')->where('partner_uuid', Auth::user()->partner_uuid)->orderBy('created_at', 'desc')->get();
        }

        return view('reservations.index', compact('reservations'));
    }
    

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            // Génération du code unique
            $code = 'RES-' . strtoupper(Str::random(6));
            $start_time = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
            $end_time = $request->end_time
                ? Carbon::parse($request->end_time)->format('Y-m-d H:i:s')
                : null;

            $still_to_pay = (float) $request->totalPrice - (float) $request->paymentAmount;
            // Création de la réservation
            $reservation = Reservation::create([
                'uuid' => Str::uuid(),
                'code' => $code,
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'email' => $request->email,
                'phone' => $request->phone,
                'appart_uuid' => $request->appart_uuid,
                'property_uuid' => $request->property_uuid,
                'partner_uuid' => $request->partner_uuid,
                'sejour' => $request->isHourly ? 'Heure' : 'Jour',
                'start_time' => $start_time,
                'end_time' => $end_time,
                'nbr_of_sejour' => $request->isHourly ? $request->hours : $request->days,
                'total_price' => $request->totalPrice,
                'unit_price' => $request->unitPrice,
                'still_to_pay' => $still_to_pay,
                'statut_paiement' => 'paid',
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                // 'custom_tarif' => $request->custom_tarif ?? false,
                'payment_amount' => $request->paymentAmount
            ]);

            if($reservation){
                // faire une decrementation du stock de l'appartement
                $appartement = Appartement::where('uuid', $request->appart_uuid)->first();
                $appartement->nbr_available = (int) $appartement->nbr_available - (int) $reservation->nbr_of_sejour;
                $appartement->save();
            }

            // Génération du PDF après enregistrement
            $pdfUrl = $this->generateReceiptPDF($reservation);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Réservation enregistrée avec succès',
                'reservation' => $reservation,
                'pdf_url' => $pdfUrl
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateReceiptPDF($reservation)
    {
        $directory = 'receipts';
        $externalUploadDir = base_path(env('STORAGE_FILES', '../uploads/'));
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($externalUploadDir . $directory)) {
            mkdir($externalUploadDir . $directory, 0755, true);
        }

        $data = [
            'reservation' => $reservation,
            'date' => now()->format('d/m/Y H:i')
        ];

        $pdf = PDF::loadView('reservations.receipt', $data);
        
        $filename = 'Recu_' . $reservation->code . '_' . $reservation->uuid . '.pdf';
        $filePath = $externalUploadDir . $directory . '/' . $filename;
        
        $pdf->save($filePath);
        
        // Enregistrer dans la table receipts
        Receipt::create([
            'uuid' => Str::uuid(),
            'code' => 'REC-' . strtoupper(Str::random(6)),
            'reservation_uuid' => $reservation->uuid,
            'filename' => $filename,
            'filepath' => "storage/files/{$directory}/{$filename}"
        ]);
        
        return "storage/files/{$directory}/{$filename}";
    }

    public function downloadReceipt($uuid)
    {
        $reservation = Reservation::with('receipt')->where('uuid', $uuid)->firstOrFail();
        $directory = 'receipts/';

        if (!$reservation->receipt) {
            $this->generateReceiptPDF($reservation);
            $reservation->load('receipt');
        }

        $externalStorageDir = base_path(env('STORAGE_FILES', '../uploads/'));
        $fileFullPath = $externalStorageDir . $directory . $reservation->receipt->filename;

        if (!file_exists($fileFullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Fichier PDF introuvable'
            ], 404);
        }

        return response()->download($fileFullPath, $reservation->receipt->filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }

    public function confirmReservation($uuid)
    {
        DB::beginTransaction();
        try {
            $reservation = Reservation::where('uuid', $uuid)->first();
            
            if (!$reservation) {
                return response()->json([
                    'type' => 'error',
                    'success' => false,
                    'code' => 404,
                    'message' => 'Reservation introuvable',
                    'urlback' => '',
                ]);
            }

            $reservation->status = 'confirmed';
            $reservation->traited_by = Auth::user()->uuid;
            $reservation->traited_at = now();

            $reservation->save();
            // Log::info('Reservation confirmed: ' . $reservation->code);
            // Use a proper Blade view for the email content
            $emailSubject = "✅ Réservation Confirmée";
            $emailContent = view('mail.confirm_reservation', [
                'reservation' => $reservation
                ])->render();
                
                $emailData = [
                    'message' => $emailContent,
                    'status' => $reservation->status,
                    'code' => $reservation->code,
                    'url' => url($reservation->receipt->filepath ?? '#'),
                    'buttonText' => 'Télécharger le reçu',
                ];
                
                Mail::to($reservation->email)->send(new reservatierNotifier($emailData, $emailSubject));
                
            
            DB::commit();
            
            return response()->json([
                'type' => 'success',
                'success' => true,
                'code' => 200,
                'urlback' => 'back',
                'message' => 'La reservation a bien ete confirmer',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation confirmation failed: ' . $e->getMessage());
            
            return response()->json([
                'type' => 'error',
                'success' => false,
                'code' => 500,
                'urlback' => '',
                'message' => 'Une erreur est survenue lors de la confirmation de la reservation',
            ]);
        }
    }

    // Afficher une réservation
    // public function show($id)
    // {
    //     $reservation = Reservation::find($id);
    //     if (!$reservation) {
    //         return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
    //     }

    //     return response()->json(['success' => true, 'data' => $reservation]);
    // }
    public function show($uuid)
    {
        $reservation = Reservation::where('uuid', $uuid)->first();
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        return view('reservations.show', compact('reservation'));
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
