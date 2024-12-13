@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Contract</h1>

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Data Contract
                    </div>

                    <a href="{{ route('contract.create') }}">Add Contract</a>
                </div>

            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Contract Number</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">OTR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contract->contract_number }}</td>
                                <td>{{ $contract->client_name }}</td>
                                <td>{{ $contract->otr }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
