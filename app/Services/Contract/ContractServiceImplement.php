<?php

namespace App\Services\Contract;

use App\Models\Contract;
use LaravelEasyRepository\ServiceApi;

class ContractServiceImplement extends ServiceApi implements ContractService
{

  /**
   * set title message api for CRUD
   * @param string $title
   */
  protected string $title = "";
  /**
   * uncomment this to override the default message
   * protected string $create_message = "";
   * protected string $update_message = "";
   * protected string $delete_message = "";
   */

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(Contract $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAllContract()
  {
    return $this->mainRepository->all();
  }

  public function storeContract($payload)
  {
    return $this->mainRepository->create([
      'contract_number' => $payload['contract_number'],
      'client_name' => $payload['client_name'],
      'otr' => $payload['otr']
    ]);
  }

  // Define your custom methods :)
}
