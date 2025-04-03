<div class="custom-admin__content">
    <div class="custom-content__title">
        <h3>Quản Lý Danh Mục</h3>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="custom-content_add-cate p-2">
                <h2 class="fs-20">Thêm danh mục</h2>
                <form action="<?=_WEB_ROOT_?>/admin/category/handle_new" method="post" onsubmit="return valid_add_cate()"
                class="mt-3" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="fs-15" for="name_cate">Tên danh mục <span class="star">*</span></label>
                        <input type="text" class="form-control fs-15" id="name_cate" name="name_cate">
                    </div>                                                                  
                    <div class="mb-3">  
                        <label class="fs-15" for="parent_id">Danh mục cha</label>
                        <select class="form-select fs-15" id="parent_id" name="parent_id">  
                            <option value="0">None</option>
                            <?php foreach($data_cate_parent as $cate):?>
                            <option value="<?php echo $cate['id']?>"><?=$cate['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fs-15" for="img_cate">Hình ảnh</label>
                        <div onclick="action_input(this)"
                            class="custom-content__box--img--basic custom--flex__column">
                            <p class="m-0 fs-12 text-center">Chọn ảnh</p>
                            <input type="file" hidden name="img_cate" class="input_file" onchange="handle_img__cor_change(this)">
                            <div class="d-flex flex-column align-items-center justify-content-center text-center custom-text-primary w-100">
                                <img src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png" class="w-50 h-50" alt="hinh-anh">
                            </div>
                        </div>
                    </div>
                    <button class="custom-btn custom-btn__primary" name="submit_cate" type="submit">Thêm</button>
                </form>
            </div>
        </div>
        <?php if(!empty($data_cate_all)): ?>
        <div class="col-8">
            <div class="custom-content__show p-3">
                <div class="custom-content__show--top">
                    <p><?=$total_cate['total']?> danh mục</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <form method="GET">
                            <input type="hidden" name="page" value="1">
                            <input type="text" name="keyword" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : '';?>" placeholder="Tìm kiếm...">
                            <button type="submit"><i class="ph ph-magnifying-glass"></i></button>
                        </form>
                        <!-- <div class="category-filter__page">
                            <span class="category-filter__page-num">
                                <span class="category-filter__page-current">2</span>/4</span>

                            <div class="category-filter__page-control">
                                Prev Next
                            </div>
                        </div> -->
                    </div>
                </div>
                <form action="<?= _WEB_ROOT_ ?>/admin/category/handle_del_groups" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn xóa danh sách danh mục!')">
                    <div class="custom-content__show--main">
                        <div class="custom-content__show--main--top bg-light">
                            <div class="row ">
                                <div class="col-1">
                                    <div class="text-center">
                                        <input class="custom-table__check--all " id="check_all" type="checkbox">
                                    </div>
                                </div>
                                <div class="col-11">
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="m-0">Ảnh</p>
                                        </div>
                                        <div class="col-5 p-0">
                                            <p class="m-0 ">Tên</p>
                                        </div>
                                        <div class="col-3">
                                            <p class="m-0 text-center">Thao tác</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Item cate-->
                         <?php foreach($data_cate_all as $cate):  ?>
                            <div class="custom-table__item ">
                                <div class="row align-items-center my-4 g-0">
                                    <!-- Checkbox Column -->
                                    <div class="col-1 ">
                                        <div class="text-center" style="text-align: middle;">
                                            <input type="checkbox" value="<?=$cate['id']?>" name="cate_del_groups[]"
                                                class="custom-table__check check-item" type="checkbox">
                                        </div>
                                    </div>
                                    <!-- Cate chirld -->
                                    <div class="col-11">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-lg-4 col-12">
                                                <div class="col-lg-3 col-sm-2 col-3">
                                                    <?php if($cate['url_image'] == null):?>
                                                        <img style="width: 50px; height: 50px; object-fit: cover;"
                                                        src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png" alt="">
                                                    <?php else: ?>
                                                        <img style="width: 60px; height: 60px; object-fit: cover;"
                                                        src="<?= _WEB_ROOT_ ?>/public/assets/img/cate/<?=$cate['url_image']?>" alt="<?=$cate['name']?>">
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-3">
                                                <p class="m-0 fs-12 fw-bold"><?=$cate['name']?></p>
                                            </div>
                                            <div class="col-lg-3 col-2 ">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="get_cate_by_cate_id(this)"
                                                    data-id="<?=$cate['id']?>" data-bs-toggle="modal" data-bs-target="#myModalEdit">
                                                        <i class="ph ph-pen"></i>
                                                    </button>
                                                    <a href="<?= _WEB_ROOT_ ?>/admin/category/handle-del-<?=$cate['id']?>"
                                                        style="width: 50px;" data-bs-toggle="tooltip" title="Xóa!"
                                                        onclick="return confirm('Bạn có chắc muốn xóa danh mục này!')"
                                                        class="btn btn-outline-danger btn-sm "><i
                                                            class="ph ph-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php if(!empty($cate['children'])): ?>
                                <?php foreach($cate['children'] as $cate_children): ?>
                                    <div class="custom-table__item ">
                                        <div class="row align-items-center my-4 g-0">
                                            <!-- Checkbox Column -->
                                            <div class="col-1">
                                                <div class="text-center" style="text-align: middle;">
                                                    <input type="checkbox" value="<?=$cate_children['id']?>" name="cate_del_groups[]"
                                                        class="custom-table__check check-item" type="checkbox">
                                                </div>
                                            </div>
                                            <!-- Cate chirld -->
                                            <div class="col-11">
                                                <div class="row align-items-center g-0">
                                                    <div class="col-lg-4 col-12">
                                                        <div class="col-lg-3 col-sm-2 col-3">
                                                            <?php if($cate_children['url_image'] == null):?>
                                                                <img style="width: 50px; height: 50px; object-fit: cover;"
                                                                src="https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png" alt="">
                                                            <?php else: ?>
                                                                <img style="width: 60px; height: 60px; object-fit: cover;"
                                                                src="<?= _WEB_ROOT_ ?>/public/assets/img/cate/<?=$cate_children['url_image']?>" alt="<?=$cate_children['name']?>">
                                                            <?php endif ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-3">
                                                        <p class="m-0"><i class="fs-20 ph ph-minus"></i> <?=$cate_children['name']?></p>
                                                    </div>
                                                    <div class="col-lg-3 col-2 ">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="get_cate_by_cate_id(this)"
                                                            data-id="<?=$cate_children['id']?>" data-bs-toggle="modal" data-bs-target="#myModalEdit">
                                                                <i class="ph ph-pen"></i>
                                                            </button>
                                                            <a href="<?= _WEB_ROOT_ ?>/admin/category/handle-del-<?=$cate_children['id']?>"
                                                                style="width: 50px;" data-bs-toggle="tooltip" title="Xóa!"
                                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này!')"
                                                                class="btn btn-outline-danger btn-sm "><i
                                                                    class="ph ph-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr> 
                                <?php endforeach ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        <ul class="pagination">
                        <?php if (isset($links))
                        echo $links; ?>
                        </ul>
                        <!-- End item cate -->
                        <div class="custom-content__button bg-light p-4 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-center d-flex align-items-center gap-2">
                                        <input class="custom-table__check--all check-all" id="check_all"
                                            type="checkbox">
                                        <label class="fs-17 cursor-pointer" for="check_all">Tất cả</label>
                                    </div>
                                </div>
                                <button type="submit" name="submit_del_groups" style="width: 50px;"
                                    class="btn btn-outline-danger btn-sm "><i class="ph ph-trash"></i></button>
                            </div>
                        </div>
                
                    </div> 
                </form>
            </div>
        </div>
        <?php else: ?>
         <div class="d-flex align-items-center justify-content-center mt-5">
            <p class="alert alert-warning w-100 text-center">Hiện tại không có danh mục nào!</h3>
        </div>    
        <?php endif; ?>
    </div> 
</div>
<!-- The Modal -->
<div class="modal" id="myModalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title fs-6 fw-bold">Chỉnh Sửa Danh Mục</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?=_WEB_ROOT_?>/admin/category/handle_edit" method="post" onsubmit="return valid_edit_cate()" class="mt-3" enctype="multipart/form-data">
                <!-- Modal body -->
                <div class="modal-body" id="show_edit_cate"></div>
                <!-- Modal footer -->
                <div class="modal-footer">  
                    <button type="submit" name="submit_edit" class="custom-btn custom-btn__primary">Cập Nhật</button>
                </div>
            </form>
        </div>
  </div>
</div>