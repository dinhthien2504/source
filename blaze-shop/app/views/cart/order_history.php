<div class="container-pro profile-container-pro" style="display: flex; flex-direction: row;">
    <!-- Sidebar -->
    <div class="profile-sidebar-pro"
        style="background-color: #fff; padding: 20px; border-radius: 10px; border: 2px solid #088178; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-right: 20px; height: 250px;">
        <ul class="sidebar-menu-pro" style="list-style: none; padding: 0; margin: 0;">
            <li><a href="<?= _WEB_ROOT_ ?>/trang-ca-nhan" class="sidebar-item-pro"
                    style="display: block; padding: 10px 20px; font-size: 16px; color: #088178; text-decoration: none; border-radius: 5px; margin-bottom: 10px; transition: background-color 0.3s ease;">Tài
                    Khoản</a></li>
            <hr style="border: 1px solid #088178; margin: 0;">
            <li><a href="<?= _WEB_ROOT_ ?>/lich-su-mua-hang" class="sidebar-item-pro"
                    style="display: block; padding: 10px 20px; font-size: 16px; color: #088178; text-decoration: none; border-radius: 5px; margin-bottom: 10px; transition: background-color 0.3s ease;">Đơn
                    hàng</a></li>
            <hr style="border: 1px solid #088178; margin: 0;">
            <li><a href="#" class="sidebar-item-pro"
                    style="display: block; padding: 10px 20px; font-size: 16px; color: #088178; text-decoration: none; border-radius: 5px; margin-bottom: 10px; transition: background-color 0.3s ease;">Mật
                    khẩu và bảo mật</a></li>
            <hr style="border: 1px solid #088178; margin: 0;">
            <li><a href="#" class="sidebar-item-pro"
                    style="display: block; padding: 10px 20px; font-size: 16px; color: #088178; text-decoration: none; border-radius: 5px; margin-bottom: 10px; transition: background-color 0.3s ease;">Sản
                    phẩm yêu thích</a></li>
        </ul>
    </div>

    <main class="content-order">
        <div class="pro-list-order">
            <h2 class="title-order">Đơn hàng của bạn</h2>
            <div class="tabs-order">
                <a href="<?= _WEB_ROOT_ ?>/lich-su-mua-hang" class="text-decoration-none">
                    <button class="tab-order">
                        Tất cả
                    </button>
                </a>
                <button class="tab-order btn-order-status" data-status="1">
                    Chờ xác nhận
                </button>
                <button class="tab-order btn-order-status" data-status="2">
                    Đã xác nhận
                </button>
                <button class="tab-order btn-order-status" data-status="3">
                    Đang giao
                </button>
                <button class="tab-order btn-order-status" data-status="4">
                    Đã giao
                </button>
                <button class="tab-order btn-order-status" data-status="0">
                    Đã hủy
                </button>
            </div>
            <!-- Order Item -->
            <div id="box-order">
                <?php foreach ($order as $or): ?>
                    <div class="pro-item-order">
                        <div class="status-time-order">
                            <p class="status-order">Trạng thái: <span
                                    class="wait-apply"><?= $status[$or['status']] ?></span>
                            </p>
                            <p class="time-order">Thời gian: <span class="time-pro-order"><?= $or['by_date'] ?></span> </p>
                        </div>
                        <p>Mã vận đơn: <span class="item-price-order"><?= $or['code_order'] ?></span></p>
                        <p class="total-order">Tổng thanh toán: <span
                                style="color: #088178; font-weight: bold;"><?= number_format($or['total']) ?>đ</span></p>
                        <button class="details-button-order button-show-Dord" data-toggle="modal"
                            data-target="#watchAllDord" data-id="<?= $or['id'] ?>"
                            data-orderstatus="<?= $or['status'] ?>">Xem chi tiết</button>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Repeat for other items -->
        </div>
    </main>
    <!-- The Modal -->
    <div class="modal fade" id="watchAllDord">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <!-- Modal Body -->
                <div class="modal-body">
                    <div id="Dorder_order">
                        <div id="showDtail">

                        </div>
                        <!-- <input type="hidden" name="role" value="1"> -->
                        <!-- <div class="form-group">
                                <label for="nameUser">Tên danh mục:</label>
                                <input type="text" class="form-control" id="nameUser" name="cateName"
                                    placeholder="Tên danh mục..." require>
                            </div> -->

                        <!-- Modal Footer -->
                        <!-- <div class="modal-footer mt-2">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" id="submit"
                                    name="submit_regester">Thêm</button>
                            </div>
                            <div id="message"></div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="rateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= _WEB_ROOT_ ?>/rate/addRate" method="POST" enctype="multipart/form-data">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="d-flex gap-2 col-12 " id="showRate"></div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-start gap-1">
                                <p class="m-0">Chất lượng sản phẩm:</p>
                                <div class="d-flex text-warning fs-15 justify-content-center align-items-center"
                                    id="starRating">
                                    <i class="fa-solid fa-star selected" data-star="1"></i>
                                    <i class="fa-solid fa-star selected" data-star="2"></i>
                                    <i class="fa-solid fa-star selected" data-star="3"></i>
                                    <i class="fa-solid fa-star selected" data-star="4"></i>
                                    <i class="fa-solid fa-star selected" data-star="5"></i>
                                </div>
                                <p class="m-0" id="ratingText">Tuyệt vời</p>
                            </div>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="5">
                        <input type="hidden" name="user_id"
                            value="<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : 1; ?>">
                        <div class="col-12 p-3" style="background-color: #f5f5f5;">
                            <div class="p-2 border " style="background-color: #fff;">
                                <div class="my-1">
                                    <label for="text" class="form-label">Cảm nhận của bạn về sản phẩm:</label>
                                    <input type="text" class="form-control border border-0" id="text"
                                        placeholder="để lại đánh giá." name="review">
                                </div>
                                <div class="container my-1">
                                    <label for="fileInput" id="createImg" class="label-file">
                                        <i class="bi bi-camera-fill"></i>
                                        Thêm Hình Ảnh:
                                    </label>
                                    <div class="file-preview" id="filePreview"></div>
                                    <div id="remainingImages" class="text-muted">5/5 ảnh.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="submitRate" class="btn btn-danger">Hoàn thành</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        $(document).on('click', '.button-show-Dord', function () {
            var orderId = $(this).data('id');
            var orderStatus = $(this).data('orderstatus')

            $.ajax({
                url: 'order/showDorderByOrder', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    order_id: orderId, order_status: orderStatus
                },
                success: function (data) {
                    if (data) {
                        $('#showDtail').html(data)

                        // Mở modal
                        $('#watchAllDord').modal('show');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin don hang');
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.btn-order-status', function () {

            var order_status = $(this).data('status')
            $.ajax({
                url: "<?= _WEB_ROOT_ ?>/order/showOrderById",
                type: "POST",
                data: {
                    status: order_status
                },
                success: function (data) {
                    $("#box-order").html(data)
                }, error: function () {
                    console.log("loi roi")
                }
            })
        })
    })

    $(document).ready(function () {
        $(document).on('click', '.cancelOrder', function () {

            var order_id = $(this).data('order-id')
            $.ajax({
                url: "<?= _WEB_ROOT_ ?>/order/cancelOrder",
                type: "POST",
                data: {
                    orderId: order_id
                },
                success: function () {
                    window.location.reload()
                }, error: function () {
                    console.log("loi roi")
                }
            })
        })
    })

    $(document).ready(function () {

        $(document).on('click', '.button-show-rate', function () {
            var productId = $(this).data('productid');
            var dOrderId = $(this).data('dorderid');
            $.ajax({
                url: 'order/showRate', // Đường dẫn đến controller xử lý
                type: 'POST',
                data: {
                    product_id: productId,
                    Dorder_id: dOrderId
                },
                success: function (data) {
                    if (data) {
                        $('#showRate').html(data)
                        // Mở modal
                        $('#rateModal').modal('show');
                        $('#watchAllDord').modal('hide');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra khi tải thông tin don hang');
                }
            });
        });
    });


    function updateCountImg() {
        const filePreview = document.querySelector("#filePreview");
        const maxImages = 5; // Giới hạn tối đa 5 ảnh
        const countImg = maxImages - (filePreview.children.length);
        //Chọc tới hiển thị số lượng ảnh có thể thêm
        document.querySelector("#remainingImages").innerText = `${countImg}/5 ảnh.`;
    }
    function addNewImageInput() {
        updateCountImg()
        const filePreview = document.querySelector("#filePreview");
        const maxImages = 5; // Giới hạn tối đa 5 ảnh
        if (filePreview.children.length >= maxImages) {
            messger({ title: 'Cảnh báo', mess: 'Giới hạn tối đa 5 ảnh!', type: 'warning' });
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
    }

    //Bắt sự khi nhấn vào thêm ảnh
    document.getElementById('createImg').addEventListener("click", function () {
        addNewImageInput();
    })


    //Bắt sự kiện khi chọn sao
    document.addEventListener("click", function () {
        const stars = document.querySelectorAll("#starRating i");
        const ratingValue = document.getElementById("ratingValue");
        const ratingText = document.getElementById("ratingText");
        const rateTextDeteil = [
            "Rất tệ",
            "Tệ",
            "Bình thường",
            "Tốt",
            "Tuyệt vời"
        ];
        stars.forEach((star, index) => {
            star.addEventListener("click", function () {
                const rating = index + 1;
                ratingValue.value = rating;
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add("selected");
                    } else {
                        s.classList.remove("selected");
                    }
                });
                ratingText.innerText = rateTextDeteil[rating - 1];
            });
        });
    });
</script>