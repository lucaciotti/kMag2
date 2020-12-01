<!DOCTYPE html>
<html>
<?php include_once "autoload.php"; ?>
<?php include_once "header.php"; ?>

<!-- <body class="hold-transition sidebar-mini layout-fixed"> -->
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <header class="main-header bg-gray-light pl-3 pt-2 pb-1 pr-3">
            <div class="row">
                <div class="col col-2 text-left">
                    <img src="images/logo.jpg" height="25px">
                </div>
                <div class="col col-8 text-center text-lg">
                    <label class="text-xl-center font-italic"><?php echo $title; ?></label>
                </div>
                <div class="col col-2 text-right">
                    <img src="images/logo.jpg" height="25px">
                </div>
            </div>
        </header>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active"><?php echo $title; ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php include "$page_content"; ?>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer bg-gray-light">
            <?php
            if (isset($page_footer)) {
                include "$page_footer";
            } else {
                include "footer.php";
            }
            ?>
        </footer>
    </div>
</body>

</html>