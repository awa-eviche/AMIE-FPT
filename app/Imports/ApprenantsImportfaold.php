<?php
namespace App\Imports;

use App\Models\Apprenant;
use App\Models\Commune;
use App\Models\Inscription;
use App\Services\MatriculeGenerator;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ApprenantsImport implements OnEachRow, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    protected $classe;

    public function __construct($classe)
    {
        $this->classe = $classe;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $data = $row->toArray();

        $validator = Validator::make($data, [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required|string',
            'adresse' => 'nullable|string',
            'telephone' => 'required',
            'email' => 'nullable|email',
            'nomtuteur' => 'nullable|string',
            'prenomtuteur' => 'nullable|string',
            'numteltuteur' => 'nullable|string',
            'situationmatrimoniale' => 'nullable|string',
            'prenompere' => 'nullable|string',
            'nompere' => 'nullable|string',
            'prenommere' => 'nullable|string',
            'nommere' => 'nullable|string',
            'dateinsertion' => 'nullable',
            'autoemploi' => 'nullable|string',
            'emploisalarie' => 'nullable|string',
            'nationalite' => 'required|string',
            'sexe' => 'required|in:M,F',
            'commune' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            throw new \Exception("Erreur à la ligne $rowIndex : $errors");
        }

        $matricule = MatriculeGenerator::genererMatricule($data['sexe']);
        $commune = Commune::where('libelle', $data['commune'])->first();

        if (!$commune) {
            throw new \Exception("Erreur à la ligne $rowIndex : La commune '{$data['commune']}' est introuvable.");
        }

        $apprenant = Apprenant::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'date_naissance' => $this->convertDate($data['date_naissance'], $rowIndex, 'date_naissance'),
            'lieu_naissance' => $data['lieu_naissance'],
            'adresse' => $data['adresse'] ?? null,
            'telephone' => $data['telephone'],
            'email' => $data['email'] ?? null,
            'nomTuteur' => $data['nomtuteur'] ?? null,
            'prenomTuteur' => $data['prenomtuteur'] ?? null,
            'numTelTuteur' => $data['numteltuteur'] ?? null,
            'situationMatrimoniale' => $data['situationmatrimoniale'] ?? null,
            'prenomPere' => $data['prenompere'] ?? null,
            'nomPere' => $data['nompere'] ?? null,
            'prenomMere' => $data['prenommere'] ?? null,
            'nomMere' => $data['nommere'] ?? null,
            'dateInsertion' => isset($data['dateinsertion']) ? $this->convertDate($data['dateinsertion'], $rowIndex, 'dateinsertion') : null,
            'autoEmploi' => $this->toBoolean($data['autoemploi'] ?? ''),
            'emploiSalarie' => $this->toBoolean($data['emploisalarie'] ?? ''),
            'nationalite' => $data['nationalite'],
            'sexe' => $data['sexe'],
            'matricule' => $matricule,
            'commune_id' => $commune->id,
            'etablissement_id' => $this->classe->etablissement_id,
        ]);

        Inscription::create([
            'apprenant_id' => $apprenant->id,
            'classe_id' => $this->classe->id,
            'dateInscription' => now(),
        ]);
    }

    private function toBoolean($value)
    {
        return strtolower(trim($value)) === 'oui' ? 1 : 0;
    }

    private function convertDate($value, $rowIndex, $fieldName)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            return Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception("Erreur à la ligne $rowIndex : Champ '$fieldName' avec valeur invalide '$value'. Utilisez le format jj/mm/aaaa ou une date Excel valide.");
        }
    }
}
