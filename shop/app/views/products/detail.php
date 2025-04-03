<div class="wide">
    <div class="p-2">
        <!-- Main Detail -->
        <div class="d-flex align-items-center justify-content-start pb-4 gap-2 flex-nowrap">
            <a href="<?= _WEB_ROOT_ ?>" class="text-decoration-none text-secondary fs-14 no-wrap cursor-pointer">Trang
                chủ</a>
            <i class="fas fa-chevron-right"></i>
            <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $data_cate['parent_name'] ?>', 'cat<?= $data_cate['parent_id'] ?>-cidnull')"
                class="text-decoration-none text-secondary fs-14 no-wrap cursor-pointer"><?= $data_cate['parent_name'] ?></a>
            <i class="fas fa-chevron-right"></i>
            <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $data_cate['chirld_name'] ?>', 'cat<?= $data_cate['parent_id'] ?>-cid<?= $data_cate['cate_id'] ?>')"
                class="text-decoration-none text-secondary fs-14 no-wrap cursor-pointer"><?= $data_cate['chirld_name'] ?></a>
            <i class="fas fa-chevron-right"></i>
            <span class="fs-14 fw-normal ellipsis"><?= $pro_id['name'] ?></span>
        </div>
        <div class="bg-white p-3">
            <div class="row g-4">
                <?php if (!empty($pros_image)): ?>
                    <div class="col-12 col-lg-5 col-md-6">
                        <div class="row g-1">
                            <div class="col-12">
                                <div class="custom-detail__container-img-main">
                                    <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pros_image[0]['url_image'] ?>"
                                        class="custom-detail__img--main" alt="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 align-items-center justify-content-star scroll">
                                    <?php foreach ($pros_image as $pro_img): ?>
                                        <div onclick="change_img_main(this, '.custom-detail__img--item')"
                                            class="custom-detail__img--item">
                                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_img['url_image'] ?>"
                                                class="cursor-pointer" alt="">
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                <div class="col-12 col-lg-7 col-md-6">
                    <div class="mt-3 d-flex flex-column h-100 gap-4">
                        <h3 class="m-0"><?= $pro_id['name'] ?></h3>
                        <div class="d-flex align-items-center gap-3 fs-14">
                            <span class="text-decoration-underline">
                                <?php
                                if (isset($data_avg_rate) && !empty($data_avg_rate['totalStars'])) {
                                    $avgRate = $data_avg_rate['totalStars'] / $data_avg_rate['totalReviews'];
                                    echo round($avgRate, 1);
                                } else {
                                    echo 0;
                                }
                                ?>
                            </span>
                            <div class="d-flex text-warning">
                                <?php if (isset($avgRate) && $avgRate > 0) {
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < floor($avgRate)) {
                                            echo '<i class="fa-solid fa-star"></i>';
                                        } elseif ($i < $avgRate) {
                                            echo '<i class="fa-solid fa-star-half-alt"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                } else {
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                } ?>
                            </div>
                            <i class="fa-solid fa-minus"></i>
                            <span><?= !empty($data_avg_rate['totalReviews']) ? $data_avg_rate['totalReviews'] : 0 ?>
                                đánh
                                giá</span>
                        </div>
                        <div class="d-flex align-items-center custom-detail__price gap-2">
                            <p class="m-0">
                                <?= number_format($pro_id['price'] - ($pro_id['price'] * ($pro_id['discount_percent'] / 100))) ?>
                                đ
                            </p>
                            <del class=" ms-1 text-sale"><?= number_format($pro_id['price']) ?> đ</del>
                        </div>
                        <div class="d-flex align-items-center fs-14 gap-1">
                            <p class="my-0">Còn <span class="fw-bold"><?= $pro_id['total_quantity'] ?></span> sản phẩm
                                trong
                                kho!</p>
                        </div>
                        <!-- Nếu có cả màu và size -->
                        <?php if (isset($cor_size_pro_id) && !empty($cor_size_pro_id)): ?>
                            <div class="row g-2">
                                <div class="col-2">
                                    <p class="m-0 fs-14">Màu sắc</p>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php foreach ($cor_size_pro_id as $cor): ?>
                                            <div class="custom-detail__img--color"
                                                onclick="change_cor(this, '<?= $cor['pro_id'] ?>', <?= $cor['cor_id'] ?>)">
                                                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cor['url_image'] ?>"
                                                    class="cursor-pointer" alt="">
                                                <p class="m-0"><?= $cor['name'] ?></p>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-2">
                                    <p class="m-0 mb-1 fs-14">Size</p>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex align-items-center gap-3 ">
                                        <div
                                            class="d-flex custom-detail__size align-items-center flex-wrap gap-1 show__size">
                                            <?php if (!empty($size_cor_id)): ?>
                                                <?php foreach ($size_cor_id as $size): ?>
                                                    <button class="size"><?= $size['name'] ?></button>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <!-- Nếu chỉ có màu -->
                        <?php if (isset($color_pro_id) && !empty($color_pro_id)): ?>
                            <div class="row g-2">
                                <div class="col-2">
                                    <p class="m-0 fs-14">Màu sắc</p>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php foreach ($color_pro_id as $cor): ?>
                                            <div class="custom-detail__img--color"
                                                onclick="get_quantity(this, '.custom-detail__img--color', '<?= $cor['pro_id'] ?>', '<?= $cor['cor_id'] ?>')">
                                                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cor['url_image'] ?>"
                                                    class="cursor-pointer" alt="">
                                                <p class="m-0"><?= $cor['name'] ?></p>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <!-- Nếu chỉ có size -->
                        <?php if (isset($size_pro_id) && !empty($size_pro_id)): ?>
                            <div class="row g-2">
                                <div class="col-2">
                                    <p class="m-0 mb-1 fs-14">Size</p>
                                </div>
                                <div class="col-10">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="d-flex custom-detail__size align-items-center gap-1 show__size flex-wrap">
                                            <?php foreach ($size_pro_id as $size): ?>
                                                <button
                                                    onclick="get_quantity(this, '.size', '<?= $size['pro_id'] ?>', '<?= $size['cor_id'] ?>', '<?= $size['size_id'] ?>')"
                                                    class="size"><?= $size['name'] ?></button>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="row g-2">
                            <div class="col-2">
                                <span class="fs-14">Số lượng</span>
                            </div>
                            <div class="col-10">
                                <div
                                    class="d-flex align-items-center custom-detail__btn--quantity custom-btn__disabled">
                                    <button onclick="change_quantity_detail()"><i
                                            class="fa-solid fa-minus"></i></button>
                                    <input id="custom-detail__quantity" value="1" disabled>
                                    <button class="custom-detail__btn--plus"><i class="fa-solid fa-plus"></i></button>
                                    <p class="m-0 ms-3 text-secondary fw-normal show_stock fs-5"></p>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 custom-detail__btn--submit">
                            <form action="<?= _WEB_ROOT_ ?>/save_cart" method="POST"
                                onclick="return valid_handle_cart()">
                                <input type="hidden" name="pro_quantity" class="quantity__handle">
                                <input type="hidden" name="pro_variant_id" class="variant__handle">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?? '' ?>"
                                    class="user__id">
                                <button type="submit" name="submit_save_cart" class="custom-btn btn-add__cart">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> Thêm vào giỏ
                                </button>
                            </form>
                            <form>
                                <input type="hidden" name="pro_quantity" class="quantity__handle">
                                <input type="hidden" name="pro_variant_id" class="variant__handle">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?? '' ?>"
                                    class="user__id">
                                <button type="button" class="custom-btn btn-by__cart custom-btn__primary">Mua
                                    hàng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Description Detail -->
        <div class="row my-4">
            <div class="col-md-9 col-lg-10">
                <!-- Mô tả -->
                <div class="bg-white p-5">
                    <div class="bg-light p-3">
                        <h3 class="text-secondary fw-normal m-0">MÔ TẢ SẢN PHẨM</h3>
                    </div>
                    <div class="m-0 fs-4 mt-3 p-2"><?= $pro_id['description'] ?></div>
                </div>
                <!-- Đánh giá -->
                <div class="bg-white p-5 my-4" id="session_rating">
                    <div class="p-2">
                        <h3 class="text-secondary fw-normal">ĐÁNH GIÁ SẢN PHẨM</h3>
                        <div class="custom-detail__rating ">
                            <div class="row align-items-center mt-3 py-5 px-1 g-3 custom-detail__rating--box">
                                <div class="col-12 col-md-3 text-center">
                                    <div class="d-flex justify-content-center gap-2 align-items-center">
                                        <h1 class="m-0 fs-2 text-warning">
                                            <?php
                                            if (isset($data_avg_rate) && !empty($data_avg_rate['totalStars'])) {
                                                $avgRate = $data_avg_rate['totalStars'] / $data_avg_rate['totalReviews'];
                                                echo round($avgRate, 1);
                                            } else {
                                                echo 0;
                                            }
                                            ?>
                                        </h1>
                                        <p class="m-0 text-warning fs-4">trên 5</p>
                                    </div>
                                    <div
                                        class="d-flex text-warning mt-1 fs-4 justify-content-center align-items-center">
                                        <?php if (isset($avgRate) && $avgRate > 0) {
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < floor($avgRate)) {
                                                    echo '<i class="fa-solid fa-star"></i>';
                                                } elseif ($i < $avgRate) {
                                                    echo '<i class="fa-solid fa-star-half-alt"></i>';
                                                } else {
                                                    echo '<i class="far fa-star"></i>';
                                                }
                                            }
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <form class="m-0 p-0" action="" method="POST">
                                        <div class="gap-1 d-flex flex-wrap custom-detail__btn--rate">
                                            <button type="button"
                                                class="<?= !isset($_GET['rating']) || $_GET['rating'] == 0 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(0)">Tất cả</button>
                                            <button type="button"
                                                class="<?= isset($_GET['rating']) && $_GET['rating'] == 5 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(5)">5
                                                sao</button>
                                            <button type="button"
                                                class="<?= isset($_GET['rating']) && $_GET['rating'] == 4 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(4)">4 sao</button>
                                            <button type="button"
                                                class="<?= isset($_GET['rating']) && $_GET['rating'] == 3 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(3)">3 sao</button>
                                            <button type="button"
                                                class="<?= isset($_GET['rating']) && $_GET['rating'] == 2 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(2)">2 sao</button>
                                            <button type="button"
                                                class="<?= isset($_GET['rating']) && $_GET['rating'] == 1 ? 'custom-detail__btn--rate_active' : '' ?>"
                                                onclick="updateRating(1)">1 sao</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <!-- Item rate -->
                            <?php if (!empty($data_rates)): ?>
                                <?php foreach ($data_rates as $rate): ?>
                                    <div class="row mb-3">
                                        <div class="col-lg-1 col-md-2 col-2">
                                            <img src="https://i.pinimg.com/236x/5e/e0/82/5ee082781b8c41406a2a50a0f32d6aa6.jpg"
                                                alt="Avatar" class="rounded-circle w-100">
                                        </div>
                                        <div class="col-lg-11 col-md-10 col-10">
                                            <h5 class="mb-1 fs-14"><?= $rate['name_user'] ?></h5>
                                            <p class="text-muted mb-2 fs-14"> <?= $rate['date_rate'] ?> | Phân loại hàng:
                                                <?= $rate['name_variant'] ?>
                                            </p>
                                            <div class="text-warning mb-2 fs-14">
                                                <?php
                                                for ($i = 0; $i < 5; $i++) {
                                                    if ($i < $rate['rating']) {
                                                        echo '<i class="fa-solid fa-star"></i>';
                                                    } else {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <p class="fs-14"><?= $rate['review_text'] ?></p>
                                            <div class="d-flex gap-1 flex-wrap custom-detail__img--rate scroll">
                                                <?php
                                                $rate['url_images'] = !empty($rate['url_images']) ? explode(',', $rate['url_images']) : [];
                                                if (!empty($rate['url_images'])) {
                                                    foreach ($rate['url_images'] as $key => $img) {
                                                        echo ' <img src="' . _WEB_ROOT_ . '/public/assets/img/rate/' . $img . '" alt="Image 1" style="width: 75px; height: 75px;"
                                                class="img-thumbnail">';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                <?php endforeach ?>
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center mt-5">
                                    <p class="alert alert-warning w-100 text-center fs-17">Không có đánh giá!</h3>
                                </div>
                            <?php endif ?>
                        </div>
                        <ul class="pagination home-product__pagination">
                            <?php
                            if (isset($links)) {
                                echo $links;
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if (!empty($pro_cate_id)): ?>
                <div class="col-md-3 col-lg-2">
                    <div class="bg-white p-2">
                        <h3 class="fw-normal text-secondary fs-5 mb-3">TOP LIÊN QUAN</h3>
                        <div class="row">
                            <?php foreach ($pro_cate_id as $pro_cate): ?>
                                <div class="col-md-12 col-sm-3 col-4">
                                    <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $pro_cate['name'] ?>', 'i<?= $pro_cate['id'] ?>')"
                                        class="custom-pro__item">
                                        <div class="custom-pro__item__img"
                                            style="background-image: url(<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_cate['url_image'] ?>);">
                                        </div>
                                        <h4 class="custom-pro__item__name"><?= $pro_cate['name'] ?></h4>
                                        <div class="custom-pro__item__price">
                                            <span class="custom-pro__item__price-old"><?= number_format($pro_cate['price']) ?>
                                                đ</span>
                                            <span
                                                class="custom-pro__item__price-current"><?= number_format($pro_cate['price'] - ($pro_cate['price'] * ($pro_cate['discount_percent'] / 100))) ?>
                                                đ</span>
                                        </div>

                                        <div class="custom-pro__item__sale-off">
                                            <span
                                                class="custom-pro__item__sale-off-percent"><?= $pro_cate['discount_percent'] ?>%</span>
                                            <span class="custom-pro__item__sale-off-label">GIẢM</span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>