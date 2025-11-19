<?php
namespace App\Repositories;

use App\Models\CategoryFile;
use App\Models\Fichier;
use Illuminate\Support\Facades\Auth;

final class CategoryFichiersRepository extends ResourceRepository
{

    public function __construct(){}

    public function index(){

        $categoryFiles = CategoryFile::query()->orderBy('created_at','desc')->paginate(10);
        return $categoryFiles;
        
    }

    public function addCategory($request){
        $userAuth = Auth::user();
        CategoryFile::create([
            'libelle'=>$request->libelle,
            'access'=>[
                "DFPT"=>$request->DFPT,
                "EFPT"=>$request->EFPT,
                "IA"=>$request->IA,
            ],
            'user_id'=>$userAuth->id,
        ]);

    }

    

    public function addFichier($request){
        $user = Auth::user();
        $documentName = time().'.'.$request->document->extension();
        $document = $request->document->storeAs('public/document',$documentName,);
        Fichier::create([
            'libelle'=>$request->libelle,
            'document'=>$document,
            'user_id'=>$user->id,
            'category_file_id'=>$request->category_file_id
        ]);

    }
    public function updateCategory($request, $category){
        $category->update([
            'libelle'=>$request->libelle,
            'access'=>[
                "DFPT"=>$request->DFPT,
                "EFPT"=>$request->EFPT,
                "IA"=>$request->IA_IEF,
            ],
        ]);
    }
    public function deleteFichier($fichier){
        $fichier->delete();
    }

    public function deleteCategoryFichier($categoryFichier){
        
        Fichier::destroy($categoryFichier->fichiers()->get());
        $categoryFichier->forceDelete();
    }

    public function updateDocument($request, $fichier){
        $fichier->update([
            'libelle'=>$request->libelle,
        ]);
    }
    
}
