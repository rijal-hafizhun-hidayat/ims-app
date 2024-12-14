<?php

namespace App\Services\Contract;

use App\Models\Contract;
use Carbon\Carbon;
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
    $query = $this->mainRepository->withSum(['installmentSchedules' => function ($query) {
      if (request()->filled('due_date')) {
        $query->where('due_date', '<=', request()->due_date);
        $query->whereNull('paid_date');
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

  public function contractWithSumInstallmentSchedulesAsPinalties()
  {
    $query = $this->mainRepository->withWhereHas('installmentSchedules', function ($query) {
      if (request()->filled('due_date')) {
        $query->where('due_date', '<=', request()->due_date);
        $query->whereNull('paid_date');
      }
    });

    $query->withSum(['installmentSchedules' => function ($query) {
      if (request()->filled('due_date')) {
        $query->where('due_date', '<=', request()->due_date);
        $query->whereNull('paid_date');
      }
    }], 'installment_per_month');

    if (request()->filled('client_name')) {
      $query->where('client_name', 'like', '%' . request()->client_name . '%');
    }

    return $query->get();
  }

  public function setPenalty($contractWithSumInstallmentSchedulesAsPinalties, $timePeriode, $pinaltyRate)
  {
    $contracts = $contractWithSumInstallmentSchedulesAsPinalties->map(function ($contract) use ($timePeriode, $pinaltyRate) {
      $pinaltyData = $contract->installmentSchedules->map(function ($installmentSchedule) use ($timePeriode, $pinaltyRate) {
        $dueDate = Carbon::parse($installmentSchedule->due_date);
        $daysLate = $dueDate->diffInDays($timePeriode);
        $pinalty = $installmentSchedule->installment_per_month * $pinaltyRate * $daysLate;

        return [
          'due_date' => $installmentSchedule->due_date,
          'amount' => $installmentSchedule->installment_per_month,
          'days_late' => $daysLate,
          'pinalty' => $pinalty
        ];
      });

      $totalPinalty = $pinaltyData->sum('pinalty');

      return [
        'contract_id' => $contract->id,
        'contract_number' => $contract->contract_number,
        'total_amount' => $contract->installment_schedules_sum_installment_per_month,
        'client_name' => $contract->client_name,
        'total_pinalty' => $totalPinalty,
        'installments' => $pinaltyData,
      ];
    });

    return $contracts;
  }

  // Define your custom methods :)
}
