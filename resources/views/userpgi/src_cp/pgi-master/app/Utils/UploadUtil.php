<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadUtil
{
    const AVATAR_USER_PATH = '/avatars';
    const IMPORT_PATH = '/imports';
    const FRONT_SLIDER_PATH = '/front/sliders';
    const FRONT_ACTU_PATH = '/front/actualites';
    const DEFAULT_PATH = '/default';
    protected $repertoire;

    public function __construct()
    {
        $this->repertoire = self::AVATAR_USER_PATH;
    }

    public function traiterFile($fichier, $mode = 'avatar', $disk = 'public')
    {
        if ($mode != 'avatar')
            $this->repertoire = $this->selectPath($mode);
        if ($mode == 'projet')
            $this->repertoire = '/projets';
        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . Str::random(32) . '.' . $fichier->getClientOriginalExtension();
        Storage::disk($disk)->putFileAs($this->repertoire, $fichier, $name);
        return $name;
    }

    public function deleteFile($nom, $mode = 'avatar', $disk = 'public')
    {
        if ($mode != 'avatar')
            $this->repertoire = $this->selectPath($mode);

        //Suppression du fichier
        $file = $this->repertoire . '/' . $nom;

        if (Storage::disk($disk)->exists($file)) {
            Storage::disk($disk)->delete($file);
            return true;
        }
        return false;
    }

    private function selectPath($mode)
    {
        switch ($mode) {
            case 'avatar' :
                return self::AVATAR_USER_PATH;
            case 'import' :
                return self::IMPORT_PATH;
                break;
            case 'slider' :
                return self::FRONT_SLIDER_PATH;
                break;
            case 'actualite' :
                return self::FRONT_ACTU_PATH;
                break;
            default:
                return self::DEFAULT_PATH;
        }
    }

}
