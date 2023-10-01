@extends('layouts.app')

@section('title')
    Set Up Password
@endsection

@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Set Up Password
                </div>
                <div class="card-body">
                    <form action="{{ route('user-verification.store', [$email, $token]) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $email }}" readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right ">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Password
                                Confirmation</label>
                            <div class="col-md-6">
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation">
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Set Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
