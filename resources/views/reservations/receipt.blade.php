<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de Réservation</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
        }
        .title { 
            font-size: 24px; 
            font-weight: bold; 
            color: #dc3545;
            margin: 10px 0;
        }
        .section { 
            margin-bottom: 20px; 
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .section-title { 
            font-size: 18px;
            font-weight: bold; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #dc3545;
        }
        .info-row { 
            display: flex; 
            margin-bottom: 8px; 
            font-size: 14px;
        }
        .info-label { 
            width: 150px; 
            font-weight: bold; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold;
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 12px;
            color: #666;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header" style="width: 30%; margin: 0 auto">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path("assets/images/logo/logo-main.png"))) }}" style="width: 100%" alt="MOKAZ Logo" class="logo">
    </div>
    <div class="header">
        <div class="title">Reçu de Réservation</div>
        <div>Date: {{ $date }}</div>
    </div>

    <div class="section">
        <div class="section-title">Informations Client</div>
        <div class="info-row">
            <div class="info-label">Référence:</div>
            <div>{{ $reservation->code }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nom:</div>
            <div>{{ $reservation->prenoms }} {{ $reservation->nom }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div>{{ $reservation->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Téléphone:</div>
            <div>{{ $reservation->phone }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Détails de la Réservation</div>
        @if($reservation->sejour == 'Heure')
            <div class="info-row">
                <div class="info-label">Type:</div>
                <div>Réservation horaire</div>
            </div>
            <div class="info-row">
                <div class="info-label">Arrivée:</div>
                <div>{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Depart:</div>
                {{-- <div>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</div> --}}
                <div>{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Durée:</div>
                <div>{{ $reservation->nbr_of_sejour }} heure(s)</div>
            </div>
        @else
            <div class="info-row">
                <div class="info-label">Type:</div>
                <div>Réservation journalière</div>
            </div>
            <div class="info-row">
                <div class="info-label">Arrivée:</div>
                <div>{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Départ:</div>
                <div>{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nuits:</div>
                <div>{{ $reservation->nbr_of_sejour }}</div>
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Détails de Paiement</div>
        <table>
            <tr>
                <th>Description</th>
                <th>Montant (XOF)</th>
            </tr>
            <tr>
                <td>Prix {{ $reservation->sejour == 'Heure' ? 'horaire' : 'journalier' }}</td>
                <td>{{ number_format($reservation->unit_price, 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>Quantité</td>
                <td>{{ $reservation->nbr_of_sejour }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total à payer</strong></td>
                <td><strong>{{ number_format($reservation->total_price, 0, ',', ' ') }}</strong></td>
            </tr>
            <tr>
                <td>Montant payé</td>
                <td>{{ number_format($reservation->payment_amount, 0, ',', ' ') }}</td>
            </tr>
            <tr>
                <td>Reste à payé</td>
                @php
                    $reste = (float) $reservation->total_price - (float) $reservation->payment_amount;
                @endphp
                <td> {{ number_format($reste, 0, ',', ' ') }} </td>
            </tr>
            {{-- <tr>
                <td>Méthode de paiement</td>
                <td>{{ $reservation->payment_method ?? 'N/A' }}</td>
            </tr> --}}
            <tr>
                <td>Statut</td>
                <td><span style="color: green;">{{ $reservation->statut_paiement == 'paid' ? 'Payé' : 'En attente de paiement' }}</span></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Merci pour votre réservation !</p>
        <p>Pour toute question, contactez-nous à contact@example.com</p>
    </div>
</body>
</html>