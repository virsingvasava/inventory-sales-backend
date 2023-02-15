<nav class="nav user">
    <div class="nav_list">
        @auth
            @if (Auth::check())
                @if(Auth::User()->role == ADMIN_ROLE)
                    <ul>
                        <li>
                            <a class="nav_link {{ request()->is('admin/dashboard*') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/dashboard.png') }}" alt="Dashboard" /><img
                                    class="purple-nav-icon" src="{{ asset('theme/images/dashboard-h.png') }}" alt="Dashboard">
                                <span>Dashboard</span> </a>
                        </li>

                        <li>
                            <a class="nav_link {{ request()->is('admin/kiosk*') ? 'active' : '' }}"
                                href="{{ route('admin.kiosk.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/inventory.png') }}" alt="Kiosk"> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/inventory-h.png') }}"
                                    alt="Kiosk" /> <span>Kiosk</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav_link {{ request()->is('admin/product*') ? 'active' : '' }}"
                                href="{{ route('admin.product.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/products.png') }}" alt="Products" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/products-h.png') }}"
                                    alt="Products">
                                <span>Products</span> </a>
                        </li>
                        <li>
                            <a class="nav_link {{ request()->is('admin/user-management*') ? 'active' : '' }}"
                                href="{{ route('admin.user_management.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/user-management.png') }}" alt="User Management" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/user-management-h.png') }}"
                                    alt="User Management">
                                <span>User Management</span> </a>
                        </li>
                        <li>
                            <a class="nav_link {{ request()->is('admin/customer-feedback*') ? 'active' : '' }}"
                                href="{{ route('admin.customer_feedback.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/customer-feedback.png') }}" alt="Customer Feedback" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/customer-feedback-h.png') }}"
                                    alt="Customer Feedback">
                                <span>Customer Feedback</span> </a>
                        </li>

                        <!-- <li>
                            <a class="nav_link {{ request()->is('admin/notifications*') ? 'active' : '' }}"
                                href="{{ route('admin.notifications.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/notifications.png') }}" alt="Notifications" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/notifications-h.png') }}"
                                    alt="Notifications" />
                                <span>Notifications</span> </a>
                        </li> -->
                        <li>
                            <a class="nav_link {{ request()->is('admin/insentive*') ? 'active' : '' }}"
                                href="{{route('admin.dashboard.insentive')}}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/notifications.png') }}" alt="Notifications" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/notifications-h.png') }}"
                                    alt="Notifications" />
                                <span>ECP</span> </a>
                        </li>
                        <li>
                            <a class="nav_link {{ request()->is('admin/notifications*') ? 'active' : '' }}"
                                href="{{route('admin.dashboard.oss_alert')}}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/notifications.png') }}" alt="Notifications" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/notifications-h.png') }}"
                                    alt="Notifications" />
                                <span>Oos Alert</span> </a>
                        </li>
                        <li>
                            <a class="nav_link {{ request()->is('admin/settings*') ? 'active' : '' }}"
                                href="{{ route('admin.settings.profile') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/settings.png') }}" alt="Settings" /><img
                                    class="purple-nav-icon" src="{{ asset('theme/images/settings-h.png') }}"
                                    alt="Settings" />
                                <span>Settings</span> </a>
                        </li>

                        <?php
                        $treeview_open = '';
                        if (in_array($route_name, ['admin.profile.index', 'admin.change_password', 'admin.support.index'])) {
                            $treeview_open = 'menu-open';
                        }
                        ?>
                        <li class="nav-item has-treeview {{ $treeview_open }}" style="display:none">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Settings<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview {{ $treeview_open }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.profile.index') }}"
                                        class="nav-link @if ($route_name == 'admin.profile.index') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Edit Profile</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.change_password') }}"
                                        class="nav-link @if ($route_name == 'admin.change_password') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Change Password</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.support.index') }}"
                                        class="nav-link @if ($route_name == 'admin.support.index') active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Support Details</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li  class="nav-item">
                            <a class="nav_link" href="{{ route('admin.dashboard.logout') }}">
                                <img class="gray-nav-icon" src="{{ asset('theme/images/logout-16.jpg') }}" alt="Logout" />
                                <img class="purple-nav-icon" src="{{ asset('theme/images/logout_h.png') }}" alt="Logout" />
                                <span>Logout</span>
                            </a>
                        </li>
                        @auth
                        @endauth
                    </ul>
                @endif
            @endif
        @endauth
        @auth
            @if (Auth::check())
                @if (Auth::User()->role == AIRPORT_MANAGER)
                    <ul>
                        <li>
                            <a class="nav_link {{ request()->is('airport-manager/dashboard*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.dashboard.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/dashboard.png') }}" alt="Dashboard" /><img
                                    class="purple-nav-icon" src="{{ asset('theme/images/dashboard-h.png') }}"
                                    alt="Dashboard">
                                <span>Dashboard</span> </a>
                        </li>

                        {{-- <li>
                            <a class="nav_link {{ request()->is('airport-manager/pending-request*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.pending_request.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/inventory.png') }}" alt="pending-request"> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/inventory-h.png') }}"
                                    alt="pending-request" /> <span>User Approved</span>
                            </a>
                        </li> --}}
                        <li>
                            <a class="nav_link {{ request()->is('airport-manager/city-users*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.city_users.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/user-management.png') }}" alt="User Management" /> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/user-management-h.png') }}"
                                    alt="User Management">
                                <span>User Management</span> </a>
                        </li>

                        <li>
                            <a class="nav_link {{ request()->is('airport-manager/request-qty-approved*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.requested_qty.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/inventory.png') }}" alt="request-qty-approved"> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/inventory-h.png') }}"
                                    alt="request-qty-approved" /> <span>Request Qty Approved</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav_link {{ request()->is('airport-manager/stock-qty-update*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.stock_qty_update.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/inventory.png') }}" alt="stock-qty-update"> <img
                                    class="purple-nav-icon" src="{{ asset('theme/images/inventory-h.png') }}"
                                    alt="stock-qty-update" /> <span>Stocks Qty Update</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav_link {{ request()->is('airport-manager/profile*') ? 'active' : '' }}"
                                href="{{ route('airport_manager.profile.index') }}"> <img class="gray-nav-icon"
                                    src="{{ asset('theme/images/settings.png') }}" alt="Settings" /><img
                                    class="purple-nav-icon" src="{{ asset('theme/images/settings-h.png') }}"
                                    alt="Settings" />
                                <span>Settings</span> </a>
                        </li>
                        <li  class="nav-item">
                            <a class="nav_link" href="{{ route('airport_manager.dashboard.logout') }}">
                                <img class="gray-nav-icon" src="{{ asset('theme/images/logout-16.jpg') }}" alt="Logout" />
                                <img class="purple-nav-icon" src="{{ asset('theme/images/logout_h.png') }}" alt="Logout" />
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                @endif
            @endif
        @endauth

        @auth
        @if (Auth::check())
            @if (Auth::User()->role == SALESMAN)
                <ul>
                    <li>
                        <a class="nav_link {{ request()->is('salesman/dashboard*') ? 'active' : '' }}"
                            href="{{ route('salesman.dashboard.index') }}"> <img class="gray-nav-icon"
                                src="{{ asset('theme/images/dashboard.png') }}" alt="Dashboard" /><img
                                class="purple-nav-icon" src="{{ asset('theme/images/dashboard-h.png') }}"
                                alt="Dashboard">
                            <span>Dashboard</span> </a>
                    </li>
                    <li>
                        <a class="nav_link {{ request()->is('salesman/sales-history*') ? 'active' : '' }}"
                            href="{{ route('salesman.sales_history.index') }}">  <img class="gray-nav-icon"
                            src="{{ asset('theme/images/inventory.png') }}" alt="Kiosk"> <img
                            class="purple-nav-icon" src="{{ asset('theme/images/inventory-h.png') }}"
                            alt="Kiosk" />
                            <span>Inventory</span> </a>
                    </li>
                    <li>
                        <a class="nav_link {{ request()->is('salesman/profile*') ? 'active' : '' }}"
                            href="{{ route('salesman.profile.index') }}"> <img class="gray-nav-icon"
                                src="{{ asset('theme/images/settings.png') }}" alt="Settings" /><img
                                class="purple-nav-icon" src="{{ asset('theme/images/settings-h.png') }}"
                                alt="Settings" />
                            <span>Settings</span> </a>
                    </li>
                    <li  class="nav-item">
                        <a class="nav_link" href="{{ route('salesman.dashboard.logout') }}">
                            <img class="gray-nav-icon" src="{{ asset('theme/images/logout-16.jpg') }}" alt="Logout" />
                            <img class="purple-nav-icon" src="{{ asset('theme/images/logout_h.png') }}" alt="Logout" />
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            @endif
        @endif
    @endauth
    </div>
</nav>
</div>
