<?php

namespace App\Services\InstallmentSchedule;

use App\Models\InstallmentSchedule;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\InstallmentSchedule\InstallmentScheduleRepository;
use Carbon\Carbon;

class InstallmentScheduleServiceImplement extends ServiceApi implements InstallmentScheduleService
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

  public function __construct(InstallmentSchedule $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAllInstallmentScheduleWithContract()
  {
    return $this->mainRepository->with('contract')->get();
  }

  public function storeManyInstallmentSchedule($timePeriode, $contract)
  {
    $monthlyInstallment = $this->setMonthlyInstallment($contract, $timePeriode);
    $due_date = Carbon::parse(Carbon::now());
    for ($i = 1; $i <= $timePeriode; $i++) {
      $this->mainRepository->create([
        'contract_id' => $contract->id,
        'installment_to' => $i,
        'installment_per_month' => $monthlyInstallment,
        'due_date' => $due_date->addMonths()
      ]);
    }
  }

  public function setMonthlyInstallment($contract, $timePeriode)
  {
    $nominalPrincipelDebt = ($contract->dp / 100) * $contract->otr;
    $principalDebt = $contract->otr - $nominalPrincipelDebt;

    if ($timePeriode <= 12) {
      $interest = 12 / 100;
    } else if ($timePeriode > 12 && $timePeriode <= 24) {
      $interest = 14 / 100;
    } else if ($timePeriode >= 24) {
      $interest = 16.5 / 100;
    }

    $monthlyInstallment = ($principalDebt + ($principalDebt * $interest)) / $timePeriode;

    return $monthlyInstallment;
  }
  // Define your custom methods :)
}
