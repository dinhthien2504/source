<?php
// Lấy URL hiện tại
$currentUrl = $_SERVER['REQUEST_URI'];

// Phân tích URL để lấy id từ phần đường dẫn
$path = parse_url($currentUrl, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

// Giả sử id nằm ở cuối URL (như trong /admin/danh-gia/chi-tiet/{id})
$id = end($segments);
?>

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
            <h1 class="h3 mb-2 text-gray-800 mb-3 mt-1"><?= $this->data['productName'] ?></h1>
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-center">

                        <tr>
                            <th>Mã</th>
                            <th>Người Bình Luận</th>
                            <th>Ngày Bình Luận</th>
                            <th>Nội Dung</th>
                            <th>Đánh Giá</th>
                            <th>Hình Ảnh</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rateData)): ?>
                            <?php foreach ($rateData as $rate): ?>
                                <tr>
                                    <td class="align-middle"><?= $rate['comment_id'] ?></td>
                                    <td class="align-middle"><?= $rate['user_name'] ?></td>
                                    <td class="align-middle"><?= $rate['date_rate'] ?></td>
                                    <td class="align-middle"><?= $rate['review_text'] ?></td>
                                    <td class="align-middle"><?= $rate['rating'] ?></td>
                                    <td class="align-middle">
                                        <?php if (!empty($rate['comment_images'])): ?>
                                            <?php
                                            $images = explode(',', $rate['comment_images']);
                                            foreach ($images as $image):
                                            ?>
                                                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/<?= $image ?>" alt="Comment Image" style="max-width: 80px;">
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>No images</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="align-middle">
                                        <form action="<?= _WEB_ROOT_ ?>/admin/danh-gia/chi-tiet/<?= $id ?>" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idDelete" value="<?= $rate['comment_id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger ml-2"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Không có bình luận nào.</td>
                            </tr>
                        <?php endif; ?>
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