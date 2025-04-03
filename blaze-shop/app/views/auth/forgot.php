    <div class="forgot-container my-4">
        <h2>Quên mật khẩu</h2>
        <p>Nhập email để đặt lại mật khẩu của bạn.</p>
        <form action="<?= _WEB_ROOT_ ?>/auth/forgot_pass" id="forgot-password-form" method='POST'>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Nhập email">
            <?php if (isset($this->errorMessage)): ?>
                <div class="error" style="color: red; margin-bottom: 10px;">
                    <?= $this->errorMessage ?>
                </div>
            <?php endif; ?>
            <button type="submit">Gửi yêu cầu</button>
        </form>
        <div class="forgot-footer">
            <a href="<?= _WEB_ROOT_ ?>/tai-khoan">Quay lại đăng nhập</a>
        </div>
    </div>