@extends('layouts.app')

@section('title', 'Update Profile')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Update Profile</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status') == 'profile-information-updated')
                        @php toast('Profile changed successfully!','success'); @endphp
                    @endif
                    <form action="{{ route('user-profile-information.update') }}" method="post">
                        @csrf @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Email address" readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
