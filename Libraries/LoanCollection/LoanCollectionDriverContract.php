<?php

namespace App\Libraries\LoanCollection;

use App\Models\Loan;

interface LoanCollectionDriverContract
{
    /**
     * Get EMI Table
     *
     * @param Loan $loan
     * @return \Illuminate\Support\Collection
     */
    public function getEmiTable(Loan $loan);
}
