<?php

namespace App\Http\Controllers;

use App\Services\Contract\ContractService;
use App\Services\InstallmentSchedule\InstallmentScheduleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ContractController extends Controller
{
    protected $contractService;
    protected $installmentScheduleService;

    public function __construct(ContractService $contractService, InstallmentScheduleService $installmentScheduleService)
    {
        $this->contractService = $contractService;
        $this->installmentScheduleService = $installmentScheduleService;
    }

    public function index()
    {
        return view('contract.index', [
            'contracts' => $this->contractService->getAllContract()
        ]);
    }

    public function create()
    {
        return view('contract.create');
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'contract_number' => 'required|string',
            'client_name' => 'required|string',
            'time_periode' => 'required|numeric',
            'otr' => 'required|numeric',
            'downpayment' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $contract = $this->contractService->storeContract($payload);
            $this->installmentScheduleService->storeManyInstallmentSchedule($payload['time_periode'], $contract);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->route('contract.index');
    }
}
