<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprenantsExport;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;

class ExportController extends Controller
{
    public function exportApprenants()
    {
        return Excel::download(new ApprenantsExport, 'liste_apprenants.xlsx');
    }
}