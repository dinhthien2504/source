const valid_new_user = async () => {
    // Kiểm tra name
    const name = $('#name_new');
    if (name.val().trim() === '') {
        name.focus();
        messager({ title: 'Cảnh báo!', mess: 'Vui lòng nhập tên', type: 'error' });
        return false;
    }

    // Kiểm tra email
    const email = $('#email_new');
    if (email.val().trim() === '') {
        email.focus();
        messager({ title: 'Cảnh báo!', mess: 'Vui lòng nhập email!', type: 'error' });
        return false;
    }
    if (!validate_email(email.val())) {
        email.focus();
        return false;
    }

    const emailExists = await check_exist_email(email.val());
    if (emailExists) {
        return false;
    }

    // Kiểm tra mật khẩu
    const pwd = $('#pwd_new');
    if (pwd.val().trim() === '') {
        pwd.focus();
        messager({ title: 'Cảnh báo!', mess: 'Vui lòng nhập mật khẩu!', type: 'error' });
        return false;
    }
    if (!validate_pwd(pwd.val())) {
        pwd.focus();
        messager({ title: 'Cảnh báo!', mess: 'Mật khẩu phải có ít nhất 8 ký tự, chứa ít nhất một chữ cái viết hoa và một ký tự đặc biệt!', type: 'error' });
        return false;
    }

    return true;
}

const check_exist_email = (email) => {
    return new Promise((resolve) => {
        $.ajax({
            url: '../check_email',
            type: 'POST',
            data: { email: email },
            success: (data) => {
                if (data) {
                    messager({ title: 'Cảnh báo!', mess: 'Email đã tồn tại!', type: 'error' });
                    resolve(true);
                } else {
                    resolve(false);
                }
            },
            error: () => {
                console.log("Không gửi lên được");
                resolve(false);
            }
        });
    });
};
$('#submit_new_user').click(async () => {
    const isValid = await valid_new_user();
    if (isValid) {
        $('#form_new_user').submit(); // Nếu hợp lệ, gửi form
    }
});

const get_user_by_id = (el) => {
    // Gửi yêu cầu AJAX để lấy thông tin danh mục
    const user_id = $(el).data('id');
    $('#form_edit_user').html('');
    $.ajax({
        url: 'get_user_by_id',
        type: 'POST',
        data: {
            id: user_id
        },
        success: function (data) {
            $('#form_edit_user').html(data);
        },
        error: function () {
            alert('Có lỗi xảy ra khi tải thông tin thành viên');
        }
    });
}

const valid_edit_user = () => {
    // Kiểm tra name
    const name = $('#name_edit');
    if (name.val().trim() === '') {
        name.focus();
        messager({ title: 'Cảnh báo!', mess: 'Vui lòng nhập tên', type: 'error' });
        return false;
    }
    return true;
}