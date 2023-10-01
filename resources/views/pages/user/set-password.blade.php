@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('users.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                    Back
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status') == 'password-updated')
                        @php toast('Password changed successfully!','success'); @endphp
                    @endif
                    <form action="{{ route('users.reset.update', $user->getKey()) }}" method="post">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" value="{{ old('password') }}"
                                    placeholder="New password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">New Password
                                Confirmation</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Confirm new password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
