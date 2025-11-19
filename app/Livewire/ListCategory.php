<?php

namespace App\Livewire;

use App\Models\CategoryFile;
use App\Repositories\CategoryFichiersRepository;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Nette\Utils\Arrays;

class ListCategory extends Component
{
    use WithPagination;
    public string $search = "";
    public $fichiers =[] ;
    public $path;
    public $libelle;
    public $libelleDocument;
    public $idDocument;
    public $nameCategory;
    public $idCategory;
    public $editDocument = false;
    public $deleteDocument;
    public $typeUser;
    public $access;
    public $accessDelete;
    public $accessUpdate;
    public ?string $currentDocUrl = null;

    public function delete($id){
        $this->deleteDocument =true;
        $this->idDocument = $id;
    }

    public function edit( $id,$libelleDocument){
        $this->path = null;
        $this->editDocument =true;
        $this->idDocument = $id;
        $this->libelleDocument = $libelleDocument;
    }
    public function resetAll(){
        $this->search = "";

        $this->resetPage();
    }
    public function getFileCategory(int $categoryId): void
    {
        // Reset UI
        $this->editDocument   = false;
        $this->deleteDocument = false;
        $this->path    = null;
        $this->libelle = null;
    
        $cat = CategoryFile::with('fichiers')->findOrFail($categoryId);
    
        $this->idCategory   = $cat->id;
        $this->nameCategory = $cat->libelle;
    
        // Accès sécurisés (évite "Undefined index")
        $this->access  = is_array($cat->access) ? $cat->access : [];
        $allowed       = (array) data_get($this->access, $this->typeUser, []);
    
        $this->accessUpdate = ($this->typeUser === 'DFPT' || in_array('Modifier', $allowed, true)) ? 'Modifier'  : '';
        $this->accessDelete = ($this->typeUser === 'DFPT' || in_array('Supprimer', $allowed, true)) ? 'Supprimer' : '';
    
        // Fichiers → array simple (robuste pour Livewire)
        $this->fichiers = $cat->fichiers->map(fn ($f) => [
            'id'       => (int) $f->id,
            'libelle'  => (string) $f->libelle,
            'document' => (string) $f->document, // chemin storage (pas URL)
            'user_id'  => $f->user_id ? (int) $f->user_id : null,
        ])->values()->toArray();
    }
    
   

protected function toPublicUrl(string $path): string
{
    // normalise: enlève 'public/' si présent, car disk('public')->url() le rajoute
    $relative = ltrim(preg_replace('#^public/#', '', $path), '/');
    return Storage::disk('public')->url($relative); // => /storage/relative/path
}

public function getpath($pathParameter = null, $libelle = null): void
{
    $this->deleteDocument = null;
    $this->libelle = $libelle;

    if (!is_string($pathParameter) || $pathParameter === '') {
        $this->path = null;
        return;
    }

    // 1) URL absolue (http/https) -> on garde
    if (str_starts_with($pathParameter, 'http://') || str_starts_with($pathParameter, 'https://')) {
        $this->path = $pathParameter;
        return;
    }

    // 2) URL publique déjà montée (/storage/...) -> on garde
    if (str_starts_with($pathParameter, '/storage/')) {
        $this->path = $pathParameter;
        return;
    }

    // 3) Chemin de stockage (public/... ou relatif) -> on construit l'URL publique
    $this->path = $this->toPublicUrl($pathParameter);
}
public function download($pathParameter, $libelle)
{
    $ext  = pathinfo((string) $pathParameter, PATHINFO_EXTENSION);
    $name = (string) $libelle . ($ext ? '.'.$ext : '');
    return Storage::download((string) $pathParameter, $name);
}

    public function close(){
        $this->path = "";
        $this->deleteDocument = null;
    }

    public function render()
    {

        $roles =Arr::pluck(Auth::user()->roles, 'name') ;

        if (in_array('superadmin',$roles)) {
            $this->typeUser ="DFPT";
            $categoryFiles = CategoryFile::query()->orderBy('created_at','desc')
                            ->orWhere('libelle', 'like', "%{$this->search}%")
                            ->get();
            return view('livewire.CategoryFile.list-category',compact(
                'categoryFiles'
            ));
        }
        if (in_array('ia',$roles)) {
            $this->typeUser ="IA";
            return view('livewire.CategoryFile.list-category',
            ['categoryFiles'=>CategoryFile::query()->orderBy('created_at','desc')
            ->orWhere('libelle', 'like', "%{$this->search}%")
            ->get()
            ->filter(function($categoryFile){
                return collect($categoryFile->access["IA"])->contains('voir') == true;

                })->sort()
            ]
        );
        }

        if (in_array('ia',$roles) ==false && in_array('superadmin',$roles)==false) {
            $this->typeUser ="EFPT";
            return view('livewire.CategoryFile.list-category',
            ['categoryFiles'=>CategoryFile::query()->orderBy('created_at','desc')
            ->orWhere('libelle', 'like', "%{$this->search}%")
            ->get()
            ->filter(function($categoryFile){
                return collect($categoryFile->access["EFPT"])->contains('voir') == true;

                })->sort()
            ]
        );
        }

    }
}
