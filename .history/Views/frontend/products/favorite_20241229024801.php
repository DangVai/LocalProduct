<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/food.css">
</head>

<body>
    <div class="container">
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <h1>SẢN PHẨM YÊU THÍCH</h1>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <button class="remove-favorite-btn" data-favorite-id="<?= $product['favorite_id'] ?>">
                            <i class="fas fa-heart text-danger"></i>
                        </button>
                        <a href="index.php?controller=product&action=detail&id=<?= $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?= htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm" class="product-image" width="150">
                        </a>

                        <div class="detail">
                            <h3 class="product-name"><?= htmlspecialchars($product['product_name']); ?></h3>
                            <p class="product-price">Giá: <?= number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Bạn chưa thêm sản phẩm nào vào mục yêu thích! <br>
                    <a href="index.php?controller=home&action=home">Khám phá ngay các sản phẩm khác!</a>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.remove-favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                const favoriteId = this.dataset.favoriteId;

                fetch('index.php?controller=favorite&action=removeFavorite', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            favorite_id: favoriteId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            location.reload();
                        }
                    });
            });
        });
    </script>
</body>

</html>