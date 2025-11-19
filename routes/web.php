<?php

use App\Http\Controllers\DemandeController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\FrontAdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MaterielController;
use App\Livewire\Parametrage\ElementCompetence\ElementCompetenceMultiFixed;
//use App\Http\Controllers\FrontController;
use App\Http\Controllers\parametrage\EtatWorkflowController;
use App\Http\Controllers\parametrage\ProfilController;
use App\Http\Controllers\parametrage\SecteurController;
use App\Http\Controllers\parametrage\FiliereController;
use App\Http\Controllers\parametrage\MetierController;
use App\Http\Controllers\parametrage\NiveauEtudeController;
use App\Http\Controllers\parametrage\MatiereController;
use App\Http\Controllers\parametrage\CompetenceController;
use App\Http\Controllers\parametrage\ElementCompetenceController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\TerritoireController;
use App\Http\Controllers\parametrage\TypeNotificationController;
use App\Http\Controllers\parametrage\WorkflowController;
use App\Http\Controllers\PromoteurController;
use App\Http\Controllers\TypeDemandeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\FiliereEtablissementController;
use App\Http\Controllers\NiveauEtudeEtablissementController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\InspecteurController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CritereController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\IaController;
use App\Http\Controllers\IefController;
use App\Http\Controllers\EvaluteController;
use App\Http\Controllers\ReinscriptionController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\parametrage\DiplomeController;
use App\Http\Controllers\IndicateurController;
use App\Http\Controllers\SuiviIndicateurController;
use App\Http\Controllers\TypeIndicateurController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ActualiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasseMatiereFormateurController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/absences/create/{inscription}', [AbsenceController::class, 'create'])->name('absences.create');
Route::post('/absences/store', [AbsenceController::class, 'store'])->name('absences.store');
Route::get('/absences/{inscription_id}', [AbsenceController::class, 'show'])->name('absences.show');
Route::get('absences/{id}/edit', [AbsenceController::class, 'edit'])->name('absences.edit');
Route::put('absences/{id}', [AbsenceController::class, 'update'])->name('absences.update');
Route::resource('critere', CritereController::class);
Route::post('/ressources/store', [RessourceController::class, 'store'])->name('ressources.store');
Route::put('/ressources/{ressource}', [RessourceController::class, 'update'])
    ->name('ressources.update');
Route::get('/', function () {
    $faqs = \App\Models\Faq::orderBy('priority', 'asc')->get();
    $actualites = \App\Models\Actualite::orderBy('id', 'desc')->limit(5)->get();

    return view('welcome',compact('faqs', 'actualites'));
})->name('welcome');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

Route::get('/classe/{classe}/bulletins/pdf', [InscriptionController::class, 'generateClassePdf'])
    ->name('classe.bulletins.pdf');

    // Route::resource('demande', DemandeController::class);
    Route::group(['prefix' => 'demande', 'as' => 'demande.'], function () {
        // Route::get('/test/{id}', [DemandeController::class, "newTest"])->name("demande-test");
        Route::get('/index/{demande}', [DemandeController::class, 'indexRejet'])->name('indexRejet');
        Route::get('/', [DemandeController::class, 'index'])->name('index');
        Route::get('/efpt/{idEtablissement}', [DemandeController::class, 'getRequestByIdEtab'])->name('demandebyEfpt');
        Route::get('/create/{typeDemandeId}', [DemandeController::class, 'create'])->name('create');
        Route::get('/completer/{typeDemandeId}', [DemandeController::class, 'completer'])->name('completer');
        Route::get('/genererRecepisser/{demande}', [DemandeController::class, 'genererRecepisser'])->name('genererRecepisser');
        // Route::post('/', [DemandeController::class, 'store'])->name('store');
        Route::get('/{demande}', [DemandeController::class, 'show'])->name('show');
        Route::get('/{demande}/edit', [DemandeController::class, 'edit'])->name('edit');
        Route::put('/{demande}', [DemandeController::class, 'update'])->name('update');
        Route::delete('/{demande}', [DemandeController::class, 'destroy'])->name('destroy');
        Route::get('/suivant/{id}', [DemandeController::class, 'next'])->name('suivant');
        Route::put('/rejet/{id}', [DemandeController::class, 'rejet'])->name('rejet');
    });
    Route::resource('entreprise', EntrepriseController::class);
    Route::resource('etablissement', EtablissementController::class);
    Route::get('send-acess/{id}',  [EtablissementController::class, 'sendAccountAcces'])->name('etablissement.send');
    Route::get('etablissement-info', [EtablissementController::class, 'schoolInfo']);
    Route::resource('apprenant', ApprenantController::class);
    Route::resource('classe', ClasseController::class);
    Route::resource('ia', IaController::class);
    Route::resource('ief', IefController::class);
    Route::resource('inspecteur', InspecteurController::class);
    Route::resource('inscription', InscriptionController::class);
    Route::post('/apprenants/import/{classe}', [App\Http\Controllers\ApprenantController::class, 'import'])->name('apprenant.import');


    // Route pour les evaluations;
    Route::resource('evaluation', EvaluationController::class);
    Route::get('/evaluation/{inscriptionId}/{matiereId}', [EvaluationController::class, 'create'])->name('evaluation.create');
    Route::post('/evaluation/{inscriptionId}', [EvaluationController::class, 'store'])->name('evaluation.store');
    Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluation.edit');
    Route::put('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluation.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluation.destroy');
    Route::get('/evaluations/{inscription}/pdf', [EvaluationController::class, 'generatePDF'])->name('evaluation.pdf');

 Route::get('/classe/{classe}/admis', [ReinscriptionController::class, 'getAdmis'])->name('classe.admis');
    Route::post('/reinscription', [\App\Http\Controllers\ReinscriptionController::class, 'store'])->name('reinscription.store');
    Route::get('/classe/admis/selection', [ReinscriptionController::class, 'selectClasse'])->name('classe.admis.selector');


    Route::resource('filiereetablissement', FiliereEtablissementController::class);
    Route::resource('niveauetudeetablissement', NiveauEtudeEtablissementController::class);
    Route::get('/niveauetudeetablissement/{id}/view', [NiveauEtudeEtablissementController::class, 'detailProgrammeFormation'])->name('program.view');
    Route::get('/niveauetudeetablissement/{id}/{decision}/{idEtablissement}/treatment', [NiveauEtudeEtablissementController::class, 'validateProgramFormation'])->name('program.validate');
    Route::get('/niveauetudeetablissement/{id}/{idEtablissement}/remove', [NiveauEtudeEtablissementController::class, 'removeProgramFormation'])->name('program.logic.remove');




    // Route::resource('notifications', NotificationController::class);
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/all', [NotificationController::class, 'allNotificaions'])->name('notifications.all');
    });



    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');


    Route::prefix('page-acceuil')->group(function () {

        Route::resource('faqs', FaqController::class);
        Route::resource('actualite', ActualiteController::class);
        Route::post('/publier/{actualite}', [ActualiteController::class, "publier"])->name('actualite.publier');

    });


    Route::get('/actualites', [FrontController::class, 'actualites'])->name('actualites');
    



    Route::prefix('parametrage')
        ->middleware(['permission:gerer_parametrage'])
        ->group(function () {

            Route::resource('profil', ProfilController::class);
            Route::resource('type_notification', TypeNotificationController::class);
            Route::resource('type_demande', TypeDemandeController::class);
            /*  Route::resource('secteur', SecteurController::class);
        Route::resource('filiere', FiliereController::class);
        Route::resource('metier', MetierController::class);
        Route::resource('niveauetude', NiveauEtudeController::class);
        Route::resource('matiere', MatiereController::class);
        Route::resource('diplome',DiplomeController::class);*/


            Route::prefix('workflow')->name('etat_workflow.')->group(function () {
                Route::get('{workflow}/etat_workflow/create', [EtatWorkflowController::class, "create"])->name('create');
                Route::get('/etat_workflow/{etat}', [EtatWorkflowController::class, "show"])->name('show');


                Route::post('etat_workflow', [EtatWorkflowController::class, "store"])->name('store');

                Route::get('etat_workflow/{etat_workflow}/edit', [EtatWorkflowController::class, "edit"])->name('edit');
                Route::put('etat_workflow/{etat_workflow}/update', [EtatWorkflowController::class, "update"])->name('update');
            });
            Route::resource('workflow', WorkflowController::class);
        });



    Route::prefix('referentiel')
        ->middleware(['permission:gerer_parametrage'])
        ->group(function () {
            Route::resource('secteur', SecteurController::class);
            Route::resource('filiere', FiliereController::class);
            Route::resource('metier', MetierController::class);
            Route::resource('niveauetude', NiveauEtudeController::class);
            Route::resource('matiere', MatiereController::class);
            Route::resource('competence', CompetenceController::class);
            Route::resource('elementcompetence', ElementCompetenceController::class);
            Route::resource('diplome', DiplomeController::class);
            Route::resource('region', RegionController::class);
            Route::resource('departement', DepartementController::class);
            Route::resource('commune', CommuneController::class);
            Route::resource('liste', ListeController::class);
            Route::resource('anneeacademique', AnneeAcademiqueController::class);
            Route::resource('typeIndicateur', TypeIndicateurController::class);
        });

    Route::resource('indicateur', IndicateurController::class);
    Route::resource('suiviIndicateur', SuiviIndicateurController::class);


    Route::prefix('promoteur')->group(function () {
        Route::get('/', [PromoteurController::class, "index"])->name('index');
        Route::get('/demandes', [PromoteurController::class, "demandes"])->name('demandes');
        Route::get('/demande/{demande}', [PromoteurController::class, "demande"])->name('demande');
    });
    Route::get('/teste', [TestController::class, 'dropMenu'])->name('teste.dropdown');
});

Route::get('/teste', [TestController::class, 'dropMenu'])->name('teste.dropdown');



/* Espace admin */

/*  Route::prefix('admin')->middleware(['permission:gerer_administration'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users/search/{query?}', [UserController::class, 'index'])->name('users.search');
    Route::get('/users/filter/{role}', [UserController::class, 'searchByRole'])->name('users.filter.role');
    Route::patch('/users/{id}/activitation', [UserController::class, 'activation'])->name('users.activation');
    Route::patch('/users/{id}/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::resource('permissions', PermissionController::class)->only('index', 'edit', 'update');
    Route::resource('roles', RoleController::class)->except('show');
    Route::get('/logs', [UserController::class, 'logs'])->name('users.logs');
    Route::get('/logs/{id}', [UserController::class, 'detailLog'])->name('users.logs.detail');



});*/


Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users/search/{query?}', [UserController::class, 'index'])->name('users.search');
    Route::get('/users/filter/{role}', [UserController::class, 'searchByRole'])->name('users.filter.role');
    Route::patch('/users/{id}/activitation', [UserController::class, 'activation'])->name('users.activation');
    Route::patch('/users/{id}/{action}/restrictAccess', [UserController::class, 'activationEtablissement'])->name('users.activationEtablissement');
    Route::get('/users/access/forum/{id}', [UserController::class, 'accessForum'])->name('users.accessForum');
    // Route::patch('/users/{id}/{action}/restrictAccess', [UserController::class, 'activationInspecteur'])->name('users.activationInspecteur');
    Route::patch('/users/{id}/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::resource('permissions', PermissionController::class)->only('index', 'edit', 'update');
    Route::resource('roles', RoleController::class)->except('show');
    Route::get('/logs', [UserController::class, 'logs'])->name('users.logs');
    Route::get('/logs/{id}', [UserController::class, 'detailLog'])->name('users.logs.detail');
});


Route::prefix('document')->group(function () {
    Route::get('/category', [DocumentController::class, 'index'])->name('document.category');
    Route::get('/create/category', [DocumentController::class, 'create'])->name('create.category');
    Route::post('/store/category', [DocumentController::class, 'addCategory'])->name('add.category');
    Route::post('/create', [DocumentController::class, 'addDocument'])->name('crate.document');
    Route::put('/update/{fichier}', [DocumentController::class, 'updateDocument'])->name('update.document');
    Route::get('/downloadFile/{id}', [DocumentController::class, 'downloadFile'])->name('crate.downloadFile');
    Route::delete('/delete/{fichier}', [DocumentController::class, 'deleteFichier'])->name('delete.document');
    Route::delete('/delete/categoty/{categoryFile}', [DocumentController::class, 'deleteCategoryFichier'])->name('delete.category');

    Route::get('/show/category/{categoryFile}', [DocumentController::class, 'show'])->name('show.category');
    Route::get('/edite/category/{categoryFile}', [DocumentController::class, 'editeCategory'])->name('edite.category');
    Route::put('/update/category/{categoryFile}', [DocumentController::class, 'updateCategory'])->name('update.category');
});



Route::get('/affiche', [DemandeController::class, 'affiche'])->name('affiche');
Route::get('/personnels', [EtablissementController::class, 'getAllPersonnel'])->name('getAllPersonnel');
Route::get('/apprenants', [EtablissementController::class, 'getAllApprenant'])->name('getAllApprenant');

Route::post('/classe/{id}/validated', [ClasseController::class, 'validated'])
    ->name('classe.validate');

//Route::get('/forum', [ForumController::class, 'goToFlarum'])->name('forum');

Route::get('/forum', function () {
    return redirect(config('constants.flarum.url'));
})->name('forum');


Route::get('/request', function () {
    $typeDemande = App\Models\TypeDemande::find(1);
    return view('request', compact('typeDemande'));
})->name('request');

Route::get('/actualites/{id}', [FrontController::class, 'show_actualite'])->name('actualites.show');
Route::get('/front/etablissements', [FrontController::class, 'etablissements'])->name('front.etablissements');
Route::get('/front/programmes', [FrontController::class, 'programmes'])->name('front.programmes');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact-send', [FrontController::class, 'contactSend'])->name('contact.send');

Route::get('/competence/manage', [CompetenceController::class, 'manage'])->name('competence.manage.index');
Route::get('/competence/generate/{inscription}/pdf', [InscriptionController::class, 'generateCompetencePdf'])->name('competence.generate.pdf');
Route::get('/competence/classe/generate/{classe}/pdf', [InscriptionController::class, 'generateCompetenceClassePdf'])->name('competence.classe.generate.pdf');

Route::get('/evaluate/{inscription}', [EvaluteController::class, 'create'])->name('evaluate.create');
Route::post('/evaluate/{inscription}/store', [EvaluteController::class, 'store'])->name('evaluate.store');

Route::get('/auto-redirect-sso', function () {
    // L'utilisateur a le rôle "dage" et vient d'être authentifié
    // On redirige vers l'endpoint OAuth en utilisant le client OAuth créé
    $clientId = 6; // Remplacez par le client_id attribué au client (par ex. 7)
    $redirectUri = 'https://amiefpt.sec.gouv.sn/SYGEP/admin/home/auth/callback';
    $query = http_build_query([
        'client_id'     => $clientId,
        'redirect_uri'  => $redirectUri,
        'response_type' => 'code',
    ]);
    return redirect("/oauth/authorize?$query");
});
Route::middleware(['auth'])->group(function () {
    Route::get('/materiels', [MaterielController::class, 'index'])->name('materiel.index');
});
Route::get('/elementcompetence/multiple/create', ElementCompetenceMultiFixed::class)
    ->name('elementcompetence.multiple.create');Route::get('/elementcompetence/multiple/create', ElementCompetenceMultiFixed::class)
    ->name('elementcompetence.multiple.create');
//Route::post('/inscription/{id}/suspendre', [InscriptionController::class, 'suspendre'])->name('inscription.suspendre');
Route::post('/inscriptions/{id}/abandonner', [InscriptionController::class, 'abandonner'])
    ->name('inscription.abandonner');
Route::get('/carto', [TerritoireController::class, 'index']);
Route::view('/carte-efp', 'carte-efp');



Route::view('/carte-efp', 'carte-efp')->name('carte-efp');

// API JSON — si tu as déjà une route qui marche, garde-la.
// Ici on lit public/data/etablissements.json
Route::get('/carte-efp/data', function () {
    $path = public_path('data/etablissements.json');
    abort_unless(file_exists($path), 404, 'Fichier manquant');
    $json = file_get_contents($path);
    return response($json, 200)->header('Content-Type', 'application/json');
})->name('carte-efp.data');


Route::get('/classe/{classe}/export-pdf', [ClasseController::class, 'exportPdf'])->name('classe.exportPdf');
Route::get('/classes/{classe}/formateurs/assign', [App\Http\Controllers\ClasseController::class, 'assign'])
    ->name('classe.formateurs.assign');

Route::post('/classes/{classe}/formateurs/assign', [App\Http\Controllers\ClasseController::class, 'storeAssign'])
    ->name('classe.formateurs.storeAssign');
 Route::prefix('classe')->name('classe.assign.')->group(function () {
        Route::post('{classe}/assignations', [App\Http\Controllers\ClasseMatiereFormateurController::class, 'store'])->name('store');
        Route::delete('{classe}/assignations/{formateur}/{id}', [App\Http\Controllers\ClasseMatiereFormateurController::class, 'destroy'])->name('destroy');
    });
    
// Route::get('/classe/{id}/bulletins/semestre/{semestre}', [App\Http\Controllers\EvaluationController::class, 'previewClasseBulletins'])
   // ->name('evaluation.classe.preview');
Route::get(
    '/classe/{id}/bulletins/semestre/{semestre}',
    [App\Http\Controllers\EvaluationController::class, 'previewClasseBulletins']
)->name('evaluation.classe.preview');
 Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/etablissement/{id}/classes', [ClasseController::class, 'byEtablissement'])
    ->name('classes.byEtablissement');
