@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                @can('roles.index')
                    <a href="{{ route('roles.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                        Back
                    </a>
                @endcan
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('permissions.store', $role->getKey()) }}" method="post"
                                id="inactive-form">
                                @csrf
                                <button type="submit" class="btn btn-success" autocomplete="off">Activate</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-md-1"><input type="checkbox" id="toggleAllInactives"></th>
                                <th>Inactive Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $id => $permission)
                                <?php
                                if ($role->hasPermissionTo($permission)) {
                                    continue;
                                }
                                ?>
                                <tr data-inactive="inactive{{ $loop->iteration }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="inactive-permissions" value="{{ $permission }}"
                                            id="inactive-permission-{{ $id }}" form="inactive-form" name="permissions[]">
                                    </td>
                                    <td><label for="inactive-permission-{{ $id }}">{{ $permission }}</label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No permission left</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('permissions.destroy', $role->getKey()) }}" method="post"
                                id="active-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" autocomplete="off">Deactivate</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-md-1"><input type="checkbox" id="toggleAllActives"></th>
                                <th>Active Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $id => $permission)
                                <?php
                                if (!$role->hasPermissionTo($permission)) {
                                    continue;
                                }
                                ?>
                                <tr data-active="active{{ $loop->iteration }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="active-permissions" value="{{ $permission }}"
                                            id="active-permission-{{ $id }}" name="permissions[]" form="active-form">
                                    </td>
                                    <td><label for="active-permission-{{ $id }}">{{ $permission }}</label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No permission left</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inactiveRows = document.querySelectorAll('tr[data-inactive]');
            const activeRows = document.querySelectorAll('tr[data-active]');
            const toggleInactive = document.getElementById('toggleAllInactives');
            const toggleActive = document.getElementById('toggleAllActives');
            const inactiveCheckbox = this.querySelectorAll('.inactive-permissions');
            const activeCheckbox = this.querySelectorAll('.active-permissions');

            // clickable td for active
            activeRows.forEach(row => {
                row.addEventListener('click', function() {
                    const activeCheckbox = this.querySelector('.active-permissions');
                    activeCheckbox.checked = !activeCheckbox.checked;
                });
            });
            // clickable td for inactive
            inactiveRows.forEach(row => {
                row.addEventListener('click', function() {
                    const inactiveCheckbox = this.querySelector('.inactive-permissions');
                    inactiveCheckbox.checked = !inactiveCheckbox.checked;
                });
            });

            // check all for active
            toggleActive.addEventListener('change', function() {
                const isChecked = this.checked;
                activeCheckbox.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
            // check all for inactive
            toggleInactive.addEventListener('change', function() {
                const isChecked = this.checked;
                inactiveCheckbox.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });
    </script>
@endpush
