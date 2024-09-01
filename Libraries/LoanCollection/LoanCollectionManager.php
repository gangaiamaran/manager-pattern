<?php

namespace App\Libraries\LoanCollection;

use Illuminate\Support\Manager;
use App\Libraries\LoanCollection\Drivers\Daily;
use App\Libraries\LoanCollection\Drivers\Monthly;

class LoanCollectionManager extends Manager
{
    public function getDefaultDriver()
    {
        return new Daily();
    }

    public function getDailyDriver()
    {
        return new Daily();
    }

    public function getMonthlyDriver()
    {
        return new Monthly();
    }
}
