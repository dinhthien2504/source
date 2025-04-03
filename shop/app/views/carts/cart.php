<div class="wide">
    <div class="custom-cart__title">
        <div class="title-sesson bg-while p-4 mg-0 d-flex align-items-center">
            <h1 class="m-0">Giỏ Hàng</h2>
        </div>
    </div>
    <?php if (!empty($data_carts)): ?>
        <form action="<?=_WEB_ROOT_?>/handle-cart" method="POST" onsubmit="return valid_cart()">
            <!-- header cart -->
            <div class="custom-cart__top-nav my-3">
                <div class="px-2 py-3 bg-while">
                    <div class="row">
                        <div class="col-1">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="custom-cart__check">
                                    <div class="cbx">
                                        <input class="check-all__item custom-cart_check--all" type="checkbox" id="check__all">
                                        <label for="check__all"></label>
                                        <svg fill="none" viewBox="0 0 15 14" height="12" width="13">
                                            <path d="M2 8.36364L6.23077 12L13 2"></path>
                                        </svg>
                                    </div>
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <filter id="goo-12">
                                                <feGaussianBlur result="blur" stdDeviation="4" in="SourceGraphic"></feGaussianBlur>
                                                <feColorMatrix result="goo-12" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" mode="matrix" in="blur"></feColorMatrix>
                                                <feBlend in2="goo-12" in="SourceGraphic"></feBlend>
                                            </filter>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-11">
                            <div class="row">
                                <div class="col-5">
                                    <p class="m-0">Sản phẩm</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0 text-center">Đơn giá</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0 text-center">Số lượng</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0 text-center">Số tiền</p>
                                </div>
                                <div class="col-1">
                                    <p class="m-0 text-center">Thao tác</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php foreach ($data_carts as $cart) :
                $cart['variants'] = json_decode("[" . $cart['variants'] . "]", true);
                $price_sales = $cart['price'] - ($cart['price'] * $cart['discount_percent'] / 100); ?>
                <!-- item cart -->
                <div class="custom-cart__item my-3 ">
                    <div class="custom-cart__item--title">
                        <div class="row g-0">                       
                            <div class="col-1">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="custom-cart__check">
                                        <div class="cbx">
                                            <input class="check-all__item custom-cart__check--all-item"  type="checkbox"  data-checkgroup="<?= $cart['pro_id'] ?>">
                                            <label ></label>
                                            <svg fill="none" viewBox="0 0 15 14" height="12" width="13">
                                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                                            </svg>
                                        </div>

                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <filter id="goo-12">
                                                    <feGaussianBlur result="blur" stdDeviation="4" in="SourceGraphic"></feGaussianBlur>
                                                    <feColorMatrix result="goo-12" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" mode="matrix" in="blur"></feColorMatrix>
                                                    <feBlend in2="goo-12" in="SourceGraphic"></feBlend>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-11">
                                <h4 class="m-0"><?= $cart['name_pro'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- content -->
                    <?php if (!empty($cart['variants'])) : ?>
                        <?php foreach ($cart['variants'] as $pro_variant) : ?>
                            <div class="custom-cart__item--content">
                                <div class="row g-0 align-items-center">
                                    <div class="col-1">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="custom-cart__check">
                                                <div class="cbx">
                                                    <input name="pro_check__cart[]"  value="<?=$pro_variant['cart_id']?>" 
                                                    class="custom-cart__check--item" type="checkbox" id="check__item-<?=$pro_variant['cart_id']?>" data-checkgroup="<?= $cart['pro_id'] ?>">
                                                    <label for="check__item-<?=$pro_variant['cart_id']?>"></label>
                                                    <svg fill="none" viewBox="0 0 15 14" height="12" width="13">
                                                        <path d="M2 8.36364L6.23077 12L13 2"></path>
                                                    </svg>
                                                </div>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <filter id="goo-12">
                                                            <feGaussianBlur result="blur" stdDeviation="4" in="SourceGraphic"></feGaussianBlur>
                                                            <feColorMatrix result="goo-12" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" mode="matrix" in="blur"></feColorMatrix>
                                                            <feBlend in2="goo-12" in="SourceGraphic"></feBlend>
                                                        </filter>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-11">
                                        <div class="row g-0 align-items-center custom-cart__container--handle">
                                            <div class="col-lg-5 col-12">
                                                <div class="row g-0 d-flex align-items-center">
                                                    <div class="col-lg-3 col-sm-2 col-3">
                                                        <?php if (!empty($pro_variant['url_image'])) : ?>
                                                            <img style="width: 80px; height: 80px; object-fit: cover;" alt="<?= $cart['name_pro'] ?>"
                                                                src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_variant['url_image'] ?>">
                                                        <?php else: ?>
                                                            <img style="width: 80px; height: 80px; object-fit: cover;" alt="<?= $cart['name_pro'] ?>"
                                                                src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cart['url_image'] ?>">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-10 col-9">
                                                        <p class="m-0 text-black custom-cart__name"><?= $cart['name_pro'] ?></p>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="d-flex flex-column">
                                                            <p class="m-0">Phân loại hàng:</p>
                                                            <p class="m-0">
                                                                <?= $pro_variant['name_cor'] ?>
                                                                <?php if ($pro_variant['name_size'] && $pro_variant['name_cor']) echo ', '; ?>
                                                                <?= $pro_variant['name_size'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3">
                                                <div class="text-center">
                                                    <span class="m-0 text-black fw-normal custom-cart_price--sales">
                                                        <?= number_format($price_sales) ?> đ
                                                    </span>
                                                    <del class="fs-5 text-secondary fw-normal"><?= number_format($cart['price']) ?> đ</del>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-4">
                                                <div class="d-flex align-items-center custom-cart__quantity">
                                                    <button type="button" class="cart-quanity__item" onclick="changeQuantity(this, 'minus', <?= $pro_variant['cart_id'] ?>)"><i
                                                            class="fas fa-minus"></i></button>
                                                    <input class="cart-quanity__item cart__quantity" disabled value="<?= $pro_variant['quantity'] ?>">
                                                    <button type="button" class="cart-quanity__item" onclick="changeQuantity(this, 'plus', <?= $pro_variant['cart_id'] ?>, <?= $pro_variant['quantity_stock'] ?>)"><i
                                                            class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-3">
                                                <p class="m-0 text-center custom-cart__price--total---item  fs-4"><?= number_format($price_sales * $pro_variant['quantity']) ?> đ</p>
                                            </div>
                                            <div class="col-lg-1 col-2">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="<?=_WEB_ROOT_?>/handle_del/<?=$pro_variant['cart_id']?>" class="custom-cart__btn-del">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 69 14"
                                                            class="custom-cart__btn-del--icon bin-top">
                                                            <g clip-path="url(#clip0_35_24)">
                                                                <path
                                                                    fill="black"
                                                                    d="M20.8232 2.62734L19.9948 4.21304C19.8224 4.54309 19.4808 4.75 19.1085 4.75H4.92857C2.20246 4.75 0 6.87266 0 9.5C0 12.1273 2.20246 14.25 4.92857 14.25H64.0714C66.7975 14.25 69 12.1273 69 9.5C69 6.87266 66.7975 4.75 64.0714 4.75H49.8915C49.5192 4.75 49.1776 4.54309 49.0052 4.21305L48.1768 2.62734C47.3451 1.00938 45.6355 0 43.7719 0H25.2281C23.3645 0 21.6549 1.00938 20.8232 2.62734ZM64.0023 20.0648C64.0397 19.4882 63.5822 19 63.0044 19H5.99556C5.4178 19 4.96025 19.4882 4.99766 20.0648L8.19375 69.3203C8.44018 73.0758 11.6746 76 15.5712 76H53.4288C57.3254 76 60.5598 73.0758 60.8062 69.3203L64.0023 20.0648Z"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_35_24">
                                                                    <rect fill="white" height="14" width="69"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 69 57"
                                                            class="custom-cart__btn-del--icon bin-bottom">
                                                            <g clip-path="url(#clip0_35_22)">
                                                                <path
                                                                    fill="black"
                                                                    d="M20.8232 -16.3727L19.9948 -14.787C19.8224 -14.4569 19.4808 -14.25 19.1085 -14.25H4.92857C2.20246 -14.25 0 -12.1273 0 -9.5C0 -6.8727 2.20246 -4.75 4.92857 -4.75H64.0714C66.7975 -4.75 69 -6.8727 69 -9.5C69 -12.1273 66.7975 -14.25 64.0714 -14.25H49.8915C49.5192 -14.25 49.1776 -14.4569 49.0052 -14.787L48.1768 -16.3727C47.3451 -17.9906 45.6355 -19 43.7719 -19H25.2281C23.3645 -19 21.6549 -17.9906 20.8232 -16.3727ZM64.0023 1.0648C64.0397 0.4882 63.5822 0 63.0044 0H5.99556C5.4178 0 4.96025 0.4882 4.99766 1.0648L8.19375 50.3203C8.44018 54.0758 11.6746 57 15.5712 57H53.4288C57.3254 57 60.5598 54.0758 60.8062 50.3203L64.0023 1.0648Z"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_35_22">
                                                                    <rect fill="white" height="57" width="69"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="custom-cart__hr">
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <!-- btn bottom-->
            <div class="custom-cart__btn--footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">                  
                        <div class="custom-cart__check">
                            <div class="cbx">
                                <input class="check-all__item custom-cart_check--all" type="checkbox" id="check_all">
                                <label for="check_all"></label>
                                <svg fill="none" viewBox="0 0 15 14" height="12" width="13">
                                    <path d="M2 8.36364L6.23077 12L13 2"></path>
                                </svg>
                            </div>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <filter id="goo-12">
                                        <feGaussianBlur result="blur" stdDeviation="4" in="SourceGraphic"></feGaussianBlur>
                                        <feColorMatrix result="goo-12" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" mode="matrix" in="blur"></feColorMatrix>
                                        <feBlend in2="goo-12" in="SourceGraphic"></feBlend>
                                    </filter>
                                </defs>
                            </svg>
                        </div>
                        <p class="m-0 fs-3 text-black fw-normal">Tất cả</p>
                        <button type="submit" name="submit_handle__del" class="custom-cart__btn--del--footer">
                            <svg class="delete-svg__con" viewBox="0 0 448 512">
                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <p class="m-0 custom-cart__total">Tổng: 0 đ</p>
                        <button type="submit" name="submit_handle__buy" class="custom-btn custom-btn__primary">Mua hàng</button>
                    </div>
                    
                </div>
            </div>
        </form>
    <?php else: ?>
        <h1 class="alert alert-warning text-center">Giỏ hàng trống</h1>
    <?php endif ?>
</div>