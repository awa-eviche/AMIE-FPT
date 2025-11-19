<!-- resources/views/pdf/example.blade.php -->
<!-- resources/views/pdf/recepisse.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récepissé de Dépôt - {{ uniqid() }}</title>

    <!-- Ajoutez ici vos styles personnalisés -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .content {
            margin-top: 20px;
        }

        /* Ajoutez d'autres styles selon vos besoins */
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <p class="title">Récepissé de Dépôt de demande</p>
            <p>{{ date('d-m-Y') }}</p>
        </div>

        <div class="content">
            <p>
                Bonjour {{$demande->entreprise->user->prenom}} {{ $demande->entreprise->user->prenom}},
            </p>

            <p>
                Nous avons bien reçu votre demande le {{ date('d-m-Y', strtotime($demande->date_depot)) }}.
                Un accusé de réception officiel est joint à ce document.
            </p>

            <p>
                Le delai de traitement est de : 10 jour pour CI et 21 pour EFE
            </p>

            <p>
                Merci de votre coopération.
            </p>

            <p>Cordialement,</p>
            <p>APIX</p>
        </div>
    </div>

</body>
</html>

