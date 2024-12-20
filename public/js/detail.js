
// Xử lý nút "Thanh toán khi nhận hàng"
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




// Lấy tất cả các ảnh thumbnail
const thumbnails = document.querySelectorAll('.preview-thumbnail li a img');
// Lấy ảnh chính
const mainImage = document.querySelector('.preview-pic .tab-pane img');

// Lặp qua từng thumbnail và thêm sự kiện click
thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener('click', (event) => {
        event.preventDefault(); // Ngăn chặn hành động mặc định (nếu cần)

        // Thay đổi src của ảnh chính thành src của thumbnail
        mainImage.src = thumbnail.src;
    });
});





document.addEventListener("DOMContentLoaded", function () {
    const priceElement = document.getElementById("product-price"); // Phần tử chứa giá gốc
    const decreaseBtn = document.getElementById("decrease"); // Nút giảm số lượng
    const increaseBtn = document.getElementById("increase"); // Nút tăng số lượng
    const quantityInput = document.querySelector(".quantity"); // Ô nhập số lượng
    const totalPriceElement = document.getElementById('total-price'); // Phần tử hiển thị tổng giá
    const shippingPriceElement = document.getElementById('shipping-price'); // Phần tử hiển thị phí ship
    const hiddenTotalPrice = document.getElementById('hidden-total-price'); // Trường ẩn
    // Lấy giá gốc từ phần tử HTML
    let basePrice = parseFloat(
        priceElement.textContent.replace('.', '').replace(',', '.').replace('$', '').trim()
    );

    // Hàm cập nhật giá
    function updatePrice() {
        const quantity = parseInt(quantityInput.value, 10) || 1; // Đảm bảo số lượng >= 1
        if (quantity < 1) {
            quantityInput.value = 1;
            return;
        }

        const shippingPrice = 5 * quantity; // Phí ship cố định (5$ cho mỗi sản phẩm)
        const adjustedBasePrice = basePrice * quantity; // Tính giá gốc theo số lượng
        const totalPrice = adjustedBasePrice + shippingPrice; // Tổng giá (bao gồm phí ship)

        // Cập nhật giá hiển thị trên giao diện
        priceElement.textContent = `${adjustedBasePrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`;

        shippingPriceElement.textContent = `Phí ship: ${shippingPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`; // Phí ship
        totalPriceElement.textContent = `${totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`; // Tổng giá
        hiddenTotalPrice.value = totalPrice.toFixed(2); // Chỉ gửi số
    }

    // Sự kiện giảm số lượng
    decreaseBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value, 10);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
            updatePrice();
        }
    });

    // Sự kiện tăng số lượng
    increaseBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value, 10);
        quantityInput.value = quantity + 1;
        updatePrice();
    });

    // Sự kiện khi người dùng nhập số lượng trực tiếp
    quantityInput.addEventListener("input", () => {
        if (quantityInput.value < 1) {
            quantityInput.value = 1;
        }
        updatePrice();
    });

    // Khởi tạo giá trị ban đầu
    updatePrice();
});



function addToCart() {
    if (!userId || userId === 'null') {
        const userChoice = confirm('You need to log in to add products to the cart. Do you want to log in now?');
        if (userChoice) {
            // Người dùng chọn "OK" -> chuyển hướng đến trang đăng nhập
            window.location.href = 'index.php?controller=user&action=login';
        } else {
            // Người dùng chọn "Cancel" -> không làm gì
            console.log('User chose not to log in.');
        }
        return; // Dừng hàm nếu chưa đăng nhập
    }
    const size = document.getElementById('size-selector')?.value || null;
    const quantity = parseInt(document.querySelector('.quantity')?.value) || null;

    fetch('index.php?controller=product&action=addtocart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, product_id: productId, size, quantity }),
    })
        .then(res => res.json())
        .then(({ success, message }) => alert(message))
        .catch(err => console.error('Error:', err));
}
// document.querySelector("form").addEventListener("submit", function (event) {
//     const fullName = document.getElementById("fullName").value.trim();
//     const phone = document.getElementById("phone").value.trim();
//     const location = document.getElementById("location").value.trim();
//     const specificAddress = document.getElementById("specificAddress").value.trim();

//     const errorMessage = document.getElementById("error-message"); // Phần tử hiển thị thông báo lỗi

//     // Xóa thông báo lỗi cũ (nếu có)
//     errorMessage.textContent = "";

//     // Kiểm tra nếu tên đầy đủ rỗng
//     if (fullName === "") {
//         errorMessage.textContent = "Full Name is required.";
//         event.preventDefault(); // Ngăn chặn form gửi
//         return;
//     }

//     // Kiểm tra nếu số điện thoại không hợp lệ
//     const phoneRegex = /^\d{10}$/;
//     if (!phoneRegex.test(phone)) {
//         errorMessage.textContent = "Please enter a valid 10-digit phone number.";
//         event.preventDefault();
//         return;
//     }

//     // Kiểm tra nếu location quá ngắn
//     if (location.length < 40) {
//         errorMessage.textContent = "Location must be at least 40 characters long.";
//         event.preventDefault();
//         return;
//     }

//     // Kiểm tra nếu địa chỉ cụ thể quá ngắn
//     if (specificAddress.length < 40) {
//         errorMessage.textContent = "Specific Address must be at least 40 characters long.";
//         event.preventDefault();
//         return;
//     }
// });
