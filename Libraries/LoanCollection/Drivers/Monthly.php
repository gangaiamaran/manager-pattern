<?php

namespace App\Libraries\LoanCollection\Drivers;

use App\Libraries\LoanCollection\LoanCollectionDriverContract;
use Illuminate\Support\Collection;
use App\Models\Collection as LoanCollection;

class Monthly implements LoanCollectionDriverContract
{
    /**
     * Get EMI table based on monthly
     */
    public function getEmiTable($loan)
    {
        $collections = new collect([]);

        $interestRepo = new InterestRepository();

        $interest = $interestRepo->getInterestAmountForEmi($loan);

        collect()->times($loan->tenure)->each(function ($tenure) use ($interest, $collections, $loan) {
            $collection = new LoanCollection([
                'loan_id' => $loan->id,
                'amount' => $loan->emi_amount,
                'emi_date' => Carbon::createFromDate($loan->opening_date)->addMonths($tenure),
                'interest' => $interest,
                'status_id' => 1,
                'user_id' => $loan->user_id,
            ]);

            $collections->push($collection);
        });

        return $collections;
    }
}
