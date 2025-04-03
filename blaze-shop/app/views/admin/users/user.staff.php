<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Nhân Viên</h1>
        <button type="button" class="btn bg-success text-light" data-toggle="modal" data-target="#addUserModal">
            Thêm Nhân Viên
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
                <form action="<?= $base_url ?>/user/staff" method="POST">
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
        <?php if (isset($success)) { ?>
            <p class="ml-4 mt-2 mb-0"><?= $success ?></p>
        <?php } ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Email</th>
                            
                            <th>Trạng thái</th>
                            <th>Phân quyền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataStaff as $staff) {
                            extract($staff) ?>
                            <tr>
                                <td class="align-middle"><?= $id ?></td>
                                <td class="align-middle"><?= $name ?></td>
                                <td class="align-middle"><?= $email ?></td>
                            
                                <td class="align-middle"><?= $status  == 0 ? 'Hoạt động' : 'Tạm dừng' ?></td>  
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-success PrivilegeUserModal" data-id="<?= $id ?>"
                                            data-toggle="modal" data-target="#PrivilegeUserModal">
                                            Phân quyền
                                        </button>
                                    </td>
                                <td class="align-middle">

                                    <div class="d-flex align-items-center justify-content-center">
                                        <button data-toggle="modal" class="btn btn-outline-warning ml-2 editStaffBtn"
                                            data-target="#editStaffModal" data-id="<?= $id ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                                        <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/nhan-vien">
                                            <!-- Bạn có thể thay idStatus và statusNew bằng dữ liệu động từ mỗi người dùng -->
                                            <input type="hidden" name="idStatus" value="<?= $id ?>" />
                                            <input type="hidden" name="statusNew" value="<?= $status == 1 ? 0 : 1 ?>" />
                                            <!-- 'active' hoặc 'inactive' -->
                                            <button class="btn btn-outline-success change-status-btn ml-2"
                                                onclick="return confirm('Bạn có muốn đổi trạng thái không?')">
                                                <i class="ri-refresh-line"></i>
                                            </button>
                                        </form>
                                        <form action="<?= _WEB_ROOT_ ?>/admin/nhan-vien" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idDelete" value="<?= $id ?>">
                                            <button type="submit" class="btn btn-outline-danger ml-2"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
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
<div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm Nhân Viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/nhan-vien" method="post">
                    <input type="hidden" name="role" value="1">
                    <div class="form-group">
                        <label for="nameUser">Tên Nhân Viên:</label>
                        <input type="text" class="form-control" id="nameUser" name="nameStaffAdd"
                            placeholder="Nhập tên nhân viên...">
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Email Nhân Viên:</label>
                        <input type="text" class="form-control" id="emailUser" name="emailStaffAdd"
                            placeholder="Email nhân viên...">
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password" class="form-label">Mật Khẩu:</label>
                            <input type="password" class="form-control" id="password" name="passwordStaffAdd"
                                placeholder="Nhập mật khẩu...">
                        </div>
                        <div class="col">
                            <label for="password-cf" class="form-label">Nhập Lại Mật Khẩu:</label>
                            <input type="password" class="form-control" id="password-cf" name="passwordCf"
                                placeholder="Nhập lại mật khẩu...">
                        </div>
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
<div class="modal fade" id="editStaffModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Sửa Nhân Viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/nhan-vien" method="post">
                    <input type="hidden" name="idStaffEdit" id="idStaff">
                    <div class="form-group">
                        <label for="nameUser">Tên Nhân Viên:</label>
                        <input type="text" class="form-control" id="nameStaff" name="nameStaffEdit"
                            placeholder="Nhập tên nhân viên...">
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Email Nhân Viên:</label>
                        <input type="text" class="form-control" id="emailStaff" name="emailStaffEdit"
                            placeholder="Email nhân viên...">
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password" class="form-label">Mật Khẩu:</label>
                            <input type="text" class="form-control" id="passwordStaff" name="passwordStaffEdit"
                                placeholder="Nhập mật khẩu...">
                        </div>
                        <div class="col">
                            <label for="password-cf" class="form-label">Nhập Lại Mật Khẩu:</label>
                            <input type="password" class="form-control" id="password-cfShow" name="passwordCfEdit"
                                placeholder="Nhập lại mật khẩu...">
                        </div>
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
<!-- The Modal Privilege-->
<div class="modal fade" id="PrivilegeUserModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Phân quyền</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form action="<?= _WEB_ROOT_ ?>/admin/chinh-sua-quyen" method="post">
                    <div class="row px-3 " id="result"></div>
                    <button type="submit" name="submitPrivilege" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.PrivilegeUserModal', function () {
            var idStaff = $(this).data('id'); // Lấy ID của danh mục
            $.ajax({
                url: 'user/showEditPrivilege', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    staffId: idStaff
                },
                success: function (data) {
                    console.log(data); // Kiểm tra dữ liệu trả về từ server
                    $("#result").html(data);
                    // Mở modal
                    $('#PrivilegeUserModal').modal('show');
                },
                error: function () {
                    $("#result").html('');
                    alert('Có lỗi xảy ra khi tải thông tin nhân viên');
                }
            });
        });


        // Khi nhấn nút "Chỉnh sửa", mở modal và điền dữ liệu
        $(document).on('click', '.editStaffBtn', function () {
            var staffId = $(this).data('id'); // Lấy ID của danh mục

            // Gửi yêu cầu AJAX để lấy thông tin danh mục
            $.ajax({
                url: 'user/showStaffModal', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    idShow: staffId
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ server

                    if (response) {
                        $('#idStaff').val(response.id);
                        $('#nameStaff').val(response.name);
                        $('#emailStaff').val(response.email);
                        $('#passwordStaff').val(response.password);
                        $('#password-cfShow').val(response.password);
                        // Mở modal
                        $('#editStaffModal').modal('show');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin người dùng');
                }
            });
        });
    });
</script>