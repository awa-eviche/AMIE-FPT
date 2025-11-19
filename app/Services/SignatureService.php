<?php

namespace App\Services;

use App\Enums\EtatTransactionEnum;
use App\Models\Document;
use App\Models\SignatureTransaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SignatureService
{
    public function signerDocument(Document $document, User $user){
        try {
            $documentPath = storage_path("app/public/{$document->lien_ressource}");
            $signatureServiceURL = "https://sign.sentrust.sn/invitation/geturlsentrustTestApix.php";

            $httpClient = Http::withBasicAuth("apix@apix.sn", "Passer123");


            $response = $httpClient->attach('idFiles1', file_get_contents($documentPath), $document->nom)
                ->attach('choix', 1)
                ->attach('firstname1', $user->prenom)
                ->attach('lastname1', $user->nom)
                ->attach('email1', $user->email)
                ->attach('phone1', $user->telephone)
                ->attach('profile', "default")
                ->attach('numero_page', 1)
                ->attach('current-page', 1)
                ->attach('X1', 480)
                ->attach('Y1', 100)
                ->withOptions([
                    'verify' =>  false,

                ])
                ->post($signatureServiceURL);

            // Traitement de la réponse XML


            $xmlResponse = simplexml_load_string($response->body());

            // Extraction des éléments nécessaires
            $code = (string) $xmlResponse->recuperation->Code;

            // Vérification du code de réponse
            if ($code === '200') {
                $url = (string) $xmlResponse->recuperation->URL;
                $idTransaction = (string) $xmlResponse->recuperation->IdTransaction;

                return [
                    'success' => true,
                    'url' => $url,
                    'idTransaction' => $idTransaction,
                ];
            } else {
                // Gérez les autres codes de réponse en conséquence
                return [
                    'success' => false,
                    'message' => $response,
                ];
            }
        } catch (\Exception $e) {
            // Gérez l'erreur et retournez une réponse appropriée
            return [
                'success' => false,
                'message' => 'Erreur lors de la signature : ' . $e->getMessage(),
            ];
        }
    }

    public function recupererDocument($lien){
        try {
            $response = Http::get($lien);
            if ($response->successful()) {
                // Extraire le nom du fichier du lien
                $nomFichier = basename($lien);
                return [
                    "success"=> true,
                    "document"=> $response->body()
                ];
            } else {
                return [
                    "success"=> false,
                ];
            }

        } catch (\Throwable $th) {
            return [
                "success"=> false,
            ];
        }
    }

    public function verifierStatut($idTransaction){
        try {
            $statutUrl = "https://sign.sentrust.sn/invitation/statusApix.php";

            $httpClient = Http::withBasicAuth("apix@apix.sn","Passer123");


            $response = $httpClient->attach('idTransaction', $idTransaction)
            ->withOptions([
                'verify' =>  false,

            ])
            ->post($statutUrl);

            $xmlResponse = simplexml_load_string($response->body());


            $code = (string) $xmlResponse->recuperation->Code;

            // Vérification du code de réponse
            if ($code === '1') {
                $prenom = (string) $xmlResponse->recuperation->prenom;
                $nom = (string) $xmlResponse->recuperation->nom;
                $email = (string) $xmlResponse->recuperation->email;
                // Traitement en cas de succès
                return [
                    'est_signe' => false,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'email' => $email,
                ];
            } else {
                // Gérez les autres codes de réponse en conséquence
                $lien = (string) $xmlResponse->recuperation->docSigne;

                return [
                    'est_signe' => true,
                    'lien_document' => $lien,
                ];
            }


        } catch (\Throwable $th) {
            throw new Exception("Un problème inattendu !");
        }
    }

}
