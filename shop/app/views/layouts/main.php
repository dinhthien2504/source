<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= _WEB_ROOT_ ?>/public/assets/img/logo-site.store.png" type="image/x-icon">
  <title><?= $title_page ?? 'Trang Chủ Website'; ?></title>
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/css/base.css">
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/css/main.css">
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/css/responsive.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
  <!-- icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <!-- bootstrap -->
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/bootstrap/bootstrap.min.css">
  <script src="<?= _WEB_ROOT_ ?>/public/assets/bootstrap/bootstrap.bundle.min.js"></script>
  <!-- messager -->
  <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/messager/messager.css">

</head>

<body>
  <div class="app">
    <!-- header -->
    <?= $this->render('layouts/header') ?>
    <div class="app__container">
      <!-- Content -->
      <?= $this->render($content, $sub_content) ?>
    </div>
    <!-- Footer -->
    <?= $this->render('layouts/footer') ?>

    <?= $this->render('layouts/messager'); ?>
    <div id="messager"></div>
  </div>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/messager/messager.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/jquery/jquery-3.7.1.min.js"></script>

  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/main.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/pro.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/cart.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/user.js"></script>
  <script src="<?= _WEB_ROOT_ ?>/public/assets/js/rating.js"></script>
</body>

</html>