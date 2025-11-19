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

    public function getFileCategory($categoryFile, $accessFile){
        $this->accessUpdate = "";
        $this->accessDelete = "";

        if($this->typeUser =="DFPT"){
            $this->accessUpdate = "Modifier";
            $this->accessDelete = "Supprimer";
        }else{
            if ($this->typeUser =="FPT"){

            }
            if (in_array('Modifier',$accessFile[$this->typeUser])) {
            $this->accessUpdate ="Modifier";

            }
            if (in_array('Supprimer',$accessFile[$this->typeUser])) {
                $this->accessDelete ="Supprimer";

            }


        }
        $this->access =  $accessFile;
        $this->fichiers =$categoryFile;
    }

    public function getpath($pathParameter, $libelle){
        $this->deleteDocument = null;
        $this->path = $pathParameter;
        $this->libelle = $libelle;
    }

    public function download($pathParameter, $libelle){
        $extension =pathinfo($pathParameter)['extension'];
        return Storage::download($pathParameter, $libelle.'.'.$extension);
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
