<div class="wide">
    <!-- Banner -->
    <div class="pt-3">
        <div class="row g-2">
            <div class="col-lg-8 col-12">
                <!-- Carousel -->
                <div id="demo" class="carousel slide" data-bs-ride="carousel">

                    <!-- Indicators/dots -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0"
                            class="active custom-btn__banner"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"
                            class="custom-btn__banner"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"
                            class="custom-btn__banner"></button>
                    </div>

                    <!-- The slideshow/carousel -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/banner1.jpg" alt="Hình Ảnh Banner 1"
                                class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/banner2.jpg" alt="Hình Ảnh Banner 2"
                                class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/banner3.jpg" alt="Hình Ảnh Banner 3"
                                class="d-block w-100">
                        </div>
                    </div>

                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="row g-1">
                    <div class="col-lg-12 col-6">
                        <img src="https://cf.shopee.vn/file/sg-11134258-7rfgj-m3ztxoc27iic14_xhdpi" class="w-100"
                            alt="">
                    </div>
                    <div class="col-lg-12 col-6">
                        <img src="https://cf.shopee.vn/file/sg-11134258-7rfhq-m3yntz5dpl8o78_xhdpi" class="w-100"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category -->
    <div class="my-2">
        <div class="p-4 bg-white custom-title_session">
            <h3>DANH MỤC</h3>
        </div>
        <div class="row g-0 flex-nowrap scroll">
            <?php if (!empty($cates_parent)): ?>
                <?php foreach ($cates_parent as $cate): ?>
                    <div class="custom-col-lg-1-2 col-sm-2 col-3">
                        <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $cate['name'] ?>', 'cat<?= $cate['id'] ?>-cidnull')"
                            class="custom-pro__item m-0 p-3 ">
                            <div class="custom-pro__item__img p-5 justify-content-center d-flex align-items-center"
                                style="background-image: url(<?= _WEB_ROOT_ ?>/public/assets/img/cate/<?= $cate['url_image'] ?>);">
                            </div>
                            <h4 class="custom-pro__item__name text-center m-0"><?= $cate['name'] ?></h4>
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <!-- Banner Phụ -->
    <div class="my-2">
        <img src="https://cf.shopee.vn/file/vn-11134258-7r98o-lylx97r9vezl4e" class="w-100" alt="">
    </div>
    <!-- Product new -->
    <div class="my-2">
        <div class="p-4 bg-white custom-title_session">
            <h3>SẢN PHẨM MỚI</h3>
        </div>
        <div class="row g-2">
            <?php if (!empty($pros_new)): ?>
                <?php foreach ($pros_new as $__pro): ?>
                    <div class="custom-col-lg-2-5 col-md-3 col-sm-4 col-6">
                        <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $__pro['name'] ?>', 'i<?= $__pro['id'] ?>')"
                            class="custom-pro__item">
                            <div class="custom-pro__item__img"
                                style="background-image: url(<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $__pro['url_image'] ?>);">
                            </div>
                            <h4 class="custom-pro__item__name"><?= $__pro['name'] ?></h4>
                            <div class="custom-pro__item__price">
                                <span class="custom-pro__item__price-old"><?= number_format($__pro['price']) ?> đ</span>
                                <span
                                    class="custom-pro__item__price-current"><?= number_format($__pro['price'] - ($__pro['price'] * ($__pro['discount_percent'] / 100))) ?>đ</span>
                            </div>
                            <div class="custom-pro__item__action">
                                <div class="custom-pro__item__rating">
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="custom-pro__item__sold"><?= $__pro['sell'] ?> Đã bán</div>
                            </div>
                            <div class="custom-pro__item__origin">
                                <span class="custom-pro__item__origin-name">Việt Nam</span>
                            </div>
                            <!-- <div class="custom-pro__item__favourite">
              <i class="fas fa-check "></i>
              <span>Yêu thích</span>
            </div> -->
                            <?php if ($__pro['discount_percent'] > 0): ?>
                                <div class="custom-pro__item__sale-off">
                                    <span class="custom-pro__item__sale-off-percent"><?= $__pro['discount_percent'] ?>%</span>
                                    <span class="custom-pro__item__sale-off-label">GIẢM</span>
                                </div>
                            <?php endif ?>
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <!-- Banner Phụ -->
    <div class="my-2">
        <img src="https://cf.shopee.vn/file/sg-11134252-7rfgf-m3zsauhtdegkac" class="w-100" alt="">
    </div>
    <!-- Product Hot -->
    <div class="my-2">
        <div class="p-4 bg-white custom-title_session">
            <h3>SẢN PHẨM BÁN CHẠY</h3>
        </div>
        <div class="row g-2">
            <?php if (!empty($pros_best_sellers)): ?>
                <?php foreach ($pros_best_sellers as $__pro): ?>
                    <div class="custom-col-lg-2-5 col-md-3 col-sm-4 col-6">
                        <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $__pro['name'] ?>', 'i<?= $__pro['id'] ?>')"
                            class="custom-pro__item">
                            <div class="custom-pro__item__img"
                                style="background-image: url(<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $__pro['url_image'] ?>);">
                            </div>
                            <h4 class="custom-pro__item__name"><?= $__pro['name'] ?></h4>
                            <div class="custom-pro__item__price">
                                <span class="custom-pro__item__price-old"><?= number_format($__pro['price']) ?> đ</span>
                                <span
                                    class="custom-pro__item__price-current"><?= number_format($__pro['price'] - ($__pro['price'] * ($__pro['discount_percent'] / 100))) ?>đ</span>
                            </div>
                            <div class="custom-pro__item__action">
                                <div class="custom-pro__item__rating">
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="custom-pro__item__star--gold fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="custom-pro__item__sold"><?= $__pro['sell'] ?> Đã bán</div>
                            </div>
                            <div class="custom-pro__item__origin">
                                <span class="custom-pro__item__origin-name">Việt Nam</span>
                            </div>
                            <!-- <div class="custom-pro__item__favourite">
              <i class="fas fa-check "></i>
              <span>Yêu thích</span>
            </div> -->
                            <?php if ($__pro['discount_percent'] > 0): ?>
                                <div class="custom-pro__item__sale-off">
                                    <span class="custom-pro__item__sale-off-percent"><?= $__pro['discount_percent'] ?>%</span>
                                    <span class="custom-pro__item__sale-off-label">GIẢM</span>
                                </div>
                            <?php endif ?>
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>