<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Voucher</h1>
        <button type="button" class="btn bg-success text-light" data-toggle="modal" data-target="#addVoucherModal">
            Tạo voucher
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
                            placeholder="Tìm kiếm tên voucher...">
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
                            <th>Mã nhập Voucher</th>
                            <th>Mức Giảm (%)</th>
                            <th>Giảm tối đa (đ)</th>
                            <th>Ngày hết hạn</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataVoucher as $key => $voucher): ?>
                            <tr>
                                <td class="align-middle"><?= $voucher['id'] ?></td>
                                <td class="align-middle"><?= $voucher['code_voucher'] ?></td>
                                <td class="align-middle"><?= $voucher['discount_percent'] ?></td>
                                <td class="align-middle"><?= $voucher['max_discount'] ?></td>
                                <td class="align-middle"><?= $voucher['expiration_date'] ?></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">

                                        <button data-toggle="modal" class="btn btn-outline-warning ml-2 editVoucherBtn"
                                            data-target="#editVoucherModal" data-id="<?= $voucher['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>

                                        <form action="<?= _WEB_ROOT_ ?>/admin/voucher" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idDelete" value="<?= $voucher['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger ml-2"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
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
<div class="modal fade" id="addVoucherModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tạo Voucher</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/voucher" method="post">
                    <input type="hidden" name="role" value="1">
                    <div class="form-group">
                        <label for="nameUser">Mã Voucher:</label>
                        <input type="text" class="form-control" placeholder="Nhập mã voucher..." name="codeAdd" require>
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Mức Giảm (%):</label>
                        <input type="number" class="form-control" placeholder="Phần trăm..." name="discountAdd" require>
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Giảm Tối Đa (đ):</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền..." name="maxAdd" require>
                    </div>
                    <div class="form-group">
                        <label for="date">Ngày Hết Hạn:</label>
                        <input type="date" class="form-control custom-date-input" id="date" require name="expAdd">
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

<!-- The Modal Edit-->
<div class="modal fade" id="editVoucherModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Sửa Voucher</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/voucher" method="post">
                    <input type="hidden" id="voucherId" name="idUpdate">
                    <div class="form-group">
                        <label for="nameUser">Mã Voucher:</label>
                        <input type="text" class="form-control" placeholder="Nhập mã voucher..." name="codeUpdate"
                            id="voucherCode">
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Mức Giảm:</label>
                        <input type="number" class="form-control" placeholder="Phần trăm..." name="discountUpdate"
                            id="voucherDiscount">
                    </div>
                    <div class="form-group">
                        <label for="emailUser">Giảm Tối Đa (đ):</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền..." name="maxUpdate" require
                            id="voucherMax">
                    </div>
                    <div class="form-group">
                        <label for="date">Ngày Hết Hạn:</label>
                        <input type="date" class="form-control custom-date-input" name="expUpdate" id="voucherExp">
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
    $(document).ready(function () {
        // Khi nhấn nút "Chỉnh sửa", mở modal và điền dữ liệu
        $(document).on('click', '.editVoucherBtn', function () {
            var voucherId = $(this).data('id'); // Lấy ID của danh mục

            // Gửi yêu cầu AJAX để lấy thông tin danh mục
            $.ajax({
                url: 'voucher/showEditModal', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    idShow: voucherId
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ server

                    if (response) {
                        $('#voucherId').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#voucherCode').val(response.code_voucher);
                        $('#voucherDiscount').val(response.discount_percent);
                        $('#voucherMax').val(response.max_discount);
                        $('#voucherExp').val(response.expiration_date);


                        // Mở modal
                        $('#editVoucherModal').modal('show');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin voucher');
                }
            });
        });
    });
</script>