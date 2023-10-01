@extends('layouts.app')

@section('title', 'Update Password')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Update Password</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status') == 'password-updated')
                        @php toast('Password changed successfully!','success'); @endphp
                    @endif
                    <form action="{{ route('user-password.update') }}" method="post">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" id="current_password" value="{{ old('current_password') }}"
                                    placeholder="Current password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
