<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Danh Mục Phụ</h1>
        <button type="button" class="btn bg-success text-light" data-toggle="modal" data-target="#addsubCateModal">
            Thêm danh mục phụ
        </button>
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
                            placeholder="Tìm kiếm danh mục phụ...">
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
                            <th>Danh mục</th>
                            <th>Danh mục phụ</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataSubCate as $key => $subCate): ?>
                            <tr>
                                <td class="align-middle"><?= $subCate['id'] ?></td>
                                <td class="align-middle"><?= $subCate['category_name'] ?></td>
                                <td class="align-middle"><?= $subCate['name'] ?></td>
                                <td class="align-middle"><?= $subCate['status'] == 0 ? 'Hoạt động' : 'Tạm dừng'; ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">

                                        <button data-toggle="modal" class="btn btn-outline-warning ml-2 editCategoryBtn"
                                            data-target="#editsubCateModal" data-id="<?= $subCate['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>

                                        <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/danh-muc-phu">
                                            <!-- Bạn có thể thay idStatus và statusNew bằng dữ liệu động từ mỗi người dùng -->
                                            <input type="hidden" name="idStatus" value="<?= $subCate['id'] ?>" />
                                            <input type="hidden" name="statusNew" value="<?= $subCate['status'] == 1 ? 0 : 1 ?>" /> <!-- 'active' hoặc 'inactive' -->
                                            <button class="btn btn-outline-success change-status-btn ml-2" onclick="return confirm('Bạn có muốn đổi trạng thái không?')">
                                                <i class="ri-refresh-line"></i>
                                            </button>
                                        </form>

                                        <form action="<?= _WEB_ROOT_ ?>/admin/danh-muc-phu" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idSubDelete" value="<?= $subCate['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger ml-2"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                    </form>


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


<!-- The Modal -->
<div class="modal fade" id="addsubCateModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm danh mục phụ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/danh-muc-phu" method="post">
                    <input type="hidden" name="role" value="1">
                    <div class="form-group">
                        <label for="sel1">Danh mục chính</label>
                        <select class="form-control" id="subCate_cate" name="subCate_cate">
                            <?php foreach ($dataCate as $key => $cate): ?>
                                <option value="<?= $cate['id'] ?>"><?= $cate['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subCateName">Tên danh mục phụ:</label>
                        <input type="text" class="form-control" id="subCateName" name="subCateName"
                            placeholder="Tên danh mục phụ...">
                    </div>



                    <!-- Modal Footer -->
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" id="submit" name="submit_regester">Thêm</button>
                    </div>
                    <div id="message"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Edit -->
<div class="modal fade" id="editsubCateModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Sửa danh mục phụ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/danh-muc-phu" method="post">
                    <input type="hidden" id="subId" name="subIdUpdate"> <!-- ID ẩn -->
                    <div class="form-group">
                        <label for="subName">Tên danh mục phụ:</label>
                        <input type="text" class="form-control" id="subName" name="subNameUpdate"
                            placeholder="Tên danh mục phụ...">
                    </div>

                    <div class="form-group">
                        <label for="subCate_cate">Danh mục chính:</label>
                        <select class="form-control" id="subCate" name="subCateUpdate">
                            <?php foreach ($dataCate as $key => $cate): ?>
                                <option value="<?= $cate['id'] ?>"><?= $cate['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Modal Footer -->
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" id="submit" name="submit_regester">Lưu</button>
                    </div>
                    <div id="message"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Khi nhấn nút "Chỉnh sửa", mở modal và điền dữ liệu
        $(document).on('click', '.editCategoryBtn', function() {
            var subCategoryId = $(this).data('id'); // Lấy ID của danh mục
            console.log('Sub Category ID:', subCategoryId); // Kiểm tra giá trị
            // Gửi yêu cầu AJAX để lấy thông tin danh mục
            $.ajax({
                url: 'category/showSubEditModal', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    idSubShow: subCategoryId
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ server

                    if (response) {
                        $('#subId').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#subName').val(response.name); // Điền tên vào trường input
                        $('#subCate').val(response.category_id);


                        // Mở modal
                        $('#editsubCateModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi từ server:", xhr.responseText); // Log lỗi chi tiết
                    console.error("Status:", status, "Error:", error);
                    alert('Có lỗi xảy ra khi tải thông tin danh mục');
                }

            });
        });
    });
</script>