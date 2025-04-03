<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= _WEB_ROOT_ ?>/public/assets/img/logo-site.store.png" type="image/x-icon">
  <!-- STYLESHEET -->
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/css/admin/main.css" />
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/messager/messager.css" />
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/bootstrap/bootstrap.min.css">
  <!-- ICONS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <!-- Editor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
  <title><?= !empty($title_page) ? $title_page : 'Trang Chủ Admin'; ?></title>
</head>

<body>
  <div class="custom-container">
    <!-- header -->
    <?= $this->render('layouts/header_admin'); ?>
    <!-- content -->
    <?= $this->render($content, $sub_content); ?>
  </div>
  <?= $this->render('layouts/messager'); ?>
  <div id="messager"></div>
  <!-- Jquery -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/jquery/jquery-3.7.1.min.js"></script>
  <!-- Messager -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/messager/messager.js"></script>
  <!-- Bootstrap -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/bootstrap/bootstrap.bundle.min.js"></script>
  <!-- Custom Main -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/admin/main.js"></script>
  <!-- Custom Pro -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/admin/pro.js"></script>
  <!-- Custom Cate -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/admin/cate.js"></script>
  <!-- Custom User -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/admin/user.js"></script>
  <!-- Custom Order -->
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/admin/order.js"></script>
</body>

</html>