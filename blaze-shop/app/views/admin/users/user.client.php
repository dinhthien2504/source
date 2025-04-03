<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Nhân Viên</h1>
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
                            placeholder="Tìm kiếm tên nhân viên...">
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
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataUser as $key => $user): ?>
                            <tr>
                                <td class="align-middle"><?= $user['id'] ?></td>
                                <td class="align-middle"><?= $user['name'] ?></td>
                                <td class="align-middle"><?= $user['email'] ?></td>
                                <td class="align-middle"><?= $user['status'] == 0 ? 'Hoạt động' : 'Tạm dừng' ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button data-toggle="modal" class="btn btn-outline-warning ml-2 showUserBtn"
                                            data-target="#showUserModal" data-id="<?= $user['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                                        <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/khach-hang">
                                            <!-- Bạn có thể thay idStatus và statusNew bằng dữ liệu động từ mỗi người dùng -->
                                            <input type="hidden" name="idStatus" value="<?= $user['id'] ?>" />
                                            <input type="hidden" name="statusNew" value="<?= $user['status'] == 1 ? 0 : 1 ?>" />
                                            <!-- 'active' hoặc 'inactive' -->
                                            <button class="btn btn-outline-success change-status-btn ml-2"
                                                onclick="return confirm('Bạn có muốn đổi trạng thái không?')">
                                                <i class="ri-refresh-line"></i>
                                            </button>
                                        </form>
                                        <!-- <form action="<?= _WEB_ROOT_ ?>/admin/khach-hang" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idDelete" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger ml-2"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form> -->
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
    <!-- The Modal Add -->
    <div class="modal fade" id="showUserModal">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Tin Khách Hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addUserForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="role" value="1">
                        <div class="form-group">
                            <label for="nameUser">Tên:</label>
                            <input type="text" class="form-control" id="nameUser" name="username" placeholder="Trống"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="emailUser">Email:</label>
                            <input type="text" class="form-control" id="emailUser" name="email" placeholder="Trống"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="emailUser">Số Điện Thoại:</label>
                            <input type="text" class="form-control" id="phoneUser" name="email" placeholder="Trống"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="emailUser">Địa Chỉ:</label>
                            <input type="text" class="form-control" id="addressUser" name="email" placeholder="Trống"
                                disabled>
                        </div>
                        <!-- <div class="form-group">
                            <label for="passUser">Mật Khẩu:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="passUser" name="email" placeholder="Trống"
                                    disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mb-3">
                            <div class="col">
                                <label for="priceProduct">Số Đơn Hàng Thành Công:</label>
                                <input type="text" class="form-control" id="soUser" placeholder="Trống" name="priceProduct"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="priceSaleProduct">Số Đơn Hàng Đã Hủy:</label>
                                <input type="text" class="form-control" id="coUser" placeholder="Trống"
                                    name="priceSaleProduct" disabled>
                            </div>
                        </div>


                        <!-- Modal Footer -->
                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                        <div id="message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Khi nhấn nút "Chỉnh sửa", mở modal và điền dữ liệu
        $(document).on('click', '.showUserBtn', function () {
            var userId = $(this).data('id'); // Lấy ID của danh mục

            // Gửi yêu cầu AJAX để lấy thông tin danh mục
            $.ajax({
                url: 'user/showUserModal', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    idShow: userId
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ server

                    if (response) {
                        $('#nameUser').val(response.name);
                        $('#emailUser').val(response.email);
                        $('#phoneUser').val(response.phone);
                        $('#addressUser').val(response.address);
                        // $('#passUser').val(response.password);
                        $('#soUser').val(response.sOrders);
                        $('#coUser').val(response.cOrders);

                        // Mở modal
                        $('#showUserModal').modal('show');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin người dùng');
                }
            });
        });

        // Khi nhấn nút "Hiển thị mật khẩu"
        // $(document).on('click', '.toggle-password', function () {
        //     var passInput = $('#passUser'); // Trường mật khẩu
        //     var passFieldType = passInput.attr('type');

        //     // Kiểm tra loại input và chuyển đổi
        //     if (passFieldType === 'password') {
        //         passInput.attr('type', 'text');
        //         $(this).html('<i class="ri-eye-off-line"></i>'); // Thay icon thành "ẩn"
        //     } else {
        //         passInput.attr('type', 'password');
        //         $(this).html('<i class="ri-eye-line"></i>'); // Thay icon thành "hiển thị"
        //     }
        // });
    });
</script>
</div>
<!-- /.container-fluid -->