<?php

namespace App\Http\Controllers;

use App\Services\Contract\ContractService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ContractController extends Controller
{
    protected $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
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
            'otr' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $this->contractService->storeContract($payload);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->route('contract.index');
    }
}
