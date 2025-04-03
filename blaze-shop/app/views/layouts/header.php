<header id="header">
    <a href="<?= _WEB_ROOT_ ?>/trang-chu"><img src="<?= _WEB_ROOT_ ?>/public/assets/img/logo.png" style="width: 110px;"
            class="logo" alt="" /></a>
    <div>
        <ul id="navbar">
            <li><a href="<?= _WEB_ROOT_ ?>/trang-chu">Trang chủ</a></li>
            <li><a href="<?= _WEB_ROOT_ ?>/san-pham/danh-muc-1-trang-1">Cửa hàng</a></li>
            <li><a href="<?= _WEB_ROOT_ ?>/ve-chung-toi">Về chúng tôi</a></li>
            <li><a href="<?= _WEB_ROOT_ ?>/lien-he">Liên hệ</a></li>
            <input class="view-cart-mb" style="display: none;" type="submit" value="Xem giỏ hàng">
            <li id="lg-bag"><a data-bs-toggle="modal" data-bs-target="#myModal"><i style="font-size: 20px;"
                        class="fa-solid fa-magnifying-glass"></i></a></li>
            <li id="lg-bag">
                <a href="<?= _WEB_ROOT_ ?>/gio-hang"><i style="font-size: 20px;"
                        class="fa-solid fa-bag-shopping fa-lg"></i></a>
            </li>
            <li id="lg-bag">
                <a><i style="font-size: 20px;" class="fa-solid fa-heart fa-lg"></i></a>
            </li>
            <li id="lg-bag">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['image'] != "") { ?>
                        <a href="<?= _WEB_ROOT_ ?>/trang-ca-nhan"><img
                                src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/<?= $_SESSION['user']['image'] ?>" alt=""
                                class="m-0 p-0" style="width: 30px; height: 30px; border-radius: 5px;"></a>
                    <?php } else { ?>
                        <a href="<?= _WEB_ROOT_ ?>/trang-ca-nhan"><img
                                src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/anh-avatar-fb-8.jpg" alt="" class="m-0 p-0"
                                style="width: 30px; height: 30px; border-radius: 5px;"></a>
                    <?php } ?>
                    <!-- Nút đăng xuất -->
                <?php else: ?>
                    <a href="<?= _WEB_ROOT_ ?>/tai-khoan"><i style="font-size: 20px;" class="fa-solid fa-user"></i></a>
                <?php endif; ?>
            </li>

            <!-- Thẻ này được thêm vào khi mình làm responsive -->
            <a href="#" id="close"><i class="fa-solid fa-xmark fa-sm"></i></a>
        </ul>
    </div>

    <!-- Thẻ này được thêm vào khi mình làm responsive -->
    <div id="mobile">
        <a data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="<?= _WEB_ROOT_ ?>/gio-hang"><i class="fa-solid fa-bag-shopping fa-lg"></i></a>
        <?php if (isset($_SESSION['user'])): ?>
            <?php if ($_SESSION['user']['image'] != "") { ?>
                <a href="<?= _WEB_ROOT_ ?>/trang-ca-nhan" style="margin-left: 20px"><img
                        src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/<?= $_SESSION['user']['image'] ?>" alt=""
                        class="m-0 p-0" style="width: 30px; height: 30px; border-radius: 5px;"></a>
            <?php } else { ?>
                <a href="<?= _WEB_ROOT_ ?>/trang-ca-nhan" style="margin-left: 20px"><img
                        src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/anh-avatar-fb-8.jpg" alt="" class="m-0 p-0"
                        style="width: 30px; height: 30px; border-radius: 5px;"></a>
            <?php } ?>
            <!-- Nút đăng xuất -->
        <?php else: ?>
            <a href="<?= _WEB_ROOT_ ?>/tai-khoan"><i style="font-size: 20px;" class="fa-solid fa-user"></i></a>
        <?php endif; ?>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</header>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg m-auto mt-1">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Form for Search -->
                <form action="<?= _WEB_ROOT_ ?>/san-pham/tim-kiem" method="POST">
                    <!-- Search Bar -->
                    <div class="search-bar d-flex justify-content-center">
                        <div class="input-group w-100">
                            <input style="height: 50px;" type="text" id="search" name="kyw" class="form-control"
                                placeholder="Tìm kiếm sản phẩm" aria-label="Tìm kiếm sản phẩm">
                            <button style="height: 50px; width: 60px" class="btn btn-outline-secondary" type="submit"
                                name="submitSearch"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <!-- Keywords -->
                    <div class="my-2">
                        <h4 class="fs-5 text-black my-1">Từ khóa nổi bật hôm nay</h4>
                        <div class="d-flex justify-content-star gap-2 flex-wrap">
                            <button type="submit" name="submitSearch" value="Smartjean"
                                class="btn btn-outline-secondary">Smartjean</button>
                            <button type="submit" name="submitSearch" value="Áo thun"
                                class="btn btn-outline-secondary">Áo
                                thun</button>
                            <button type="submit" name="submitSearch" value="Quần dài"
                                class="btn btn-outline-secondary">Quần
                                dài</button>
                            <button type="submit" name="submitSearch" value="Quần đùi"
                                class="btn btn-outline-secondary">Quần
                                đùi</button>
                            <button type="submit" name="submitSearch" value="Hoodie"
                                class="btn btn-outline-secondary">Hoodie</button>
                        </div>

                        <div id="result" class="my-2 row gap-0"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- The Modal Cho Anh Huy -->
<div class="modal" id="favouriteModal">
    <div class="modal-dialog modal-lg m-auto mt-1">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <h1>Sản Phẩm Yêu Thích</h1>
                <div class="row g-2">
                    <?php if (isset($_SESSION['favor'])):
                        foreach ($_SESSION['favor'] as $pro) {
                            extract($pro) ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 position-relative">
                                <div class="card rounded-4 ">
                                    <div class="card-body d-flex flex-column gap-2">
                                        <a class="text-decoration-none text-secondary"
                                            href="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $id ?>">
                                            <img src="<?php echo _WEB_ROOT_ ?>/public/assets/img/<?= $img ?>"
                                                class="card-img-top rounded-4" alt="...">
                                        </a>
                                        <p class="card-title m-0 p-0 fw-semibold"><?= $name; ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php }
                    endif ?>
                </div>
                <form id="sizeForm" action="<?= _WEB_ROOT_ ?>/them-vao-gio" method="POST">
                    <input type="hidden" name="selected_size" class="selected_size" value="1">
                    <input type="hidden" name="pro_id" id="pro_id" value="<?= $pro_id ?>">
                    <input type="hidden" name="quantity" id="quantityToCart" value="1">
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var url = "<?= _WEB_ROOT_ ?>";

    function search() {
        var action = "search";
        $(document).ready(function () {
            $("#search").keyup(function () {
                var search = $("#search").val();
                if (search != '') {
                    $.ajax({
                        url: url + "/product/search",
                        type: "POST",
                        data: {
                            action: action,
                            search: $("#search").val(),
                        },
                        success: function (data) {
                            console.log(data);
                            $("#result").html(data);

                        }
                    })
                } else {
                    $("#result").html('');
                }
            })
        })
    }
    search();

    $(document).ready(() => {
        $(document).on('click', '.navHeader', () => {
            $('.navHeader').removeClass('active')
            $(this).addClass('active')
            return
        })
    })
</script>