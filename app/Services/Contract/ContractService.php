<?php

namespace App\Services\Contract;

use LaravelEasyRepository\BaseService;

interface ContractService extends BaseService
{

    // Write something awesome :)
    public function getAllContract();
    public function storeContract($payload);
}