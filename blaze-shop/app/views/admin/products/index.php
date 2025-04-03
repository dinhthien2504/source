<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Sản Phẩm</h1>
        <button type="button" class="btn bg-success text-light" data-toggle="modal" data-target="#addProductModal">
            Thêm Sản Phẩm
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
                        <input id="search_cate" type="text" class="form-control " name="search" value=""
                            placeholder="Tìm kiếm tên sản phẩm...">
                        <button class="btn btn-success " type="submit" name="submit_search">
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
                            <th>Sản phẩm</th>
                            <th>Lượt bán</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataPro as $key => $pro): ?>
                            <tr>
                                <td class="align-middle">
                                    <?= $pro['id'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $pro['name'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $pro['sales'] ?>
                                </td>

                                <td class="align-middle">
                                    <?= $pro['subCate_name'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $pro['status'] == 0 ? 'Hoạt động' : 'Tạm dừng'; ?>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center">

                                        <button data-toggle="modal" class="btn btn-outline-warning ml-2 editProBtn"
                                            data-target="#editModal" data-id="<?= $pro['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                                        <!-- Nút thêm ảnh với biểu tượng img-->
                                        <button class="btn btn-outline-info upload-image-btn ml-2 imgBtn"
                                            data-toggle="modal" data-target="#addImgProModal" data-id="<?= $pro['id'] ?>">
                                            <i class="ri-image-line"></i>
                                        </button>

                                        <!-- Nút thay đổi kích thước với biểu tượng fullscreen -->
                                        <button data-toggle="modal"
                                            class="btn btn-outline-primary change-size-btn ml-2 quantityBtn"
                                            data-target="#editQuantityModal" data-id="<?= $pro['id'] ?>">
                                            <i class="ri-fullscreen-line"></i>
                                            <!-- Biểu tượng thay đổi kích thước -->
                                        </button>

                                        <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/san-pham">
                                            <!-- Bạn có thể thay idStatus và statusNew bằng dữ liệu động từ mỗi người dùng -->
                                            <input type="hidden" name="idStatus" value="<?= $pro['id'] ?>" />
                                            <input type="hidden" name="statusNew"
                                                value="<?= $pro['status'] == 1 ? 0 : 1 ?>" />
                                            <!-- 'active' hoặc 'inactive' -->
                                            <button class="btn btn-outline-success change-status-btn ml-2"
                                                onclick="return confirm('Bạn có muốn đổi trạng thái không?')">
                                                <i class="ri-refresh-line"></i>
                                            </button>
                                        </form>
                                        <form action="<?= _WEB_ROOT_ ?>/admin/san-pham" method="post"
                                            style="display: inline;">
                                            <input type="hidden" name="idDelete" value="<?= $pro['id'] ?>">
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
            <ul class="pagination">
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
<div class="modal fade" id="addProductModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addCategoryForm" method="POST" enctype="multipart/form-data"
                    action="<?= _WEB_ROOT_ ?>/admin/san-pham">
                    <div class="form-group">
                        <label for="nameProduct">Tên Sản Phẩm:</label>
                        <input type="text" class="form-control" id="nameProduct" name="nameAdd"
                            placeholder="Nhập tên sản phẩm..." require>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="priceProduct">Giá Gốc (đ):</label>
                            <input type="number" class="form-control" id="priceProduct" placeholder="Nhập giá gốc..."
                                name="priceAdd" require>
                        </div>
                        <div class="col">
                            <label for="priceSaleProduct">Mức Giảm (%):</label>
                            <input type="number" class="form-control" id="priceSaleProduct"
                                placeholder="Nhập mức giảm..." name="discountAdd" require>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="idCategory" class="form-label">Danh Mục:</label>
                            <select class="form-control" id="idCategory" name="idCategory">
                                <?php if (isset($dataCate)) {
                                    foreach ($dataCate as $item) {
                                        extract($item);
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="statusProduct" class="form-label">Danh Mục Phụ:</label>
                            <select class="form-control" id="idSubCategory" name="subCateAdd">
                                <?php if (isset($dataSubCate)) {
                                    foreach ($dataSubCate as $item) {
                                        extract($item);
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="detailProduct">Mô tả:</label>
                        <textarea class="form-control" rows="5" id="detailProduct" name="detailAdd" require></textarea>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" name="submit_addPro" id="submit">Thêm</button>
                    </div>
                    <div id="message" class="p-3"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal Edit-->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Sửa Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addCategoryForm" method="POST" enctype="multipart/form-data"
                    action="<?= _WEB_ROOT_ ?>/admin/san-pham">
                    <input type="hidden" name="idEdit" id="idEdit">
                    <div class="form-group">
                        <label for="nameProduct">Tên Sản Phẩm:</label>
                        <input type="text" class="form-control" id="nameShow" name="nameEdit"
                            placeholder="Nhập tên sản phẩm..." require>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="priceProduct">Giá Gốc (đ):</label>
                            <input type="number" class="form-control" id="priceShow" placeholder="Nhập giá gốc..."
                                name="priceEdit" require>
                        </div>
                        <div class="col">
                            <label for="priceSaleProduct">Mức Giảm (%):</label>
                            <input type="number" class="form-control" id="discountShow" placeholder="Nhập mức giảm..."
                                name="discountEdit" require>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="idCategory" class="form-label">Danh Mục:</label>
                            <select class="form-control" id="idCategory" name="idCategory">
                                <?php if (isset($dataCate)) {
                                    foreach ($dataCate as $item) {
                                        extract($item);
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="statusProduct" class="form-label">Danh Mục Phụ:</label>
                            <select class="form-control subCateShow" id="idSubCategory" name="subCateEdit">
                                <?php if (isset($dataSubCate)) {
                                    foreach ($dataSubCate as $item) {
                                        extract($item);
                                        echo '<option value="' . $id . '">' . $name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="detailProduct">Mô tả:</label>
                        <textarea class="form-control" rows="5" id="detailShow" name="detailEdit" require></textarea>
                    </div>


                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" name="submit_addPro" id="submit">Thêm</button>
                    </div>
                    <div id="message" class="p-3"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal Edit Quantity -->
<div class="modal fade" id="editQuantityModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhật Số Lượng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addUserForm" action="<?= _WEB_ROOT_ ?>/admin/san-pham" method="post">
                    <input type="hidden" id="idSize" name="idSE"> <!-- ID ẩn -->
                    <div class="form-group">
                        <label for="subCate_cate">Size:</label>
                        <select class="form-control" id="sizeShow" name="sizeSE">
                            <?php foreach ($dataSize as $key => $size): ?>
                                <option value="<?= $size['id'] ?>"><?= $size['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subName">Số Lượng:</label>
                        <input type="number" class="form-control" id="quantityShow" name="quantitySE"
                            placeholder="Nhập số lượng...">
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
<!-- The Modal Image -->
<div class="modal fade" id="addImgProModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= _WEB_ROOT_ ?>/admin/product/addImgPro" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Thêm Ảnh Sản Phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="p-2 border " style="background-color: #fff;">
                        <div class="container my-1">
                            <label for="fileInput" id="createImg" class="label-file">
                                <i class="bi bi-camera-fill"></i>
                                Thêm Hình Ảnh:
                            </label>
                            <div class="file-preview align-items-center justify-content-center" id="filePreview"></div>
                            <div id="remainingImages" class="text-muted">4/4 ảnh.</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="product_id" value="" id="product_idImg">
                <div class="modal-footer">
                    <button type="submit" name="addImgPro" class="btn btn-success">Thêm Ảnh</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Khi thay đổi danh mục chính
        $('#idCategory').on('change', function () {
            const categoryId = $(this).val(); // Lấy ID danh mục chính
            const subCategoryDropdown = $('#idSubCategory'); // Dropdown Danh Mục Phụ

            // Xóa các tùy chọn cũ
            subCategoryDropdown.empty();

            if (categoryId) {
                // Gửi yêu cầu AJAX đến server
                $.ajax({
                    url: 'product/getSubcategoriesByCategoryId', // API lấy danh mục phụ
                    type: 'POST',
                    data: {
                        categoryIdDr: categoryId
                    }, // Dữ liệu gửi đi
                    dataType: 'json',
                    success: function (data) {
                        // Kiểm tra dữ liệu trả về
                        if (data && data.length > 0) {
                            $.each(data, function (index, subCategory) {
                                subCategoryDropdown.append(
                                    `<option value="${subCategory.id}">${subCategory.name}</option>`
                                );
                            });


                        } else {
                            subCategoryDropdown.append('<option value="">Không có danh mục phụ</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi lấy danh mục phụ:', error);
                        alert('Không thể tải danh mục phụ. Vui lòng thử lại.');
                    },
                });
            }
        });


        // Khi thay đổi danh mục phụ (tùy chọn bổ sung)
        $('#idSubCategory').on('change', function () {
            const subCategoryId = $(this).val(); // Lấy ID danh mục phụ
            const categoryDropdown = $('#idCategory'); // Dropdown Danh Mục Chính

            if (subCategoryId) {
                // Gửi yêu cầu AJAX đến server
                $.ajax({
                    url: 'product/getCategoryBySubCategoryId', // API lấy danh mục chính
                    type: 'POST',
                    data: {
                        subCategoryIdDr: subCategoryId
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data && data.category_id) {
                            categoryDropdown.val(data.category_id); // Cập nhật danh mục chính
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi lấy danh mục chính:', error);
                        alert('Không thể tải danh mục chính. Vui lòng thử lại.');
                    },
                });
            }
        });


        // Khi nhấn nút "Chỉnh sửa", mở modal và điền dữ liệu
        $(document).on('click', '.editProBtn', function () {
            var proId = $(this).data('id'); // Lấy ID của danh mục

            // Gửi yêu cầu AJAX để lấy thông tin danh mục
            $.ajax({
                url: 'product/showEditModal', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    idShow: proId
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ server

                    if (response) {
                        $('#idEdit').val(response.id); // Gán ID danh mục vào input ẩn
                        $('#nameShow').val(response.name); // Điền tên vào trường input
                        $('#priceShow').val(response.price);
                        $('#discountShow').val(response.discount_percent);
                        $('#detailShow').val(response.detail);
                        $('.subCateShow').val(response.subcategory_id);


                        // Mở modal
                        $('#editModal').modal('show');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin danh mục');
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on("click", ".quantityBtn", function () {
            const productId = $(this).data("id");
            console.log("Product ID:", productId); // Log ID để kiểm tra
            $("#idSize").val(productId); // Gán ID sản phẩm vào input hidden
        });

        $(document).on("change", "#sizeShow", function () {
            const productId = $("#idSize").val(); // ID sản phẩm
            const sizeId = $(this).val(); // ID size
            console.log("Product ID:", productId, "Size ID:", sizeId); // Log ID để kiểm tra

            // Kiểm tra nếu ID sản phẩm và size không hợp lệ
            if (!productId || !sizeId) {
                alert("Vui lòng chọn sản phẩm và kích cỡ hợp lệ!");
                return;
            }

            // Gửi AJAX để lấy số lượng
            $.ajax({
                url: 'product/showQuantityEdit',
                method: 'POST',
                data: {
                    product_idS: productId,
                    size_idS: sizeId
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Kiểm tra dữ liệu JSON trả về
                    if (response.success) {
                        $("#quantityShow").val(response.quantity); // Hiển thị số lượng vào input
                        $('#editQuantityModal').modal('show'); // Đảm bảo mở đúng modal
                    } else {
                        alert(response.message || "Không tìm thấy số lượng cho size này!");
                    }
                },
                error: function (xhr, status, error) {
                    // Log chi tiết lỗi và response từ server
                    console.error('Lỗi:', error);
                    console.log('Response:', xhr.responseText); // Kiểm tra nội dung trả về từ server
                    alert("Đã xảy ra lỗi khi tải số lượng!");
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on("click", ".imgBtn", function () {
            const productId = $(this).data("id");
            $("#product_idImg").val(productId);
            $.ajax({
                    url: 'product/getImgByIdPro',
                    type: 'POST',
                    data: {
                        idPro: productId
                    }, 
                    success: function (data) {
                        $("#filePreview").html(data);
                        attachRemoveEvent();
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi lấy ảnh sản phẩm:', error);
                    },
                });
        });
    });
    function attachRemoveEvent() {
    document.querySelectorAll('.remove-btn').forEach(function (removeBtn) {
        removeBtn.addEventListener('click', function () {
            const parentDiv = this.closest('.preview-item');
            if (parentDiv) {
                parentDiv.remove();
                updateCountImg(); // Cập nhật lại số lượng ảnh
            }
        });
    });
}

    function updateCountImg() {
        const filePreview = document.querySelector("#filePreview");
        const maxImages = 4; // Giới hạn tối đa 5 ảnh
        const countImg = maxImages - (filePreview.children.length);
        //Chọc tới hiển thị số lượng ảnh có thể thêm
        document.querySelector("#remainingImages").innerText = `${countImg}/4 ảnh.`;
    }
    function addNewImageInput() {
        updateCountImg()
        const filePreview = document.querySelector("#filePreview");
        const maxImages = 4; // Giới hạn tối đa 5 ảnh
        if (filePreview.children.length >= maxImages) {
            messger({ title: 'Cảnh báo', mess: 'Giới hạn tối đa 4 ảnh!', type: 'warning' });
            return;
        }
        const div = document.createElement("div");
        div.classList.add("preview-item");

        const input = document.createElement("input");
        input.type = "file";
        input.name = "img[]"; // Gán name là mảng để gửi nhiều file
        input.classList.add("file-input");
        input.hidden = true;

        // Ảnh preview
        const img = document.createElement("img");
        img.src = "<?= _WEB_ROOT_ ?>/public/assets/img/img-rate.jpg";
        img.alt = "Ảnh mới";
        img.classList.add("image-preview");

        // Nút xóa
        const removeBtn = document.createElement("div");
        removeBtn.classList.add("remove-btn");
        removeBtn.innerText = "X";

        // Xử lý xóa ảnh
        removeBtn.addEventListener("click", () => {
            div.remove();
            updateCountImg()
        });

        // Xử lý khi nhấp vào ảnh để thay đổi file
        img.addEventListener("click", () => {
            input.click();
        });

        // Xử lý thay đổi file
        input.addEventListener("change", function () {
            const file = input.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader(); // Thư viện để đọc hình ảnh
                reader.onload = function (e) {
                    img.src = e.target.result; // Cập nhật ảnh
                    addNewImageInput(); // Thêm một khung mới
                };
                reader.readAsDataURL(file);
            }
        });

        // Gắn các thành phần vào div
        div.appendChild(input);
        div.appendChild(img);
        div.appendChild(removeBtn);
        // Thêm vào container
        filePreview.appendChild(div);
        attachRemoveEvent();
    }

    //Bắt sự khi nhấn vào thêm ảnh
    document.getElementById('createImg').addEventListener("click", function () {
        addNewImageInput();
    })

</script>
<style>
    .file-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .preview-item {
        position: relative;
        width: 150px;
        height: 150px;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .preview-item .remove-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #088178;
        color: white;
        font-size: 12px;
        width: 20px;
        height: 20px;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .label-file {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: #fff;
        color: #088178;
        font-size: 14px;
        border: 1px solid #088178;
        padding: 8px 12px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .label-file i {
        font-size: 18px;
    }

    .preview-item input[type="file"] {
        display: none;
    }
</style>