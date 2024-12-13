<?php

namespace App\Services\InstallmentSchedule;

use LaravelEasyRepository\BaseService;

interface InstallmentScheduleService extends BaseService
{

    // Write something awesome :)

    public function getAllInstallmentScheduleWithContract();
    public function storeManyInstallmentSchedule($timePeriode, $contract);
}
