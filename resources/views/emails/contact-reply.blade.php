<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre message</title>
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
        }
        table.container {
            margin: 10px auto;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        td {
            width: 100%;
            max-width: 100%;
            padding: 10px;
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
        .message-details {
            background-color: #f0f9ff;
            border-left: 4px solid #0284c7;
            margin: 10px 0;
        }
        .message-details h3 {
            margin: 0 0 6px;
            color: #0284c7;
            font-size: 14px;
        }
        .reply-content {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            margin: 10px 0;
        }
        .reply-content h3 {
            margin: 0 0 6px;
            font-size: 14px;
        }
        .original-message {
            background-color: #f3f4f6;
            border-left: 4px solid #9ca3af;
            margin: 10px 0;
            font-style: italic;
        }
        .original-message h3 {
            margin: 0 0 6px;
            font-size: 14px;
        }
        .message-text {
            width: 100%;
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
            overflow: hidden;
        }
        .attachment {
            margin-top: 6px;
            overflow: hidden;
        }
        .attachment span {
            margin-right: 6px;
            font-size: 13px;
        }
        .attachment a {
            color: #0284c7;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 80%;
            display: inline-block;
            vertical-align: middle;
            font-size: 13px;
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
            .message-details h3, .reply-content h3, .original-message h3 {
                font-size: 12px;
            }
            .content p, .message-details p, .reply-content p, .original-message p {
                font-size: 12px;
            }
            .message-details, .reply-content, .original-message {
                margin: 8px 0;
            }
            .attachment span {
                font-size: 11px;
            }
            .attachment a {
                max-width: 70%;
                display: block;
            }
            .footer {
                font-size: 9px;
            }
        }
    </style>
</head>
<body>
<!--[if mso]><table role="presentation" width="600" align="center"><tr><td><![endif]-->
<table role="presentation" class="container" width="600" style="width: 100%; max-width: 600px; margin: 10px auto; background-color: #f9f9f9; border: 1px solid #ddd; table-layout: fixed;">
    <tr>
        <td style="padding: 10px; width: 100%; max-width: 600px; overflow: hidden;">
            <table role="presentation" class="header" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding-bottom: 8px; width: 100%; max-width: 100%;">
                        <h1 style="color: #0284c7; font-size: 20px; margin: 0;">Réponse à votre message</h1>
                    </td>
                </tr>
            </table>

            <table role="presentation" class="content" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Bonjour {{ $contact->name ?? 'Utilisateur' }},</p>
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Merci d'avoir pris contact avec nous. Voici notre réponse à votre message :</p>

                        <table role="presentation" class="message-details" style="width: 100%; max-width: 100%; table-layout: fixed;">
                            <tr>
                                <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                                    <h3 style="margin: 0 0 6px; color: #0284c7; font-size: 14px;">Détails de votre message</h3>
                                    <p style="margin: 3px 0; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">
                                        <strong>Sujet :</strong> {{ Str::limit($contact->subject ?? 'Sans sujet', 20) }}
                                    </p>
                                    <p style="margin: 3px 0; width: 100%; max-width: 100%; font-size: 14px;">
                                        <strong>Envoyé le :</strong> {{ $contact->created_at ? $contact->created_at->format('d/m/Y à H:i') : 'Non disponible' }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" class="reply-content" style="width: 100%; max-width: 100%; table-layout: fixed;">
                            <tr>
                                <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                                    <h3 style="margin: 0 0 6px; font-size: 14px;">Notre réponse</h3>
                                    <div class="message-text" style="width: 100%; max-width: 100%; overflow-wrap: break-word; word-wrap: break-word; overflow: hidden; font-size: 14px;">
                                        {!! nl2br(e(Str::limit($reply->message ?? 'Aucune réponse', 500))) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" class="original-message" style="width: 100%; max-width: 100%; table-layout: fixed;">
                            <tr>
                                <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                                    <h3 style="margin: 0 0 6px; font-size: 14px;">Votre message original</h3>
                                    <div class="message-text" style="width: 100%; max-width: 100%; overflow-wrap: break-word; word-wrap: break-word; overflow: hidden; font-size: 14px;">
                                        {!! nl2br(e(Str::limit($contact->message ?? 'Aucun message', 500))) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">N'hésitez pas à me contacter à nouveau si vous avez d'autres questions/propositions.</p>
                        <p style="margin: 0 0 6px; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">Cordialement,</p>
                        <p style="margin: 0; width: 100%; max-width: 100%; overflow-wrap: break-word; font-size: 14px;">L'équipe {{ config('app.name', 'Votre Site') }}</p>
                    </td>
                </tr>
            </table>

            <table role="presentation" class="footer" style="width: 100%; max-width: 100%; table-layout: fixed;">
                <tr>
                    <td style="padding: 8px; width: 100%; max-width: 100%; overflow: hidden;">
                        <p style="margin: 0 0 4px; font-size: 10px;">Cet email a été envoyé en réponse à votre message de contact.</p>
                        <p style="margin: 0; font-size: 10px;">© {{ date('Y') }} {{ config('app.name', 'Votre Site') }}. Tous droits réservés.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>