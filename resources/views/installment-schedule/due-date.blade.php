@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="my-4">Installment Schedule</h1>
        <form method="get" action="{{ route('installment-schedule.contractWithSumInstallmentSchedulesAsPinalty') }}">
            <div class="container mb-4">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Client Name</label>
                        <input type="text" class="form-control" name="client_name" value="{{ request()->client_name }}">
                    </div>
                    <div class="col">
                        <label class="form-label">Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ request()->due_date }}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mt-4">search</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Data Installment Schedule Due
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Contract Number</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Total Installments due</th>
                            <th scope="col">Total Pinalty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinaltyDatas as $pinaltyData)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pinaltyData['contract_number'] }}</td>
                                <td>{{ $pinaltyData['client_name'] }}</td>
                                <td>{{ formatRupiah($pinaltyData['total_amount']) }}</td>
                                <td>{{ formatRupiah($pinaltyData['total_pinalty']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
