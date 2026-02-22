<!doctype html>

<html
        lang="en"
        class="light-style layout-wide customizer-hide"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="assets/"
        data-template="vertical-menu-template-no-customizer"
        data-style="dark">

<head>
    <meta charset="utf-8"/>
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Login</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css"/>
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css"/>

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css"/>
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css"/>
    <link rel="stylesheet" href="assets/css/demo.css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css"/>
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/vendor/libs/@form-validation/form-validation.css"/>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css"/>

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
</head>

<body>
<!-- Content --><?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Errors:</strong>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">


        <div class="authentication-inner py-6">
            <!-- Login Card -->
            <div class="card p-md-4 p-3">
                <div class="app-brand justify-content-center mt-4">
                    <a href="/" class="app-brand-link gap-2">
                        <span class="app-brand-text demo text-primary fw-bold fs-3">Projects Tracking</span>
                    </a>
                </div>

                <div class="card-body">
                    <h4 class="mb-2">Welcome Back! 👋</h4>
                    <p class="mb-4 text-muted">Please log in to continue managing your projects.</p>

                    <!-- Redesigned demo credentials – no wide table -->
                    <div class="bg-light border rounded p-3 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-information-line me-2 text-primary"></i>
                            <small class="fw-bold text-uppercase text-muted">Demo Credentials</small>
                        </div>

                        <div class="demo-credentials-list d-grid gap-3">
                            <!-- Admin -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border border-2 border-dark">
                                <div>
                                    <span class="badge bg-label-danger me-2">Admin</span>
                                    <code>admin@mail.com</code>
                                </div>
                                <div class="small">
                                    <span class="badge bg-label-danger me-2">Password</span>
                                    <code>20252025</code>
                                </div>
                            </div>


                            <!-- Supervisor -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border border-2 border-dark">
                                <div>
                                    <span class="badge bg-label-warning me-2">Supervisor</span>
                                    <code>supervisor@mail.comm</code>
                                </div>
                                <div class="small">
                                    <span class="badge bg-label-warning me-2">Password</span>
                                    <code>20252025</code>
                                </div>
                            </div>


                            <!-- Student -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border border-2 border-dark">
                                <div>
                                    <span class="badge bg-label-info me-2">Student</span>
                                    <code>2106643@students.kcau.ac.ke</code>
                                </div>
                                <div class="small">
                                    <span class="badge bg-label-info me-2">Password</span>
                                    <code>20252025</code>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Login form -->
                    <form id="formAuthentication" class="mb-3" action="<?= $loginUrl ?>" method="POST">
                        <div class="form-floating form-floating-outline mb-4">
                            <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    required
                                    autofocus
                            />
                            <label for="email">Email</label>
                        </div>

                        <div class="mb-4">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="············"
                                            required
                                    />
                                    <label for="password">Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer">
            <i class="ri-eye-off-line"></i>
          </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100 shadow-sm" type="submit">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Login Card -->
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Core JS -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/libs/hammer/hammer.js"></script>
<script src="assets/vendor/libs/i18n/i18n.js"></script>
<script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="assets/vendor/js/menu.js"></script>
<!-- endbuild -->
<!-- Main JS -->
<script src="assets/js/main.js"></script>

</body>

</html>