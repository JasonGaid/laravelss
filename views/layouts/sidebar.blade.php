<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Users</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('post') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Manage Posts</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/category">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Manage Category</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('violation') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Violations</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span style="color: white;">Reports</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingReports" data-parent="#accordionSidebar" style="background-color: #3f51b5;">
            <div class="bg-primary py-2 collapse-inner rounded" style="color: white;">
            <a class="collapse-item" href="{{ route('user_report') }}">User Report</a>
            <a class="collapse-item" href="{{ route('post_report') }}">Post Report</a>

                <a class="collapse-item" href="#">Violation Report</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
