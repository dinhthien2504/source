<section id="Hero">
    <h4>Trade-in-offer</h4>
    <h2>Ưu đãi siêu giá trị</h2>
    <h1>Trên tất cả sản phẩm</h1>
    <p>Tiết kiệm nhiều hơn với phiếu giảm giá & giảm giá tới 70%!</p>
    <button>Mua Sắm Ngay</button>
</section>

<section id="feature" class="section">
    <div class="row g-0 xl-overflow-hidden-brand flex-nowrap horizontal-scroll g-2">
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img class="w-100" src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f1.png" alt="" />
                <h6>Free Shipping</h6>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img class="w-100" src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f2.png" alt="" />
                <h6>Đặt Hàng Online</h6>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img class="w-100" src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f3.png" alt="" />
                <h6>Tiết Kiệm Tiền</h6>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img class="w-100" src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f4.png" alt="" />
                <h6>Khuyến Mãi</h6>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img class="w-100" src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f5.png" alt="" />
                <h6>Happy Sell</h6>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="d-flex align-items-center flex-column fe-box">
                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/features/f6.png" alt="" />
                <h6>Hỗ Trợ 24/7</h6>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="text-center">
        <h2>Sản Phẩm Mới</h2>
        <p>Bộ sưu tập mùa hè - Thiết kế mới</p>
    </div>
    <div class="row g-2">
        <?php foreach ($proNew as $pro) {
            extract($pro) ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 position-relative">
                <div class="card rounded-4 ">
                    <div class="card-body d-flex flex-column gap-2">
                        <a class="text-decoration-none text-secondary"
                            href="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $id ?>">
                            <img style="height: 350px; object-fit: cover;"
                                src="<?php echo _WEB_ROOT_ ?>/public/assets/img/<?= $img ?>"
                                class="card-img-top img-pro rounded-4" alt="...">
                        </a>
                        <p class="card-title m-0 p-0 fw-semibold"><?= $name; ?></p>
                        <div class="rate d-flex text-warning mt-1 fs-13">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span
                                    class="price fw-bold"><?= number_format($price - ($price * $discount_percent / 100)) ?>đ</span>
                                <del class="fs-13 text-secondary"><?= number_format($price) ?></del>
                            </div>

                            <a href="#" id="shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>

                </div>
                <div class="btn--new">
                    <span class="pro--new">New</span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<section id="banner" class="section-m1">
    <h4>Dịch Vụ Sửa Chữa</h4>
    <h2>Giảm giá lên tới <span>70% </span> đối với áo thun và tất cả phụ kiện</h2>
    <button class="normal">Khám Phá Thêm</button>
</section>

<section id="product1" class="section">
    <div class="text-center">
        <h2>Sản Phẩm Bán Chạy</h2>
        <p>Bộ sưu tập mùa hè - Thiết kế mới</p>
    </div>
    <div class="row g-2">
        <?php foreach ($proSales as $pro) {
            extract($pro) ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 position-relative">
                <div class="card rounded-4 ">
                    <div class="card-body d-flex flex-column gap-2">
                        <a class="text-decoration-none text-secondary"
                            href="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $id ?>">
                            <img style="height: 350px; object-fit: cover;" src="<?php echo _WEB_ROOT_ ?>/public/assets/img/<?= $img ?>" class="card-img-top rounded-4"
                                alt="...">
                        </a>
                        <p class="card-title m-0 p-0 fw-semibold"><?= $name; ?></p>
                        <div class="rate d-flex text-warning mt-1 fs-13">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span
                                    class="price fw-bold"><?= number_format($price - ($price * $discount_percent / 100)) ?>đ</span>
                                <del class="fs-13 text-secondary"><?= number_format($price) ?></del>
                            </div>

                            <a href="#" id="shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>

                </div>
                <div class="btn--new">
                    <span class="pro--new">Hot</span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<style>
    .btn--new {
        position: absolute;

        top: 0px;
        left: 4px;
    }

    .pro--new {
        background-color: #EE0000;
        color: #fff;
        padding: 5px 10px;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 23px 0 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>