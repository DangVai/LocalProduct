// Xử lý nút "Thanh toán qua COD"
document.querySelector(".cod-btn").addEventListener("click", function () {
    var codRadio = document.querySelector('input[name="payment_method"][value="cod"]');
    var momoRadio = document.querySelector('input[name="payment_method"][value="momo"]');

    // Kiểm tra nếu radio button 'COD' chưa được chọn
    if (!codRadio.checked) {
        // Đánh dấu radio button 'COD' là checked
        codRadio.checked = true;

        // Bỏ chọn radio button 'Momo'
        momoRadio.checked = false;

        // Thay đổi màu sắc của nút COD
        document.querySelector(".cod-btn").style.backgroundColor = "#4CAF50"; // Màu xanh ví dụ
        document.querySelector(".cod-btn").style.color = "white";

        // Ẩn nút Momo
        document.querySelector(".momo-btn").style.display = "none";
    } else {
        // Bỏ chọn radio button 'COD'
        codRadio.checked = false;

        // Đổi lại màu của nút COD về mặc định
        document.querySelector(".cod-btn").style.backgroundColor = ""; // Màu mặc định
        document.querySelector(".cod-btn").style.color = ""; // Màu chữ mặc định

        // Hiển thị lại nút Momo
        document.querySelector(".momo-btn").style.display = "inline-block"; // Hoặc "block" tùy vào bố cục
    }
});

// Xử lý nút "Thanh toán qua Momo"
document.querySelector(".momo-btn").addEventListener("click", function () {
    var momoRadio = document.querySelector('input[name="payment_method"][value="momo"]');
    var codRadio = document.querySelector('input[name="payment_method"][value="cod"]');

    // Kiểm tra nếu radio button 'Momo' chưa được chọn
    if (!momoRadio.checked) {
        // Đánh dấu radio button 'Momo' là checked
        momoRadio.checked = true;

        // Bỏ chọn radio button 'COD'
        codRadio.checked = false;

        // Đổi lại màu của nút Momo
        document.querySelector(".momo-btn").style.backgroundColor = "#4CAF50"; // Màu xanh ví dụ
        document.querySelector(".momo-btn").style.color = "white";

        // Ẩn nút COD
        document.querySelector(".cod-btn").style.display = "none";
    } else {
        // Bỏ chọn radio button 'Momo'
        momoRadio.checked = false;

        // Đổi lại màu của nút Momo về mặc định
        document.querySelector(".momo-btn").style.backgroundColor = ""; // Màu mặc định
        document.querySelector(".momo-btn").style.color = ""; // Màu chữ mặc định

        // Hiển thị lại nút COD
        document.querySelector(".cod-btn").style.display = "inline-block"; // Hoặc "block" tùy vào bố cục
    }
});
