<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>

    <title>21/06643</title>

    <meta name="description" content=""/>

    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css"/>
    <!-- <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" /> -->

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core-dark.css"/>
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-bordered-dark.css"/>
    <link rel="stylesheet" href="assets/css/demo.css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php
        if ($_SESSION['user']['role'] == 'admin') {
            $menu = '../app/Views/Admin/menu.php';
        } elseif ($_SESSION['user']['role'] == 'supervisor') {
            $menu = '../app/Views/Supervisor/menu.php';
        } else {
            $menu = '../app/Views/Student/menu.php';
        }
        if (isset($_SESSION['viewpdf'])) {
            unset($_SESSION['viewpdf']);
        } else {
            require_once $menu;
        }
        ?>


        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                 id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                        <i class="ri-menu-fill ri-22px"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="btn btn-outline-info" href="javascript:history.back()">
                                Back
                            </a>
                        </div>
                    </div>

                    <ul class="navbar-nav flex-row align-items-center ms-auto">


                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow waves-effect waves-light"
                               href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                               aria-expanded="false">
                                <i class="ri-notification-2-line ri-22px"></i>
                                <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="dropdown-menu-header border-bottom py-50">
                                    <div class="dropdown-header d-flex align-items-center py-2">
                                        <h6 class="mb-0 me-auto">Notification</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">8 New</span>
                                            <a href="javascript:void(0)"
                                               class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all waves-effect waves-light"
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               aria-label="Mark all as read"
                                               data-bs-original-title="Mark all as read"><i
                                                        class="ri-mail-open-line text-heading ri-20px"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container ps">
                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect waves-light">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/6.png" alt=""
                                                             class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">New unread notification</h6>
                                                    <small class="mb-1 d-block text-body">New unread notifiaction
                                                        body</small>
                                                    <small class="text-muted">today</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                       class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                                class="ri-close-line ri-20px"></span></a>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                    </div>
                                </li>
                                <li class="border-top">
                                    <div class="d-grid p-4">
                                        <a class="btn btn-primary btn-sm d-flex waves-effect waves-light"
                                           href="javascript:void(0);">
                                            <small class="align-middle">View all notifications</small>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                               data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="../../assets/img/user.jpg" alt="" class="rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item waves-effect" href="pages-account-settings-account.html">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <img src="../../assets/img/user.jpg" alt="" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block small"><?= $_SESSION['user']['username'] ?> </span>
                                                <small class="text-muted"><?= $_SESSION['user']['role'] ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>


                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>

                                <li>
                                    <div class="d-grid px-4 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex waves-effect waves-light"
                                           href="<?= $this->router->generate('logout'); ?>">
                                            <small class="align-middle">Logout</small>
                                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>

                <!-- Search Small Screens -->
                <div class="navbar-search-wrapper search-input-wrapper d-none">
                    <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
                           aria-label="Search...">
                    <i class="ri-close-fill search-toggler cursor-pointer"></i>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">