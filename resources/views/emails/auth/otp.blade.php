<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0284c7;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .otp-code {
            background-color: #e0f2fe;
            color: #0284c7;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            letter-spacing: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        @media only screen and (max-width: 480px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .header h1 {
                font-size: 20px;
            }
            .otp-code {
                font-size: 24px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Code de vérification</h1>
        </div>
        
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez demandé un code de vérification pour votre compte. Veuillez utiliser le code suivant pour compléter votre demande :</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <p>Ce code est valable pendant 10 minutes. Si vous n'avez pas demandé ce code, vous pouvez ignorer cet email.</p>
            <p>Pour des raisons de sécurité, ne partagez jamais ce code avec quelqu'un d'autre.</p>
        </div>
        
        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
