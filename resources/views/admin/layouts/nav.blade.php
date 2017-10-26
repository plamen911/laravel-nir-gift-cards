<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">NIR Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('admin.profile') }}"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-fw fa-power-off"></i> Log Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
    @if (Auth::check())
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="{{ (\Request::route()->getName() == 'admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                <li class="{{ (\Request::route()->getName() == 'admin.orders') ? 'active' : '' }}"><a href="{{ route('admin.orders') }}"><i class="fa fa-fw fa-table"></i> Orders</a></li>
                <li class="{{ (\Request::route()->getName() == 'admin.payment-gateway') ? 'active' : '' }}"><a href="{{ route('admin.payment-gateway') }}"><i class="fa fa-fw fa-money"></i> Payment Gateway</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    @endif
</nav>