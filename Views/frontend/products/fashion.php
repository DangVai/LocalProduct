<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/fashion.css"> <!-- Liên kết với file CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body>
    <div class="container">
        <div class="filter-container">
            <h3>Filer sản phẩm</h3>
            <form id="filter-form">
                <label for="price">Lọc theo giá:</label>
                <select name="price" id="price">
                    <option value="">Chọn khoảng giá</option>
                    <option value="0-500000">Dưới 500.000 VNĐ</option>
                    <option value="500000-1000000">500.000 - 1.000.000 VNĐ</option>
                    <option value="1000000-1500000">1.000.000 - 1.500.000 VNĐ</option>
                </select>

                <label for="type">Lọc theo loại:</label>
                <select name="type" id="type">
                    <option value="">Chọn loại</option>
                    <option value="Vân Kiều">Vân Kiều</option>
                    <option value="Pa Cô">Pa Cô</option>
                </select>

                <label for="keyword">Tìm theo tên:</label>
                <input type="text" name="keyword" id="keyword" placeholder="Nhập từ khóa (áo, xấn)" />

                <button type="button" id="apply-filter">Lọc</button>
            </form>

        </div>

        <!-- Phần danh sách sản phẩm -->
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <h1>THỜI TRANG</h1>
                <?php foreach ($products as $product): ?>
                    <div class="product-item" data-price="<?= $product['price'] ?>" data-type="<?= htmlspecialchars($product['type']) ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>">
                        <button class="favourite-btn" data-product-id="<?= $product['product_id']; ?>">
                            <i class="fas fa-heart"></i>
                        </button>
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm" class="product-image" width="150">
                        </a>
                        <div class="detail">
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            </a>
                            <button class="add-to-cart btn btn-default" id="add-to-cart-btn" type="button" onclick="addToCart('add')">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- <script src="/LocalProduct/public/js/fashion.js"></script> -->
    <script>
        const buttons = document.querySelectorAll('.favourite-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const productId = this.dataset.productId;
                console.log("Product ID:", productId);

                try {
                    const response = await fetch('index.php?controller=favorite&action=addFavorite', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        }),
                    });

                    // Đảm bảo rằng phản hồi không phải HTML
                    if (response.ok) {
                        const responseText = await response.text(); // Chuyển đổi phản hồi thành văn bản
                        console.log("Response Text:", responseText); // In nội dung phản hồi ra console

                        // Kiểm tra nếu phản hồi trả về JSON
                        let data;
                        try {
                            data = JSON.parse(responseText);
                            console.log("Response Data:", data);
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Đã xảy ra lỗi, vui lòng thử lại!',
                            });
                            return;
                        }

                        // Cập nhật giao diện
                        const heartIcon = this.querySelector('i');
                        if (data.is_favorite) {
                            heartIcon.classList.add('text-danger'); // Thêm màu đỏ nếu đã yêu thích
                        } else {
                            heartIcon.classList.remove('text-danger'); // Xóa màu đỏ nếu không còn yêu thích
                        }

                        // Hiển thị thông báo với SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else {
                        throw new Error('Error: ' + response.status);
                    }

                } catch (error) {
                    console.error("Fetch error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi, vui lòng thử lại!',
                    });
                }
            });
        });
    </script>
</body>

</html>