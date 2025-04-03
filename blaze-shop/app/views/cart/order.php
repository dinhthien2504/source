<section id="page-header" class="about-header">
    <h2>#Giỏ Hàng</h2>
</section>
<div class="container my-5">
    <form action="<?= _WEB_ROOT_ ?>/order/createOrder" method="post">
        <div class="row g-5">
            <div class="col-12 col-md-6">
                <h3 class="fs-5">Địa chỉ giao hàng</h3>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="my-2">
                            <label class="fs-13" for="name">Họ tên*</label>
                            <input type="text" class="form-control fs-13" name="name" required
                                value="<?= $_SESSION['user']['name'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="my-2">
                            <label class="fs-13" for="phone">Số điện thoại*</label>
                            <input type="text" class="form-control fs-13" name="phone" required
                                value="<?= $_SESSION['user']['phone'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="my-2">
                            <label class="fs-13" for="email">Email*</label>
                            <input type="email" class="form-control fs-13" name="email" required
                                value="<?= $_SESSION['user']['email'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="my-2">
                            <label class="fs-13" for="address">Địa chỉ*</label>
                            <input type="text" class="form-control fs-13" name="address" required
                                value="<?= $_SESSION['user']['address'] ?? '' ?>">
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <label class="fs-13" for="comment">Ghi chú đơn hàng:</label>
                    <textarea class="form-control" rows="3" name="note"></textarea>
                </div>
            </div>
            <div class="col-12 col-md-6 ps-4">
                <div class="p-2 bg-checkout">
                    <div class="voucher-box">
                        <h3 class="fs-5">Mã giảm giá</h3>
                        <form action="">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá..."
                                name="voucher_id" />
                            <button class="normal btn-checkout my-3" type="submit">Áp dụng</button>
                        </form>
                    </div>
                    <h3 class="fs-5">Đơn hàng</h3>
                    <?php
                    $total = 0;
                    $ids = "";
                    $size = "";
                    $quantites = "";
                    $prices = "";
                    $Dcart_id = "";

                    foreach ($pros as $pro):

                        $price = $pro['price'] - ($pro['price'] * $pro['discount_percent'] / 100);
                        $total += $price * $pro['quantity'];

                        $ids .= '.' . $pro['id'];
                        $size .= "." . $pro['size'];
                        $quantites .= '.' . $pro['quantity'];
                        $prices .= '.' . $price;
                        $pro_Dcart_id = $pro['Dcart_id'] ?? "";
                        $Dcart_id .= '.' . $pro_Dcart_id;


                        ?>
                        <p class="fs-13 my-2 fw-bold"><?= $pro['name'] ?></p>
                        <p class="fs-13 my-2">Giá: <span class="fw-bold"><?= number_format($price) ?>đ</span></p>
                        <p class="fs-13 my-2">Size: <span class="fw-bold"><?= $pro['size_name'] ?></span></p>
                        <p class="fs-13 my-2">Số lượng: <span class="fw-bold"><?= $pro['quantity'] ?></span></p>
                        <p class="fs-13 my-2">Tổng sản phẩm: <span
                                class="fw-bold"><?= number_format($price * $pro['quantity']) ?>đ</span></p>
                        <hr>

                    <?php
                    endforeach;
                    $ids = ltrim($ids, '.');
                    $size = ltrim($size, '.');
                    $quantites = ltrim($quantites, '.');
                    $prices = ltrim($prices, '.');
                    $Dcart_id = ltrim($Dcart_id, '.');
                    ?>


                    <div class="d-flex align-items-center justify-content-between">
                        <label class="fs-10 my-2"> Giảm giá:</label>
                        <div class="text-end">
                            <p class="fs-13 my-0 fw-bold text-end">0đ</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="fs-10 my-2"> Tổng tiền:</label>
                        <div class="text-end">
                            <p class="fs-13 my-0 fw-bold text-end"><?= number_format($total) ?>đ</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <label class="fs-13"><input type="radio" checked name="payment" value="cod"> Tiền
                            mặt(COD)</label>
                        <div class="text-end">
                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pay/money.png" class="h-100" alt="">
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="fs-13"><input type="radio" name="payment" value="vnpay"> Ví điện tử VNPAY</label>
                        <div class="text-end">
                            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pay/vnpay.png" class="h-100" alt="">
                        </div>
                    </div>

                    <input type="hidden" name="user_id" id="" value="<?= $_SESSION['user']['id'] ?>">
                    <input type="hidden" name="pro_ids" id="" value="<?= $ids ?>">
                    <input type="hidden" name="sizes" id="" value="<?= $size ?>">
                    <input type="hidden" name="quantities" id="" value="<?= $quantites ?>">
                    <input type="hidden" name="prices" id="" value="<?= $prices ?>">
                    <input type="hidden" name="total" id="" value="<?= $total ?>">
                    <input type="hidden" name="Dcart_id" id="" value="<?= $Dcart_id ?>">

                    <button class="normal btn-checkout mt-2" type="submit">Hoàn tất đặt hàng</button>
                </div>
            </div>
        </div>
</div>




</form>


</div>