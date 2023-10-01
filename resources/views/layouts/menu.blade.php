@can('users.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
    </li>
@endcan
@can('roles.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
    </li>
@endcan
@can('modules.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('modules.index') }}">Modules</a>
    </li>
@endcan
@can('members.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('members.index') }}">Members</a>
    </li>
@endcan
