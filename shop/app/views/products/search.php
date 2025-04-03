<div class="grid wide">
    <div class="row g-1 my-2">
        <div class="col-xxl-2 col-md-3 col-sm-4 col-0">
            <div class="category">
                <!-- <h3 class="category__heading"><i class="fas fa-list-ul me-2"></i>Theo Danh mục</h3> -->
                <!-- category-item--active -->
                <ul class="category-list">
                    <?php if (!empty($data_cate_list_id)): ?>
                        <?php foreach ($data_cate_list_id as $cate): ?>
                            <li class="category-item <?= $cate_id == $cate['id'] ? 'category-item--active' : '' ?>">
                                <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $cate['name'] ?>', 'cat<?= $cate['parent'] ?>-cid<?= $cate['id'] ?>')"
                                    class="category-item__link"><?= $cate['name'] ?></a>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
            <div class="category">
                <h3 class="category__heading"><i class="fas fa-filter me-2"></i>Bộ Lọc Tìm Kiếm</h3>
                <div class="p-4">
                    <h5 class="mb-4">Khoảng Giá</h5>
                    <form method="GET" onsubmit="return valid_filter()">
                        <input type="hidden" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col category-filter__price">
                                <input type="number" id="min_price" name="minPrice"
                                    value="<?= htmlspecialchars($_GET['minPrice'] ?? '') ?>" placeholder="Từ">
                            </div>
                            <div class="col-auto category-filter__price">
                                <span>-</span>
                            </div>
                            <div class="col category-filter__price">
                                <input type="number" id="max_price" name="maxPrice"
                                    value="<?= htmlspecialchars($_GET['maxPrice'] ?? '') ?>" placeholder="Đến">
                            </div>
                        </div>
                        <!-- Hidden input giữ tham số khác -->
                        <input type="hidden" name="order" value="<?= htmlspecialchars($_GET['order'] ?? 'asc') ?>">
                        <input type="hidden" name="page" value="1">
                        <input type="hidden" name="sortBy" value="<?= htmlspecialchars($_GET['sortBy'] ?? 'id') ?>">
                        <!-- Nút áp dụng -->
                        <button type="submit" class="custom-btn__primary w-100">ÁP DỤNG</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xxl-10 col-md-9 col-sm-8 col-12">
            <p class="filter-keyword_pro">
                <i class="fas fa-lightbulb"></i>
                Bộ lọc tìm kiếm cho kết quả
                <span>'<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : '' ?>'</span>
            </p>
            <div class="category-filter ">

                <div class="row g-2 align-items-center">
                    <?php
                    $keyword = isset($_GET["keyword"]) ? 'keyword=' . trim($_GET['keyword']) . '&' : '';
                    $minPrice = isset($_GET["minPrice"]) && $_GET['minPrice'] > 0 ? 'minPrice=' . $_GET['minPrice'] . '&' : '';
                    $maxPrice = isset($_GET["maxPrice"]) && $_GET["maxPrice"] > 0 ? 'maxPrice=' . $_GET['maxPrice'] . '&' : '';
                    ?>
                    <div class="col-lg-2 col-4">
                        <span class="category-filter__lable">
                            <i class="fas fa-filter"></i>
                            Sắp xếp
                        </span>
                    </div>
                    <div class="col-lg-2 col-4">
                        <a href="?<?= $keyword ?><?= $minPrice ?><?= $maxPrice ?>page=1&sortBy=id"
                            class="category-filter__btn <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'id' ? 'category-filter__active' : '' ?>">
                            Mới nhất
                        </a>
                    </div>
                    <div class="col-lg-2 col-4">
                        <a href="?<?= $keyword ?><?= $minPrice ?><?= $maxPrice ?>page=1&sortBy=sell"
                            class="category-filter__btn <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'sell' ? 'category-filter__active' : '' ?>">
                            Bán chạy
                        </a>
                    </div>
                    <div class="col-lg-4 col-8">
                        <div class="select-input">
                            <span
                                class="select-input__lable <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'price' ? 'select-input__link--active' : ''; ?>">Giá:
                                <?= isset($_GET['order']) && $_GET['order'] == 'asc' ? 'Thấp đến cao' : ''; ?>
                                <?= isset($_GET['order']) && $_GET['order'] == 'desc' ? 'Cao đến thấp' : ''; ?>
                            </span>
                            <i class="select-input__icon fa-solid fa-angle-down"></i>
                            <ul class="select-input__list">
                                <li class="select-input__item">
                                    <a href="?<?= $keyword ?><?= $minPrice ?><?= $maxPrice ?>order=asc&page=1&sortBy=price"
                                        class="select-input__link <?= isset($_GET['order']) && $_GET['order'] == 'asc' ? 'select-input__link--active' : ''; ?>">Giá:
                                        Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="?<?= $keyword ?><?= $minPrice ?><?= $maxPrice ?>order=desc&page=1&sortBy=price"
                                        class="select-input__link <?= isset($_GET['order']) && $_GET['order'] == 'desc' ? 'select-input__link--active' : ''; ?>">Giá:
                                        Cao đến thấp</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-4">
                        <div class="category-filter__page">
                            <span class="category-filter__page-num">
                                <span
                                    class="category-filter__page-current"><?= $_GET['page'] ?? 1; ?></span>/<?= $total_page ?>
                            </span>

                            <div class="category-filter__page-control">
                                <?= $prev ?><?= $next ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3">
                    <div class="row g-2">
                        <?php if (!empty($pro_filter)): ?>
                            <?php foreach ($pro_filter as $pro_search): ?>
                                <div class="custom-col-lg-2-5 col-md-3 col-sm-4 col-6">
                                    <a onclick="handle__url_link(this, '<?= _WEB_ROOT_ ?>','<?= $pro_search['name'] ?>', 'i<?= $pro_search['id'] ?>')"
                                        class="custom-pro__item">
                                        <div class="custom-pro__item__img"
                                            style="background-image: url(<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_search['url_image'] ?>);">
                                        </div>
                                        <h4 class="custom-pro__item__name"><?= $pro_search['name'] ?></h4>
                                        <div class="custom-pro__item__price">
                                            <span class="custom-pro__item__price-old"><?= number_format($pro_search['price']) ?>
                                                đ</span>
                                            <span
                                                class="custom-pro__item__price-current"><?= number_format($pro_search['price'] - ($pro_search['price'] * ($pro_search['discount_percent'] / 100))) ?>đ</span>
                                        </div>
                                        <div class="custom-pro__item__action">
                                            <div class="custom-pro__item__rating">
                                                <i class="custom-pro__item__star--gold fas fa-star"></i>
                                                <i class="custom-pro__item__star--gold fas fa-star"></i>
                                                <i class="custom-pro__item__star--gold fas fa-star"></i>
                                                <i class="custom-pro__item__star--gold fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="custom-pro__item__sold"><?= $pro_search['sell'] ?> Đã bán</div>
                                        </div>
                                        <div class="custom-pro__item__origin">
                                            <span class="custom-pro__item__origin-name">Việt Nam</span>
                                        </div>
                                        <?php if ($pro_search['discount_percent'] > 0): ?>
                                            <div class="custom-pro__item__sale-off">
                                                <span
                                                    class="custom-pro__item__sale-off-percent"><?= $pro_search['discount_percent'] ?>%</span>
                                                <span class="custom-pro__item__sale-off-label">GIẢM</span>
                                            </div>
                                        <?php endif ?>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <h3 class="alert alert-warning text-center p-5">Không Tìm Thấy Sản Phẩm Nào!</h3>
                        <?php endif ?>
                    </div>
                </div>
                <!-- page -->
                <ul class="pagination">
                    <?php if (isset($links))
                        echo $links; ?>
                </ul>
            </div>
        </div>
    </div>
</div>