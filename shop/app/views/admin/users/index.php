<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Quản Lý Thành Viên</h3>
    </div>
    <div class="custom-content__add custom-btn__hover">
        <button data-bs-toggle="modal" data-bs-target="#myModelNewUser"><i class="ph ph-plus"></i>Thêm 1 thành
            viên</button>
    </div>
    <div class="custom-content__show p-3">
        <div class="custom-content__show--top">
            <p>
                <?= $total_user['total'] - 1 ?>
                thành viên
            </p>
            <form method="GET">
                <input type="hidden" name="page" value="1">
                <input type="text" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>"
                    placeholder="Tìm kiếm...">
                <button type="submit">Tìm</button>
            </form>
        </div>
        <?php if (!empty($users)): ?>
            <form action="<?= _WEB_ROOT_ ?>/admin/user/handle-del-groups" method="POST"
                onsubmit="return confirm('Bạn có chắc muốn xóa danh sách người dùng!')">
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
                                    <div class="col-3">
                                        <p class="m-0">Hình ảnh</p>
                                    </div>
                                    <div class="col-2 p-0">
                                        <p class="m-0 text-center">Tên</p>
                                    </div>
                                    <div class="col-3 p-0">
                                        <p class="m-0 text-center">Email</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="m-0 text-center">Vai trò</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="m-0 text-center">Thao tác</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Item pro -->
                    <?php foreach ($users as $user):
                        $role = [
                            '2' => 'Quản trị',
                            '0' => 'Khách hàng'
                        ];
                        ?>
                        <div class="custom-table__item">
                            <div class="row my-4 g-0">
                                <!-- Checkbox Column -->
                                <div class="col-1">
                                    <div class="text-center">
                                        <input type="checkbox" value="<?= $user['id'] ?>" name="user_del_groups[]"
                                            class="custom-table__check check-item" type="checkbox">
                                    </div>
                                </div>
                                <!-- Product Details -->
                                <div class="col-11">
                                    <div class="row g-0">
                                        <div class="col-lg-3 col-12">
                                            <div class="row d-flex g-0">
                                                <div class="col-lg-3 col-sm-2 col-3">
                                                    <?php if ($user['url_image'] == null): ?>
                                                        <img style="width: 60px; height: 60px; object-fit: cover;"
                                                            src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                                                            alt="hình ảnh">
                                                    <?php else: ?>
                                                        <img style="width: 60px; height: 60px; object-fit: cover;"
                                                            src="<?= _WEB_ROOT_ ?>/public/assets/img/user/<?= $user['url_image'] ?>"
                                                            alt="hình ảnh">
                                                    <?php endif ?>
                                                </div>
                                                <div class="col-lg-9 col-sm-10 col-9">
                                                    <p class="m-0 text-black fs-15 fw-bold"><?= $user['name'] ?></p>
                                                    <p class="m-0 fs-12">ID Sản phẩm: <?= $user['id'] ?> - (
                                                        <?php if ($user['status'] == 0): ?>
                                                            <span class="text-success">Đang hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="text-danger">Đang ẩn</span>
                                                        <?php endif; ?>
                                                        )
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Sales and Price -->
                                        <div class="col-lg-2 col-3">
                                            <p class="m-0 fs-12 text-center"><?= $user['name'] ?></p>
                                        </div>
                                        <div class="col-lg-3 col-4">
                                            <p class="m-0 fs-12 text-center"><?= $user['email'] ?></p>
                                        </div>
                                        <div class="col-lg-2 col-3">
                                            <p class="m-0 text-black fs-12 text-center"><?= $role[$user['role']] ?></p>
                                        </div>
                                        <div class="col-lg-2 col-2 ">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" onclick="get_user_by_id(this)" data-bs-toggle="modal"
                                                    data-bs-target="#myModelEditUser" style="width: 50px;"
                                                    data-id="<?= $user['id'] ?>" class="btn btn-outline-warning btn-sm "><i
                                                        class="ph ph-pen"></i></button>
                                                <a href="<?= _WEB_ROOT_ ?>/admin/user/handle_del-<?= $user['id'] ?>"
                                                    style="width: 50px;" data-bs-toggle="tooltip" title="Xóa!"
                                                    onclick="return confirm('Bạn có chắc muốn xóa thành viên này không!')"
                                                    class="btn btn-outline-danger btn-sm "><i class="ph ph-trash"></i></a>
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
                    <!-- End item user -->
                    <div class="custom-content__button bg-light p-4 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-center d-flex align-items-center gap-2">
                                    <input class="custom-table__check--all check-all" id="check_all" type="checkbox">
                                    <label class="fs-17 cursor-pointer" for="check_all">Tất cả</label>
                                </div>
                            </div>
                            <button type="submit" name="submit_del_groups" style="width: 50px;"
                                class="btn btn-outline-danger btn-sm "><i class="ph ph-trash"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center mt-5">
                <p class="alert alert-warning w-100 text-center">Hiện tại không có thành viên nào!</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Model new -->
<div class="modal" id="myModelNewUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/user/handle-new" id="form_new_user"
                class="custom-form__account">
                <div class="text-center">
                    <h3 class="fs-2 fw-normal">Tạo Tài Khoản</h3>
                </div>
                <div class="flex-column">
                    <label>Tên </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5z"></path>
                        <path d="M12 14c-4.4 0-8 3.6-8 8h16c0-4.4-3.6-8-8-8z"></path>
                    </svg>
                    <input placeholder="Nhập tên" id="name_new" name="name_new" class="input" type="text" />
                </div>
                <div class="flex-column">
                    <label>Email </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                        <g data-name="Layer 3" id="Layer_3">
                            <path
                                d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
                            </path>
                        </g>
                    </svg>
                    <input placeholder="Nhập email" id="email_new" name="email_new" class="input" type="text" />
                </div>

                <div class="flex-column">
                    <label>Mật Khẩu </label>
                </div>
                <div class="inputForm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                        <path
                            d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
                        </path>
                        <path
                            d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
                        </path>
                    </svg>
                    <input placeholder="Nhập mật khẩu" id="pwd_new" name="pwd_new" class="input" type="password" />
                </div>
                <div class="flex-column">
                    <label>Vai trò </label>
                </div>
                <div class="mb-3">
                    <select name="role_new" class="custom-form-select">
                        <option value="0">Khách hàng</option>
                        <option value="2">Quản trị</option>
                    </select>
                </div>
                <button type="button" id="submit_new_user" class="button-submit">Thêm Thành Viên</button>
            </form>
        </div>
    </div>
</div>


<!-- Model edit-->
<div class="modal" id="myModelEditUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?= _WEB_ROOT_ ?>/admin/user/handle-edit" id="form_edit_user"
                onsubmit="return valid_edit_user()" class="custom-form__account">
                <!-- Show thông tin bằng ajax -->
            </form>
        </div>
    </div>
</div>