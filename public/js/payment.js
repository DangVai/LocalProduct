
document.querySelector(".cod-btn").addEventListener("click", function () {
    var codRadio = document.querySelector('input[name="payment_method"][value="cod"]');

    // Kiểm tra nếu radio button 'COD' chưa được chọn
    if (!codRadio.checked) {
        // Đánh dấu radio button 'COD' là checked
        codRadio.checked = true;

        // Ẩn nút Momo
        document.querySelector(".momo-btn").style.display = "none";

        // Thay đổi màu sắc của nút COD
        document.querySelector(".cod-btn").style.backgroundColor = "#4CAF50"; // Màu xanh ví dụ
        document.querySelector(".cod-btn").style.color = "white";
    }
    else {
        // Bỏ chọn radio button 'COD'
        codRadio.checked = false;

        // Hiển thị lại nút Momo
        document.querySelector(".momo-btn").style.display = "inline-block"; // Hoặc "block" tùy vào bố cục

        // Đổi lại màu của nút COD về mặc định
        document.querySelector(".cod-btn").style.backgroundColor = ""; // Màu mặc định
        document.querySelector(".cod-btn").style.color = ""; // Màu chữ mặc định
    }
});

// Xử lý nút "Thanh toán qua Momo"
document.querySelector(".momo-btn").addEventListener("click", function () {
    // Kiểm tra nếu radio button 'Momo' chưa được chọn, chọn nó và chuyển hướng
    var momoRadio = document.querySelector('input[name="payment_method"][value="momo"]');
    if (!momoRadio.checked) {
        momoRadio.checked = true;
    }

    // Chuyển hướng đến trang khác (ví dụ: trang Momo)
    window.location.href = "index.php?controller=checkout&action=onlinePayment"; // Thay đổi URL theo nhu cầu
});
