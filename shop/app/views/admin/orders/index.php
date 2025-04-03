<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Quản Lý Đơn Hàng</h3>
    </div>
    <div class="custom-content__show p-3">
        <div class="custom-content__show--top">
            <p><?= $total_order['total'] ?> đơn hàng</p>
            <form method="GET">
                <input type="hidden" name="page" value="1">
                <input type="text" name="code" value="<?= isset($_GET['code']) ? $_GET['code'] : ''; ?>"
                    placeholder="Tìm kiếm theo mã đơn...">
                <button type="submit">Tìm</button>
            </form>
        </div>
        <form class="w-25 mb-2" method="GET">
            <div class="d-flex align-items-center gap-2">
                <select name="status" class="form-select fs-15">
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 0) ? 'selected' : ''; ?> value="0">Tất cả
                    </option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 1) ? 'selected' : ''; ?> value="1">Chờ xác
                        nhận</option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 2) ? 'selected' : ''; ?> value="2">Đã xác
                        nhận
                    </option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 3) ? 'selected' : ''; ?> value="3">Đang giao
                    </option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 4) ? 'selected' : ''; ?> value="4">Đã giao
                    </option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 6) ? 'selected' : ''; ?> value="6">Hoàn thành
                    </option>
                    <option <?= (isset($_GET['status']) && $_GET['status'] == 5) ? 'selected' : ''; ?> value="5">Đã hủy
                    </option>
                </select>
                <button type="submit" class="btn btn-primary fs-15">Lọc</button>
            </div>
        </form>
        <?php if(!empty($orders)): ?>
        <form action="<?= _WEB_ROOT_ ?>/admin/order/handle_update_groups" method="POST"
            onsubmit="return confirm('Bạn có chắc muốn duyệt tất cả đơn hàng này!')">
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
                                <div class="col-2">
                                    <p class="m-0 text-center no-drop">Mã Đơn</p>
                                </div>
                                <div class="col-1">
                                    <p class="m-0 text-center">Tên</p>
                                </div>
                                <div class="col-2 p-0">
                                    <p class="m-0 text-center">Ngày Đặt</p>
                                </div>
                                <div class="col-2 p-0">
                                    <p class="m-0 text-center">Tổng</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0 text-center">TT Đơn Hàng</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0 text-center">TT Thanh Toán</p>
                                </div>
                                <div class="col-1">
                                    <p class="m-0 text-center">Thao tác</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item pro -->
                <?php 
                    $role = [
                        '2' => 'Quản trị',
                        '0' => 'Khách hàng'
                    ]; 
                    foreach ($orders as $order):?>
                    <div class="custom-table__item">
                        <div class="row my-4 g-0">
                            <!-- Checkbox Column -->
                            <div class="col-1">
                                <div class="text-center">
                                    <input type="checkbox" value="<?= $order['id'] ?>" name="order_groups[]"
                                        class="custom-table__check check-item" type="checkbox">
                                </div>
                            </div>
                            <!-- Product Details -->
                            <div class="col-11">
                                <div class="row g-0">
                                    <div class="col-lg-2 col-3">
                                        <p class="m-0 fs-12 text-center"><?= $order['code_order'] ?></p>
                                    </div>
                                    <div class="col-lg-1 col-3">
                                        <p class="m-0 fs-12 text-center"><?= $order['name'] ?></p>
                                    </div>
                                    <div class="col-lg-2 col-4">
                                        <p class="m-0 fs-12 text-center"><?= $order['by_date'] ?></p>
                                    </div>
                                    <div class="col-lg-2 col-3">
                                        <p class="m-0 text-black fs-12 text-center">
                                            <?= number_format($order['total']) ?> đ
                                        </p>
                                    </div>
                                    <div class="col-lg-2 col-3">
                                        <select onchange="update_status_order(this, '<?= $order['id'] ?>')"
                                            class="form-select form-select-md fs-15">
                                            <option <?= ($order['status'] == 1 ? 'selected' : 'disabled') ?> value="1">Chờ xác
                                                nhận</option>
                                            <option <?= ($order['status'] == 2 ? 'selected' : ($order['status'] == 1 ? '' : 'disabled')) ?> value="2">Đã xác nhận</option>
                                            <option <?= ($order['status'] == 3 ? 'selected' : ($order['status'] == 2 ? '' : 'disabled')) ?> value="3">Đang giao</option>
                                            <option <?= ($order['status'] == 4 ? 'selected' : ($order['status'] == 3 ? '' : 'disabled')) ?> value="4">Đã giao</option>
                                            <option  <?= $order['status'] == 6 ? 'selected' : ''?> disabled>Hoàn thành</option>
                                            <option <?= ($order['status'] == 5 ? 'selected' : ($order['status'] == 1 ? '' : 'disabled')) ?> value="5">Đã hủy</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-3">
                                        <p class="m-0 text-black fs-12 text-center fw-bold"><?=$order['payment_status']?></p>
                                    </div>
                                    <div class="col-lg-1 col-1 ">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" onclick="get_order_by_id(this)" data-bs-toggle="modal"
                                                data-bs-target="#showOrderModal"
                                                data-id="<?= $order['id'] ?>" class="btn btn-outline-success btn-sm"><i
                                                    class="ph ph-eye"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach ?>
                <ul class="pagination">
                    <?php if (isset($links))
                        echo $links; ?>
                </ul>
                <?php if (isset($_GET['status']) && $_GET['status'] > 0 && $_GET['status'] < 4): ?>
                <input type="hidden" name="status_current" value="<?=$_GET['status']?>">
                <!-- End item order -->
                <div class="custom-content__button bg-light p-4 mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-center d-flex align-items-center gap-2">
                                <input class="custom-table__check--all check-all" id="check_all" type="checkbox">
                                <label class="fs-17 cursor-pointer" for="check_all">Tất cả</label>
                            </div>
                        </div>
                        <button type="submit" name="submit_update_groups"
                            class="btn btn-info btn-sm ">Duyệt hàng loạt</button>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </form>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center mt-5">
                <p class="alert alert-warning w-100 text-center">Hiện tại không có đơn hàng nào!</h3>
            </div>
        <?php endif ?>
    </div>
</div>
<!-- End Main Content -->
<!-- The Modal -->
<div class="modal" id="showOrderModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông Tin Đơn Hàng</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="show_order_detail"></div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>