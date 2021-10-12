<ul class="nav navbar-nav navbar-right sidebar-menu hidden">
    @auth

    @if(\Route::has('dashboards.index') && \Auth::User()->can("view_dashboards"))
    <li class="{{ (request()->segment(1) == 'dashboards') ? 'active' : '' }}">
        <a href="{{ route('dashboards.index') }}">
            <i class="fa fa-dashboard"></i>&nbsp;Dashboard
        </a>
    </li>
    @endif

    <li class="dropdown {{ (request()->segment(1) == 'master') ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-database"></i>&nbsp;Master Data <b class="caret"></b></a>
        <ul class="dropdown-menu treeview-menu">

            @if(\Route::has('brands.index') && \Auth::User()->can("view_brands"))
            <li>
                <a href="{{ route('brands.index') }}">
                    <i class="fa fa-car"></i>&nbsp;Brand
                </a>
            </li>
            @endif

            @if(\Route::has('categories.index') && \Auth::User()->can("view_categories"))
            <li>
                <a href="{{ route('categories.index') }}">
                    <i class="fa fa-tags"></i>&nbsp;Category
                </a>
            </li>
            @endif

            @if(\Route::has('customers.index') && \Auth::User()->can("view_customers"))
            <li>
                <a href="{{ route('customers.index') }}">
                    <i class="fa fa-users"></i>&nbsp;Customers
                </a>
            </li>
            @endif

            @if(\Route::has('products.index') && \Auth::User()->can("view_products"))
            <li>
                <a href="{{ route('products.index') }}">
                    <i class="fa fa-space-shuttle"></i>&nbsp;Product
                </a>
            </li>
            @endif

            @if(\Route::has('suppliers.index') && \Auth::User()->can("view_suppliers"))
            <li>
                <a href="{{ route('suppliers.index') }}">
                    <i class="fa fa-truck"></i>&nbsp;Supplier
                </a>
            </li>
            @endif

            @if(\Route::has('types.index') && \Auth::User()->can("view_types"))
            <li>
                <a href="{{ route('types.index') }}">
                    <i class="fa fa-rocket"></i>&nbsp;Types
                </a>
            </li>
            @endif

            <li class="divider"></li>
            
            @if(\Route::has('roles.index') && \Auth::User()->can("view_roles"))
            <li>
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-key"></i>&nbsp;Role
                </a>
            </li>
            @endif

            @if(\Route::has('users.index') && \Auth::User()->can("view_users"))
            <li>
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-user"></i>&nbsp;User
                </a>
            </li>
            @endif

        </ul>
    </li>
    <li class="dropdown {{ (request()->segment(1) == 'transaction') ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-money"></i>&nbsp;Transaction <b class="caret"></b></a>
        <ul class="dropdown-menu treeview-menu">
            @if(\Route::has('purchases.index') && \Auth::User()->can("view_purchases"))
            <li>
                <a href="{{ route('purchases.index') }}">
                    <i class="fa fa-cart-arrow-down"></i>&nbsp;Purchases
                </a>
            </li>
            @endif
            @if(\Route::has('sales.index') && \Auth::User()->can("view_sales"))
            <li>
                <a href="{{ route('sales.index') }}">
                    <i class="fa fa-cart-plus"></i>&nbsp;Sales
                </a>
            </li>
            @endif
        </ul>
    </li>

    @if(\Route::has('reports.index') && \Auth::User()->can("view_reports"))
    <li class="{{ (request()->segment(1) == 'reports') ? 'active' : '' }}">
        <a href="{{ route('reports.index') }}">
            <i class="fa fa-line-chart"></i>&nbsp;Report
        </a>
    </li>
    @endif


    <li class="dropdown {{ (request()->segment(1) == 'profiles') ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-plus"></i>&nbsp;{{ \Auth::User()->username }} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('profiles.index') }}"><i class="fa fa-user"></i>&nbsp;My Profile</a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>&nbsp;Sign out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
    
    @endauth
    @yield('shortcut-link')
</ul>