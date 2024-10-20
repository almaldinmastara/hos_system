<?php

namespace App\Exports;

use App\Models\exportlab;
use Maatwebsite\Excel\Concerns\FromCollection;

class labExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return exportlab::all();
    }
}
