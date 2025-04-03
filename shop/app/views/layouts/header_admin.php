<div class="custom-sidebar">
    <div class="custom-menu-btn">
        <i class="ph-bold ph-caret-left"></i>
    </div>
    <div class="custom-head">
        <div class="custom-user-img">
            <img src="https://cdn-icons-png.flaticon.com/512/219/219983.png" alt="" />
        </div>
        <div class="custom-user-details">
            <p class="custom-title">web developer</p>
            <p class="custom-name">ADMIN</p>
        </div>
    </div>
    <div class="custom-nav">
        <div class="custom-menu">
            <p class="custom-title">Chính</p>
            <ul>
                <li>
                    <a href="<?= _WEB_ROOT_ ?>/admin/">
                        <i class="custom-icon ph-bold ph-house-simple"></i>
                        <span class="custom-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="cursor-pointer">
                        <i class="custom-icon ph-bold ph-calendar-blank"></i>
                        <span class="custom-text">Sản Phẩm</span>
                        <i class="custom-arrow ph-bold ph-caret-down"></i>
                    </a>
                    <ul class="custom-sub-menu">
                        <li>
                            <a href="<?= _WEB_ROOT_ ?>/admin/products">
                                <span class="custom-text">Tất cả sản phẩm</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= _WEB_ROOT_ ?>/admin/product-new">
                                <span class="custom-text">Thêm sản phẩm</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= _WEB_ROOT_ ?>/admin/categories">
                                <span class="custom-text">Danh mục</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= _WEB_ROOT_ ?>/admin/orders">
                        <i class="custom-icon ph-bold ph-package"></i>
                        <span class="custom-text">Đơn Hàng</span>
                    </a>
                </li>
                <!-- <li class="active">
                    <a href="#">
                        <i class="custom-icon ph-bold ph-file-text"></i>
                        <span class="custom-text">Posts</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="<?= _WEB_ROOT_ ?>/admin/category">
                        <i class="custom-icon ph-bold ph-browsers"></i>
                        <span class="custom-text">Danh Mục</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="<?= _WEB_ROOT_ ?>/admin/product">
                        <i class="custom-icon ph-bold ph-calendar-blank"></i>
                        <span class="custom-text">Sản Phẩm</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="#">
                        <i class="custom-icon ph-bold ph-chart-bar"></i>
                        <span class="custom-text">Income</span>
                        <i class="custom-arrow ph-bold ph-caret-down"></i>
                    </a>
                    <ul class="custom-sub-menu">
                        <li>
                            <a href="#">
                                <span class="custom-text">Earnings</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="custom-text">Funds</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="custom-text">Declines</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="custom-text">Payouts</span>
                            </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <!-- <div class="custom-menu">
            <p class="custom-title">Settings</p>
            <ul>
                <li>
                    <a href="#">
                        <i class="custom-icon ph-bold ph-gear"></i>
                        <span class="custom-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div> -->
    </div>
    <div class="custom-menu custom-footer">
        <p class="custom-title">Tài khoản</p>
        <ul>
            <li>
                <a href="<?= _WEB_ROOT_ ?>/admin/users">
                    <i class="custom-icon ph-bold ph-user"></i>
                    <span class="custom-text">Thành Viên</span>
                </a>
            </li>
            <li>
                <a href="<?= _WEB_ROOT_ ?>/logout">
                    <i class="custom-icon ph-bold ph-sign-out"></i>
                    <span class="custom-text">Đăng xuất</span>
                </a>
            </li>
        </ul>
    </div>
</div>