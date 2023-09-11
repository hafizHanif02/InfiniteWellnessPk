<?php

namespace App\Queries;

use App\Models\DoctorOpdCharge;

class DoctorOPDChargeDataTable
{
    public function get()
    {
        $query = DoctorOpdCharge::whereHas('doctor.user')->with('doctor.user')->select('doctor_opd_charges.*')
            ->orderBy('created_at', 'desc');

        return $query;
    }
}
