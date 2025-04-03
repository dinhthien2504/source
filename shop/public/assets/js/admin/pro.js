//Lấy danh sách danh mục con dựa vào parent
const get_cate_chirld_by_parent = (el = null, id, name) => {
    if (el != null) {
        $('.container__cate li').removeClass("custom-cate__active");
        $(el).addClass("custom-cate__active");
    }

    $.ajax({
        url: `get_cate_chirld_by_parent`,
        type: 'POST',
        data: {
            parent_id: id
        },
        success: (data) => {
            if (data != '') {
                $('#show_cate_chirld').html(data);
            } else {
                $('#show_cate_chirld').html('Hiện tại không có danh mục con!');
            }
            $('#cate').html(name);
            $('#sub_cate').html('');
            // Xóa dữ liệu đã lấy trước đó
            $('#show_option_cate').removeData('cate-id'); // Xóa cả dữ liệu jQuery
            $('#show_option_cate').removeAttr('data-cate-id'); // Xóa thuộc tính HTML
            $('#pro__cate').val('');
        },
        error: () => {
            console.log("Đã có lỗi xảy ra!");
        }
    });
};
//Lấy id danh mục con để thêm sản phẩm
const action_cate_chirld = (el, id, name) => {
    //Xóa dữ liệu cate-id đã lấy trước đó
    $('#show_option_cate').removeData('cate-id');
    if (el) {
        $('.container__sub_cate li').removeClass("custom-cate__active");
        $(el).addClass("custom-cate__active");
    }
    $('#sub_cate').html(` > ${name}`);
    $('#show_option_cate').attr('data-cate-id', id);
};
//Xác nhận lấy dữ liệu cuối cùng
const confirm_cate = () => {
    const cate_id = $('#show_option_cate').data('cate-id');
    let text_cate = $('#show_option_cate').text();
    if (text_cate.startsWith('Đã chọn: ')) {
        text_cate = text_cate.replace('Đã chọn: ', '');
    }
    $('#title_cate').html(text_cate);
    if (!cate_id) {
        console.log("Chưa chọn danh mục!");
        return;
    }
    $('#pro__cate').val(cate_id);
};
//Lấy attritubes khi onchange
const change_attri_select = (el_select) => {
    const selected_val = el_select.value;
    const container = el_select.closest('.container__option');
    const el_selects = container.querySelectorAll('.select-template');
    el_selects.forEach((ops, index) => {
        if (index > 0) {
            ops.remove();
        }
    });
    //Chỉ hiện nút thêm thuộc tính nếu hiện tại là màu sắc
    show_add_select(selected_val);
    //Cập nhật lại ô số lượng
    $('#show_stock_option').html('');
    //Lấy dữ liệu attri_values mới nhất
    get_attri_val_by_attri_id(selected_val);
    //Xóa ảnh nếu có ảnh
    $('#file_preview_cor').html('');
    //Xóa dữ liệu đã lấy trước đó
    $('#show-select__2').html('');
    $('#show-select__2').removeClass('bg-light');
}
//Lấy dữ liệu attri_values từ server
const get_attri_val_by_attri_id = (selected_val) => {
    $.ajax({
        url: `get_attri_val_by_attri_id`,
        type: 'POST',
        data: {
            attri_id: selected_val
        },
        success: (data) => {
            $('.show_select').html(data)
        },
        error: () => {
            console.log("Đã có lỗi xảy ra!");
        }
    })
}
//Ẩn hiện nút thêm thuộc tính
const show_add_select = (value) => {
    const el_btn_show_add__attri = $('#btn_add_attri');
    if (el_btn_show_add__attri) {
        value == 2 ? el_btn_show_add__attri.addClass('d-none') : el_btn_show_add__attri.removeClass('d-none');
    }
}
//Hàm click vào thì mở input file
const action_input = (el) => {
    return el.querySelector('.input_file').click();
};
//Hàm xử lý khi chọn ảnh 
const handle_img__change = (input) => {
    const file = input.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            // Tìm phần tử cha chứa input file
            const parent_box = input.closest('.custom-content__box--img--basic');
            if (parent_box) {
                const div = parent_box.querySelector('div');
                //Tìm phần tử p để xóa
                const p = div.querySelector('p');
                const check_img__main = div.querySelector('.check_img__main');
                if (check_img__main) {
                    div.removeChild(check_img__main);
                }
                if (p) {
                    div.removeChild(p);
                }
                //Tìm phần tử img để gán ảnh vừa chọn
                const img = parent_box.querySelector('img');
                img.classList.add('w-100', 'h-100');
                img.src = e.target.result;

                // Tùy chọn: Thêm nút xóa
                const del_box = document.createElement('div');
                del_box.className = 'custom-content__img-del';
                del_box.innerHTML = '<i class="ph ph-x-circle"></i>';
                del_box.onclick = () => del_img(del_box);
                parent_box.appendChild(del_box);
            }
        };
        // Đọc file
        reader.readAsDataURL(file);
        // Kiểm tra xem phần tử hiện tại có phải là phần tử cuối cùng không
        const container = input.closest('#file_preview');
        const allBoxes = container.querySelectorAll('.custom-content__box--img--basic');
        const lastBox = allBoxes[allBoxes.length - 1];

        if (lastBox === input.closest('.custom-content__box--img--basic')) {
            // Nếu đúng là phần tử cuối cùng, thêm box mới
            add_new__img();
        }
    } else {
        input.value = '';
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn file là ảnh', type: 'error' });
    }
};
//Hàm thêm 1 box thêm ảnh mới
const add_new__img = () => {
    const container__img = document.getElementById('file_preview');
    const box_items = container__img.querySelectorAll('.custom-content__box--img--basic');
    if (box_items.length >= 5) {
        messager({ title: 'Cảnh báo!', mess: 'Chỉ có thể upload tối đa 5 ảnh', type: 'error' });
        return;
    }

    if (container__img) {
        const new_box = document.createElement('div');
        new_box.classList.add('custom-content__box--img--basic');
        new_box.innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary"
                onclick="action_input(this)">
                <input type="file" hidden name="pro_img__main[]" class="input_file pro_img__main"
                    onchange="handle_img__change(this)">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                    alt="">
                <p class="m-0 fs-12 show_count_img" >Thêm hình ảnh(1/5)</p>
            </div>`;

        container__img.append(new_box);
        updated_count();
    }
}
//Hàm xóa ảnh 
const del_img = (el) => {
    const container_box = document.getElementById('file_preview');
    //Lấy tất cả phần tử con có trong file_preview.
    const el_child = container_box.querySelectorAll('.custom-content__box--img--basic');
    //lấy box đang có ý định xóa
    const parent_box = el.closest('.custom-content__box--img--basic');
    //Chưa hoàn thiện xử lý sau
    if (el_child.length == 1) {
        parent_box.innerHTML = `
        <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary"
            onclick="action_input(this)">
            <input type="file" hidden name="pro_img__main[]" class="input_file"
                onchange="handle_img__change(this)">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                alt="">
            <p class="m-0 fs-12 show_count_img">Thêm hình ảnh(1/5)</p>
        </div>`;
    } else {
        container_box.removeChild(parent_box);
    }
    updated_count();
};
//Hàm cập nhật lại số lượng khi thêm ảnh mới 
const updated_count = () => {
    const box_items = $('.custom-content__box--img--basic');
    if (box_items.length > 0) {
        const count = box_items.length - 1;
        document.querySelectorAll('.show_count_img').forEach((el) => {
            el.innerHTML = `Thêm hình ảnh(${count}/5)`;
        });
    }
};

//Hàm thêm phân loại mới 
const add_select__2 = () => {
    $.ajax({
        url: `get_attri_val_select_2`,
        type: 'GET',
        success: (data) => {
            show_add_select(2);
            $('#show-select__2').addClass('bg-light');
            $('#show-select__2').html(data);
            //Gắn sự kiện handle lại vào dữ liệu mới thêm
            handle_select_group();
        },
        error: () => {
            console.log("Đã có lỗi xảy ra!");
        }
    })
}
//Hàm xóa phân loại mới
const del_select__2 = () => {
    $('#show-select__2').html('');
    $('#show-select__2').removeClass('bg-light');
    show_add_select(1);
    check_stock();
}
const handle_select_change = (el_select, container_group) => {
    const current_options = container_group.querySelectorAll(".option-select");
    const last_options = current_options[current_options.length - 1];
    if (el_select === last_options) {
        add_new_select(container_group);
    }
    check_stock();
}

const add_new_select = (container_group) => {
    const template = container_group.querySelector('.select-template:last-of-type');
    if (template) {
        const new_div = template.cloneNode(true);
        container_group.appendChild(new_div);
    }
};

const del_ops = (node, container_group) => {
    const parent = node.parentNode;
    const el_ops = container_group.querySelectorAll('.col-6');
    if (parent) {
        if (el_ops.length > 1) {
            parent.removeChild(node);
        } else {
            messager({
                title: 'Cảnh báo!',
                mess: 'Phải có ít nhất 1 tùy chọn',
                type: 'error'
            });
        }
    } else {
        console.log('');
    }
};

const check_stock = () => {
    const check_show_option1 = document.querySelector('#check_show_option1');
    const check_show_option2 = document.querySelector('#check_show_option2');
    const show_stock_option = document.querySelector('#show_stock_option');
    if (check_show_option1 && check_show_option2) {
        create_two_option_stock(show_stock_option);
    } else {
        create_one_option_stock(show_stock_option);
    }
}
//Khi có 1 phân loại
const create_one_option_stock = (show_stock_option) => {
    const selects = document.querySelectorAll('.option-select');
    show_stock_option.innerHTML = '';

    selects.forEach((select) => {
        if (select.value) {
            const div = document.createElement('div');
            div.classList.add('col-3', 'stock__group');
            div.innerHTML = `
            <label>${select.options[select.selectedIndex].text}: </label>
            <div class="custom-content__input">
                <input type="number" class="form-control pro__quantity" value="1" name="pro_stock[]" placeholder="Nhập số lượng...">
            </div>`;
            show_stock_option.appendChild(div);
        }
    });
};
//Khi có 2 phân loại
const create_two_option_stock = (show_stock_option) => {
    const select1 = document.querySelectorAll('.show_option_select1');
    const select2 = document.querySelectorAll('.show_option_select2');

    // Xóa các input cũ
    show_stock_option.innerHTML = '';

    select1.forEach((option1) => {
        if (option1.value) {
            select2.forEach((option2) => {
                if (option2.value) {
                    const div = document.createElement('div');
                    div.classList.add('col-3', 'stock__group');
                    div.innerHTML = `
                        <label>${option1.options[option1.selectedIndex].text} - ${option2.options[option2.selectedIndex].text}: </label>
                        <div class="custom-content__input">
                            <input type="number" class="form-control pro__quantity" value="1" name="pro_stock[]" placeholder="Nhập số lượng...">
                        </div>
                    `;
                    show_stock_option.appendChild(div);
                }
            });
        }
    });
};
//Viết hàm thêm box hình ảnh theo màu
const add_new_img_cor = (container__img, cor) => {
    // Kiểm tra nếu box ảnh cho màu này đã tồn tại
    // const existingBox = Array.from(container__img.children).find(box =>
    //     box.querySelector('.show_count_img')?.textContent.includes(`Màu ${cor}`)
    // );

    // if (existingBox) {
    //     messager({ title: 'Thông báo', mess: `Box ảnh cho màu ${cor} đã tồn tại`, type: 'info' });
    //     return;
    // }

    if (container__img) {
        const new_box = document.createElement('div');
        new_box.classList.add('custom-content__box--img--basic', 'custom--flex__column');
        new_box.addEventListener('click', () => {
            new_box.querySelector('input').click();
        })
        new_box.innerHTML = ` 
        <p class="m-0 fs-12 text-center" >${cor}</p>
        <input type="file" hidden name="pro_img__cor[]" class="input_file pro__file_cor"
                onchange="handle_img__cor_change(this)">
        <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary w-100">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                alt="">
        </div>`;
        container__img.append(new_box);
    }
};

const handle_add_new_img_cor = (container_group) => {
    const container__img = document.getElementById('file_preview_cor');
    const current_selects = container_group.querySelectorAll(".option-select");
    const type = current_selects[0][1].getAttribute('data-type');
    if (type == 1) {
        container__img.innerHTML = '';
        current_selects.forEach((select) => {
            if (select.value) {
                add_new_img_cor(container__img, select.options[select.selectedIndex].text);
            }
        })
    }
}
//Viết hàm xử lý ảnh theo màu 
const handle_img__cor_change = (input) => {
    const file = input.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            // Tìm phần tử cha chứa input file
            const parent_box = input.closest('.custom-content__box--img--basic');
            if (parent_box) {
                //Tìm phần tử img để gán ảnh vừa chọn
                const img = parent_box.querySelector('img');
                img.classList.add('w-100', 'h-100');
                img.src = e.target.result;
            }
        };
        // Đọc file
        reader.readAsDataURL(file);
    } else {
        input.value = '';
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn file là ảnh', type: 'error' });
    }
};

const handle_select_group = () => {
    const el_select_groups = document.querySelectorAll(".select-group");
    //Bắt sự kiện option khi Chọn để thêm 
    el_select_groups.forEach((ops) => {
        ops.addEventListener('change', (event) => {
            handle_select_change(event.target, ops);
            handle_add_new_img_cor(ops);
        });
    })

    //Bắt sự kiện option khi click để xóa
    el_select_groups.forEach((ops) => {
        ops.addEventListener('click', (event) => {
            if (event.target.closest('.del_option')) {
                const ops_del = event.target.closest('.col-6');
                if (ops_del) {
                    del_ops(ops_del, ops);
                    handle_add_new_img_cor(ops);
                    check_stock();
                }
            }
        })
    })
}
handle_select_group();

//Hàm valida dữ liệu đầu vào
const validation_form_add__pro = () => {
    // Kiểm tra nếu không có input file nào hoặc input đầu tiên không có file
    const pro_img__main = $('.pro_img__main');
    if (!pro_img__main.length || !pro_img__main[0].files.length) {
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn ít nhất 1 ảnh chính!', type: 'error' });
        return false;
    }
    //Kiểm tra tên sản phẩm
    const pro__name = $('#pro__name');
    if (pro__name.val() == '') {
        pro__name.focus();
        messager({ title: 'Lỗi!', mess: 'Vui lòng nhập tên sản phẩm!', type: 'error' });
        return false;
    }
    //Kiểm tra danh mục sản phẩm
    const pro__cate = $('#pro__cate');
    if (pro__cate.val() == '') {
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn danh mục!', type: 'error' });
        return false;
    }
    //Kiểm tra giá sản phẩm
    const pro__price = $('#pro__price');
    if (pro__price.val() == '' || isNaN(pro__price.val()) || pro__price.val() <= 1000) {
        pro__price.focus();
        messager({ title: 'Lỗi!', mess: 'Giá sản phẩm phải là số lớn hơn 1000 và không để trống!', type: 'error' });
        return false;
    }
    //Kiểm tra mức giảm nếu người dùng chọn
    const pro__discount = $('#pro__discount');
    if (pro__discount.val() && (isNaN(pro__discount.val()) || pro__discount.val() < 1 || pro__discount.val() > 99)) {
        pro__discount.focus();
        messager({ title: 'Lỗi!', mess: 'Mức giảm phải là số nguyên từ 1 đến 99!', type: 'error' });
        return false;
    }
    //Kiểm phân loại sản phẩm
    if (!validate_select_inputs('show_option_select1', 'Vui lòng chọn ít nhất 1 tùy chọn phân loại!')) {
        return false;
    }
    //Nếu có phân loại 2 thì kiểm tra
    if ($('.show_option_select2').length > 0 && !validate_select_inputs('show_option_select2', 'Vui lòng chọn ít nhất 1 tùy chọn phân loại 2!')) {
        return false;
    }
    //Kiểm tra số lượng sản phẩm 
    if (!validate_quantities()) {
        return false;
    }

    // Kiểm tra ảnh hoặc file
    const pro__file_cor = $('.pro__file_cor');
    if (pro__file_cor && pro__file_cor.length > 0) {
        let valid = true;
        pro__file_cor.each(function () {
            const files = this.files;
            if (!files || files.length === 0) {
                messager({ title: 'Lỗi!', mess: 'Ảnh theo màu không được để trống!', type: 'error' });
                $(this).click();
                valid = false;
            }
        });
        if (!valid) {
            return false;
        }
    }
    return true;
};
const validate_select_inputs = (class_el, mess) => {
    const el_selects = $(`.${class_el}`);
    const has_selected_val = Array.from(el_selects).some(select => select.value.trim() !== "");
    if (!has_selected_val) {
        messager({ title: 'Lỗi!', mess: mess, type: 'error' });
        return false;
    }
    return true;
};
const validate_quantities = () => {
    const el = $('.pro__quantity');
    let isValid = true;
    el.each(function () {
        const value = parseInt($(this).val(), 10);
        if (!$(this).val() || isNaN(value) || value <= 0) {
            $(this).focus();
            messager({ title: 'Lỗi!', mess: 'Số lượng phải là số lớn hơn 0 và không được để trống!', type: 'error' });
            isValid = false;
            return false;
        }
    });

    return isValid;
};

const validation_form_edit__pro = () => {
    // Kiểm tra nếu không có input file nào hoặc không có hình ảnh tồn tại
    const pro_img__main = $('.pro_img__main');
    const check_img__main = $('.check_img__main'); // Hidden input chứa hình ảnh đã có

    // Kiểm tra nếu không có ảnh mới được chọn và không có ảnh cũ
    let has_new_img = false;
    pro_img__main.each(function () {
        if (this.files && this.files.length > 0) {
            has_new_img = true;
            return false; // Dừng vòng lặp
        }
    });

    if (!has_new_img && check_img__main.length === 0) {
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn ít nhất 1 ảnh chính!', type: 'error' });
        return false;
    }

    // Kiểm tra tên sản phẩm
    const pro__name = $('#pro__name');
    if (pro__name.val() === '') {
        pro__name.focus();
        messager({ title: 'Lỗi!', mess: 'Vui lòng nhập tên sản phẩm!', type: 'error' });
        return false;
    }

    // Kiểm tra danh mục sản phẩm
    const pro__cate = $('#pro__cate');
    if (pro__cate.val() === '') {
        messager({ title: 'Lỗi!', mess: 'Vui lòng chọn danh mục!', type: 'error' });
        return false;
    }

    // Kiểm tra giá sản phẩm
    const pro__price = $('#pro__price');
    if (pro__price.val() === '' || isNaN(pro__price.val()) || pro__price.val() <= 1000) {
        pro__price.focus();
        messager({ title: 'Lỗi!', mess: 'Giá sản phẩm phải là số lớn hơn 1000 và không để trống!', type: 'error' });
        return false;
    }

    // Kiểm tra mức giảm nếu người dùng chọn
    const pro__discount = $('#pro__discount');
    if (pro__discount.val() && (isNaN(pro__discount.val()) || pro__discount.val() < 0 || pro__discount.val() > 99)) {
        pro__discount.focus();
        messager({ title: 'Lỗi!', mess: 'Mức giảm phải là số nguyên từ 1 đến 99!', type: 'error' });
        return false;
    }

    // Kiểm phân loại sản phẩm
    if (!validate_select_inputs('show_option_select1', 'Vui lòng chọn ít nhất 1 tùy chọn phân loại!')) {
        return false;
    }

    // Nếu có phân loại 2 thì kiểm tra
    if ($('.show_option_select2').length > 0 && !validate_select_inputs('show_option_select2', 'Vui lòng chọn ít nhất 1 tùy chọn phân loại 2!')) {
        return false;
    }

    // Kiểm tra số lượng sản phẩm 
    if (!validate_quantities()) {
        return false;
    }

    // Kiểm tra ảnh theo màu sắc
    const pro__file_cor = $('.pro__file_cor');
    const pro__file_cor_olds = $('.check_img__cor');
    if (pro__file_cor_olds.length == 0) {
        if (pro__file_cor && pro__file_cor.length > 0) {
            let valid = true;
            pro__file_cor.each(function () {
                const files = this.files;
                if (!files || files.length === 0) {
                    messager({ title: 'Lỗi!', mess: 'Ảnh theo màu không được để trống!', type: 'error' });
                    valid = false;
                }
            });
            if (!valid) {
                return false;
            }
        }
    }
    return true;
};


