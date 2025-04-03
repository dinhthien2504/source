const show_add_rating = (Dorder_id) => {
    $.ajax({
        url: 'show-add-rating',
        type: 'POST',
        data: {
            Dorder_id: Dorder_id
        },
        success: function (data) {
            if (data) {
                $('#showRate').html(data)
                // Mở modal
                $('#showAddRating').modal('show');
                //Ẩn modal Thông tin đơn hàng
                $('#showOrderModal').modal('hide');
            }
        },
        error: function () {
            alert('Có lỗi xảy ra khi tải thông tin don hang');
        }
    });
}

const updateCountImg = () => {
    const filePreview = document.querySelector("#filePreview");
    const maxImages = 5; // Giới hạn tối đa 5 ảnh
    const countImg = maxImages - (filePreview.children.length);
    //Chọc tới hiển thị số lượng ảnh có thể thêm
    document.querySelector("#remainingImages").innerText = `${countImg}/5 ảnh.`;
}
const addNewImageInput = () => {
    updateCountImg()
    const filePreview = document.querySelector("#filePreview");
    const maxImages = 5; // Giới hạn tối đa 5 ảnh
    if (filePreview.children.length >= maxImages) {
        messager({ title: 'Cảnh báo', mess: 'Giới hạn tối đa 5 ảnh!', type: 'warning' });
        return;
    }
    const div = document.createElement("div");
    div.classList.add("preview-item");

    const input = document.createElement("input");
    input.type = "file";
    input.name = "img[]"; // Gán name là mảng để gửi nhiều file
    input.classList.add("file-input");
    input.hidden = true;

    // Ảnh preview
    const img = document.createElement("img");
    img.src = "https://static.vecteezy.com/system/resources/thumbnails/014/440/983/small_2x/image-icon-design-in-blue-circle-png.png";
    img.alt = "Ảnh mới";
    img.classList.add("image-preview");

    // Nút xóa
    const removeBtn = document.createElement("div");
    removeBtn.classList.add("remove-btn");
    removeBtn.innerText = "X";

    // Xử lý xóa ảnh
    removeBtn.addEventListener("click", () => {
        div.remove();
        updateCountImg()
    });

    // Xử lý khi nhấp vào ảnh để thay đổi file
    img.addEventListener("click", () => {
        input.click();
    });

    // Xử lý thay đổi file
    input.addEventListener("change", function () {
        const file = input.files[0];
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader(); // Thư viện để đọc hình ảnh
            reader.onload = function (e) {
                img.src = e.target.result; // Cập nhật ảnh
                addNewImageInput(); // Thêm một khung mới
            };
            reader.readAsDataURL(file);
        }
    });

    // Gắn các thành phần vào div
    div.appendChild(input);
    div.appendChild(img);
    div.appendChild(removeBtn);
    // Thêm vào container
    filePreview.appendChild(div);
}

//Bắt sự khi nhấn vào thêm ảnh
const btn_create_img_rate = document.getElementById('createImg');
if (btn_create_img_rate) {
    btn_create_img_rate.addEventListener("click", function () {
        addNewImageInput();
    })
}


//Bắt sự kiện khi chọn sao
document.addEventListener("click", function () {
    const stars = document.querySelectorAll("#starRating i");
    const ratingValue = document.getElementById("ratingValue");
    const ratingText = document.getElementById("ratingText");
    const rateTextDeteil = [
        "Rất tệ",
        "Tệ",
        "Bình thường",
        "Tốt",
        "Tuyệt vời"
    ];
    stars.forEach((star, index) => {
        star.addEventListener("click", function () {
            const rating = index + 1;
            ratingValue.value = rating;
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add("selected");
                } else {
                    s.classList.remove("selected");
                }
            });
            ratingText.innerText = rateTextDeteil[rating - 1];
        });
    });
});

const updateRating = (rating) => {
    let url = new URL(window.location.href);
    let urlParams = new URLSearchParams(window.location.search);

    // Nếu rating chưa tồn tại hoặc khác giá trị mới, thì mới cập nhật và reload
    if (urlParams.get("rating") != rating) {
        url.searchParams.set("rating", rating);
        url.searchParams.set("page", 1);
        window.location.href = url.toString();
    }
}

window.onload = function () {
    let urlParams = new URLSearchParams(window.location.search);

    // Nếu đã có rating hoặc page, thì chỉ scroll mà không reload
    if (urlParams.has("rating") || urlParams.has("page")) {
        let reviewSection = document.getElementById("session_rating");
        if (reviewSection) {
            reviewSection.scrollIntoView({ behavior: "smooth" });
        }
    }
};