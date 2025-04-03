const valid_add_cate = () => {
    const el_name = document.getElementById('name_cate');
    if (!el_name.value.trim()) {
        messager({title: 'Lỗi!', mess: 'Tên danh mục không được để trống!', type: 'error'});
        return false;
    }
    return true;
    
}
const valid_edit_cate = () => {
    const el_name = document.getElementById('name_cate_edit');
    if (!el_name.value.trim()) {
        messager({title: 'Lỗi!', mess: 'Tên danh mục không được để trống!', type: 'error'});
        return false;
    }
    return true;
    
}
const get_cate_by_cate_id = (el) => {
    // Gửi yêu cầu AJAX để lấy thông tin danh mục
    const cate_id = $(el).data('id');
    $.ajax({
        url: 'get_cate_by_cate_id',
        type: 'POST',
        data: {
            cate_id: cate_id
        },
        success: function (data) {
            $('#show_edit_cate').html(data);
        },
        error: function () {
            alert('Có lỗi xảy ra khi tải thông tin danh mục');
        }
    });
}