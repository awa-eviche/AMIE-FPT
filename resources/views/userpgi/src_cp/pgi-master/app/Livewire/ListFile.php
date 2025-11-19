<?php

namespace App\Livewire;

use App\Models\Fichier;
use Livewire\Component;
use Livewire\WithPagination;

class ListFile extends Component
{
    use WithPagination;
    // public string $searchFile = "";
    // public int $category_id;
    // //public $files;

    // public function update(){
    //     $this->files = Fichier::where('category_file_id',$this->category_id)
    //     ->orderBy('created_at','desc')
    //     ->orWhere('libelle', 'like', "%{$this->search}%")   
    //     ->paginate(10);
    // }
    
    public function render()
    {
        // $files = Fichier::query()
        //         ->orderBy('created_at','desc')
        //         //->orWhere('libelle', 'like', "%{$this->search}%")   
        //         ->paginate(10);
        return view('livewire.categoryFile.file.list-file');
    }
}
