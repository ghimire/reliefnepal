<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="{{ asset('/libs/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ $user->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        <img src="{{ asset('/libs/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
                        <p class="text-muted"><small>Member Since</small></p>
                        <p>
                            @if($user->created_at)
                                {{ $user->created_at }}
                            @endif
                        </p>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="javascript:;" class="btn btn-default btn-flat">
                                <i class="fa fa-user"></i> Profile
                            </a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat">
                                <i class="fa fa-sign-out"></i> Sign out
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>