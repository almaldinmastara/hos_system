<?php

namespace App\Exports;

use App\Models\clinic;
use Maatwebsite\Excel\Concerns\FromCollection;

class clinicExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return clinic::all();
    }
}
