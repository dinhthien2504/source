<div class="forgot-container my-4">
    <h2>Mã xác nhận</h2>
    <p>Nhập mã xác nhận được gửi qua email của bạn</p>
    <form action="<?= _WEB_ROOT_ ?>/auth/check_verify" id="forgot-password-form" method='POST' id="forgot-password-form">
        <label for="email">Nhập tại đây:</label>
        <input type="text" id="email" name="text" placeholder="Mã xác nhận" required>
        <?php if (isset($this->errorMessage)): ?>
            <div class="error" style="color: red; margin-bottom: 10px;">
                <?= $this->errorMessage ?>
            </div>
        <?php endif; ?>
        <button type="submit">Gửi</button>
    </form>
    <div class="forgot-footer">
        <a href="<?= _WEB_ROOT_ ?>/tai-khoan">Quay lại đăng nhập</a>
    </div>
</div>