<section class="container bg-eee">
    <div class="row p-3 gap-clm">
        <div class="col-lg-2 col-md-12 col-12">
            <div class="custom-profile py-3">
                <div class="d-flex align-items-center justify-content-start gap-3">
                    <?php if ($_SESSION['user']['url_image'] == '') {
                        echo '<img class="custom-profile-img__main" src="https://m.yodycdn.com/blog/avatar-dep-cho-nam-yody-vn33.jpg">';
                    } else {
                        echo '<img src="' . _WEB_ROOT_ . '/public/img/' . $_SESSION['user']['url_image'] . '" alt="Profile Image">';
                    } ?>
                    <h5 class="mt-2 text-color fs-5 fw-bold"><?= $_SESSION['user']['name'] ?? ""; ?></h5>
                </div>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item d-flex align-items-center fs-17">
                        <i class="fas fa-clipboard-list"></i>
                        <a class="nav-link text-black" href="<?= _WEB_ROOT_ ?>/user/purchase">Đơn Mua</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-10 col-md-12 col-12 py-3 rounded">
            <!-- Thông tin đơn hàng -->
            <div>
                <!-- header cart -->
                <div class="custom-profile__top-nav my-3">
                    <div class="px-2 py-3 bg-while">
                        <div class="row scroll flex-nowrap">
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=0"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= !isset($_GET['status']) || $_GET['status'] == 0 ? 'active' : '' ?>">Tất
                                    cả
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=1"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 1 ? 'active' : '' ?>">Chờ
                                    xác
                                    nhận</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=2"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 2 ? 'active' : '' ?>">Đã
                                    xác
                                    nhận</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=3"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 3 ? 'active' : '' ?>">Đang
                                    giao
                                    hàng</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=4"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 4 ? 'active' : '' ?>">Đã
                                    giao
                                    hàng</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=6"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 6 ? 'active' : '' ?>">Hoàn thành
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                                <a href="<?= _WEB_ROOT_ ?>/user/purchase?status=5"
                                    class="fs-17 mb-1 m-0 text-decoration-none d-block text-center no-wrap cursor-pointer <?= isset($_GET['status']) && $_GET['status'] == 5 ? 'active' : '' ?>">Đã
                                    hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($data_order_by_user_id)): ?>
                    <?php $status = [
                        '1' => 'Chờ xác nhận',
                        '2' => 'Đã xác nhận',
                        '3' => 'Đang giao hàng',
                        '4' => 'Đã giao hàng',
                        '5' => 'Đã hủy',
                        '6' => 'Hoàn thành',
                    ];
                    foreach ($data_order_by_user_id as $order):
                        $order_detail = json_decode($order['order_detail'], true);
                        ?>
                        <!-- item order -->
                        <div class="custom-cart__item my-3 ">
                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                <div class="p-3">
                                    <h4 class="cursor-pointer" onclick="get_order_by_id(this)" data-bs-toggle="modal"
                                        data-bs-target="#showOrderModal" data-id="<?= $order['order_id'] ?>" class="m-0">#
                                        <?= $order['code_order'] ?>
                                    </h4>
                                </div>
                                <p class="fw-bold m-0 me-2 no-wrap">
                                    <i class="fas fa-caravan"></i>
                                    <?= $status[$order['status']] ?>
                                </p>
                            </div>
                            <!-- content -->
                            <?php if (!empty($order_detail)): ?>
                                <?php foreach ($order_detail as $Dorder):
                                    ?>
                                    <div class="custom-cart__item--content">
                                        <div class="row g-0 align-items-center custom-cart__container--handle">
                                            <div class="col-xl-1 col-md-2 col-sm-2 col-3">
                                                <img style="width: 80px; height: 80px; object-fit: cover;" alt="Hình ảnh"
                                                    src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $Dorder['url_image'] ?>">
                                            </div>
                                            <div class="col-xl-9 col-md-8 col-sm-8 col-6">
                                            <a onclick="handle__url_link(this, '<?=_WEB_ROOT_ ?>',  '<?= $Dorder['name_pro'] ?>', 'i<?=$Dorder['pro_id']?>')" class="text-decoration-none text-black my-0 cursor-pointer">
                                                <?=$Dorder['name_pro'] ?>
                                            </a>
                                                <div class="d-flex gap-1">
                                                    <p class="m-0">Phân loại hàng:</p>
                                                    <p class="m-0"><?= $Dorder['name_variant'] ?></p>
                                                </div>
                                                <p class="m-0 text-black custom-cart__name">x<?= $Dorder['quantity'] ?></p>
                                            </div>
                                            <div class="col-xl-2 col-md-2 col-sm-2 col-3">
                                                <div class="text-center">
                                                    <span class="m-0 custom-text-primary fw-normal">
                                                        <?= number_format($Dorder['price']) ?> đ
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="custom-cart__hr">
                                <?php endforeach; ?>
                                <div class="custom-profile__btn--footer">
                                    <div class="d-flex align-items-center justify-content-between gap-4">
                                        <p class="m-0 custom-cart__total">Tổng: <?= number_format($order['total']) ?> đ</p>
                                        <div>
                                        <?php if ($order['status'] >= 4): ?>
                                            <button type="submit" name="submit_handle__buy" class="custom-btn custom-btn__primary "
                                                style="padding: 0 10px;">Mua
                                                lại</button>
                                        <?php endif; ?>
                                        <?php if ($order['status'] == 1): ?>
                                            <a href="<?= _WEB_ROOT_ ?>/user/cancel_order-<?= $order['order_id'] ?>"
                                                onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                                                class="custom-btn custom-btn__danger " style="padding: 0 10px;">Hủy đơn</a>
                                        <?php endif; ?>
                                        <?php if ($order['status'] == 4): ?>
                                            <a href="<?= _WEB_ROOT_ ?>/user/confirm-order-success-<?= $order['order_id'] ?>"
                                                class="custom-btn custom-btn__success " style="padding: 0 10px;">Đã nhận được hàng</a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning d-flex align-items-center justify-content-center">
                        <p class="fs-17 fw-bold text-center m-0">Bạn chưa có đơn hàng nào!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- The Modal Show Order -->
<div class="modal" id="showOrderModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông Tin Đơn Hàng</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="show_order_detail"></div>
        </div>
    </div>
</div>

<!-- The Modal Show Rating -->
<div class="modal custom-rating" id="showAddRating">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= _WEB_ROOT_ ?>/create-rating" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="d-flex gap-2 col-12" id="showRate"></div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-start gap-1">
                                <p class="m-0 fs-17">Chất lượng sản phẩm:</p>
                                <div class="d-flex text-warning fs-17 justify-content-center align-items-center" id="starRating">
                                    <i class="fa-solid fa-star selected" data-star="1"></i>
                                    <i class="fa-solid fa-star selected" data-star="2"></i>
                                    <i class="fa-solid fa-star selected" data-star="3"></i>
                                    <i class="fa-solid fa-star selected" data-star="4"></i>
                                    <i class="fa-solid fa-star selected" data-star="5"></i>
                                </div>
                                <p class="m-0 fs-17" id="ratingText">Tuyệt vời</p>
                            </div>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="5">
                        <input type="hidden" name="user_id" value="<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : 1; ?>">
                        <div class="col-12 p-3" style="background-color: #f5f5f5;">
                            <div class="p-2 border" style="background-color: #fff;">
                                <div class="my-1">
                                    <label for="text" class="form-label fs-17">Cảm nhận của bạn về sản phẩm:</label>
                                    <textarea class="custom-textarea-rating fs-17" name="review_text"></textarea>
                                </div>
                                <div class="container my-1">
                                    <label for="fileInput" id="createImg" class="label-file">
                                        <i class="bi bi-camera-fill"></i>
                                        Thêm Hình Ảnh:
                                    </label>
                                    <div class="file-preview" id="filePreview"></div>
                                    <div id="remainingImages" class="text-muted">5/5 ảnh.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit_create_rating" class="custom-btn custom-btn__danger">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>
</div>
