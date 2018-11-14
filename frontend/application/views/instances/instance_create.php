<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Free Bootstrap-4 Admin Dashboard Template</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php  $this->load->view('layout/navbar'); ?>


    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->

        <?php  $this->load->view('layout/navbar-menu'); ?>


        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">



            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->

            <?php  $this->load->view('layout/footer'); ?>

            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
</body>
</html>
