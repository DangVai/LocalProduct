<?php
// Kiểm tra trạng thái đăng nhập
$isLoggedIn = isset($_SESSION['user']);
?>
<script>
    const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/fashion.css"> <!-- Liên kết với file CSS -->

</head>


<body>
    <div class="container">
        <!-- Phần danh sách sản phẩm -->
        <div class="product-list">
            <?php if (!empty($favorites)): ?>
                <h1>THỜI TRANG</h1>
                <?php foreach ($favorites as $product): ?>
                    <div class="product-item" data-price="<?= $product['price'] ?>" data-type="<?= htmlspecialchars($product['type']) ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>">

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
                            <button class="remove-favorite" data-product-id="<?= $product['product_id'] ?>">Xóa</button>
                        </div>
                    </div>
        </div>

    <?php endforeach; ?>
<?php else : ?>
    <p>Không có sản phẩm nào để hiển thị.</p>
<?php endif; ?>
    </div>
    </div>
    <script>
        document.querySelectorAll('.remove-favorite').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                fetch('/index.php?controller=favorite&action=addFavorite', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                            location.reload();
                        }
                    });
            });
        });


        function showPopup(message) {
            Swal.fire({
                title: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>

</html>