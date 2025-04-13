<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réception</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        table {
            table-layout: fixed;
            width: 100%;
            max-width: 600px;
            border-collapse: collapse;
        }
        table.container {
            margin: 10px auto;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        td {
            padding: 10px;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0284c7;
        }
        .header h1 {
            color: #0284c7;
            font-size: 20px;
            margin: 0;
        }
        .content p {
            margin: 0 0 6px;
            width: 100%;
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
            font-size: 14px;
            overflow: hidden;
        }
        .contact-details {
            background-color: #f0f9ff;
            border-left: 4px solid #0284c7;
            margin: 10px 0;
        }
        .contact-details h3 {
            margin: 0 0 6px;
            color: #0284c7;
            font-size: 14px;
        }
        .message-content {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            margin: 10px 0;
            max-height: 250px;
            overflow-y: auto;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }
        .message-content h3 {
            margin: 0 0 6px;
            font-size: 14px;
        }
        .message-text {
            width: 100%;
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
            overflow: hidden;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 0 0 4px;
        }
        @media only screen and (max-width: 640px) {
            table.container {
                margin: 5px auto;
                border: none;
            }
            td {
                padding: 8px;
            }
            .header h1 {
                font-size: 16px;
            }
            .contact-details h3, .message-content h3 {
                font-size: 12px;
            }
            .content p, .contact-details p, .message-content p {
                font-size: 12px;
            }
            .contact-details, .message-content {
                margin: 8px 0;
            }
            .message-content {
                max-height: 150px;
            }
            .footer {
                font-size: 9px;
            }
        }
    </style>
</head>
<body>
<table role="presentation" class="container" width="600" style="width: 100%; max-width: 600px; margin: 10px auto; background-color: #f9f9f9; border: 1px solid #ddd; table-layout: fixed;">
    <tr>
        <td style="padding: 10px; width: 100%; max-width: 600px; overflow: hidden;">
            <table role="presentation" class="header" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding-bottom: 8px; width: 100%; max-width: 100%;">
                        <h1 style="color: #0284c7; font-size: 20px; margin: 0;">Confirmation de réception</h1>
                    </td>
                </tr>
            </table>

            <table role="presentation" class="content" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Bonjour {{ $contact->name ?? 'Utilisateur' }},</p>
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Nous avons bien reçu votre message et nous vous remercions de nous avoir contactés.</p>

                        <table role="presentation" class="contact-details" style="width: 100%; max-width: 100%; table-layout: fixed;">
                            <tr>
                                <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                                    <h3 style="margin: 0 0 6px; color: #0284c7; font-size: 14px;">Récapitulatif de votre message</h3>
                                    <p style="margin: 3px 0; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">
                                        <strong>Sujet :</strong> {{ Str::limit($contact->subject ?? 'Sans sujet', 20) }}
                                    </p>
                                    <p style="margin: 3px 0; width: 100%; max-width: 100%; font-size: 14px;">
                                        <strong>Date d'envoi :</strong> {{ $contact->created_at ? $contact->created_at->format('d/m/Y H:i') : 'Non disponible' }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" class="message-content" style="width: 100%; max-width: 100%; table-layout: fixed; max-height: 250px; overflow-y: auto; overflow-x: hidden; border: 1px solid #e5e7eb; margin: 10px 0; background-color: #ffffff;">
                            <tr>
                                <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                                    <h3 style="margin: 0 0 6px; font-size: 14px;">Votre message</h3>
                                    <div class="message-text" style="width: 100%; max-width: 100%; overflow-wrap: break-word; word-wrap: break-word; overflow: hidden; font-size: 14px;">
                                        {!! nl2br(e(Str::limit($contact->message ?? 'Aucun message', 500))) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Je lirai personnellement votre message et vous répondrai dans les meilleurs délais.</p>
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Cordialement,</p>
                        <p style="margin: 0; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;"> Djiepmo Marc</p>
                    </td>
                </tr>
            </table>

            <table role="presentation" class="footer" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                        <p style="margin: 0 0 4px; font-size: 10px;">Cet email est une confirmation automatique, merci de ne pas y répondre.</p>
                        <p style="margin: 0; font-size: 10px;">© {{ date('Y') }} {{ config('app.name', 'Votre Site') }}. Tous droits réservés.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>