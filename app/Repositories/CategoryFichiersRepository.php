<?php
namespace App\Repositories;

use App\Models\CategoryFile;
use App\Models\Fichier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;  
use Illuminate\Http\Request;   

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

    public function updateDocument(Request $request, Fichier $fichier): Fichier
{
    $fichier->libelle = $request->input('libelle');

    if ($request->hasFile('document')) {
        $disk = config('filesystems.default', 'public');
        $dir  = $fichier->category_file_id ? 'documents/'.$fichier->category_file_id : 'documents';

        $oldPath = $fichier->document;
        $newPath = $request->file('document')->store($dir, $disk);

        $fichier->document = $newPath;

        if ($oldPath && \Storage::disk($disk)->exists($oldPath)) {
            \Storage::disk($disk)->delete($oldPath);
        }
    }

    $fichier->save();
    return $fichier;
}

    
}
