<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Cập Nhật Sản Phẩm</h3>
    </div>
    <?php if (isset($data_pro_id)) : extract($data_pro_id); ?>
        <form class="custom-content__show p-3" action="<?= _WEB_ROOT_ ?>/admin/product/handle_edit" method="POST"
            enctype="multipart/form-data" onsubmit="return validation_form_edit__pro()">
            <div class="custom-content__show--main">
                <div class="custom-content__show--main--top bg-light">
                    <h4 class="m-0 fs-6 fw-normal">Cập Nhật Sản Phẩm</h4>
                </div>
                <!-- Thông tin cơ bản -->
                <div class="custom-content__show-basic p-3">
                    <h5 class="fs-6 fw-bold mb-3">Thông tin cơ bản</h5>
                    <div class="row g-3">
                        <div class="col-2">
                            <p class="fs-15">Hình ảnh sản phẩm <span class="star">*</span></p>
                        </div>
                        <div class="col-10">
                            <div class="container-custom-content__box--img--basic" id="file_preview">
                                <?php if (!empty($data_img_main_pro_id)): ?>
                                    <?php foreach ($data_img_main_pro_id as $img_main): extract($img_main) ?>
                                        <div class="custom-content__box--img--basic">
                                            <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary"
                                                onclick="action_input(this)">
                                                <input type="file" hidden name="pro_img__main[]" class="input_file pro_img__main"
                                                    onchange="handle_img__change(this)">
                                                <input type="hidden" class="check_img__main" name="check_img__mains[]" value="<?= $id ?>">
                                                <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $url_image ?>"
                                                    alt="<?= $url_image ?>" class="w-100 h-100">
                                            </div>
                                            <div onclick="del_img(this)" class="custom-content__img-del"><i class="ph ph-x-circle"></i></div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                                <div class="custom-content__box--img--basic">
                                    <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary"
                                        onclick="action_input(this)">
                                        <input type="file" hidden name="pro_img__main[]" class="input_file pro_img__main"
                                            onchange="handle_img__change(this)">
                                        <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                                            alt="">
                                        <p class="m-0 fs-12 show_count_img">Thêm hình ảnh(<?= count($data_img_main_pro_id) ?>/5)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <p class="fs-15">Tên sản phẩm <span class="star">*</span></p>
                        </div>
                        <div class="col-10">
                            <div class="custom-content__input">
                                <input type="text" name="pro__name" id="pro__name" value="<?= $name ?>" placeholder="Tên sản phẩm...">
                            </div>
                        </div>
                        <div class="col-2">
                            <p class="fs-15">Ngành hàng <span class="star">*</span></p>
                        </div>
                        <div class="col-10">
                            <div class="custom-content__input--cate" data-bs-toggle="modal" data-bs-target="#myModalSelectCate">
                                <div class="custom-content__input--cate___item">
                                    <span id="title_cate"><?= $data_cate_by_id['parent_name'] ?> > <?= $data_cate_by_id['chirld_name'] ?></span>
                                    <div class="icon__edit">
                                        <i class="ph ph-pen"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-2">
                            <p class="fs-15">Mô tả sản phẩm <span class="star">*</span></p>
                        </div>
                        <div class="col-10">
                            <div class="custom-content__input--description">
                                <textarea name="pro__description" id="description__pro" rows="10" cols="80"><?= $description ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thông tin bán hàng -->
                <div class="custom-content__show-store p-3">
                    <h5 class="fs-6 fw-bold mb-3">Thông tin bán hàng</h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="fs-15 m-0">Giá sản phẩm <span class="star">*</span></p>
                            <div class="custom-content__input">
                                <input type="text" name="pro__price" id="pro__price" value="<?= $price ?>" placeholder="Giá bán...">
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="fs-15 m-0">Mức giảm <span class="star">*</span></p>
                            <div class="custom-content__input">
                                <input type="text" name="pro__discount" id="pro__discount" value="<?= $discount_percent ?>" placeholder="Giảm giá...">
                            </div>
                        </div>
                    </div>
                    <!-- Nếu có cả màu và size -->
                    <?php if (isset($data_variant_cor_and_size)): ?>
                        <div class="row g-2 my-3">
                            <div class="col-2">
                                <p class="fs-15 m-0">Phân loại hàng <span class="star">*</span></p>
                            </div>
                            <div class="col-10">
                                <div class="bg-light p-3">
                                    <div class="row g-2 container__option">
                                        <div class="col-2">
                                            <p class="fs-15">Phân loại 1</p>
                                        </div>
                                        <div class="col-10">
                                            <select class="custom-form__select w-50 main-select" id="check_show_option1"
                                                onchange="change_attri_select(this)">
                                                <?php foreach ($data_attri as $attri): ?>
                                                    <option data-main-option="<?= $attri['name'] ?>" value="<?= $attri['id'] ?>">
                                                        <?= $attri['name'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <p class="fs-15">Tùy chọn</p>
                                        </div>
                                        <div class="col-10">
                                            <div class="row g-2 select-group">
                                                <!-- Dữ liệu có sẳn nếu có màu và size -->
                                                <?php if (!empty($data_variant_cor_and_size)) : ?>
                                                    <?php foreach ($data_variant_cor_and_size as $cor): ?>
                                                        <div class="col-6 select-template">
                                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                                <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                                    name="pro_one_option[]">
                                                                    <option value="">Chọn</option>
                                                                    <?php foreach ($data_attri_val_by_attri_cor as $attri_val): ?>
                                                                        <option <?= $cor['cor_id'] == $attri_val['id'] ? 'selected' : ''; ?> data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                                <div class="text-secondary del_option" style="cursor: pointer;">
                                                                    <i class="ph ph-trash-simple"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                                <!-- Dữ liệu hiện mặt định -->
                                                <div class="col-6 select-template">
                                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                                        <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                            name="pro_one_option[]">
                                                            <option value="">Chọn</option>
                                                            <?php if (!empty($data_attri_val_by_attri_cor)): ?>
                                                                <?php foreach ($data_attri_val_by_attri_cor as $attri_val): ?>
                                                                    <option data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                        <div class="text-secondary del_option" style="cursor: pointer;">
                                                            <i class="ph ph-trash-simple"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 bg-light p-3 show" id="btn_add_attri">
                                    <div class="custom-add__variant" onclick="add_select__2()">
                                        <i class="ph ph-plus"></i>
                                        <p class="m-0 fs-15">Thêm phân loại hàng</p>
                                    </div>
                                </div>
                                <!-- Phân loại 2 -->
                                <?php if (!empty($data_size_by_cor_id)) : ?>
                                    <div class="p-3 mt-2 bg-light" id="show-select__2">
                                        <div class="row g-2 container__option">
                                            <div class="col-2">
                                                <p class="fs-15">Phân loại 2</p>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <select class="custom-form__select w-50 main-select" id="check_show_option2">
                                                        <option value="2">Size</option>
                                                    </select>
                                                    <button type="button" onclick="del_select__2()" class="btn text-secondary fs-5"><i class="fa-solid fa-delete-left"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <p class="fs-15">Tùy chọn</p>
                                            </div>
                                            <div class="col-10">
                                                <div class="row g-2 select-group">
                                                    <?php foreach ($data_size_by_cor_id as $size): ?>
                                                        <div class="col-6 select-template">
                                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                                <select name="pro_two_option[]" class="custom-form__select w-100 option-select show_select show_option_select2">
                                                                    <option value="">Chọn</option>';
                                                                    <?php foreach ($data_attri_val_by_attri_size as $attri_val): ?>
                                                                        <option <?= $size['size_id'] == $attri_val['id'] ? 'selected' : ''; ?> value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                                <div class="text-secondary del_option" style="cursor: pointer;">
                                                                    <i class="ph ph-trash-simple"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                    <div class="col-6 select-template">
                                                        <div class="d-flex align-items-center justify-content-between gap-1">
                                                            <select name="pro_two_option[]" class="custom-form__select w-100 option-select show_select show_option_select2">
                                                                <option value="">Chọn</option>';
                                                                <?php foreach ($data_attri_val_by_attri_size as $attri_val): ?>
                                                                    <option value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                            <div class="text-secondary del_option" style="cursor: pointer;">
                                                                <i class="ph ph-trash-simple"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- Nếu chỉ có màu -->
                    <?php if (isset($data_variant_cor)): ?>
                        <div class="row g-2 my-3">
                            <div class="col-2">
                                <p class="fs-15 m-0">Phân loại hàng <span class="star">*</span></p>
                            </div>
                            <div class="col-10">
                                <div class="bg-light p-3">
                                    <div class="row g-2 container__option">
                                        <div class="col-2">
                                            <p class="fs-15">Phân loại 1</p>
                                        </div>
                                        <div class="col-10">
                                            <select class="custom-form__select w-50 main-select" id="check_show_option1"
                                                onchange="change_attri_select(this)">
                                                <?php foreach ($data_attri as $attri): ?>
                                                    <option data-main-option="<?= $attri['name'] ?>" value="<?= $attri['id'] ?>">
                                                        <?= $attri['name'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <p class="fs-15">Tùy chọn</p>
                                        </div>
                                        <div class="col-10">
                                            <div class="row g-2 select-group">
                                                <!-- Dữ liệu có sẳn nếu chỉ có màu -->
                                                <?php if (!empty($data_variant_cor)) : ?>
                                                    <?php foreach ($data_variant_cor as $cor): ?>
                                                        <div class="col-6 select-template">
                                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                                <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                                    name="pro_one_option[]">
                                                                    <option value="">Chọn</option>
                                                                    <?php foreach ($data_attri_val_by_attri_cor as $attri_val): ?>
                                                                        <option <?= $cor['cor_id'] == $attri_val['id'] ? 'selected' : ''; ?> data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                                <div class="text-secondary del_option" style="cursor: pointer;">
                                                                    <i class="ph ph-trash-simple"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                                <!-- Dữ liệu hiện mặt định -->
                                                <div class="col-6 select-template">
                                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                                        <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                            name="pro_one_option[]">
                                                            <option value="">Chọn</option>
                                                            <?php if (!empty($data_attri_val_by_attri_cor)): ?>
                                                                <?php foreach ($data_attri_val_by_attri_cor as $attri_val): ?>
                                                                    <option data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                        <div class="text-secondary del_option" style="cursor: pointer;">
                                                            <i class="ph ph-trash-simple"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 bg-light p-3" id="btn_add_attri">
                                    <div class="custom-add__variant" onclick="add_select__2()">
                                        <i class="ph ph-plus"></i>
                                        <p class="m-0 fs-15">Thêm phân loại hàng</p>
                                    </div>
                                </div>
                                <!-- Phân loại 2 -->
                                <div class="p-3 mt-2" id="show-select__2"></div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- Nếu chỉ có size -->
                    <?php if (isset($data_variant_size)): ?>
                        <div class="row g-2 my-3">
                            <div class="col-2">
                                <p class="fs-15 m-0">Phân loại hàng <span class="star">*</span></p>
                            </div>
                            <div class="col-10">
                                <div class="bg-light p-3">
                                    <div class="row g-2 container__option">
                                        <div class="col-2">
                                            <p class="fs-15">Phân loại 1</p>
                                        </div>
                                        <div class="col-10">
                                            <select class="custom-form__select w-50 main-select" id="check_show_option1"
                                                onchange="change_attri_select(this)">
                                                <?php foreach ($data_attri as $attri): ?>
                                                    <option <?= $attri['id'] == 2 ? "selected" : '' ?> data-main-option="<?= $attri['name'] ?>" value="<?= $attri['id'] ?>">
                                                        <?= $attri['name'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <p class="fs-15">Tùy chọn</p>
                                        </div>
                                        <div class="col-10">
                                            <div class="row g-2 select-group">
                                                <!-- Dữ liệu có sẳn nếu chỉ có size -->
                                                <?php if (!empty($data_variant_size)) : ?>
                                                    <?php foreach ($data_variant_size as $size): ?>
                                                        <div class="col-6 select-template">
                                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                                <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                                    name="pro_one_option[]">
                                                                    <option value="">Chọn</option>
                                                                    <?php foreach ($data_attri_val_by_attri_size as $attri_val): ?>
                                                                        <option <?= $size['size_id'] == $attri_val['id'] ? 'selected' : ''; ?> data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                                <div class="text-secondary del_option" style="cursor: pointer;">
                                                                    <i class="ph ph-trash-simple"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                                <!-- Dữ liệu hiện mặt định -->
                                                <div class="col-6 select-template">
                                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                                        <select class="custom-form__select w-100 option-select show_select show_option_select1"
                                                            name="pro_one_option[]">
                                                            <option value="">Chọn</option>
                                                            <?php if (!empty($data_attri_val_by_attri_size)): ?>
                                                                <?php foreach ($data_attri_val_by_attri_size as $attri_val): ?>
                                                                    <option data-type="<?= $attri_val['id'] ?>" value="<?= $attri_val['id'] ?>"><?= $attri_val['name'] ?></option>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                        <div class="text-secondary del_option" style="cursor: pointer;">
                                                            <i class="ph ph-trash-simple"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 bg-light p-3 show d-none" id="btn_add_attri">
                                    <div class="custom-add__variant" onclick="add_select__2()">
                                        <i class="ph ph-plus"></i>
                                        <p class="m-0 fs-15">Thêm phân loại hàng</p>
                                    </div>
                                </div>
                                <!-- Phân loại 2 -->
                                <div class="p-3 mt-2" id="show-select__2"></div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- Phân loại hàng -->
                    <?php if (!empty($data_variant_pro_id)): ?>
                        <div class="row g-2 my-3">
                            <div class="col-2">
                                <p class="fs-15 m-0">Kho hàng <span class="star">*</span></p>
                            </div>
                            <div class="col-10">
                                <div class="bg-light p-3">
                                    <h3 class="fs-15 fw-normal">Số lượng phân loại:</h3>
                                    <div class="row" id="show_stock_option">
                                        <!-- Số lượng -->
                                        <?php foreach ($data_variant_pro_id as $pro_variant): ?>
                                            <div class="col-3 stock__group">
                                                <label><?= $pro_variant['cor_name'] ?> <?= $pro_variant['size_name'] ?>: </label>
                                                <div class="custom-content__input">
                                                    <input type="number" class="form-control pro__quantity" value="<?= $pro_variant['quantity'] ?>" name="pro_stock[]" placeholder="Nhập số lượng...">
                                                </div>
                                            </div>
                                            <input type="hidden" name="check_variant_olds[]" value="<?= $pro_variant['id'] ?>">
                                            <input type="hidden" name="check_variant_img_olds[]" value="<?= $pro_variant['url_image'] ?>">
                                        <?php endforeach ?>
                                    </div>
                                    <!-- Hình ảnh màu sắc -->
                                    <div class="d-flex align-item-center mt-3 gap-2" id="file_preview_cor">
                                        <?php if (isset($data_variant_cor_and_size)): ?>
                                            <?php foreach ($data_variant_cor_and_size as $cor_img): ?>
                                                <div onclick="action_input(this)"
                                                    class="custom-content__box--img--basic custom--flex__column">
                                                    <p class="m-0 fs-12 text-center"><?= $cor_img['name'] ?></p>
                                                    <input type="file" hidden name="pro_img__cor[]" class="input_file pro__file_cor" onchange="handle_img__cor_change(this)">
                                                    <input type="hidden" class="check_img__cor">
                                                    <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary w-100">
                                                        <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cor_img['url_image'] ?>" class="w-100 h-100" alt="<?= $cor_img['url_image'] ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php if (isset($data_variant_cor)): ?>
                                            <?php foreach ($data_variant_cor as $cor_img): ?>
                                                <div onclick="action_input(this)"
                                                    class="custom-content__box--img--basic custom--flex__column">
                                                    <p class="m-0 fs-12 text-center"><?= $cor_img['name'] ?></p>
                                                    <input type="file" hidden name="pro_img__cor[]" class="input_file pro__file_cor" onchange="handle_img__cor_change(this)">
                                                    <input type="hidden" class="check_img__cor">
                                                    <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary w-100">
                                                        <img src="<?= _WEB_ROOT_ ?>/public/assets/img/pro/<?= $cor_img['url_image'] ?>" class="w-100 h-100" alt="<?= $cor_img['url_image'] ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <input type="hidden" name="pro__cate" id="pro__cate" value="<?= $cate_id ?>">
                <input type="hidden" name="pro__id" value="<?= $data_pro_id['id'] ?>">
                <div class="bg-light p-4 mt-3 custom-content__footer">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a onclick="confirm_with_alert(event, 'Xác nhận?', 'Bạn có chắc muốn hủy thay đổi!', 'info', 'Có, tôi đồng ý!', 'confirm_cancel', 'click')"
                        href="<?= _WEB_ROOT_ ?>/admin/san-pham" id="confirm_cancel" class="custom-btn custom-btn__normal">Hủy</a>
                        <button class="custom-btn custom-btn__normal" value="1" name="submit__pro" type="submit">Cập Nhật & Ẩn</button>
                        <button class="custom-btn custom-btn__primary" value="0" name="submit__pro" type="submit">Cập Nhật & Hiển Thị</button>
                    </div>
                </div>
            </div>
        </form>
    <?php endif ?>
</div>
<!-- The Modal Select Cate -->
<div class="modal" id="myModalSelectCate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title fs-6">Chọn Nghành Hàng</h4>
                <button type="button" class="btn-close fs-15" data-bs-dismiss="modal"></button>
            </div>
            <?php if (!empty($data_cate_parent)): ?>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-content__select--cate">
                        <div class="row">
                            <div class="col-6">
                                <div class="custom-content__cate ">
                                    <ul class="container__cate">
                                        <?php foreach ($data_cate_parent as $__cate_parent): ?>
                                            <li class="<?= $__cate_parent['id'] == $data_cate_by_id['parent_id'] ? 'custom-cate__active' : '' ?>"
                                                onclick="get_cate_chirld_by_parent(this, '<?= $__cate_parent['id'] ?>', '<?= $__cate_parent['name'] ?>')">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <?= $__cate_parent['name'] ?>
                                                    <i class="ph ph-caret-right"></i>
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-content__cate ">
                                    <ul id="show_cate_chirld" class="container__sub_cate">
                                        <?php foreach ($data_cate_by_parent as $__cate_chirld): ?>
                                            <li class="<?= $__cate_chirld['id'] == $data_cate_by_id['chirld_id'] ? 'custom-cate__active' : '' ?>"
                                                onclick="action_cate_chirld(this, '<?= $__cate_chirld['id'] ?>', '<?= $__cate_chirld['name'] ?>')">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <?= $__cate_chirld['name'] ?>
                                                    <i class="ph ph-caret-right"></i>
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <!-- Modal footer -->
            <div class="d-flex align-items-center justify-content-between p-3 border-top">
                <p class="m-0 fs-15 fw-light" id="show_option_cate">Đã chọn:
                    <span class="fw-bold" id="cate"><?= $data_cate_by_id['parent_name'] ?></span>
                    <span class="fw-bold" id="sub_cate"> > <?= $data_cate_by_id['chirld_name'] ?></span>
                </p>
                <div>
                    <button type="button" class="custom-btn custom-btn__normal"
                        data-bs-dismiss="modal">Hủy</button>
                    <button onclick="confirm_cate()" type="button" data-bs-dismiss="modal"
                        class="custom-btn custom-btn__primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    ClassicEditor
        .create(document.querySelector('#description__pro'));
</script>