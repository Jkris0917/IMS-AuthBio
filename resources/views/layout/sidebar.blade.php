<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link" style="text-align: center;">
        <img src="{{ asset('logo.png') }}" alt="CNHS" class="brand-image img-circle elevation-3"
            style="opacity: .8; max-width: 200%; max-height: 200px;" height="auto" width="auto">
    </a>
    <br>
    <br>
    <br>
    <!-- Sidebar -->
    <div class="sidebar">
        <br>
        <br>
        <br>
        <br>
        <!-- Sidebar Menu -->
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.inventory') }}"
                        class="nav-link {{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('admin/settings/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.area') }}"
                                class="nav-link {{ request()->routeIs('admin.area') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Area</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.category') }}"
                                class="nav-link {{ request()->routeIs('admin.category') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.userList') }}"
                                class="nav-link {{ request()->routeIs('admin.userList') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
