<section id="page-header" class="about-header">
    <h2>#Giỏ Hàng</h2>
</section>
<?php if (!empty($carts)): ?>
    <section id="cart" class="section">
        <table>
            <thead>
                <tr>
                    <td>Thao Tác</td>
                    <td>Ảnh</td>
                    <td>Sản Phẩm</td>
                    <td>Giá</td>
                    <td>Số Lượng</td>
                    <td>Size</td>
                    <td>Tổng Cộng</td>
                </tr>
            </thead>
            <tbody>

                <?php

                $total = 0;
                $all_id = "";
                foreach ($carts as $cart):
                    $price = $cart['price'] - ($cart['price'] * $cart['discount_percent'] / 100);
                    $total += $price * $cart['quantity'];
                    $all_id .= "," . $cart['D_id'];
                    ?>
                    <tr>
                        <td>
                            <form action="<?= _WEB_ROOT_ ?>/Cart/delCart/<?= $cart['D_id'] ?>"><button type="submit"
                                    class="bg-white" style="border: none;"><i class="fa-regular fa-circle-xmark"></i></button>
                            </form>
                        </td>
                        <td><img src="<?= _WEB_ROOT_ ?>/public/assets/img/<?= $cart['img'] ?>" alt="" /></td>
                        <td><?= $cart['name'] ?></td>
                        <td><?= number_format($price) ?>đ</td>
                        <td>
                            <div class="counter">
                                <form action="<?= _WEB_ROOT_ ?>/Cart/miniusCart/<?= $cart['D_id'] ?>">
                                    <button class="button minus bg-white" <?php if ($cart['quantity'] <= 1)
                                        echo "disabled" ?>>-</button>
                                    </form>
                                    <input type="number" name="" id="" value="<?= $cart['quantity'] ?>" class="number" />
                                <form action="<?= _WEB_ROOT_ ?>/Cart/plusCart/<?= $cart['D_id'] ?>">
                                    <button class="button plus bg-white" type="submit" <?php if ($cart['quantity'] >= $cart['stock_quantity'])
                                        echo "disabled" ?>>+</button>
                                    </form>
                                </div>
                            </td>
                            <td><?= $cart['size_name'] ?></td>
                        <td><?= number_format($price * $cart['quantity']) ?>đ</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section">
        <form action="<?= _WEB_ROOT_ ?>/dat-hang" id="subtotal" method="post">
            <h3>Tổng giỏ hàng</h3>
            <table>
                <tr>
                    <td>Tổng giỏ hàng</td>
                    <td><?= number_format($total) ?></td>
                </tr>
                <tr>
                    <td>Phí ship</td>
                    <td>0đ</td>
                </tr>
                <tr>
                    <td><strong>Tổng thanh toán</strong></td>
                    <td><strong><?= number_format($total) ?> đ</strong></td>
                </tr>
            </table>
            <?php $all_id = ltrim($all_id, ","); ?>
            <input type="hidden" name="all_id" id="" value="<?= $all_id ?>">
            <input type="hidden" name="total" id="" value="<?= $total ?>">
            <button class="normal" type="submit">Tiến hành thanh toán</button>
        </form>
        <?php ?>
    </section>
<?php else: ?>
    <div class="container">
        <div class="w-100 text-center my-3">
            <p class="alert alert-warning">Giỏ hàng trống!</p>
        </div>
        <a href="<?= _WEB_ROOT_ ?>/trang-chu" class="btn btn-outline-success m-3">Mua hàng</a>
    </div>
<?php endif ?>