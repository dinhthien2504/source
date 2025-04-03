//Hàm chuyển đổi chuổi ký tự
const handle_text = (text) => {
    return text 
        .replace(/[!@#$%^&*(),.]/g, '-')
        .replace(/\s+/g, '-') 
        .replace(/-+/g, '-');
}
//Hàm link tới trang sản phẩm
const handle__url_link = (el, web_root, text, id) => {
    let new_text = handle_text(text);
    el.setAttribute('href', `${web_root}/${new_text}-${id}`);
}
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