<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/another.css"> <!-- Link to CSS file -->

</head>

<body>
    <div class="container">
        <div class="filter-container">
            <h3>Product Filter</h3>
            <form id="filter-form">
                <label for="price">Filter by Price:</label>
                <select name="price" id="price">
                    <option value="">Select Price Range</option>
                    <option value="0-500">Under 500$</option>
                    <option value="500-1000">500$ - 1000$</option>
                    <option value="1000000 ->">1000$ -> </option>
                </select>


                <label for="type">Filter by Type:</label>
                <select name="type" id="type">
                    <option value="">Select Type</option>
                    <option value="Vân Kiều">Vân Kiều</option>
                    <option value="Pa Cô">Pa Cô</option>
                </select>

                <label for="keyword">Search by Name:</label>
                <input type="text" name="keyword" id="keyword" placeholder="Enter keyword" />

                <button type="button" id="apply-filter">Filter</button>
            </form>

        </div>

        <!-- Product List Section -->
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <h1>HANDMADE PRODUCTS</h1>
                <?php foreach ($products as $product): ?>
                    <div class="product-item" data-price="<?= $product['price'] ?>" data-type="<?= htmlspecialchars($product['type']) ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>">
                        <button class="favourite-btn" type="button" onclick="addToFavorite(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-heart"></i>
                        </button>
                        <!-- Product Image -->
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="product-image" width="150">
                        </a>

                        <!-- Detailed Information -->
                        <div class="detail">
                            <!-- Product Name -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>

                            <!-- Product Price -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Price: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            </a>

                            <!-- Cart -->
                            <a href="index.php?controller=cart&action=addToCart" class="cart-home">
                                <i class="bi bi-cart-plus"></i> <!-- Bootstrap Cart Icon -->
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p>No products to display.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="/LocalProduct/public/js/fashion.js"></script>

</body>

</html>