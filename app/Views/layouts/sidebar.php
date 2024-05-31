<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-pink elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/assets/dist/img/aptatola.png" alt="Aptatola Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bolder text-uppercase "><?= $toko; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/profile/<?= session()->get('photo'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-capitalize"><?= session()->get('fullname'); ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/transaction/payment" class="nav-link <?= (uri_string() == 'transaction/payment') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Payment
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= ((uri_string() == 'transaction') || (uri_string() == 'transaction/create') || (uri_string() == 'transaction/reports')) ? 'menu-open' : '' ?>">
                    <a href="" class="nav-link <?= ((uri_string() == 'transaction') || (uri_string() == 'transaction/create') || (uri_string() == 'transaction/reports') || (strpos(uri_string(), 'transaction/edit/') !== false) || (strpos(uri_string(), 'transaction/invoice/') !== false) || (strpos(uri_string(), 'transaction/detail/') !== false)) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>
                            Transaction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/transaction/create" class="nav-link <?= (uri_string() == 'transaction/create') ? 'active' : '' ?>">
                                <i class="ml-3 fas fa-plus-circle nav-icon"></i>
                                <p>New Transaction</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/transaction" class="nav-link <?= (uri_string() == 'transaction') ? 'active' : '' ?>">
                                <i class="ml-3 fas fa-list-alt nav-icon"></i>
                                <p>Transaction List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/transaction/reports" class="nav-link <?= (uri_string() == 'transaction/reports') ? 'active' : '' ?>">
                                <i class="ml-3 fas fa-book nav-icon"></i>
                                <p>Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <?php if (!empty($package['id'])) { ?>
                        <a href="/package" class="nav-link <?= (uri_string() == 'package' || uri_string() == 'package/create' || uri_string() == 'package/edit/' . $package['id']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Package
                            </p>
                        </a>
                    <?php } else { ?>
                        <a href="/package" class="nav-link <?= (uri_string() == 'package' || uri_string() == 'package/create' || uri_string() == 'package/edit/') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Package
                            </p>
                        </a>
                    <?php } ?>
                </li>
                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <?php if (!empty($employee['id'])) { ?>
                        <a href="/employee" class="nav-link <?= (uri_string() == 'employee' || uri_string() == 'employee/create' || uri_string() == 'employee/edit/' . $employee['id']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Employee
                            </p>
                        </a>
                    <?php } else { ?>
                        <a href="/employee" class="nav-link <?= (uri_string() == 'employee' || uri_string() == 'employee/create' || uri_string() == 'employee/edit/') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Employee
                            </p>
                        </a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <a href="/store" class="nav-link <?= (uri_string() == 'store') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Store
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/profile/information" class="nav-link <?= (uri_string() == 'profile/information') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <form id="logout" action="/logout" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <button type="submit" class="nav-link btn btn-secondary text-white logout-btn">
                            <i class="nav-icon fas fa-angle-left"></i>
                            <p>
                                Log Out
                            </p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>