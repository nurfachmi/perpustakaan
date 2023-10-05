@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                @can('borrows.index')
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{ route('borrows.index') }}" type="button" class="btn btn-primary">Back</a>
                    </div>
                @endcan
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white font-weight-bold">
                            Details
                        </div>
                        <div class="card-body">
                            <p class="card-text">Name: {{ $borrow->user->name }} / {{ $borrow->user->card->number }}</p>
                            <p class="card-text">Start: {{ $borrow?->start_at?->format('d F Y') }}</p>
                            <p class="card-text">End: {{ $borrow?->end_at?->format('d F Y') }}</p>
                            @if ($borrow->return_at)
                                <p class="card-text">Returned: {{ $borrow?->return_at?->format('d F Y') }}</p>
                            @endif
                            @if ($borrow->late_days > 0)
                                <p class="card-text text-danger">Days Late: {{ $borrow->late_days }} day(s)</p>
                            @endif
                            @if ($borrow?->late_fee > 0)
                                <p class="card-text text-danger">Late Fees: IDR
                                    {{ number_format($borrow?->late_fee, 0, ',', '.') }}</p>
                            @endif
                            @if ($borrow?->lost_fee > 0)
                                <p class="card-text text-danger">Lost Fees: IDR
                                    {{ number_format($borrow?->lost_fee, 0, ',', '.') }}</p>
                            @endif
                            @if ($borrow?->total_fee > 0)
                                <p class="card-text text-danger font-weight-bold">Total Fees: IDR
                                    {{ number_format($borrow?->total_fee, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>

                    @if (!$borrow->return_at)
                        @php
                            if (!$borrow->start_at) {
                                $text = 'Borrow';
                            } else {
                                $text = 'Return';
                            }
                        @endphp
                        <div class="card mt-4">
                            <div class="card-header bg-success text-white font-weight-bold">
                                Confirm to {{ $text }}
                            </div>
                            <div class="card-body">
                                <form action="{{ route('borrows.update', $borrow->getKey()) }}" method="post"
                                    class="form-inline">
                                    @csrf @method('PUT')
                                    <label class="sr-only" for="number">Member Card</label>
                                    <input type="text" class="form-control mr-sm-2" id="number" name="number"
                                        placeholder="Member card number" autocomplete="off">

                                    <button type="submit" class="btn btn-success">{{ $text }}</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if (!$borrow->start_at)
                        <div class="card mt-4">
                            <div class="card-header bg-danger text-white font-weight-bold">
                                Cancel to {{ $text }}
                            </div>
                            <div class="card-body">
                                <form action="{{ route('borrows.destroy', $borrow->getKey()) }}" method="post"
                                    class="form-inline">
                                    @csrf @method('DELETE')
                                    <label class="sr-only" for="number">Member Card</label>
                                    <input type="text" class="form-control mr-sm-2" id="number" name="number"
                                        placeholder="Member card number" autocomplete="off">

                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-8">
                    @if (!$borrow->return_at)
                        <div class="card">
                            <div class="card-header bg-primary text-white font-weight-bold">
                                Scan Books
                            </div>
                            <div class="card-body">
                                <form action="{{ route('borrows.borrow_books.store', $borrow->getKey()) }}" method="post"
                                    class="form-inline">
                                    @csrf
                                    <label class="sr-only" for="isbn">ISBN</label>
                                    <input type="text" class="form-control mr-sm-2" id="isbn" name="isbn"
                                        placeholder="ISBN" autofocus autocomplete="off">

                                    <button type="submit" class="btn btn-primary">Scan</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="card mt-2">
                        <div class="card-body">
                            <x-datatable :tableId="'borrow-books'" :tableHeaders="['ISBN', 'Book Title', 'Status']" :tableColumns="[['data' => 'isbn'], ['data' => 'isbn'], ['data' => 'return_at']]" :getDataUrl="route('datatables.borrow-books', $borrow->getKey())" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
