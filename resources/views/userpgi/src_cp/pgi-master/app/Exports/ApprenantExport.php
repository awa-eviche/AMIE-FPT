<?php

namespace App\Exports;

use App\Models\AppModelsApprenant;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApprenantExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AppModelsApprenant::all();
    }
}
