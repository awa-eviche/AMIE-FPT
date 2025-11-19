<?php

namespace App\Services;

class DocumentService{
    public function preparerFiles($documents){
        $filesOne = [];
        // foreach ($documents as $document) {
        //     $filesOne[] = storage_path("app/public/{$document->lien_ressource}");
        // }
        // $files = collect($filesOne)->map(function ($file) {
        //     return new \Illuminate\Http\UploadedFile(
        //         $file,
        //         basename($file)
        //     );
        // });
        foreach ($documents as $key => $document) {
            $files[] = "app/public/{$document->lien_ressource}";
        }

        return $files;
    }
}
