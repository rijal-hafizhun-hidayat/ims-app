<?php

namespace App\Http\Controllers;

use App\Services\Contract\ContractService;
use App\Services\InstallmentSchedule\InstallmentScheduleService;
use Illuminate\Http\Request;

class InstallmentScheduleController extends Controller
{
    protected $installmentScheduleService;
    protected $contractService;
    public function __construct(InstallmentScheduleService $installmentScheduleService, ContractService $contractService)
    {
        $this->installmentScheduleService = $installmentScheduleService;
        $this->contractService = $contractService;
    }

    public function index(Request $request)
    {
        $contractWithSumInstallmentSchedules = null;
        if ($request->filled('due_date') || $request->filled('client_name')) {
            $contractWithSumInstallmentSchedules = $this->contractService->getContractWithSumInstallmentSchedule();
        }

        return view('installment-schedule.index', [
            'contractWithSumInstallmentSchedules' => $contractWithSumInstallmentSchedules
        ]);
    }
}
