<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Thêm Sản Phẩm</h3>
    </div>
    <form class="custom-content__show p-3" action="<?= _WEB_ROOT_ ?>/admin/product/handle_new" method="POST"
        enctype="multipart/form-data" onsubmit="return validation_form_add__pro()">
        <div class="custom-content__show--main">
            <div class="custom-content__show--main--top bg-light">
                <h4 class="m-0 fs-6 fw-normal">Thêm 1 Sản Phẩm Mới</h4>
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
                            <div class="custom-content__box--img--basic">
                                <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary"
                                    onclick="action_input(this)">
                                    <input type="file" hidden name="pro_img__main[]" class="input_file pro_img__main"
                                        onchange="handle_img__change(this)">
                                    <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png"
                                        alt="">
                                    <p class="m-0 fs-12">Thêm hình ảnh(0/5)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <p class="fs-15">Tên sản phẩm <span class="star">*</span></p>
                    </div>
                    <div class="col-10">
                        <div class="custom-content__input">
                            <input type="text" name="pro__name" id="pro__name" placeholder="Tên sản phẩm...">
                        </div>
                    </div>
                    <div class="col-2">
                        <p class="fs-15">Ngành hàng <span class="star">*</span></p>
                    </div>
                    <div class="col-10">
                        <div class="custom-content__input--cate" data-bs-toggle="modal" data-bs-target="#myModalSelectCate">
                            <div class="custom-content__input--cate___item">
                                <span id="title_cate">Chọn ngành hàng</span>
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
                            <textarea name="pro__description" id="description__pro" rows="10" cols="80"></textarea>
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
                            <input type="text" name="pro__price" id="pro__price" placeholder="Giá bán...">
                        </div>
                    </div>
                    <div class="col-6">
                        <p class="fs-15 m-0">Mức giảm <span class="star">*</span></p>
                        <div class="custom-content__input">
                            <input type="text" name="pro__discount" id="pro__discount" placeholder="Giảm giá...">
                        </div>
                    </div>
                </div>
                <?php if (!empty($data_attri)): ?>
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
                            <div class="p-3 mt-2" id="show-select__2"></div>
                        </div>
                    </div>
                <?php endif ?>
                <div class="row g-2 my-3">
                    <div class="col-2">
                        <p class="fs-15 m-0">Kho hàng <span class="star">*</span></p>
                    </div>
                    <div class="col-10">
                        <div class="bg-light p-3">
                            <h3 class="fs-15 fw-normal">Số lượng phân loại:</h3>
                            <div class="row" id="show_stock_option"></div>
                            <!-- Hình ảnh màu sắc -->
                            <div class="d-flex align-item-center mt-3 gap-2" id="file_preview_cor"></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="pro__cate" id="pro__cate" value="">
            <div class="bg-light p-4 mt-3 custom-content__footer">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a  onclick="confirm_with_alert(event, 'Xác nhận?', 'Bạn có chắc muốn hủy thêm sản phẩm!', 'info', 'Có, tôi đồng ý!', 'confirm_cancel', 'click')"
                    href="<?=_WEB_ROOT_?>/admin/san-pham" id="confirm_cancel" class="custom-btn custom-btn__normal">Hủy</a>
                    <button class="custom-btn custom-btn__normal" value="1" name="submit__pro"  type="submit">Lưu & Ẩn</button>
                    <button class="custom-btn custom-btn__primary" value="0" name="submit__pro" type="submit">Lưu & Hiển Thị</button>
                </div>
            </div>
        </div>
    </form>
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
                                            <li
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
                                    <ul id="show_cate_chirld" class="container__sub_cate"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <!-- Modal footer -->
            <div class="d-flex align-items-center justify-content-between p-3 border-top">
                <p class="m-0 fs-15 fw-light" id="show_option_cate">Đã chọn: <span class="fw-bold"
                        id="cate"></span><span class="fw-bold" id="sub_cate">Chưa chọn ngành hàng</span></p>
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