<?php

namespace App\Http\Controllers;

use App\Services\Contract\ContractService;
use App\Services\InstallmentSchedule\InstallmentScheduleService;
use Carbon\Carbon;
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

    public function contractWithSumInstallmentSchedulesAsPinalty(Request $request)
    {
        $pinaltyDatas = null;
        if ($request->filled('due_date') || $request->filled('client_name')) {
            $pinaltyRate = 0.001;
            $timePeriode = $request->filled('due_date') ? Carbon::parse($request->due_date) : Carbon::parse(Carbon::now());
            $contractWithSumInstallmentSchedulesAsPinalties = $this->contractService->contractWithSumInstallmentSchedulesAsPinalties();

            $pinaltyDatas = $this->contractService->setPenalty($contractWithSumInstallmentSchedulesAsPinalties, $timePeriode, $pinaltyRate);
        }

        return view('installment-schedule.due-date', [
            'pinaltyDatas' => $pinaltyDatas
        ]);
    }
}
