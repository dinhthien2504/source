document.addEventListener('DOMContentLoaded', () => {
    // Lấy checkbox "Check All" và các checkbox mục
    const btn_check_alls = document.querySelectorAll(".custom-cart_check--all");

    // Lấy checkbox "Check All Groups"
    const check_all__items = document.querySelectorAll(".custom-cart__check--all-item");

    // Lấy checkbox "Check Items"
    const check_items = document.querySelectorAll(".custom-cart__check--item");

    if (btn_check_alls) {
        btn_check_alls.forEach(btn_check_all => {
            // Gắn sự kiện click cho checkbox "Check All"
            btn_check_all.addEventListener("click", () => {
                const is_checked = btn_check_all.checked;
                //Cập nhật trạng thái check all còn lại
                btn_check_alls.forEach(item => item.checked = is_checked);
                // Cập nhật trạng thái cho tất cả các checkbox mục
                check_all__items.forEach(item => item.checked = is_checked);
                check_items.forEach(item => item.checked = is_checked);
                update_total();
            });

        })
        
        // Hàm cập nhật trạng thái của các checkbox con theo nhóm
        const update_check_groups = (group, is_checked) => {
            const relate_items = document.querySelectorAll(`.custom-cart__check--item[data-checkgroup="${group}"]`);
            relate_items.forEach(item => item.checked = is_checked);
        };

        // Gắn sự kiện cho từng checkbox "Check All Groups"
        check_all__items.forEach(check_all_item => {
            check_all_item.addEventListener("click", () => {
                update_check_groups(check_all_item.dataset.checkgroup, check_all_item.checked);
                const is_checked =  [...check_all__items].every(item => item.checked);
                // Kiểm tra trạng thái tổng "Check All"
                btn_check_alls.forEach(item => item.checked = is_checked);
                update_total();
            });
        });

        // Gắn sự kiện cho từng checkbox mục
        check_items.forEach(check_item => {
            check_item.addEventListener("click", () => {
                const group = check_item.dataset.checkgroup;
                const relate_items = document.querySelectorAll(`.custom-cart__check--item[data-checkgroup="${group}"]`);
                const check__all_item = document.querySelector(`.custom-cart__check--all-item[data-checkgroup="${group}"]`);

                // Cập nhật trạng thái của checkbox "Check All Groups"
                check__all_item.checked = [...relate_items].every(item => item.checked);

                // Kiểm tra trạng thái tổng "Check All"
                const is_checked =  [...check_all__items].every(item => item.checked);
                btn_check_alls.forEach(item => item.checked = is_checked);
                update_total();
            });
        });
    }
    let el_address = document.getElementById('address_reverse');
    if(el_address) {
        const el_address__new  = el_address.textContent.split(', ').reverse().join(', ');
        el_address.innerText = el_address__new;
    }
});
// Hàm thay đổi số lượng giỏ hàng
const changeQuantity = (el, action = '', cart_id = null,  max = 1) => {
    //Lấy thằng cha gần nhất
    const el_parent = el.closest('.custom-cart__container--handle');
    //Lấy số lượng
    const el_quantity = el_parent.querySelector('.cart__quantity');
    
    let currentValue = parseInt(el_quantity.value);

    switch (action) {
        case 'plus':
            if (currentValue < max) {
                currentValue += 1;
                update_quantity_cart(cart_id, currentValue);
            } else {
                messager({title: 'Cảnh báo!', mess: 'Lượng hàng trong kho không đủ!', type: 'error'}); 
            }
            break;

        case 'minus':
            if (currentValue > 1) {
                currentValue -= 1;
                update_quantity_cart(cart_id, currentValue);
            } else {
                messager({title: 'Cảnh báo!', mess: 'Số lượng tối thiểu là 1!', type: 'error'}); 
            }
            break;
    }
    
    el_quantity.value = currentValue;
    update_total_item(el_parent, currentValue);
    update_total();
}
const update_total_item = (el_parent, currentValue) => {
    //Lấy giá để xử lý tổng
    const price_text = el_parent.querySelector('.custom-cart_price--sales').textContent.trim();

    //Chuyển từ chữ thành số
    let price_number = parseInt(price_text.replace(/[^\d]/g, ''), 10);

    let total_price_new = price_number * currentValue;

    el_parent.querySelector('.custom-cart__price--total---item').innerText = `${total_price_new.toLocaleString()} đ`;
}
const update_quantity_cart = (id, quantity) => {
    $.ajax({
        url: 'update_quantity_cart',
        method: 'POST',
        data: {
            cart_id: id ,
            quantity: quantity
        },
        success: (data) => {
            console.log(data);
        }
    })
}
const update_total = () => {
    let total = Array.from(document.querySelectorAll('.custom-cart__check--item:checked'))
        .reduce((sum, item) => {
            //Lấy box cha
            const parent = item.closest('.custom-cart__item--content');
            if (!parent) return sum;
            const text_total__item = parent.querySelector('.custom-cart__price--total---item').textContent.trim();
            let total_item = parseInt(text_total__item.replace(/[^\d]/g, ''), 10);
            return sum + total_item;
        }, 0);

    document.querySelector('.custom-cart__total').textContent = `Tổng cộng: ${total.toLocaleString()} đ`;
};

const valid_cart = () => {
    const el_check = document.querySelectorAll('.custom-cart__check--item:checked');
    if(el_check.length == 0) {
        messager({title: 'Cảnh báo!', mess: 'Vui lòng chọn ít nhất một món hàng!', type: 'error'});
        return false;
    }
    return true;  
}
// order
const get_province = () => {
    $.ajax({
        url: 'get_province',
        method: 'GET',
        success: (data) => {
            $('#custom_checkout--show--data').html(data);
            //Cập nhật lại giá trị input
            active_nav_address(0);
        }
    })
}
const get_district_province_id = (province_id, name_province) => {
    $.ajax({
        url: 'get_district_province_id',
        method: 'POST',
        data: {
            province_id: province_id
        },
        success: (data) => {
            $('#custom_checkout--show--data').html(data);
            //Cập nhật lại giá trị input
            $('#address').val(name_province);
            //Gán sự kiện vào menu
            $('#district').on('click', function () {
                get_district_province_id(province_id, name_province);
            })
            active_nav_address(1);
            //Cập nhật lại check
            $('#check_address_change').val('');
        }
    })
}
const get_ward_district_id = (district_id, name_district) => {
    $.ajax({
        url: 'get_ward_district_id',
        method: 'POST',
        data: {
            district_id: district_id
        },
        success: (data) => {
            $('#custom_checkout--show--data').html(data);
            //Cập nhật lại giá trị input
            const current_value =  $('#address').val();
            $('#address').val(`${current_value}, ${name_district}`);
            active_nav_address(2);
            //Cập nhật lại check
            $('#check_address_change').val('');
        }
    })
}

const action_ward = (name_ward) => {
    const current_value =  $('#address').val();

    const current_value__handle = current_value.split(',').slice(0, 2).join(',').trim();
    
    $('#address').val(`${current_value__handle}, ${name_ward}`);
    show_address__detail(false);

    //Cập nhật lại check
    $('#check_address_change').val(name_ward);

}

const active_nav_address = (index = 1) => {
    const el_list__span = $('.group_address__detail--content__nav span');
    el_list__span.removeClass('custom_active--border');
    $(el_list__span[index]).addClass('custom_active--border');
}

const show_address__detail = (status = true) => {
    $('.group_address__detail--content')
        .removeClass(status ? 'd-none' : 'd-block')
        .addClass(status ? 'd-block' : 'd-none');
};


const valid_checkout = () => {
    const el_check__address = document.getElementById('check_address');
    if(!el_check__address) {
        messager({title: 'Lỗi!', mess: 'Vui lòng cập nhật địa chỉ để đặt hàng!', type: 'error'});
        return false;
    }
    return true;
}
const valid_update__address = () => {
    //Kiểm tra tên
    const el_name = $('#name');
    if(!el_name.val().trim()) {
        messager({title: 'Lỗi!', mess: 'Vui lòng nhập tên người nhận!', type: 'error'});
        el_name.focus();
        return false;
    }
    //Kiểm tra số điện thoại
    const el_phone = $('#phone');
    if(!el_phone.val().trim()) {
        messager({title: 'Lỗi!', mess: 'Vui lòng nhập số điện thoại người nhận!', type: 'error'});
        el_phone.focus();
        return false;
    }

    if(!validate_phone(el_phone.val().trim())) {
        messager({title: 'Lỗi!', mess: 'Số điện thoại không hợp lệ!', type: 'error'});
        el_phone.focus();
        return false;
    }


    //Kiểm tra địa chỉ
    const el_check_address = $('#check_address_change');
    if(!el_check_address.val().trim()) {
        messager({title: 'Lỗi!', mess: 'Vụi lòng chọn địa chỉ!', type: 'error'});
        console.log(el_check_address.val());
        
        return false;
    }

    //Kiểm tra địa chỉ chi tiết
    const el_address_detail = $('#address_detail');
    if(!el_address_detail.val().trim()) {
        messager({title: 'Lỗi!', mess: 'Vụi lòng chọn địa chỉ cụ thể!', type: 'error'});
        return false;
    }
    return true;
}

const update_address = () => {
    if(!valid_update__address()) {
        return;
    }
    $.ajax({
        url: 'update_address',
        method: 'POST',
        data: {
            name: $('#name').val(),
            phone: $('#phone').val(),
            address: $('#address').val(),
            address_detail: $('#address_detail').val()
        },
        success: (data) => {
            window.location.reload();
        }
    })
}