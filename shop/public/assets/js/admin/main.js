
$(".custom-menu > ul > li").click(function (e) {
    // remove active from already active
    $(this).siblings().removeClass("active");
    // add active to clicked
    $(this).toggleClass("active");
    // if has sub menu open it
    $(this).find("ul").slideToggle();
    // close other sub menu if any open
    $(this).siblings().find("ul").slideUp();
    // remove active class of sub menu items
    $(this).siblings().find("ul").find("li").removeClass("active");
});

$(".custom-menu-btn").click(function () {
    $(".custom-sidebar").toggleClass("active");
});

const validate_file = (file) => {
    const maxFileSize = 2 * 1024 * 1024; // 2MB
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    // Kiểm tra nếu file rỗng
    if (!file || file.size === 0) {
        messager({ title: 'Lỗi!', mess: 'File không được để trống!', type: 'error' });
        return false;
    }
    // Kiểm tra kích thước file
    if (file.size > maxFileSize) {
        messager({ title: 'Lỗi!', mess: 'File tối đa 2 MB!', type: 'error' });
        return false;
    }

    // Kiểm tra định dạng file
    if (!allowedTypes.includes(file.type)) {
        messager({ title: 'Lỗi!', mess: 'Chỉ chấp nhận các định dạng: JPEG, PNG, PDF!', type: 'error' });
        return false;
    }
    return true;
}
document.addEventListener('DOMContentLoaded', () => {
    // Lấy tất cả các container chứa biến thể
    const variant_containers = document.querySelectorAll('.container-variants');
    variant_containers.forEach(container => {
        const variant_items = container.querySelectorAll('.variant-item');
        const btn__more = container.querySelector('.btn-toggle-variants');

        // Hàm hiển thị trạng thái (chỉ hiển thị 3 phần tử đầu tiên)
        const update__display = (show__all = false) => {
            variant_items.forEach((item, index) => {
                item.style.display = show__all || index < 3 ? 'block' : 'none';
            });
        };

        // Gọi trạng thái ban đầu (chỉ hiển thị 3 phần tử đầu tiên)
        update__display();

        // Nếu có hơn 3 biến thể, thêm sự kiện cho nút "Xem thêm/Thu gọn"
        if (variant_items.length > 3) {
            let check = false;

            btn__more.addEventListener('click', () => {
                check = !check;
                update__display(check);
                btn__more.textContent = check ? 'Thu gọn' : 'Xem thêm';
            });
        } else {
            // Ẩn nút nếu số biến thể <= 3
            btn__more.style.display = 'none';
        }
    });

    // Lấy checkbox "Check All" và các checkbox mục
    const el__check_all = $('.custom-table__check--all');
    const el__check_item = $('.check-item');

    // Gắn sự kiện click cho checkbox "Check All"
    el__check_all.on('click', function () {
        // Lấy trạng thái checked của "Check All"
        const is__checked = $(this).prop('checked');
        //Cập nhật check__all còn lại
        el__check_all.prop('checked', is__checked);
        // Áp dụng trạng thái cho tất cả các checkbox mục
        el__check_item.prop('checked', is__checked);
    });

    // (Tùy chọn) Gắn sự kiện để cập nhật trạng thái "Check All" khi các checkbox mục thay đổi
    el__check_item.on('change', function () {
        const all__checked = el__check_item.length === el__check_item.filter(':checked').length;
        el__check_all.prop('checked', all__checked);
    });

});

const validate_email = (email) => {
    // Biểu thức regex kiểm tra email
    const email_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Kiểm tra độ dài tối đa
    if (email.length > 254) {
        messager({ title: 'Cảnh báo!', mess: 'Email không được dài quá 254 ký tự.!', type: 'error' });
        return false;
    }

    // Kiểm tra định dạng email
    if (!email_regex.test(email)) {
        messager({ title: 'Cảnh báo!', mess: 'Email không hợp lệ.!', type: 'error' });
        return false;
    }

    return true;
}
const validate_phone = (phone) => {
    const phone_regex = /^(\+?\d{1,4}[-\s]?)?(\d{10}|\d{3}[-\s]?\d{3}[-\s]?\d{4})$/;
    return phone_regex.test(phone);
}
const validate_pwd = (pwd) => {
    const pwd_regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
    return pwd_regex.test(pwd);
}