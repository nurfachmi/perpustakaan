@can('users.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">{{__('general.users')}}</a>
    </li>
@endcan
@can('roles.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('roles.index') }}">{{__('general.roles')}}</a>
    </li>
@endcan
@can('modules.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('modules.index') }}">{{__('general.modules')}}</a>
    </li>
@endcan
@can('members.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('members.index') }}">{{__('general.members')}}</a>
    </li>
@endcan
@can('members.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('books.index') }}">{{__('general.books')}}</a>
    </li>
@endcan
@can('borrows.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('borrows.index') }}">{{__('general.borrowing books')}}</a>
    </li>
@endcan
