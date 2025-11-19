<?php
namespace App\Http\Controllers;
use App\Models\Liste;
use App\Models\Etablissement;
use App\Models\User;




use Illuminate\Http\Request;

class PersonnelEtablissementController extends Controller
{
    public function index()
    {
        return view('etablissements.index');
    }

    public function create(Etablissement $etablissement)
    {
        $statuts = Liste::where('libelle', 'like', '%statut%')->get();
        $statutJuridiques = Liste::where('libelle', 'like', '%statut juridique%')->get();
        $types = Liste::where('libelle', 'like', '%type%')->get();
        
        return view('etablissements.create', compact('etablissement','statuts','statutJuridiques','types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'telephone',
            'sigle',
            'email',
            'siteWeb',
            'adresse',
            // 'logo',
            'nom',
            'commune_id',
            'specifite',
            'dateAutOuv',
            'numAutOuv',
            'dateRecepisseDepot',
            'numRecipisse',
            'prenomResponsable',
            'nomResponsable',
            'reference',
            'dateCreation',
            'boitePostale',
            'type',
            'statutJuridique',
            "statut",
            ]);

        Etablissement::create($request->all());
        $user= User::create(array(
            'email' => $request->email,
            'prenom' => $request->nom,
            'nom' => $request->sigle,
            'adresse' => $request->adresse,
            'lieu_naissance' => $request->dateAutOuv,
            'telephone' => $request->telephone,
            'password' => bcrypt('password')
        ));
        $user->assignRole(config('constants.roles.chef_etablissement'));
        $user->markEmailAsVerified();

        return redirect()->route('etablissement.index')
                         ->withMessage('Etablissement créé avec succès.');
    }

    public function show($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        return view('etablissements.show', compact('etablissement'));
    }

    public function edit($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        $statuts = Liste::where('libelle', 'like', '%statut%')->get();
        $statutJuridiques = Liste::where('libelle', 'like', '%statut juridique%')->get();
        $types = Liste::where('libelle', 'like', '%type%')->get();
        // dd($statuts);
        return view('etablissements.edit', compact('etablissement','statuts','statutJuridiques','types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'telephone',
            'sigle',
            'email',
            'siteWeb',
            'adresse',
            'logo',
            'nom',
            'commune_id',
            'specifite',
            'dateAutOuv',
            'numAutOuv',
            'dateRecepisseDepot',
            'numRecipisse',
            'prenomResponsable',
            'nomResponsable',
            'reference',
            'dateCreation',
            'boitePostale',
            'type',
            'statutJuridique',
            "statut",
        ]);

        $etablissement = Etablissement::findOrFail($id);
        $etablissement->update($request->only([
        'telephone',
        'sigle',
        'email',
        'siteWeb',
        'adresse',
        'logo',
        'nom',
        'commune_id',
        'specifite',
        'dateAutOuv',
        'numAutOuv',
        'dateRecepisseDepot',
        'numRecipisse',
        'prenomResponsable',
        'nomResponsable',
        'reference',
        'dateCreation',
        'boitePostale',
        'type',
        'statutJuridique',
        "statut"]));

        return redirect()->route('etablissement.index')
                         ->withMessage('Etablissement mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        $etablissement->update(['isDeleted' => true]);

        return redirect()->route('etablissement.index')
                         ->withMessage('Etablissement supprimée avec succès.');
    }
}
