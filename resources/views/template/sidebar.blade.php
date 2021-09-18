<div id="sidebar" class="sidebar sidebar-with-footer">
    <!-- Aplication Brand -->
    <div class="app-brand">
        <a href="{{ url('admin') }}">
            <svg
                class="brand-icon"
                xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="xMidYMid"
                width="30"
                height="33"
                viewBox="0 0 30 33"
            >
                <g fill="none" fill-rule="evenodd">
                    <path
                        class="logo-fill-blue"
                        fill="#7DBCFF"
                        d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                    />
                    <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z"/>
                </g>
            </svg>
            <span class="brand-name">{{ env('APP_NAME') }}</span>
        </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-scrollbar">

        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">


            <li class="has-sub {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }} ">
                <a class="sidenav-item-link" href="{{ route('admin.dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span class="nav-text">Home</span> <b class="caret"></b>
                </a>
            </li>
            <li class="has-sub {{ request()->routeIs('admin.message*') ? 'active' : '' }}">
                <a class="sidenav-item-link" href="{{ route('admin.message.index') }}">
                    <i class="mdi mdi-message"></i>
                    <span class="nav-text">Mensagens</span> <b class="caret"></b>
                </a>
            </li>
            <li class="has-sub {{ request()->routeIs('admin.datacenterinfo*') ? 'active' : '' }}">
                <a class="sidenav-item-link" href="{{ route('admin.datacenterinfo.index') }}">
                    <i class="mdi mdi-server"></i>
                    <span class="nav-text">Server Info</span> <b class="caret"></b>
                </a>
            </li>
            <li class="has-sub {{ request()->routeIs('admin.documentation*') ? 'active' : '' }}">
                <a class="sidenav-item-link" href="{{ route('admin.documentation.index') }}">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    <span class="nav-text">Dados API</span> <b class="caret"></b>
                </a>
            </li>
            @if(\Illuminate\Support\Facades\Auth::user()->admin)
                <li class="has-sub {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.user.index') }}">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="nav-text">Usuários</span> <b class="caret"></b>
                    </a>
                </li>
            @endif
        </ul>

    </div>

    <hr class="separator"/>


</div>
