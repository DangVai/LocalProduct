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


document.addEventListener("DOMContentLoaded", function() {
    const priceElement = document.getElementById("product-price");
    const decreaseBtn = document.getElementById("decrease");
    const increaseBtn = document.getElementById("increase");
    const quantityInput = document.querySelector(".quantity");
    const totalPriceElement = document.getElementById("total-price");
    const shippingPriceElement = document.getElementById("shipping-price");
    const hiddenTotalPrice = document.getElementById("hidden-total-price");
    const maxQuantity = parseInt(document.getElementById("max-quantity").value, 10); // Số lượng tồn kho

    let basePrice = parseFloat(
        priceElement.textContent.replace('.', '').replace(',', '.').replace('$', '').trim()
    );

    // Hàm kiểm tra và cập nhật số lượng
    function checkAndUpdateQuantity(quantity) {
        if (quantity < 1) {
            quantityInput.value = 1;
            return 1;
        } else if (quantity > maxQuantity) {
            alert(`Only ${maxQuantity} items are available in stock.`);
            quantityInput.value = maxQuantity;
            return maxQuantity;
        }
        return quantity;
    }

    // Hàm cập nhật giá trị
    function updatePrice() {
        let quantity = parseInt(quantityInput.value, 10);
        quantity = checkAndUpdateQuantity(quantity); // Kiểm tra số lượng

        const shippingPrice = 5;
        const adjustedBasePrice = basePrice * quantity;
        const totalPrice = adjustedBasePrice + shippingPrice;

        priceElement.textContent = `${adjustedBasePrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`;
        shippingPriceElement.textContent = `Phí ship: ${shippingPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`;
        totalPriceElement.textContent = `${totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} $`;
        hiddenTotalPrice.value = totalPrice.toFixed(2);
    }

    decreaseBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value, 10);
        quantity = checkAndUpdateQuantity(quantity - 1); // Kiểm tra số lượng
        quantityInput.value = quantity;
        updatePrice();
    });

    increaseBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value, 10);
        quantity = checkAndUpdateQuantity(quantity + 1); // Kiểm tra số lượng
        quantityInput.value = quantity;
        updatePrice();
    });

    quantityInput.addEventListener("input", () => {
        let quantity = parseInt(quantityInput.value, 10) || 1;
        quantity = checkAndUpdateQuantity(quantity); // Kiểm tra số lượng
        quantityInput.value = quantity;
        updatePrice();
    });

    updatePrice();
});




function addToCart() {
    const size = document.getElementById('size-selector') ? .value || null;

    // Kiểm tra nếu size chưa được chọn hoặc là chuỗi rỗng
    if (!size || size === '') {
        alert('Please select a size before adding the product to the cart.');
        return; // Dừng hàm nếu chưa chọn size
    }

    const quantity = parseInt(document.querySelector('.quantity') ? .value) || null;

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

    fetch('index.php?controller=product&action=addtocart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId, product_id: productId, size, quantity }),
        })
        .then(res => res.json())
        .then(({ success, message }) => {
            if (success) {
                alert('Product added to cart successfully!');
            } else {
                alert(message);
            }
        })
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