<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Autorisation</title>
    <style>
      

        .bold-exo {
            font-family: ExoBold!important;
        }

        body {
            font-family: "ExoRegular"!important;
        }

        .border-td {
            border: 1px solid black;
            padding: .2em;
        }

        .bg-grey {
            background-color: grey;
            color: black;
        }

        .full-table {
            width: 100%;
        }

        .head {
            display: block;
        }

        .logo, .emptySpaceHeader, .details {
            vertical-align: top;
            display: inline-block;
        }

        .logo {
            width: 45%;
        }

        .img-logo {
            border: 1px solid transparent;
            border-radius: 100%;
        }

        .details {
            width: 45%;
        }

        .emptySpaceHeader {
            width: 20%;
        }

        .bill {
            width: 34%;
            margin-top: 1.5rem;
        }

        .bold {
            font-weight: bold;
            font-family: ExoBold!important;
        }

        .p-small {
            margin-top: .5rem;
            margin-bottom: .5rem;
        }

        .footer {
            position: absolute;
            bottom: .2rem;
            text-align: center;
        }

        .centered {
            text-align: center;
        }

        .dotted-line {
            width: 15%;
            height: 1px;
            border-bottom: 1px dotted black;
            margin: 10px auto;
        }
        @page {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill-opacity="0.1"><text x="10" y="50" font-family="Arial" font-size="12" fill="red">ACCEPTE</text></svg>');
            background-repeat: repeat;
        }
    </style>
</head>
<body class="tiny-font">
    <div class="head">
        <div class="centered">
            <strong>MINISTERE DE LA FORMATION PROFESSIONNELLE ET TECHNIQUE</strong>
        </div>
        <div class="dotted-line"></div>
        <div class="centered">
            <strong class="bold-exo">{{ $demande->etablissement->nom ?? " - "  }}</strong><br>
            <strong>TEL : </strong><strong class="bold-exo">{{ $demande->etablissement->telephone ?? " - "  }}</strong><br>
            <strong>EMAIL : </strong><strong class="bold-exo">{{ $demande->etablissement->email ?? " - "  }}</strong><br>

        </div>
        <div class="dotted-line"></div>
        <div class="centered">
            Etablissement : <strong class="bold-exo">{{ $demande->etablissement->type ?? " - "  }}</strong>
        </div>
        <div class="dotted-line"></div>
      {{-- <div class="centered">
            Statut juridique : <strong class="bold-exo">{{ $demande->etablissement->statutJuridique ?? " - "  }}</strong>
        </div> --}} 
        <div class="border-td bg-grey bold-exo centered">
            <span>{{ $demande->typeDemande->libelle ?? " - " }}</span><br>
            Numéro de demande <strong class="bold-exo">{{ $demande->libelle ?? " - " }}</strong>
        </div>
        <div class="emptySpaceHeader"></div>
        <div>
            <strong class="bold-exo">Prénom & Nom :</strong>
            <span class="bold-exo">{{ $demande->demandeur->nom . ' '.  $demande->demandeur->prenom ?? " - " }}</span>

            <div>
                <strong class="bold-exo">Date de la demande  :</strong>
                <span class="bold-exo">{{date('d-m-Y',strtotime($demande->date_depot) ?? " ")}}</span>
            </div>
           
            <div>
                <strong class="bold-exo">Email :</strong>
                <span class="bold-exo">{{ $demande->demandeur->email  ?? " - " }}</span>
            </div>
        </div>
 
    </div>

 
    <div style="width: 100%; margin: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 20px; border-radius: 8px; border: 2px solid #ccc;">
        <div style="padding: 16px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="font-weight: bold; font-size: 1.5rem; padding: 1rem;" colspan="2">Demande: <span style="color: green;">ACCEPTE</span></th>
                    </tr>
                </thead>
                <tbody>
                    @if(($demande->typeDemande->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT')) || 
                    ($demande->typeDemande->code == config('constants.requests.D-RECONNAISSANCE') || 
                    ($demande->typeDemande->code == config('constants.requests.D-EXTENSION-FILIERE'))))
                    @foreach($demande->projets as $projet)
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Filière :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->filiere->nom ?? " - " }}</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Niveau :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->niveau->nom ?? " - " }}</span></td>
                    </tr>
                    @endforeach
                    @endif
                    @if($demande->typeDemande->code == config('constants.requests.D-AUTORISATION-DIRIGER'))
                    @foreach($demande->projets as $projet)
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Nom :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->nom ?? " - " }}</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Prénom :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->prenom ?? " - " }}</span></td>
                    </tr>
                    @endforeach
                    @endif
                    @if($demande->typeDemande->code == config('constants.requests.D-CHANGEMENT-DENOMINATION'))
                    @foreach($demande->projets as $projet)
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Ancienne dénomination :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->ancienne_denomination_etablissement ?? " - " }}</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Nouvelle dénomination :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->nouvelle_denomination_etablissement ?? " - " }}</span></td>
                    </tr>
                    @endforeach
                    @endif
                    @if($demande->typeDemande->code == config('constants.requests.D-TRANSFERT-ETABLISSEMENT'))
                    @foreach($demande->projets as $projet)
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Ancienne adresse :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->ancienne_adresse_etablissement ?? " - " }}</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Nouvelle adresse :</td>
                        <td style="padding: 0.5rem;"><span>{{ $projet->nouvelle_adresse_etablissement ?? " - " }}</span></td>
                    </tr>
                    @endforeach
                    @endif
                    @if($demande->typeDemande->code == config('constants.requests.D-QUALIFICATION-FILIERE'))
                    @foreach($demande->projets as $projet)
                    <tr>
                        @foreach($projet->aire as $a)
                        <td style="padding: 0.5rem; font-weight: bold;">Filière :</td>
                        <td style="padding: 0.5rem;"><span>{{ $a['filiere'] ?? " - " }}</span></td>
                        <td style="padding: 0.5rem; font-weight: bold;">Niveau :</td>
                        <td style="padding: 0.5rem;"><span>{{ $a['niveau'] ?? " - " }}</span></td>
                        @endforeach
                    </tr>
                    @endforeach
                    @endif
                    @if($demande->typeDemande->code == config('constants.requests.D-SUBVENTION'))
                    @foreach($demande->projets as $projet)
                    <tr>
                        <td style="padding: 0.5rem; font-weight: bold;">Pour l'année académique :</td>
                        <td colspan="3" style="padding: 0.5rem;"><span>{{ $projet->anneeAcademique->annee1 . ' - '. $projet->anneeAcademique->annee2 }}</span></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <footer class="footer" align="center">
        <small></small>
    </footer>
</body>
</html>
