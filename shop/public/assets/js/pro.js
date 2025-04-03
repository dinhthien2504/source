//Viết hàm lấy size theo màu
const change_cor = (el, pro_id, cor_id) => {
    $('.custom-detail__img--color').removeClass('custom-detail__active');
    $(el).addClass('custom-detail__active');
    change_img_main(el);
    $.ajax({
        url: `get_size`,
        type: 'POST',
        data: {
            pro_id: pro_id,
            cor_id: cor_id
        },
        success: (data) => {   
            $('.show__size').html(data);       
            // Thiết lập số lượng mặc định là 1
            $("#custom-detail__quantity").val(1);
            //Thiết lập số lượng xử lý
            $('.quantity__handle').val('');
            //Thiết lập id phân loại
            $('.variant__handle').val('');
            //Disable cho nut so luong
            $('.custom-detail__btn--quantity').addClass('custom-btn__disabled');
            //Xoa noi dung hien thi so luong 
            $(".show_stock").html('');
        },
        error: () => {
            console.log("Đã có lỗi xảy ra!");
        }
    });
};
const get_quantity = (el, class__el, pro_id, cor_id = null, size_id = null) => {
    $(class__el).removeClass('custom-detail__active');
    $(el).addClass('custom-detail__active');
    const data = { pro_id };
    if (cor_id) data.cor_id = cor_id;
    if (size_id) data.size_id = size_id;

    if(cor_id && size_id === null) {
        change_img_main(el);
    }
    $.ajax({
        url: 'get_quantity',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: (data) => {
            //Xóa class "custom-btn__disabled" khỏi các nút 
            $('.custom-detail__btn--quantity').removeClass("custom-btn__disabled");
            // Thiết lập số lượng mặc định là 1
            $("#custom-detail__quantity").val(1);
            //Thiết lập số lượng xử lý
            $('.quantity__handle').val(1);
            //Thiết lập id phân loại
            $('.variant__handle').val(data.id);
            $(".show_stock").html(`Có ${data.quantity} sản phẩm trong kho`);
            //Gắn sự kiện click vào nút điều chỉnh số lượng
            $('.custom-detail__btn--plus').off('click').on('click', () => {
                change_quantity_detail('plus', data.quantity);
            });
        },
        error: () => {
            console.log("Đã có lỗi xảy ra!");
        }
    });
};
const change_quantity_detail = (method = 'minus', max = 1) => {
    let quantity = parseInt($('#custom-detail__quantity').val(), 10);

    switch(method) {
        case 'plus': 
            if(quantity < max) {
                quantity += 1;
            }else {
                messager({title: 'Cảnh báo!', mess: 'Lượng hàng trong kho không đủ!', type: 'error'});
            }
        break;
        case 'minus':
            if(quantity > 1) {
                quantity -= 1;
            }else {
                messager({title: 'Cảnh báo!', mess: 'Số lượng tối thiểu là 1!', type: 'error'}); 
            }
        break;
    }
    $('#custom-detail__quantity').val(quantity); 
    //Thiết lập số lượng xử lý
    $('.quantity__handle').val(quantity);
};
const change_img_main = (el, class__el = null) => {
    if(class__el) {
        $(class__el).removeClass('custom-detail__active');
        $(el).addClass('custom-detail__active');
    }
    const el_img_main = $('.custom-detail__img--main'); 
    const new_src = $(el).find('img').attr('src');
    if (new_src) { 
        el_img_main.attr('src', new_src);
    }
};

//viết hàm check form
const valid_handle_cart = () => {
    const el_id = $('.variant__handle').val();
    const el_quantity = $('.quantity_handle').val();
    if(el_id == '' || el_quantity == '') {
        messager({title: 'Cảnh báo!', mess: 'Vui lòng chọn phân loại hàng!', type: 'error'});
        return false;
    } 
    //Kiểm tra đăng nhập
    const check_user = $('.user__id').val();
    if(check_user == '') {
        messager({title: 'Cảnh báo!', mess: 'Vui lòng đăng nhập để mua hàng!', type: 'error'});
        return false;
    }
    return true;
}

//Viết hàm check filter
const valid_filter = () => {
    const el_min_price = $('#min_price');
    const el_max_price = $('#max_price');

    const minPrice = el_min_price.val() ? parseFloat(el_min_price.val()) : null;
    const maxPrice = el_max_price.val() ? parseFloat(el_max_price.val()) : null;
    
    // Không cho phép submit nếu cả hai giá trị đều rỗng
    if (minPrice === null && maxPrice === null) {
        messager({title: 'Cảnh báo!', mess: 'Vui lòng nhập ít nhất một giá trị!', type: 'error'});
        return false;
    }

    // Kiểm tra nếu giá trị nhỏ nhất không hợp lệ
    if (minPrice !== null && minPrice < 1000) {
        messager({title: 'Cảnh báo!', mess: 'Giá trị nhỏ nhất phải lớn hơn hoặc bằng 1000!', type: 'error'});
        return false;
    }

    // Kiểm tra nếu giá trị lớn nhất không hợp lệ
    if (maxPrice !== null && maxPrice < 10000) {
        messager({title: 'Cảnh báo!', mess: 'Giá trị lớn nhất phải lớn hơn hoặc bằng 10000!', type: 'error'});
        return false;
    }

    // Kiểm tra mối quan hệ giữa hai giá trị nếu cả hai đều tồn tại
    if (minPrice !== null && maxPrice !== null && maxPrice <= minPrice) {
        messager({title: 'Cảnh báo!', mess: 'Giá trị lớn nhất phải lớn hơn giá trị nhỏ nhất!', type: 'error'});
        return false;
    }

    return true;
};


