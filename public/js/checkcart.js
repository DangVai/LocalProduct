document.querySelector('.buy-now').addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chặn hành vi submit mặc định

    // Kiểm tra phương thức thanh toán đã được chọn
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        alert('Please select a payment method!'); // Thông báo nếu người dùng chưa chọn phương thức thanh toán
        return;
    }

    // Nếu phương thức thanh toán là COD, tiếp tục xử lý đơn hàng và lưu vào database
    if (paymentMethod.value === 'cod') {
        // Lấy danh sách các sản phẩm được chọn
        const selectedItems = document.querySelectorAll('.select-item:checked');
        if (selectedItems.length === 0) {
            alert('Please select at least one product!');
            return;
        }

        // Thu thập thông tin người dùng
        const userInfo = {
            full_name: document.querySelector('[name="full_name"]').value.trim(),
            phone: document.querySelector('[name="phone"]').value.trim(),
            location: document.querySelector('[name="location"]').value.trim(),
            specific_address: document.querySelector('[name="specific_address"]').value.trim(),
            total_price: parseFloat(document.getElementById('total-price').textContent), // Lấy tổng giá từ phần tử ẩn
            payment_method: paymentMethod.value // Ghi nhận phương thức thanh toán
        };

        // Kiểm tra thông tin người dùng đã nhập đủ chưa
        if (!userInfo.full_name) {
            alert('Please enter your full name!');
            return;
        }

        if (!userInfo.phone) {
            alert('Please enter your phone number!');
            return;
        }

        if (!userInfo.location) {
            alert('Please select your location!');
            return;
        }

        // Thu thập thông tin các sản phẩm được chọn
        const products = [];
        selectedItems.forEach((item) => {
            const cartItem = item.closest('.cart-item');
            const quantityInput = cartItem.querySelector('.quantity');

            const product = {
                product_id: item.value,
                product_name: cartItem.dataset.name,
                size: cartItem.dataset.size,
                price: parseFloat(cartItem.dataset.price), // Giá đơn vị
                quantity: parseInt(quantityInput.value), // Lấy số lượng người dùng đã thay đổi
                total_price: parseFloat(cartItem.dataset.price) * parseInt(quantityInput.value) // Tính tổng giá
            };
            products.push(product);
        });

        // Gửi dữ liệu qua AJAX (fetch) để lưu vào database ngay khi chọn COD
        fetch('index.php?controller=checkout&action=storeOrders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userInfo, products, totalPrice: userInfo.total_price })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response Data:', data);
                if (data.success) {
                    alert(data.message || 'Order placed successfully!');
                    // Sau khi đơn hàng được lưu thành công, có thể chuyển hướng người dùng
                    window.location.href = 'index.php?controller=home&action=home';
                } else {
                    alert('Failed to place the order!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to place the order!');
            });
    }

    // Nếu phương thức thanh toán là MoMo
    if (paymentMethod.value === 'momo') {
        const totalPrice = parseFloat(document.getElementById('total-price').textContent);

        // Gửi tổng giá vào yêu cầu POST để thực hiện thanh toán qua MoMo
        fetch(window.location.href = 'index.php?controller=checkout&action=onlinePayment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `totalPrice=${totalPrice}`
        })
            .then(response => response.json())
            .then(data => {
                // Xử lý kết quả từ MoMo nếu cần
                if (data.success) {
                    alert('Payment successful!');
                    window.location.href = 'index.php?controller=home&action=home'; // Chuyển hướng sau khi thanh toán thành công
                } else {
                    alert('Payment initiation failed!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});
