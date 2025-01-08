<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/search_results.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="product-container">
        <h1 class="product-title">
            Search Results
        </h1>

        <div class="product-list">
            <?php if (!empty($products)): ?>

                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <button class="favourite-btn" data-product-id="<?= $product['product_id']; ?>">
                            <i class="fas fa-heart"></i>
                        </button>
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>"
                                alt="Product Image" class="product-image" width="150">
                        </a>
                        <div class="detail">
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Price: <?php echo number_format($product['price'], 0, ',', '.'); ?> $</p>
                            </a>
                            <a href="#" class="cart-home">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No products to display.</p>
            <?php endif; ?>
        </div>
        <script src="/LocalProduct/public/js/addtocart.js"></script>
        <script src="/LocalProduct/public/js/fashion.js"></script>
</body>

</html>