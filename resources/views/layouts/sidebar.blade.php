<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li class="{{ request()->is('/') || request()->is('root*') ? 'mm-active' : '' }}">
                    <a href="{{ route('root') }}">
                        <i data-feather="home"></i>
                        <span>Dashbooard</span>
                    </a>
                </li>
                @if (auth()->user()->can('Data Document'))
                    <li class="{{ request()->is('document') || request()->is('document/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="folder"></i>
                            <span>File Manager</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (auth()->user()->can('Data Document'))
                                <li
                                    class="{{ request()->is('document') || request()->is('document/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('document') }}">
                                        <span>Document</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <li
                    class="{{ request()->is('monitoring-project') || request()->is('monitoring-project/*') || request()->is('monitoring-project-finish') || request()->is('monitoring-project-finish/*') ? 'active text-custom' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span>Project Monitoring</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li
                            class="{{ request()->is('monitoring-project') || request()->is('monitoring-project/*') || request()->is('monitoring-project-finish') || request()->is('monitoring-project-finish/*') ? 'active text-custom' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow">
                                <span>Project</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li
                                    class="{{ request()->is('monitoring-project') || request()->is('monitoring-project/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('monitoring-project') }}">Progress</a>
                                </li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li
                                    class="{{ request()->is('monitoring-project-finish') || request()->is('monitoring-project-finish/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('monitoring-project-finish') }}">Finish</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @if (auth()->user()->can('Data Client') ||
                        auth()->user()->can('Data Client Win') ||
                        auth()->user()->can('Data Follow Up') ||
                        auth()->user()->can('Data Schedule Email'))
                    <li
                        class="{{ request()->is('client') || request()->is('client/*') || request()->is('client-win') || request()->is('client-win/*') || request()->is('follow-up-client') || request()->is('follow-up-client/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span>Sales</span>
                        </a>
                        @if (auth()->user()->can('Data Client') ||
                                auth()->user()->can('Data Client Win'))
                            <ul class="sub-menu" aria-expanded="false">
                                <li
                                    class="{{ request()->is('client') || request()->is('client/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow">
                                        <span>Client</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @if (auth()->user()->can('Data Client'))
                                            <li
                                                class="{{ request()->is('client') || request()->is('client/*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('client') }}">All</a>
                                            </li>
                                        @endif
                                        @if (auth()->user()->can('Data Client Win'))
                                            <li
                                                class="{{ request()->is('client-win') || request()->is('client-win/*') ? 'mm-active' : '' }}">
                                                <a href="{{ route('client-win') }}">Win</a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        @endif
                        @if (auth()->user()->can('Data Follow Up'))
                            <ul class="sub-menu" aria-expanded="false">
                                <li
                                    class="{{ request()->is('follow-up-client') || request()->is('follow-up-client/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('follow-up-client') }}">
                                        <span>Follow Up</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        @if (auth()->user()->can('Data Schedule Email'))
                            <ul class="sub-menu" aria-expanded="false">
                                <li
                                    class="{{ request()->is('schedule-mail') || request()->is('schedule-mail/*') ? 'mm-active' : '' }}">
                                    <a href="/schedule-mail">
                                        <span>Schedule Email</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </li>
                @endif

                <li class="menu-title mt-2">Settings</li>
                @if (auth()->user()->can('Data User') ||
                        auth()->user()->can('Data Role'))
                    <li
                        class="{{ request()->is('user') || request()->is('user/*') || request()->is('role') || request()->is('role/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span>Management User</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (auth()->user()->can('Data User'))
                                <li class="{{ request()->is('user') || request()->is('user/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('user') }}">User</a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Data Role'))
                                <li class="{{ request()->is('role') || request()->is('role/*') ? 'mm-active' : '' }}">
                                    <a href="{{ route('role') }}">Role</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Data Document Type') ||
                        auth()->user()->can('Data Document Archive'))
                    <li
                        class="{{ request()->is('document-type') || request()->is('document-type/*') || request()->is('document-archive') || request()->is('document-archive/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="archive"></i>
                            <span>Management Document</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (auth()->user()->can('Data Document Type'))
                                <li
                                    class="{{ request()->is('document-type') || request()->is('document-type/*') ? 'mm-active' : '' }}">
                                    <a href="/document-type">Document Type</a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Data Document Archive'))
                                <li
                                    class="{{ request()->is('document-archive') || request()->is('document-archive/*') ? 'mm-active' : '' }}">
                                    <a href="/document-archive">Document Archive</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Data Scope'))
                    <li class="{{ request()->is('scope') || request()->is('scope/*') ? 'mm-active' : '' }}">
                        <a href="{{ route('scope') }}">
                            <i data-feather="layout"></i>
                            <span>Scope</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->can('Data Recycle Bin'))
                    <li class="{{ request()->is('recycle') || request()->is('recycle/*') ? 'mm-active' : '' }}">
                        <a href="/recycle">
                            <i data-feather="trash"></i>
                            <span>Recycle Bin</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
