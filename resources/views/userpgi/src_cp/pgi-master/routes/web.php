<?php

use App\Http\Controllers\DemandeController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\FrontAdminController;
//use App\Http\Controllers\FrontController;
use App\Http\Controllers\parametrage\EtatWorkflowController;
use App\Http\Controllers\parametrage\ProfilController;
use App\Http\Controllers\parametrage\SecteurController;
use App\Http\Controllers\parametrage\FiliereController;
use App\Http\Controllers\parametrage\MetierController;
use App\Http\Controllers\parametrage\NiveauEtudeController;
use App\Http\Controllers\parametrage\MatiereController;
use App\Http\Controllers\parametrage\ElementCompetenceController;
use App\Http\Controllers\AnneeAcademiqueController;

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

use App\Http\Controllers\RegionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\IaController;
use App\Http\Controllers\IefController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\parametrage\DiplomeController;
use App\Http\Controllers\IndicateurController;
use App\Http\Controllers\SuiviIndicateurController;
use App\Http\Controllers\TypeIndicateurController;
use Illuminate\Support\Facades\Route;



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




Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



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

    // Route pour les evaluations;
    Route::resource('evaluation', EvaluationController::class);
    Route::get('/evaluation/{inscriptionId}/{matiereId}', [EvaluationController::class, 'create'])->name('evaluation.create');
    Route::post('/evaluation/{inscriptionId}', [EvaluationController::class, 'store'])->name('evaluation.store');
    Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluation.edit');
    Route::put('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluation.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluation.destroy');
    Route::get('/evaluations/{inscription}/pdf', [EvaluationController::class, 'generatePDF'])->name('evaluation.pdf');




    Route::resource('filiereetablissement', FiliereEtablissementController::class);
    Route::resource('niveauetudeetablissement', NiveauEtudeEtablissementController::class);
    Route::get('/niveauetudeetablissement/{id}/view', [NiveauEtudeEtablissementController::class, 'detailProgrammeFormation'])->name('program.view');

    // Route::resource('notifications', NotificationController::class);
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/all', [NotificationController::class, 'allNotificaions'])->name('notifications.all');
    });



    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');


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
