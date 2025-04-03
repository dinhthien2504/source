<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Quản Lý Sản Phẩm</h3>
    </div>
    <div class="custom-content__add custom-btn__hover">
        <a href="<?= _WEB_ROOT_ ?>/admin/product-new"><i class="ph ph-plus"></i>Thêm 1 sản phẩm</a>
    </div>
        <div class="custom-content__show p-3">
            <div class="custom-content__show--top">
                <p><?=$total_pro['total']?> sản phẩm</p>
                <form method="GET">
                    <input type="hidden" name="page" value="1">
                    <input type="text" name="keyword" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : '';?>" placeholder="Tìm kiếm...">
                    <button type="submit">Tìm</button>
                </form>
            </div>
            <?php if (!empty($data_all_pro)): ?>
            <form action="<?= _WEB_ROOT_ ?>/admin/product/handle_del_groups" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh sách sản phẩm!')">
                <div class="custom-content__show--main">
                    <div class="custom-content__show--main--top bg-light">
                        <div class="row ">
                            <div class="col-1">
                                <div class="text-center">
                                    <input class="custom-table__check--all " id="check_all" type="checkbox">
                                </div>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-5">
                                        <p class="m-0">Sản Phẩm</p>
                                    </div>
                                    <div class="col-1 p-0">
                                        <p class="m-0 text-center">Lượt Bán</p>
                                    </div>
                                    <div class="col-2 p-0">
                                        <p class="m-0 text-center">Kho Hàng</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="m-0 text-center">Giá</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="m-0 text-center">Thao Tác</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Item pro -->
                    <?php foreach ($data_all_pro as $pro): ?>
                        <div class="custom-table__item ">
                            <div class="row my-4 g-0">
                                <!-- Checkbox Column -->
                                <div class="col-1">
                                    <div class="text-center">
                                        <input type="checkbox" value="<?= $pro['id'] ?>" name="pro__del_groups[]" class="custom-table__check check-item" type="checkbox">
                                    </div>
                                </div>
                                <!-- Product Details -->
                                <div class="col-11">
                                    <div class="row g-0">
                                        <div class="col-lg-5 col-12">
                                            <div class="row d-flex g-0">
                                                <div class="col-lg-3 col-sm-2 col-3">
                                                    <img style="width: 60px; height: 60px; object-fit: cover;"
                                                        src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro['url_image'] ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-sm-10 col-9">
                                                    <p class="m-0 text-black fs-15 fw-bold"><?= $pro['name'] ?></p>
                                                    <p class="m-0 fs-12">ID Sản phẩm: <?= $pro['id'] ?> - (
                                                        <?php if ($pro['status'] == 0): ?>
                                                            <span class="text-success">Đang hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="text-danger">Hiện đang ẩn</span>
                                                        <?php endif; ?>
                                                        )
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Sales and Price -->
                                        <div class="col-lg-1 col-3">
                                            <p class="m-0 fs-12 text-center"><?= $pro['sell'] ?></p>
                                        </div>
                                        <div class="col-lg-2 col-4">
                                            <p class="m-0 fs-12 text-center"><?= $pro['total_quantity'] ?></p>
                                        </div>
                                        <div class="col-lg-2 col-3">
                                            <p class="m-0 text-black fs-12 text-center"><?= number_format($pro['price']) ?> đ</p>
                                        </div>
                                        <div class="col-lg-2 col-2 ">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= _WEB_ROOT_ ?>/admin/product-edit-<?= $pro['id'] ?>" style="width: 50px;" data-bs-toggle="tooltip" title="Chỉnh sửa"
                                                    class="btn btn-outline-warning btn-sm "><i class="ph ph-pen"></i></a>
                                                <a href="<?= _WEB_ROOT_ ?>/admin/product/handle-del-<?= $pro['id'] ?>" style="width: 50px;" data-bs-toggle="tooltip" title="Xóa!"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm!')" class="btn btn-outline-danger btn-sm "><i
                                                        class="ph ph-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Variants Section -->
                            <?php if (!empty($pro['variants'])):
                                $data = json_decode($pro['variants'], true); ?>
                                <div class="container-variants">
                                    <?php foreach ($data as $pro_variant): ?>
                                        <div class="variant-item">
                                            <div class="row ">
                                                <div class="col-1"></div>
                                                <div class="col-11">
                                                    <div class="row g-0 p-2 bg-light align-items-center">
                                                        <!-- Variant Item 1 -->
                                                        <div class="col-lg-5 col-12 bg-light">
                                                            <div class="row d-flex g-0 ">
                                                                <div class="col-lg-2 col-sm-2 col-3 ">
                                                                    <?php if ($pro_variant['url_image'] != null): ?>
                                                                        <img style="width: 40px; height: 40px; object-fit: cover;"
                                                                            src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro_variant['url_image'] ?>"
                                                                            alt="">
                                                                    <?php endif ?>
                                                                    <?php if ($pro_variant['url_image'] == null): ?>
                                                                        <img style="width: 40px; height: 40px; object-fit: cover;"
                                                                            src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $pro['url_image'] ?>" alt="">
                                                                    <?php endif ?>
                                                                </div>
                                                                <div class="col-lg-10 col-sm-10 col-9 d-flex align-items-center">
                                                                    <p class="m-0 text-black fs-12">
                                                                        <?php if ($pro_variant['cor_name'] != ''):
                                                                            echo $pro_variant['cor_name'];
                                                                        endif ?>
                                                                        <?php if ($pro_variant['cor_name'] != '' && $pro_variant['size_name'] != ''):
                                                                            echo ', ';
                                                                        endif ?>
                                                                        <?php if ($pro_variant['size_name'] != ''):
                                                                            echo ' ' . $pro_variant['size_name'] . '';
                                                                        endif ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-3 bg-light">
                                                            <p class="m-0 fs-12 text-center"><?=$pro_variant['sell']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-3 bg-light">
                                                            <p class="m-0 text-center fs-12"><?= $pro_variant['quantity'] ?></p>
                                                        </div>
                                                        <hr>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="text-center mt-2">
                                        <button type="button" class="btn-toggle-variants">Xem thêm</button>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                        <hr>
                    <?php endforeach ?>
                    <ul class="pagination">
                        <?php if (isset($links))
                        echo $links; ?>
                    </ul>
                    <!-- End item pro -->
                    <div class="custom-content__button bg-light p-4 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-center d-flex align-items-center gap-2">
                                    <input class="custom-table__check--all check-all" id="check_all" type="checkbox">
                                    <label class="fs-17 cursor-pointer" for="check_all">Tất cả</label>
                                </div>
                            </div>
                            <button type="submit" name="submit_del_groups" style="width: 50px;" class="btn btn-outline-danger btn-sm "><i
                                    class="ph ph-trash"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            <?php else : ?>
            <div class="d-flex align-items-center justify-content-center mt-5">
                <p class="alert alert-warning w-100 text-center">Hiện tại không có sản phẩm nào!</h3>
            </div>
    <?php endif; ?>
    </div>
</div>