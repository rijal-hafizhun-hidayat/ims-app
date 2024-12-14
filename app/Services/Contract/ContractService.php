<?php

namespace App\Services\Contract;

use LaravelEasyRepository\BaseService;

interface ContractService extends BaseService
{

    // Write something awesome :)
    public function getAllContract();
    public function getContractWithSumInstallmentSchedule();
    public function storeContract($payload);
    public function contractWithSumInstallmentSchedulesAsPinalties();
    public function setPenalty($contractWithSumInstallmentSchedulesAsPinalties, $timePeriode, $pinaltyRate);
}
