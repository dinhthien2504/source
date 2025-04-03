<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>
    <?= (!empty($page_title)) ? $page_title : 'Admin website'; ?>
  </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" />
  <!-- Custom fonts for this template-->
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <!-- Link icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Custom styles for this template-->
  <link href="<?= _WEB_ROOT_ ?>/public/assets/admin/css/admin.css" rel="stylesheet">

  <!-- Link messger -->
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/messger.css">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php $this->render('layouts/headerAdmin'); ?>


    <!-- Begin Page Content -->
    <?php $this->render($content, $sub_content); ?>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- End of Main Content -->
  <?php $this->render('layouts/footerAdmin'); ?>
  <?php $this->render('layouts/messger'); ?>
  <!-- Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div id="messger"></div>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn đăng xuất?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Quay lại</button>
          <a class="btn btn-success" href="<?= _WEB_ROOT_ ?>/auth/logout">Đăng xuất</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Link messger -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/client/js/messger.js"></script>
  <!-- Link icon -->
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <!-- <script src="<?= _WEB_ROOT_ ?>/public/assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script> -->

  <!-- Custom scripts for all pages-->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/admin/js/bootstrap-min-2.min.js"></script>

  <!-- Page level plugins -->


  <!-- Page level custom scripts -->

</body>

</html>