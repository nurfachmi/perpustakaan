@extends('layouts.app')

@section('title')
    Log in
@endsection

@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Log in
                </div>
                <div class="card-body">
                    <form action="{{ url('login') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" autofocus>
                                <div class="invalid-feedback">{{ $message ?? '' }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" value="1"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
