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
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" action="{{ route('borrows.store') }}" method="POST">
                        @csrf
                        <label class="sr-only" for="number">Username</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                            </div>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" placeholder="Nomor Anggota" autofocus autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
