<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        return view('contract.index');
    }

    public function create()
    {
        return view('contract.create');
    }
}
