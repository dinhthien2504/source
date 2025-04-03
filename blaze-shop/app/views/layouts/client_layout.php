<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= (!empty($page_title)) ? $page_title : 'Trang chủ website'; ?>
    </title>
    <!-- Link icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/132c0e1345.js" crossorigin="anonymous"></script>
    <!-- Link style -->
    <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/style.css">
    <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/loginstyle.css">
    <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/profile.css">
    <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/forgot.css">
    <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/OrderHistory.css">

    <!-- Link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Link messger -->
     <link rel="stylesheet" href="<?= _WEB_ROOT_ ?>/public/assets/client/css/messger.css">
</head>
<body>
    <?php
    // Render header
    $this->render('layouts/header');

    // Render content
    if (isset($sub_content) && is_array($sub_content)) {
        // Nếu sub_content tồn tại và là mảng, render
        $this->render($content, $sub_content);
    } else {
        // Nếu không có sub_content, render một mảng rỗng hoặc mặc định
        $this->render($content, []);
    }
    // Render footer
    $this->render('layouts/footer');
    $this->render('layouts/messger');
    ?>
    <div id="messger"></div>
    <!-- <button onclick="messger('Thành công', 'Thành công', 'success')">Click Me</button> -->
    <script src="<?= _WEB_ROOT_ ?>/public/assets/client/js/style.js"></script>
    <script src="<?= _WEB_ROOT_ ?>/public/assets/client/js/messger.js"></script>
</body>
</html>

