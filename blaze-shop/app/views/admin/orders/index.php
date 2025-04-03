<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3 mt-1">
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Đơn Hàng</h1>
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
                            placeholder="Tìm kiếm đơn hàng...">
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="nav nav-tabs d-flex flex-row flex-nowrap overflow-auto">
                            <a class="nav-link btn-get-order active" href="#" data-order-status="1">Chờ xác nhận</a>
                            <a class="nav-link btn-get-order" href="#" data-order-status="2">Đã xác nhận</a>
                            <a class="nav-link btn-get-order" href="#" data-order-status="3">Đang giao</a>
                            <a class="nav-link btn-get-order" href="#" data-order-status="4">Đã giao</a>
                            <a class="nav-link btn-get-order" href="#" data-order-status="0">Đã huỷ</a>
                        </div>
                        <button type="button" class="btn btn-info mb-2">Duyệt tất cả</button>
                    </div>
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Tên Khách Hàng</th>
                            <th>Ngày Đặt</th>
                            <th>Tổng Đơn Hàng</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="data-order">
                        <?php 
                        foreach($orders as $order):
                        ?>
                        
                        <tr>
                            <td class="align-middle"><?=$order['code_order']?></td>
                            <td class="align-middle"><?=$order['name']?></td>   
                            <td class="align-middle"><?=$order['by_date']?></td>
                            <td class="align-middle"><?=number_format($order['total'])?></td>
                            <td class="text-primary align-middle fw-bold"><?=$status[$order['status']]['name']?></td>
                            <td class="align-middle">
                            <button data-toggle="modal" class="btn btn-outline-warning ml-2 showDetailOrder"
                                            data-target="#showOrderModal" data-id="<?= $order['id'] ?>">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                            <button class="btn btn-outline-success change-status-btn ml-2" data-target="#editStatusOrder"
                                    <?php if($order['status'] == 4 || $order['status'] == 0 ) echo 'disabled' ?>
                                    data-id = "<?=$order['id']?>" data-status = <?=$order['status']?> onclick="return confirm('Duyệt đơn này?')">
                                <i class="ri-refresh-line"></i> 
                            </button>
                            </td>
                        </tr>
                        <?php endforeach ?>
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
 <div class="modal fade" id="editStatusOrder">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Đơn hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="updateOrder" action="<?= _WEB_ROOT_ ?>/admin/Order/updateOrder" method="post">

                        <div id="showOrder"></div>
                        <!-- Modal Footer -->
                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success" id="submit"
                                name="submit_regester">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- The Modal Edit-->
<div class="modal fade" id="showOrderModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông Tin Đơn Hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div id="showOrderDetail"></div>
            </div>
        </div>
    </div>
</div>
<style>
        .nav-link.active {
            color: red;
            font-weight: 500;
            border-bottom: 2px solid red;
        }
        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs {
            overflow-x: auto;
            overflow-y: hidden; 
            -webkit-overflow-scrolling: touch; 
        }

        .nav-tabs::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs {
            -ms-overflow-style: none;  
            scrollbar-width: none; 
        }
        .nav-tabs a{
            text-align: center;
            max-width: 180px!important;
            min-width: 170px!important;

        }
        @media (max-width: 992px) {
            .nav-tabs {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
            }
        }
    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-get-order',function(){
            $('.btn-get-order').removeClass('active')
            $(this).addClass('active')
            //end active btn

            var order_status = $(this).data('order-status')
            $.ajax({
                url: "<?= _WEB_ROOT_ ?>/admin/Order/showOrderById",
                type: "POST",
                data:{
                    status : order_status
                },
                success: function(data){
                    $("#data-order").html(data)
                },error: function(){
                    console.log("loi roi")
                }
            })
        })
    })

    $(document).ready(function(){
        $(document).on('click', '.change-status-btn', function(){
            var or_id = $(this).data('id')
            var or_status = $(this).data('status')

            $.ajax({
                url:"<?= _WEB_ROOT_ ?>/admin/Order/updateOrder",
                type: "POST",
                data:{
                    id: or_id, status: or_status
                },success: function(data){
                    console.log(data)
                    window.location.reload()
                }
                ,error: function(){
                    console.log("Loi khi gui yeu cau")
                }
            })
        })
    })
    
    $(document).ready(function () {
        $(document).on('click', '.showDetailOrder', function () {
            const orderId = $(this).data('id');
            $.ajax({
                url: "<?= _WEB_ROOT_ ?>/admin/Order/showOrderDetail",
                type: "POST",
                data: {
                    order_id: orderId
                },
            success: function (data){
                $("#showOrderDetail").html(data);
            },
            error: function () {
                console.log("Đã có lỗi xảy ra!");
            }
            });
        });
    });
</script>