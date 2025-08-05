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
    public function index()
    {
        $reservations = Reservation::where('etat', 'actif')->where('partner_uuid', Auth::user()->partner_uuid)->get();
        return view('reservations.index', compact('reservations'));
    }
    

    // Créer une réservation
    // public function store(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $validated = $request->validate([
    //             'nom' => 'required|string|max:255',
    //             'prenoms' => 'required|string|max:255',
    //             'email' => 'nullable|email|max:255',
    //             'phone' => 'nullable|string|max:50',
    //             'appart_uuid' => 'required|string',
    //             'sejour' => 'nullable|string|max:255',
    //             'start_time' => 'required|date',
    //             'end_time' => 'required|date|after_or_equal:start_time',
    //             'nbr_of_sejour' => 'nullable|integer|min:1',
    //             'total_price' => 'nullable|numeric|min:0',
    //             'unit_price' => 'nullable|numeric|min:0',
    //             'statut_paiement' => 'nullable|in:pending,paid',
    //             'status' => 'nullable|in:pending,confirmed,cancelled,reconducted',
    //             'notes' => 'nullable|string',
    //             'traited_by' => 'nullable|string|max:255',
    //             'traited_at' => 'nullable|date',
    //         ]);

    //         $saving = Reservation::create([
    //             'uuid' => Str::uuid(),
    //             'code' => Refgenerate(Reservation::class, 'RES', 'code'),
    //             'nom' => $validated['nom'],
    //             'prenoms' => $validated['prenoms'],
    //             'email' => $validated['email'] ?? null,
    //             'phone' => $validated['phone'] ?? null,
    //             'appart_uuid' => $validated['appart_uuid'],
    //             'sejour' => $validated['sejour'] ?? null,
    //             'start_time' => $validated['start_time'],
    //             'end_time' => $validated['end_time'],
    //             'nbr_of_sejour' => $validated['nbr_of_sejour'] ?? null,
    //             'total_price' => $validated['total_price'] ?? null,
    //             'unit_price' => $validated['unit_price'] ?? null,
    //             'statut_paiement' => $validated['statut_paiement'] ?? 'pending',
    //             'status' => $validated['status'] ?? 'pending',
    //             'notes' => $validated['notes'] ?? null,
    //             'traited_by' => Auth::user()->uuid ?? null,
    //             'traited_at' => $validated['traited_at'] ?? null,
    //             'etat' => 'actif',
    //         ]);

    //         if ($saving) {
    //             $dataResponse = [
    //                 'type' => 'success',
    //                 'urlback' => 'back',
    //                 'message' => 'Réservation enregistrée avec succès !',
    //                 'data' => $saving,
    //                 'code' => 200,
    //             ];
    //             DB::commit();
    //         } else {
    //             DB::rollBack();
    //             $dataResponse = [
    //                 'type' => 'error',
    //                 'urlback' => '',
    //                 'message' => "Erreur lors de l'enregistrement !",
    //                 'data' => $saving,
    //                 'code' => 500,
    //             ];
    //         }
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $dataResponse = [
    //             'type' => 'error',
    //             'urlback' => '',
    //             'message' => "Erreur système ! $th",
    //             'code' => 500,
    //         ];
    //     }

    //     return response()->json($dataResponse);
    // }

    // public function store(Request $request)
    // {
    //     // Validation des données
    //     // $validator = Validator::make($request->all(), [
    //     //     'nom' => 'required|string|max:255',
    //     //     'prenoms' => 'required|string|max:255',
    //     //     'email' => 'required|email|max:255',
    //     //     'phone' => 'required|string|max:20',
    //     //     'appart_uuid' => 'required|string|exists:appartements,uuid',
    //     //     'start_time' => 'required|date',
    //     //     'end_time' => 'nullable|date',
    //     //     'unit_price' => 'required|numeric',
    //     //     'total_price' => 'required|numeric',
    //     //     'payment_amount' => 'required|numeric',
    //     //     'payment_method' => 'required|string',
    //     //     'notes' => 'nullable|string',
    //     //     'is_hourly' => 'required|boolean',
    //     //     'hours' => 'nullable|integer|required_if:is_hourly,true',
    //     //     'days' => 'nullable|integer|required_if:is_hourly,false',
    //     //     'custom_tarif' => 'nullable|boolean'
    //     // ]);

    //     // if ($validator->fails()) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Validation error',
    //     //         'errors' => $validator->errors()
    //     //     ], 422);
    //     // }

    //     try {
    //         // Création de la réservation
    //         $reservation = Reservation::create([
    //             'uuid' => Str::uuid(),
    //             'code' => Refgenerate(Reservation::class, 'RES', 'code'),
    //             // 'code' => 'RES-' . strtoupper(Str::random(6)),
    //             'nom' => $request->nom,
    //             'prenoms' => $request->prenoms,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'appart_uuid' => $request->appart_uuid,
    //             'sejour' => $request->is_hourly ? 'Heure' : 'Jour',
    //             'start_time' => $request->start_time,
    //             'end_time' => $request->end_time,
    //             'nbr_of_sejour' => $request->is_hourly ? $request->hours : $request->days,
    //             'total_price' => $request->total_price,
    //             'unit_price' => $request->unit_price,
    //             'statut_paiement' => 'payé',
    //             'status' => 'confirmé',
    //             'notes' => $request->notes,
    //             'payment_method' => $request->payment_method,
    //             'custom_tarif' => $request->custom_tarif ?? false,
    //             'payment_amount' => $request->payment_amount
    //         ]);

    //         // Générer le PDF
    //         $pdfUrl = $this->generateReceiptPDF($reservation);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Réservation enregistrée avec succès',
    //             'reservation' => $reservation,
    //             'pdf_url' => $pdfUrl
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Erreur lors de l\'enregistrement',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

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

    // private function generateReceiptPDF($reservation)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $data = [
    //         'reservation' => $reservation,
    //         'date' => now()->format('d/m/Y H:i')
    //         ];

    //         $pdf = Pdf::loadView('reservations.receipt', $data);
            
    //         // Sauvegarder le PDF
    //         $externalUploadDir = base_path(env('STORAGE_FILES'));
            
    //         $directory = 'receipts';
    //         if (!is_dir($externalUploadDir)) {
    //             mkdir($externalUploadDir, 0777, true);
    //         }

    //         $receiptsFileName = 'Reçu_' . $reservation->code . '_' . $reservation->uuid . '.pdf';
            
    //         $pdf->save($externalUploadDir . $directory . '/', $receiptsFileName);
    //         $pdfPath = "storage/files/{$directory}/{$receiptsFileName}";

    //         // enregistrer le PDF dans la table receipts de base de données
    //         $receipt = receipt::create([
    //             'uuid' => Str::uuid(),
    //             'code' => Refgenerate(receipt::class, 'REC', 'code'),
    //             'reservation_uuid' => $reservation->uuid,
    //             'filename' => $receiptsFileName,
    //             'filepath' => $pdfPath
    //         ]);
    //         DB::commit();
            
    //         return url($pdfPath);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Une erreur s’est produite lors de la generation du PDF',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
        
    // }

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

    // public function downloadReceipt($uuid)
    // {
    //     $reservation = Reservation::with('receipt')->where('uuid', $uuid)->firstOrFail();
    //     $directory = 'receipts/';
    //     if (!$reservation->receipt) {
    //         $this->generateReceiptPDF($reservation);
    //         $reservation->load('receipt');
    //     }

    //     $externalStorageDir = base_path(env('STORAGE_FILES', '../public_html/uploads/'));
    //     $filePath = $externalStorageDir . $directory;
        
    //     if (!file_exists($filePath)) {
    //         $this->generateReceiptPDF($reservation);
    //         $reservation->load('receipt');
    //         $filePath = $externalStorageDir . $directory;
    //     }
        
    //     if (!file_exists($filePath)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Fichier PDF introuvable'
    //         ], 500);
    //     }
    //     return response()->download(url($reservation->receipt->filepath));
    // }

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


    // public function confirmReservation($uuid){

    //     DB::beginTransaction();
    //     try {
            
    //         $reservation = Reservation::where('uuid', $uuid)->first();
    //         $reservation->status = 'confirmed'; 
    //         if (!$reservation) {
    //             return response()->json([
    //                 'type' => 'error',
    //                 'success' => false,
    //                 'code' => 404,
    //                 'message' => 'Reservation introuvable',
    //                 'urlback' => '',
    //             ]);
    //         };
    //         DB::commit();
    //         $emailSubject = "✅ Réservation Confirmée";
    //         $message = ``;

    //         $emailData = [
    //             'message' => $message,
    //             'url' => url($reservation->receipt->filepath),
    //             'buttonText' => 'Télécharger le reçu',
    //         ];

    //         Mail::to($reservation->email)->send(new reservatierNotifier($emailData, $emailSubject));
            
    //         return response()->json([
    //             'type' => 'success',
    //             'success' => true,
    //             'code' => 200,
    //             'urlback' => 'back',
    //             'message' => 'La reservation a bien ete confirmer',
    //         ]);
        
    //     }catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'type' => 'error',
    //             'success' => false,
    //             'code' => 500,
    //             'urlback' => '',
    //             'message' => 'Une erreur est survenue lors de la confirmation de la reservation',
    //         ]);
    //     }

    // }


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
    public function show($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée'], 404);
        }

        return response()->json(['success' => true, 'data' => $reservation]);
    }
    public function showPartner($uuid)
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
