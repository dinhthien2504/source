<section class="section">
    <div class="d-flex align-items-center ">
        <a href="<?= _WEB_ROOT_ ?>/trang-chu" class="text-decoration-none text-secondary">Trang Chủ</a>
        <span>/</span>
        <p class="m-0 text-secondary fs-6"><?= $proDetail['name'] ?></p>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-5">
            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/<?= $proDetail['img'] ?>" id="MainImg" class="w-100 h-75"
                alt="" />
            <div class="my-2 d-flex gap-1">
                <?php foreach ($proImages as $img) { ?>
                    <div class="small-img-col">
                        <img src="<?= _WEB_ROOT_ ?>/public/assets/img/<?= $img['image'] ?>" class="small-img w-100"
                            alt="" />
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-md-7 mt-3">
            <div class="d-flex flex-column gap-3">
                <h4 class="fs-6 m-0"><?= $proDetail['name'] ?></h4>
                <h2 class="fs-5 fw-bold price m-0">
                    <?= number_format($proDetail['price'] - ($proDetail['price'] * $proDetail['discount_percent'] / 100)) ?>đ
                </h2>
                <div class="d-flex flex-column gap-1">
                    <p class="m-0 mb-1 fs-17">Kích thước: <span class="fw-bold" id="MainSize">S</span></p>
                    <div class="d-flex align-items-center gap-1">
                        <div class="d-flex align-items-center gap-1">
                            <?php if (isset($sizes) && count($sizes) > 0): ?>
                                <?php foreach ($sizes as $size): ?>
                                    <?php if ($size['quantity'] > 0): ?>
                                        <button type="button" class="btn btn-outline-secondary small-size"
                                            data-pro-id="<?= $proDetail['id'] ?>" data-size-id="<?= $size['id'] ?>"
                                            data-size-name="<?= $size['name'] ?>">
                                            <?= $size['name'] ?>
                                        </button>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center btn-quantity-detail gap-3">
                    <span class="fs-15">Số lượng</span>
                    <div class="d-flex align-items-center btn-quantity">
                        <button type="button" class="btn" onclick="minusIndex()">-</button>
                        <input type="number" style="width: 150px;" id="quantityInput" class="btn" value="1" min="1" />
                        <button type="button" class="btn" onclick="plusIndex()">+</button>

                    </div>

                </div>
                <div class="d-flex align-items-center gap-2">

                    <form id="sizeForm" action="<?= _WEB_ROOT_ ?>/them-vao-gio" method="POST">
                        <input type="hidden" name="selected_size" class="selected_size" value="1">
                        <input type="hidden" name="pro_id" id="pro_id" value="<?= $pro_id ?>">
                        <input type="hidden" name="quantity" id="quantityCart">
                        <button type="submit" class="normal fs-6 hover-brand">Thêm vào giỏ</button>
                    </form>

                    <form action="<?= _WEB_ROOT_ ?>/dat-hang" method="post">
                        <input type="hidden" name="selected_size" class="selected_size" value="1">
                        <input type="hidden" name="pro_id" id="" value="<?= $pro_id ?>">
                        <input type="hidden" name="quantity_detail" id="quantityToOrder">

                        <button type="submit" class="normal fs-6 hover-brand">Mua hàng</button>
                    </form>

                    <form>
                        <button type="button" class="normal fs-6 hover-brand"><i
                                class="fa-regular fa-heart"></i></button>
                    </form>
                </div>
                <div class="m-0">
                    <h4 class="fs-5">Mô Tả Chi Tiết</h4>
                    <span class="text-justify"><?= $proDetail['detail'] ?></span>
                </div>
            </div>
        </div>
    </div>
    <div id="comments-section my-2">
        <div class="card p-4">
            <h4 class="mb-4 fs-5">ĐÁNH GIÁ SẢN PHẨM</h4>
            <div class="row align-items-center py-3 px-1 g-3 bg-rate" style="background-color: #fffbf8; ">
                <div class="col-12 col-md-3 text-center">
                    <div class="d-flex justify-content-center gap-2 align-items-center">
                        <h1 class="m-0 fs-2 text-warning">
                            <?php
                            if (isset($dataAvgRate) && !empty($dataAvgRate['totalStars'])) {
                                $avgRate = $dataAvgRate['totalStars'] / $dataAvgRate['totalReviews'];
                                echo round($avgRate, 1);
                            } else {
                                echo 0;
                            }
                            ?>
                        </h1>
                        <p class="m-0 text-warning fs-4">trên 5</p>
                    </div>
                    <div class="d-flex text-warning mt-1 fs-6 justify-content-center align-items-center">
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
                    <form class="m-0 p-0" action="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $proDetail['id'] ?>"
                        method="POST">
                        <div class="gap-1 d-flex flex-wrap" role="group" aria-label="Filter buttons">
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1  <?= empty($_POST['submitFilterRate']) ? 'bg-active-page' : ''; ?>"
                                value="">Tất Cả</button>
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1  <?= isset($_POST['submitFilterRate']) && $_POST['submitFilterRate'] == "5" ? 'bg-active-page' : ''; ?>"
                                value="5">5
                                sao (<?= $countRate[4]['totalRate'] ?>)</button>
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1  <?= isset($_POST['submitFilterRate']) && $_POST['submitFilterRate'] == "4" ? 'bg-active-page' : ''; ?>"
                                value="4">4
                                sao (<?= $countRate[3]['totalRate'] ?>)</button>
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1  <?= isset($_POST['submitFilterRate']) && $_POST['submitFilterRate'] == "3" ? 'bg-active-page' : ''; ?>"
                                value="3">3
                                sao (<?= $countRate[2]['totalRate'] ?>)</button>
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1  <?= isset($_POST['submitFilterRate']) && $_POST['submitFilterRate'] == "2" ? 'bg-active-page' : ''; ?>"
                                value="2">2
                                sao (<?= $countRate[1]['totalRate'] ?>)</button>
                            <button type="submit" name="submitFilterRate"
                                class="btn btn-outline-secondary p-1 <?= isset($_POST['submitFilterRate']) && $_POST['submitFilterRate'] == "1" ? 'bg-active-page' : ''; ?>"
                                value="1">1
                                sao (<?= $countRate[0]['totalRate'] ?>)</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="review-item mb-3">
                <?php if (isset($dataRate) && count($dataRate) > 0) { ?>
                    <?php foreach ($dataRate as $key => $value) { ?>
                        <div class="row mb-3">
                            <div class="col-md-1 col-2">
                                <?php if ($value['imgUser'] != "") { ?>
                                    <img src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/<?= $value['imgUser'] ?>" alt="Avatar"
                                        style="width: 50px;" class="border rounded-circle">
                                <?php } else { ?>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7K2k7HM8yHu6BLUCihIcixrwQJq39Jp5fcw&s"
                                        alt="Avatar" class="rounded-circle">
                                <?php } ?>
                            </div>
                            <div class="col-md-11 col-10">
                                <h5 class="mb-1"><?= $value['userName'] ?></h5>
                                <p class="text-muted mb-2">
                                    <?= $value['date'] ?> | Phân loại hàng: <?= $value['name_size'] ?>
                                </p>
                                <div class="text-warning mb-2 fs-13">
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $value['rating']) {
                                            echo '<i class="fa-solid fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p><?= $value['review'] ?></p>
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php
                                    $value['imgRate'] = !empty($value['imgRate']) ? explode(',', $value['imgRate']) : [];
                                    if (!empty($value['imgRate'])) {
                                        foreach ($value['imgRate'] as $key => $img) {
                                            echo ' <img src="' . _WEB_ROOT_ . '/public/assets/img/' . $img . '" alt="Image 1" style="width: 75px; height: 75px;"
                                                class="img-thumbnail">';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                    <?php } ?>
                <?php } else { ?>
                    <p class=" text-danger text-center">Không có đánh giá!</>
                    <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="text-center">
        <h2>Sản Phẩm Liên Quan</h2>
    </div>
    <div class="row g-2 xl-overflow-hidden-brand flex-nowrap horizontal-scroll">
        <?php foreach ($proRelate as $pro) {
            extract($pro) ?>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card rounded-4">
                    <div class="card-body d-flex flex-column gap-2">
                        <a class="text-decoration-none text-secondary"
                            href="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $id ?>">
                            <img style="height: 350px; object-fit: cover;"
                                src="<?php echo _WEB_ROOT_ ?>/public/assets/img/<?= $img ?>" class="card-img-top rounded-4"
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
                            <span
                                class="price fw-bold"><?= number_format($price - ($price * $discount_percent / 100)) ?>đ</span>
                            <a href="#" id="shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
    <div class="test"></div>
</section>
<script>
    const MainImg = document.getElementById("MainImg");
    const smallimg = document.querySelectorAll(".small-img");
    const quantityInput = document.getElementById("quantityInput");
    const quantityToOrder = document.getElementById("quantityToOrder");
    const quantityToCart = document.getElementById("quantityCart");
    const selectedSizes = document.querySelectorAll(".selected_size")

    $(document).ready(function () { //lay size check so luong
        $(document).on('click', '.small-size', function () {
            $('.small-size').removeClass('active')
            $(this).addClass('active')
            quantityInput.value = 1
            var pro_id = $(this).data('pro-id')
            var size_id = $(this).data('size-id')
            var size_name = $(this).data('size-name')

            document.getElementById("MainSize").innerText = size_name;
            selectedSizes.forEach((input) => {
                input.value = size_id
            })
            $.ajax({
                url: "<?= _WEB_ROOT_ ?>/product/getQuantityFromDsize",
                type: "POST",
                data: {
                    proId: pro_id,
                    sizeId: size_id
                },
                success: function (data) {
                    let maxQuantity = data
                    quantityInput.dataset.max = maxQuantity

                }, error: function () {
                    console.log(error)
                }
            })
        })
    })



    smallimg.forEach((img) => {
        img.addEventListener("click", () => {
            MainImg.src = img.src;
        });
    });

    function minusIndex() {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
            updateQuantity()
        }
    }

    function plusIndex() {
        let currentQuantity = parseInt(quantityInput.value);
        let maxQuantity = quantityInput.dataset.max;

        if (currentQuantity < maxQuantity) {
            quantityInput.value = currentQuantity + 1;
            updateQuantity();
        }
    }

    function updateQuantity() {
        quantityToOrder.value = quantityInput.value;
        quantityToCart.value = quantityInput.value;
    }
    quantityInput.addEventListener("input", () => {
        updateQuantity()
    });

    updateQuantity();
</script>