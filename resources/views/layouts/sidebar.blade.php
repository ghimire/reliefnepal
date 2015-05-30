<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('/libs/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>{{ $user->name }}</p>

            <a href="#"><i class="fa fa-circle text-success"></i> Logged In</a>
        </div>
        @if ($user->is_admin())
            <div class="pull-right">
                <p class="label bg-aqua">admin</p>
            </div>
        @endif
        <div class="clearfix"></div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li>
            <a href="#organizations">
                <i class="fa fa-group"></i> Organizations
            </a>
        </li>
        @if ($user->is_admin())
        <li>
            <a href="#users">
                <i class="fa fa-group"></i> Users
            </a>
        </li>
        @endif
        <li style="margin-top: 10px; position: relative;" class="text-center">
            <small class="text-muted">
                Made with <i class="fa fa-heart"></i> by Prak.
            </small>
        </li>
    </ul><!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->