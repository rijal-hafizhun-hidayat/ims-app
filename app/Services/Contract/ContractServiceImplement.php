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

  public function getContractWithSumInstallmentSchedule()
  {
    $query =  $this->mainRepository->withSum(['installmentSchedules' => function ($query) {
      if (request()->filled('due_date')) {
        $query->where('due_date', '<=', request()->due_date);
        // $query->where('paid_date', '!=', null);
      }
    }], 'installment_per_month');

    if (request()->filled('client_name')) {
      $query->where('client_name', 'like', '%' . request()->client_name . '%');
    }

    return $query->get();
  }

  public function storeContract($payload)
  {
    return $this->mainRepository->create([
      'contract_number' => $payload['contract_number'],
      'client_name' => $payload['client_name'],
      'otr' => $payload['otr'],
      'downpayment' => $payload['downpayment']
    ]);
  }

  // Define your custom methods :)
}
