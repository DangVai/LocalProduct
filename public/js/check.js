
function validateForm() {
    const sizeSelector = document.getElementById('size-selector');
    const errorMessage = document.getElementById('error-message');

    // Kiểm tra nếu chưa chọn size
    if (sizeSelector.value === "") {
        errorMessage.textContent = "Please select a size before proceeding.";
        return false; // Ngăn không cho thêm vào giỏ hàng
    }
}

let selectedPaymentMethod = null; // Biến lưu phương thức thanh toán

function selectPaymentMethod(method) {
    selectedPaymentMethod = method; // Lưu phương thức thanh toán
    console.log(`Selected payment method: ${method}`);
}
const errorMessage = document.getElementById('error-message');

// Kiểm tra trước khi thanh toán
document.querySelector('.buy-now').addEventListener('click', function (e) {
    if (!selectedPaymentMethod) {
        e.preventDefault(); // Ngăn chặn hành động mặc định
        errorMessage.textContent = "Please select a payment method before proceeding.";
        // alert('Please select a payment method before proceeding.');
    } else {
        // Thực hiện logic thanh toán hoặc gửi form
        console.log(`Proceeding with payment method: ${selectedPaymentMethod}`);
    }
});




// Lắng nghe sự kiện giảm số lượng
document.querySelectorAll('.decrease').forEach(button => {
    button.addEventListener('click', function () {
        let quantityInput = document.querySelector(`.quantity[data-id="${this.dataset.id}"]`);
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
            updatePrice(quantityInput);
        }
    });
});

// Lắng nghe sự kiện tăng số lượng
document.querySelectorAll('.increase').forEach(button => {
    button.addEventListener('click', function () {
        let quantityInput = document.querySelector(`.quantity[data-id="${this.dataset.id}"]`);
        let currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
        updatePrice(quantityInput);
    });
});

// Hàm cập nhật giá khi thay đổi số lượng
function updatePrice(quantityInput) {
    let cartId = quantityInput.dataset.id;  // Sử dụng đúng cart_id từ data-id
    let priceElement = document.querySelector(`#price-${cartId}`);
    let totalPriceElement = document.querySelector(`#total-price-${cartId}`);

    if (!priceElement || !totalPriceElement) {
        console.error(`Price or Total Price element not found for cart ID: ${cartId}`);
        return;
    }

    let priceText = priceElement.textContent.replace('Price:', '').trim();
    let price = parseFloat(priceText.replace('$', ''));

    if (isNaN(price)) {
        console.error(`Invalid price for cart item with ID ${cartId}`);
        return;
    }

    let quantity = parseInt(quantityInput.value);
    let totalPrice = price * quantity;

    // Cập nhật tổng giá sản phẩm
    totalPriceElement.textContent = `Total Price: ${totalPrice.toFixed(2).replace('.', ',')}$`;

    // Cập nhật tổng giá toàn bộ giỏ hàng
    updateTotalPrice();
}

// Hàm tính tổng giá và cập nhật lên giao diện
function updateTotalPrice() {
    let totalPrice = 0;
    let totalQuantity = 0;
    let shippingPrice = 0;

    // Lặp qua tất cả các checkbox đã chọn
    document.querySelectorAll('.select-item:checked').forEach(function (checkbox) {
        const item = checkbox.closest('.cart-item');  // Lấy item chứa checkbox
        const itemPrice = parseFloat(item.dataset.price);  // Lấy giá sản phẩm từ data-price
        const itemQuantity = parseInt(item.querySelector('.quantity').value);  // Lấy số lượng từ input quantity

        totalPrice += itemPrice * itemQuantity;  // Cộng dồn vào tổng giá
        totalQuantity += itemQuantity;  // Cộng dồn vào tổng số lượng sản phẩm
    });

    // Hiển thị tổng giá và phí vận chuyển
    document.getElementById('total-price').textContent = (totalPrice + shippingPrice).toFixed(2);
    document.getElementById('hidden-total-price').value = (totalPrice + shippingPrice).toFixed(2);  // Lưu giá trị vào input ẩn
}

// Lắng nghe sự kiện thay đổi cho các checkbox
document.querySelectorAll('.select-item').forEach(function (checkbox) {
    checkbox.addEventListener('change', updateTotalPrice);
});





document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete-selected');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();  // Ngừng hành động mặc định (submit form)

            const productId = this.getAttribute('data-id');

            // Gửi yêu cầu fetch để xóa sản phẩm
            const formData = new FormData();
            formData.append('delete_item', productId);  // Đảm bảo key là 'delete_item'

            fetch('index.php?controller=cart&action=handleRequest', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    // Kiểm tra mã trạng thái HTTP (status code) trước khi xử lý JSON
                    if (!response.ok) {
                        throw new Error('Server returned an error: ' + response.statusText);
                    }
                    return response.text();  // Nhận phản hồi dưới dạng text
                })
                .then(data => {
                    console.log('Response Text:', data);  // Xem phản hồi thực tế từ server
                    try {
                        const jsonData = JSON.parse(data);  // Thử phân tích JSON
                        console.log('JSON Response:', jsonData);
                        if (jsonData.status === 'success') {
                            // Xóa sản phẩm khỏi giao diện mà không tải lại trang
                            const item = document.querySelector(`#cart-item-${productId}`);
                            if (item) {
                                item.remove();  // Xóa phần tử sản phẩm trong DOM
                            }

                            // Hiển thị thông báo thành công
                            alert(jsonData.message);
                        } else {
                            // Hiển thị thông báo lỗi
                            alert(jsonData.message);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        alert('Server response is not JSON. Raw Response: ' + data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error processing your request.');
                });
        });
    });
});