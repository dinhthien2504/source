<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Đánh Giá</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6 f-flex">
                <!-- Form for filter -->
                <form id="filter-form" class="form-inline" method="post">
                    <div class="form-group my-0">
                        <label for="filter-select" class="mr-2">Mã</i></label>
                    </div>
                    <button type="submit" class="btn btn-light" name="submit_sort" value="1"><i
                            class="ri-arrow-up-down-fill"></i></button>
                </form>
            </div>
            <div class="col-6">
                <form method="POST">
                    <div class="d-flex align-items-center justify-content-center">
                        <input id="search_cate" type="text" class="form-control rounded-crl-left" name="search" value=""
                            placeholder="Tìm kiếm tên sản phẩm...">
                        <button class="btn btn-success rounded-crl-right" type="submit" name="submit_search">
                            <i class="fas fa-search fa-sm fw-bold"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Mã</th>
                            <th>Sản Phẩm</th>
                            <th>Số Bình Luận</th>
                            <th>Mới Nhất</th>
                            <th>Cũ Nhất</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rateData as $key => $rate): ?>
                            <tr>
                                <td class="align-middle"><?= $rate['product_id'] ?></td>
                                <td class="align-middle"><?= $rate['product_name'] ?></td>
                                <td class="align-middle"><?= $rate['total_comments'] ?></td>
                                <td class="align-middle"><?= $rate['latest_comment_date'] ?></td>
                                <td class="align-middle"><?= $rate['oldest_comment_date'] ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="<?= _WEB_ROOT_ ?>/admin/danh-gia/chi-tiet/<?= $rate['product_id'] ?>" class="btn btn-outline-warning"><i class="ri-edit-box-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-center align-items-center">
            <ul class="pagination pagination-sm">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </div> -->

    </div>

</div>
<!-- /.container-fluid -->