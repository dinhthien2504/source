<section id="page-header">
    <h2>#Cửa Hàng</h2>
    <!-- <p>save more with coupons & up to 70% off!</p> -->
</section>
<?php if (isset($_POST['submitSearch'])) { ?>
    <div class="container mt-2">
        <div class="d-flex align-items-center gap-2">
            <h4 class="fs-5 m-0">Kết quả tìm kiếm: </h4>
            <p class="fw-bold m-0 fs-4"><?= !empty($_POST['kyw']) ? $_POST['kyw'] : $_POST['submitSearch']; ?></p>
        </div>
    </div>
<?php } ?>
<div class="container my-3 d-lg-containerFluid-brand">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4">
            <h4>Danh mục</h4>
            <ul class="list-group list-group-flush">
                <!-- Danh mục -->
                <?php foreach ($dataCategory as $cate) { ?>
                    <li class="list-group-item">
                        <a class="text-decoration-none d-flex justify-content-between align-items-center text-black fw-bold"
                            data-bs-toggle="collapse" href="#<?= $cate['id'] ?>" role="button" aria-expanded="false"
                            aria-controls="<?= $cate['id'] ?>"><?= $cate['name'] ?><span class="dropdown-toggle"></span>
                        </a>
                        <ul class="list-group list-group-flush p-0 mt-1 collapse" id="<?= $cate['id'] ?>">
                            <?php foreach ($dataSubCategory as $subCate) {
                                if ($cate['id'] == $subCate['category_id']) {
                                    if ($subCate['id'] == $idSubCate) {
                                        echo '<li class="list-group-item p-0 my-1 fs-17 active-nav">' . $subCate['name'] . '</li>';
                                    } else {
                                        echo '<li class="list-group-item p-0 my-1 fs-17"><a class="text-decoration-none text-secondary" href="' . _WEB_ROOT_ . '/san-pham/danh-muc-' . $subCate['id'] . '-trang-1">' . $subCate['name'] . '</a></li>';
                                    }
                                }
                            } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div> <!--End Cate-->
        <div class="col-lg-9 col-md-8 col-sm-8">
            <div class="d-flex justify-content-between my-2">
                <p class="fs-4">
                    <?php if (!isset($_POST['submitSearch'])) { ?>
                        <?php if (isset($idSubCate) && $idSubCate > 0) {
                            foreach ($dataSubCategory as $item) {
                                if ($item['id'] == $idSubCate) {
                                    echo $item['name'];
                                }
                            }
                        } ?>
                    <?php } ?>
                </p>
                <div class="w-25 d-flex justify-content-end">
                    <form action="<?= _WEB_ROOT_ ?>/san-pham/danh-muc-<?= $idSubCate ?>-trang-1" method="POST">
                        <div class="dropdown">
                            <button style="width: 210px;" class="btn btn-outline-secondary dropdown-toggle"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                switch ($filter ?? '') {
                                    case 'DESC':
                                        echo 'Giá từ cao đến thấp';
                                        break;
                                    case 'ASC':
                                        echo 'Giá từ thấp đến cao';
                                        break;
                                    default:
                                        echo 'Mới nhất';
                                }
                                ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button type="submit" name="submitFilter" value=""
                                    class="dropdown-content <?= isset($_POST['submitFilter']) && $_POST['submitFilter'] == '' ? 'dropdown-content-active' : '' ?>">Mới
                                    nhất</button>
                                <button type="submit" name="submitFilter" value="ASC"
                                    class="dropdown-content <?= isset($_POST['submitFilter']) && $_POST['submitFilter'] == 'ASC' ? 'dropdown-content-active' : '' ?>">Giá
                                    từ thấp đến cao</button>
                                <button type="submit" name="submitFilter" value="DESC"
                                    class="dropdown-content <?= isset($_POST['submitFilter']) && $_POST['submitFilter'] == 'DESC' ? 'dropdown-content-active' : '' ?>">Giá
                                    từ cao đến thấp</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row g-2">
                <?php if (isset($dataPro) && !empty($dataPro)) { ?>
                    <?php foreach ($dataPro as $pro) {
                        extract($pro) ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="card rounded-4">
                                <div class="card-body d-flex flex-column gap-2">
                                    <a class="text-decoretion-none" href="<?= _WEB_ROOT_ ?>/san-pham/ma-san-pham-<?= $id ?>">
                                        <img style="height: 350px; object-fit: cover;"
                                            src="<?= _WEB_ROOT_ ?>/public/assets/img/<?= $img ?>" class="card-img-top rounded-4"
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
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="price fw-bold"><?= number_format($price - ($price * $discount_percent / 100)) ?>đ</span>
                                            <del class="fs-13 text-secondary"><?= number_format($price) ?>đ</del>
                                        </div>
                                        <a href="#" id="shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php } ?>
                    <?php if (isset($totalPage) && $totalPage > 1): ?>
                        <div class="pagination">
                            <?= $pagination ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php } else {
                    echo '<div class="my-5 d-flex align-items-center justify-content-center">
                    <h2 class="text-danger">Sản phẩm không tồn tại!</h2>
                    </div>';
                } ?>
        </div>
    </div> <!--End Pros-->
</div> <!--End row(cate-pro)-->

</div> <!--End Container-->