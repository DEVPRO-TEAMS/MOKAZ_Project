<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre réservation - MOKAZ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 650px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: #fff;
            text-align: center;
            padding: 30px 20px;
        }
        .header img.logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 20px;
            margin-top: 10px;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .reservation-code {
            background: #f8f9fa;
            border: 2px dashed #dc3545;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
        }
        .reservation-code h2 {
            color: #dc3545;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .info-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .info-section h3 {
            color: #dc3545;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        .info-section .icon {
            margin-right: 8px;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
            text-align: right;
        }
        .highlight-dates {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .highlight-dates h3 {
            margin-top: 0;
            color: white;
        }
        .date-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .price-summary {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .price-summary h3 {
            color: #856404;
            margin-top: 0;
        }
        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
            margin: 15px 0;
        }
        .status-paid {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .status-partial {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .important-note {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .important-note h4 {
            color: #0c5460;
            margin-top: 0;
        }
        .contact-info {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .footer a {
            color: #dc3545;
            text-decoration: none;
        }
        .btn-download {
            background-color: #dc3545;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin: 15px auto;
            font-weight: bold;
            text-align: center;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 5px;
            }
            .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
     @php
        \Carbon\Carbon::setLocale('fr');
    @endphp
    <div class="email-container">
        <div class="header">
            <img src="{{ url('assets/images/logo/logo-main.png')}}" alt="MOKAZ Logo" class="logo">
            <h1>Réservation 
                @if($emailData['status'] == 'confirmed')
                    confirmée
                @elseif($emailData['status'] == 'pending')
                    en attente de confirmation
                @elseif($emailData['status'] == 'cancelled')
                    annulée
                @elseif($emailData['status'] == 'reconducted')
                    reconduite
                @endif
            </h1>
            <div class="status-badge">
                Statut: @if($emailData['status'] == 'confirmed')
                    confirmé
                @elseif($emailData['status'] == 'pending')
                    en attente de confirmation
                @elseif($emailData['status'] == 'cancelled')
                    annulé
                @elseif($emailData['status'] == 'reconducted')
                    reconduit
                @endif
            </div>
        </div>
        {!! $emailData['message'] ?? '' !!}

        <!-- Pied de page -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                © {{ date('Y') }} MOKAZ by jsbey — Tous droits réservés
            </p>
            <p style="margin: 0; font-size: 12px;">
                <a href="#">Mentions légales</a> |
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Conditions d'utilisation</a>
            </p>
            <p style="margin: 10px 0 0 0; font-size: 12px; color: #adb5bd;">
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.<br>
                Code de réservation : {{ $emailData['code'] ?? '' }}
            </p>
        </div>
    </div>
</body>
</html>