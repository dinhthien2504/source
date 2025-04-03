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

    <!-- Content -->
    <div class="profile-content-pro" style="flex: 1;">
        <div class="profile-img" style="display: flex; flex-direction: column">
            <h1 class="profile-title-pro">Hồ Sơ Cá Nhân</h1>
            <div class="profile-avatar-pro">
                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/<?= htmlspecialchars($_SESSION['user']['image']) ?>"
                    alt="Avatar" class="avatar-img-pro">
            </div>
        </div>
        <div class="profile-info-pro">
            <form action="<?= _WEB_ROOT_ ?>/chinh-sua-trang-ca-nhan" method="POST">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="form-group-pro">
                        <label for="name" class="label-pro">Họ và Tên</label>
                        <input type="text" class="form-control-pro" name="name" id="name"
                            value="<?= htmlspecialchars($_SESSION['user']['name']) ?>" required disabled>
                    </div>
                    <div class="form-group-pro">
                        <label for="email" class="label-pro">Email</label>
                        <input type="email" class="form-control-pro" name="email" id="email"
                            value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled disabled>
                    </div>
                    <div class="form-group-pro">
                        <label for="password" class="label-pro">Mật khẩu</label>
                        <input type="password" class="form-control-pro" name="password" id="password"
                            value="<?= htmlspecialchars($_SESSION['user']['password']) ?>" disabled>
                    </div>
                    <div class="form-group-pro">
                        <label for="phone" class="label-pro">Số điện thoại</label>
                        <input type="phone" class="form-control-pro" name="phone" id="phone"
                            value="(+84) <?= htmlspecialchars($_SESSION['user']['phone']) ?>" disabled>
                    </div>
                    <div class="form-group-pro">
                        <label for="address" class="label-pro">Địa chỉ</label>
                        <input type="text" class="form-control-pro" name="address" id="address"
                            value="<?= (isset($_SESSION['user']['address'])) ? htmlspecialchars($_SESSION['user']['address']) : 'Bạn chưa nhập địa chỉ' ?>"
                            required disabled>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn-pro btn-success-pro">Thay đổi thông tin</button>
            </form>
            <button type="submit" class="btn-pro btn-success-pro" style=" margin-top: 10px;"><a
                    href="<?= _WEB_ROOT_ ?>/dang-xuat" class="logout-btn"
                    style="font-size: 15px; color: #000; text-decoration: none; color: #fff"> Đăng xuất </a></button>
        </div>
    </div>
</div>