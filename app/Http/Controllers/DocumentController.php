<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\AddDocumentRequest;
use App\Models\CategoryFile;
use App\Models\Fichier;
use App\Repositories\CategoryFichiersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class DocumentController extends Controller
{
    protected $logUserRepository;
  
  
    public  function __construct(private CategoryFichiersRepository $categoryFichiersRepository, LogUserRepository $logUserRepository)
    {
        $this->logUserRepository = $logUserRepository;
    }
    public function index(){
        return view('categoryDocument.index');
    }

    public function create(){
        return view('categoryDocument.create');
    }

    public function addCategory(AddCategoryRequest $request){

        if($request->DFPT==null && $request->EFPT ==null && $request->IA == null){
            return back()->withErrors(['Veuillez choisir des permissions']);
        }
        
           $categorieFichier =  $this->categoryFichiersRepository->addCategory($request);
            $this->logUserRepository->store(['action' => UserAction::AddCategoryFichier, 'model' => Model::CategoryFichier, 'new_object' => json_encode($categorieFichier)]);
            return back()->withMessage('Dossier ajouté');
        
        
    }
    public function addDocument(AddDocumentRequest $request){
        
        $document = $this->categoryFichiersRepository->addFichier($request);
        $this->logUserRepository->store(['action' => UserAction::AddFichier, 'model' => Model::Fichier, 'new_object' => json_encode($document)]);

        return back()->with('message', 'Document ajouté');
    }

    public function updateDocument(Request $request, Fichier $fichier)
{
    $request->validate([
        'libelle'  => ['required','string','max:255'],
        'document' => ['nullable','file','max:10240',
            'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/png,image/jpeg'],
    ]);

    $this->categoryFichiersRepository->updateDocument($request, $fichier);

    return back()->withMessage('Document modifié');
}

    

    public function editeCategory(CategoryFile $categoryFile){
        return view('categoryDocument.edite', compact('categoryFile'));
    }

    public function updateCategory(AddCategoryRequest $request, CategoryFile $categoryFile){
        $this->categoryFichiersRepository->updateCategory($request,$categoryFile);
        return redirect()->route('document.category')->withMessage('Dossier modifié');
    }

    public function show(CategoryFile $categoryFile){
        return view('categoryDocument.show',compact('categoryFile'));
    }
    public function deleteFichier(Fichier $fichier){
        $this->logUserRepository->store([
            'action' => UserAction::DeleteFichier, 'model' => Model::Fichier,
            'old_object' => json_encode($fichier)
        ]);
        $this->categoryFichiersRepository->deleteFichier($fichier);
        return back()->withMessage('Document supprimé');
    }

    public function deleteCategoryFichier(CategoryFile $categoryFile){
        $this->logUserRepository->store([
            'action' => UserAction::DeleteCategoryFichier, 'model' => Model::CategoryFichier,
            'old_object' => json_encode($categoryFile)
        ]);
        $this->categoryFichiersRepository->deleteCategoryFichier($categoryFile);
        return back()->withMessage('Dossier supprimé');
    }
    // public function downloadFile($id){
    //     $path = Fichier::where("id", $id)->value("document");
    //     dd(Storage::get($path));
    //     return Storage::get($path);
    //   }
    
}
