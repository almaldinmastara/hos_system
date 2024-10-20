<?php

namespace App\Exports;

use App\Models\Aywa;
use Maatwebsite\Excel\Concerns\FromCollection;

class AwyaExport implements FromCollection
{
    public function collection()
    {
        return Aywa::all();
    }
}
