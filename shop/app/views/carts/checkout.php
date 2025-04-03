<div class="wide">
    <?php if (!empty($data_carts)): ?>
        <div class="custom-cart__title">
            <div class="title-sesson bg-while p-4 mg-0 d-flex align-items-center">
                <h1 class="m-0">Thanh Toán</h2>
            </div>
        </div>
        <form action="<?= _WEB_ROOT_ ?>/handle_checkout" method="POST" onsubmit="return valid_checkout()">
            <!-- header cart -->
            <div class="custom-cart__top-nav my-3 d-flex  align-items-center justify-content-between">
                <div class="px-2 py-3 bg-while ">
                    <div class="custom-checkout__address--title">
                        <i class="fa-solid fa-location-dot"></i>
                        <h3>Địa Chỉ Nhận Hàng</h3>
                    </div>
                    <?php if ($_SESSION['user']['name'] && $_SESSION['user']['phone'] && $_SESSION['user']['address'] && $_SESSION['user']['address_detail']): ?>
                        <div class="custom-checkout__address--detail">
                            <div class="custom-checkout__address--detail--name">
                                <p class="m-0 fw-normal text-black"><?= $_SESSION['user']['name'] ?? '' ?></p>
                            </div>
                            <div class="custom-checkout__address--detail--phone">
                                <p class="m-0 fw-normal text-black">(+84)<?= $_SESSION['user']['phone'] ?? '' ?></p>
                            </div>
                            <div class="custom-checkout__address--detail--address">
                                <p class="m-0 fw-normal text-black"><?= $_SESSION['user']['address_detail'] ?? '' ?>, <span
                                        id="address_reverse"><?= $_SESSION['user']['address'] ?? '' ?></span></p>
                            </div>
                        </div>
                        <input type="hidden" id="check_address">
                    <?php else: ?>
                        <p class="my-3 ms-4 text-danger">Vui lòng cập nhật địa chỉ để mua hàng</p>
                    <?php endif ?>
                </div>
                <button type="button" style="width: 100px; height: 40px;"
                    class="btn btn-primary text-black custom-checkout__change--address" data-bs-toggle="modal"
                    data-bs-target="#myModalAddress">
                    Cập nhật
                </button>
            </div>
            <?php $total = 0;
            foreach ($data_carts as $cart):
                $cart['variants'] = json_decode("[" . $cart['variants'] . "]", true);
                $price_sales = $cart['price'] - ($cart['price'] * $cart['discount_percent'] / 100); ?>
                <!-- item cart -->
                <div class="custom-cart__item my-3 ">
                    <div class="custom-cart__item--title">
                        <div class="row g-0">
                            <div class="col-12">
                                <h4 class="m-0 ps-3"><?= $cart['name_pro'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- content -->
                    <?php if (!empty($cart['variants'])): ?>
                        <?php foreach ($cart['variants'] as $pro_variant):
                            $total += $price_sales * $pro_variant['quantity']; ?>
                            <div class="custom-cart__item--content">
                                <div class="row g-0 align-items-center">
                                    <div class="col-12 ms-3">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-lg-7 col-12">
                                                <div class="row g-0 d-flex align-items-center">
                                                    <div class="col-lg-2 col-sm-2 col-3">
                                                        <?php if (!empty($pro_variant['url_image'])): ?>
                                                            <img style="width: 80px; height: 80px; object-fit: cover;"
                                                                alt="<?= $cart['name_pro'] ?>"
                                                                src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_variant['url_image'] ?>">
                                                        <?php else: ?>
                                                            <img style="width: 80px; height: 80px; object-fit: cover;"
                                                                alt="<?= $cart['name_pro'] ?>"
                                                                src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cart['url_image'] ?>">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-10 col-9">
                                                        <p class="m-0 text-black custom-cart__name"><?= $cart['name_pro'] ?></p>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="d-flex flex-column">
                                                            <p class="m-0">Phân loại hàng:</p>
                                                            <p class="m-0">
                                                                <?= $pro_variant['name_cor'] ?>
                                                                <?php if ($pro_variant['name_size'] && $pro_variant['name_cor'])
                                                                    echo ', '; ?>
                                                                <?= $pro_variant['name_size'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-3">
                                                <div class="text-center">
                                                    <span class="m-0 text-black fw-normal custom-cart_price--sales">
                                                        <?= number_format($price_sales) ?> đ
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-sm-1 col-2">
                                                <div class="d-flex align-items-center custom-cart__quantity">
                                                    <input class="cart-quanity__item text-center" disabled
                                                        value="<?= $pro_variant['quantity'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-3">
                                                <p class="m-0 text-center custom-cart__price--total---item  fs-4">
                                                    <?= number_format($price_sales * $pro_variant['quantity']) ?> đ
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="custom-cart__hr">
                            <?php
                            $__name_variant = '';
                            if ($pro_variant['name_cor']) {
                                $__name_variant .= $pro_variant['name_cor'];
                            }
                            if ($pro_variant['name_cor'] && $pro_variant['name_size']) {
                                $__name_variant .= ' - ';
                            }
                            if ($pro_variant['name_size']) {
                                $__name_variant .= $pro_variant['name_size'];
                            }
                            ?>
                            <input type="hidden" name="cart_id[]" value="<?= $pro_variant['cart_id'] ?>">
                            <input type="hidden" name="quantity[]" value="<?= $pro_variant['quantity'] ?>">
                            <input type="hidden" name="price[]" value="<?= $price_sales ?>">
                            <input type="hidden" name="pro_id[]" value="<?= $cart['pro_id'] ?>">
                            <input type="hidden" name="pro_variant_id[]" value="<?= $pro_variant['pro_variant_id'] ?>">
                            <input type="hidden" name="name_variant[]" value="<?= $__name_variant ?>">
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?? '' ?>">
            <input type="hidden" name="total" value="<?= $total ?? 0 ?>">

            <!-- btn bottom-->
            <div class="custom-cart__btn--footer">
                <div class="d-flex justify-content-between align-items-center">
                    <?php if (!empty($data_payment_method)): ?>
                        <div>
                            <h3 class=" fw-bold mb-3">Phương thức thanh toán</h3>
                            <?php foreach ($data_payment_method as $value): ?>
                                <div class="checkbox-payment-checkout my-2">
                                    <input style="display: none;" type="radio" name="payment" id="cbx<?= $value['id'] ?>" value="<?= $value['id'] ?>"
                                        class="inp-cbx" <?=$value['id'] == 1 ? 'checked' : ''?>/>
                                    <label for="cbx<?= $value['id'] ?>" class="cbx">
                                        <span>
                                            <svg viewBox="0 0 12 9" height="9px" width="12px">
                                                <polyline points="1 5 4 8 11 1"></polyline>
                                            </svg>
                                        </span>
                                        <span class="fs-17"><?= $value['name'] ?></span>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <div class="d-flex flex-column">
                        <p class="m-0 custom-cart__total mb-3">Tổng cộng: <?= number_format($total) ?> đ</p>
                        <button type="submit" name="submit__checkout" class="custom-btn custom-btn__primary">Hoàn Tất Đặt
                            Hàng</button>
                    </div>
                </div>
            </div>
        </form>
    <?php else: ?>
        <h1 class="alert alert-warning text-center">Vui lòng đăng nhập để sử dụng chức năng này!</h1>
    <?php endif; ?>
</div>
<!-- The Modal Change Address -->
<div class="modal" id="myModalAddress">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="custom-checkout__change--address--modal">
                <span class="title">Địa Chỉ Nhận Hàng</span>
                <form class="custom-checkout__change--address---form">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="group">
                                <input placeholder="‎" id="name" type="text" name="name"
                                    value="<?= $_SESSION['user']['name'] ?? '' ?>">
                                <label for="name">Họ Và Tên</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group">
                                <input placeholder="‎" type="number" id="phone" name="phone"
                                    value="<?= $_SESSION['user']['phone'] ?? '' ?>">
                                <label for="phone">Số Điện Thoại</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group_address__detail">
                                <div class="group mb-1">
                                    <input readonly class="mb-1" placeholder="‎" id="address" name="address" type="text"
                                        value="<?= $_SESSION['user']['address'] ?? '' ?>"
                                        onfocus="show_address__detail()">
                                    <label>Tỉnh/ Thành phố, Quận/Huyện, Phường/Xã</label>
                                    <input type="hidden" id="check_address_change"
                                        value="<?= $_SESSION['user']['address'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="group_address__detail--content d-none">
                                <div class="group_address__detail--content__nav">
                                    <span id="province" onclick="get_province()"
                                        class="custom_active--border">Tỉnh/Thành Phố</span>
                                    <span id="district">Quận/Huyện</span>
                                    <span id="ward">Phường/Xã</span>
                                </div>
                                <div class="group_address__detail--content__show">
                                    <ul id="custom_checkout--show--data">
                                        <?php if (!empty($data_province)): ?>
                                            <?php foreach ($data_province as $province): ?>
                                                <!-- custom_active--li -->
                                                <li onclick="get_district_province_id('<?= $province['id'] ?>', '<?= $province['name'] ?>')"
                                                    class=""><?= $province['name'] ?></li>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group mt-4">
                                <textarea placeholder="‎" id="address_detail" name="address_detail"
                                    rows="5"><?= $_SESSION['user']['address_detail'] ?? '' ?></textarea>
                                <label for="address__detail">Địa Chỉ Cụ Thể</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="update_address()">Hoàn Tất</button>
                </form>
            </div>
        </div>
    </div>
</div>