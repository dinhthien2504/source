<div class="forgot-container my-4">
    <h2>Đổi mật khẩu</h2>
    <p>Nhập mật khẩu</p>
    <form action="<?= _WEB_ROOT_ ?>/auth/reset_password" id="forgot-password-form" method='POST' id="forgot-password-form">
        <label for="email">Mật khẩu mới</label>
        <input type="text" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
        <label for="email">Xác nhận mật khẩu</label>
        <input type="text" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu mới">
        <?php if (isset($this->dataReset['error'])): ?>
            <div class="error" style="color: red; margin-bottom: 10px;">
                <?= $this->dataReset['error'] ?>
            </div>
        <?php endif; ?>
        <button type="submit">Xác nhận</button>
    </form>
    <div class="forgot-footer">
        <a href="<?= _WEB_ROOT_ ?>/tai-khoan">Quay lại đăng nhập</a>
    </div>
</div>