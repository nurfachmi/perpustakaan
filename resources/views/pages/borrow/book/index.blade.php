@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                @can('borrows.create')
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{ route('borrows.index') }}" type="button" class="btn btn-primary">Back to Borrowing List</a>
                        @if (empty($borrow->return_at))
                            <div class="btn-group" role="group">
                                <button id="btnGroup{{ str($title)->slug() }}" type="button"
                                    class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroup{{ str($title)->slug() }}">
                                    <a class="dropdown-item" href="#">Return</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endcan
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            Details
                        </div>
                        <div class="card-body">
                            <p class="card-text">Name: {{ $borrow->user->name }} / {{ $borrow->user->card->number }}</p>
                            <p class="card-text">Start: {{ $borrow->start_at->format('d F Y') }}</p>
                            <p class="card-text">End: {{ $borrow->end_at->format('d F Y') }}</p>
                            @if ($borrow->return_at)
                                <p class="card-text">Returned: {{ $borrow->return_at->format('d F Y') }}</p>
                            @endif
                            @if ($borrow->late_days > 0)
                                <p class="card-text text-danger">Days Late: {{ $borrow->late_days }} day(s)</p>
                            @endif
                            @if ($borrow->late_fee > 0)
                                <p class="card-text text-danger">Late Fees: IDR
                                    {{ number_format($borrow->late_fee, 0, ',', '.') }}</p>
                            @endif
                            @if ($borrow->lost_fee > 0)
                                <p class="card-text text-danger">Lost Fees: IDR {{ number_format($borrow->lost_fee, 0, ',', '.') }}</p>
                            @endif
                            @if ($borrow->total_fee > 0)
                                <p class="card-text text-danger font-weight-bold">Total Fees: IDR {{ number_format($borrow->total_fee, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <x-datatable :tableId="'borrow-books'" :tableHeaders="['ISBN', 'Book Title']" :tableColumns="[['data' => 'isbn'], ['data' => 'isbn']]" :getDataUrl="route('datatables.borrow-books', $borrow->getKey())" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
