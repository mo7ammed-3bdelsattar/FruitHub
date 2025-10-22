<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        @include('dashboard.partials.logo')

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Route::is('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @canany(['view users','view drivers'])
        <!-- Layouts -->
        <li class="menu-item {{ Route::is('dashboard.drivers.*')||Route::is('dashboard.users.*') ||Route::is('dashboard.addresses.user.*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon bi bi-people"></i>
                <div data-i18n="Persons">Persons</div>
            </a>

            <ul class="menu-sub">
                @can('view drivers')
                <li class="menu-item  {{ Route::is('dashboard.drivers.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.drivers.index') }}" class="menu-link">
                        <div data-i18n="Drivers">Drivers</div>
                    </a>
                </li>
                @endcan
                @can('view users')
                <li class="menu-item {{ Route::is('dashboard.users.*') ||Route::is('dashboard.addresses.user.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                        <div data-i18n="Users">Users</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        @can('create location')
        <li class="menu-item {{ Route::is('dashboard.cities.*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon bi bi-map"></i>
                <div data-i18n="Location">Locations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('dashboard.cities.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.cities.index') }}" class="menu-link">
                        <div data-i18n="cities">Cities</div>
                    </a>
                </li>
            </ul>

        </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        {{-- <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-account-settings-account.html" class="menu-link">
                        <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-notifications.html" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                        <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        @can('view products')
        <li class="menu-item {{ Route::is('dashboard.products.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Products</div>
            </a>
        </li>
        @endcan
        @can('view orders')
        <li class="menu-item {{ Route::is('dashboard.orders.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.orders.index') }}" class="menu-link">
                <i class="menu-icon bx bx-package"></i>
                <div data-i18n="OrdersManagement">Orders Management</div>
            </a>
        </li>
        @endcan
        @canany(['manage roles','manage permissions'])

        <!-- Roles & Permissions -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Roles & Permissions</span></li>
        <!-- Roles -->
        <li class="menu-item {{ Route::is('dashboard.roles.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.roles.index') }}" class="menu-link">
                <i class="menu-icon bx bx-badge-check"></i>
                <div data-i18n="Basic">Roles</div>
            </a>
        </li>
        <!-- Permissions -->
        <li class="menu-item {{ Route::is('dashboard.permissions.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.permissions.index') }}" class="menu-link">
                <i class="menu-icon bx bx-user-check"></i>
                <div data-i18n="Basic">Permissions</div>
            </a>
        </li>
        @endcanany

        <!-- System management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">System Management</span></li>
        @can('edit settings')

        <li class="menu-item {{ Route::is('dashboard.settings.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.settings.edit') }}" class="menu-link">
                <i class="menu-icon tf-icons bi bi-gear"></i>
                <div data-i18n="settings">Settings</div>
            </a>
        </li>
        @endcan
        <li class="menu-item">
            <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
            </a>
        </li>
    </ul>
</aside>