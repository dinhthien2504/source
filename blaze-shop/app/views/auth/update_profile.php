<div class="container-pro profile-container-pro">
    <h1 class="profile-title-pro">Hồ Sơ Cá Nhân</h1>
    <div class="profile-content-pro">
        <div class="profile-avatar-pro">
            <img src="<?= _WEB_ROOT_ ?>/public/assets/img/img_user/<?= htmlspecialchars($_SESSION['user']['image']) ?>"
                alt="Avatar" class="avatar-img-pro">
            <form action="<?= _WEB_ROOT_ ?>/auth/update_profile_user" method="POST" enctype="multipart/form-data"
                class="avatar-form-pro">
                <input type="file" name="image" class="form-control-pro avatar-input-pro">
                <button type="submit" class="btn-pro btn-primary-pro btn-avatar-pro">Thay đổi ảnh</button>
            </form>
        </div>
        <div class="profile-info-pro">
            <form action="<?= _WEB_ROOT_ ?>/auth/update_profile_user" method="POST">
                <?php if (isset($_SESSION['user']['id'])): ?>
                    <div class="form-group-pro">
                        <label for="name" class="label-pro">Họ và Tên</label>
                        <input type="text" class="form-control-pro" name="name" id="name"
                            value="<?= htmlspecialchars($_SESSION['user']['name']) ?> " required>
                    </div>
                    <div class="form-group-pro">
                        <label for="email" class="label-pro">Email</label>
                        <input type="email" class="form-control-pro" name="email" id="email"
                            value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>
                    </div>
                    <div class="form-group-pro">
                        <label for="password" class="label-pro">Mật khẩu cũ</label>
                        <input type="password" class="form-control-pro" name="password" id="password"
                            placeholder="Nhập lại mật khẩu cũ">
                    </div>
                    <div class="form-group-pro">
                        <label for="password" class="label-pro">Mật khẩu mới</label>
                        <input type="password" class="form-control-pro" name="password_new" id="password"
                            placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="form-group-pro">
                        <label for="phone" class="label-pro">Số điện thoại</label>
                        <input type="phone" class="form-control-pro" name="phone" id="phone"
                            value="<?= htmlspecialchars($_SESSION['user']['phone']) ?>">
                    </div>
                    <div class="form-group-pro">
                        <label for="address" class="label-pro">Địa chỉ</label>
                        <input type="text" class="form-control-pro" name="address" id="address"
                            value="<?= (isset($_SESSION['user']['address'])) ? htmlspecialchars($_SESSION['user']['address']) : '' ?>">
                    </div>
                <?php endif; ?>
                <?php if (isset($this->errorMessage)): ?>
                    <div class="error" style="color: red; margin-bottom: 10px;">
                        <?= $this->errorMessage ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn-pro btn-success-pro" class="btn-pro btn-success-pro">Thay đổi thông
                    tin</button>
            </form>
            <button type="submit" class="btn-pro btn-success-pro" style=" margin-top: 10px;"><a
                    href="<?= _WEB_ROOT_ ?>/trang-ca-nhan" class="logout-btn"
                    style="font-size: 15px; color: #000; text-decoration: none; color: #fff;"> Hủy </a></button>
        </div>
    </div>
</div>