@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Add Contract</h1>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Add Data Contract
            </div>
            <div class="card-body">
                <form action="{{ route('contract.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Contract Number</label>
                        <input type="string" class="form-control" name="contract_number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Client Name</label>
                        <input type="text" class="form-control" name="client_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OTR</label>
                        <input type="number" class="form-control" name="otr">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Downpayment (in %)</label>
                        <input type="number" class="form-control" name="downpayment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time Periode (in month)</label>
                        <input type="number" class="form-control" name="time_periode">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
