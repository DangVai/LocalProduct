<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/LocalProduct/public/css/home.css">
</head>

<body>
    <div class="container-Home">
        <!-- Featured Products Section -->
        <div class="product-list">
            <?php if (isset($featuredProducts) && !empty($featuredProducts)) : ?>
                <h1>Featured Products</h1>
                <?php foreach ($featuredProducts as $product) : ?>
                    <div class="product-item">
                        <!-- Favourite Button -->
                        <button class="favourite-btn" type="button" onclick="addToFavorite(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-heart"></i>
                        </button>

                        <!-- Product Image -->
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>"
                                alt="Product Image" class="product-image" width="150">
                        </a>
                        <div class="detail">
                            <!-- Product Name -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>

                            <!-- Product Price -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Price: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <p>No products to display.</p>
            <?php endif; ?>
        </div>

        <!-- end featured -->

        <div class="categories ">
            <div class="page ">
                <p>National Costume</p>
                <div class="slider ">
                    <div class="images ">
                        <img src="/LocalProduct/public/images/slide2.jpg " alt="Costume 1 ">
                    </div>
                </div>
                <button class="explore-btn "><a href="# ">Explore now</a></button>
            </div>
            <div class="page ">
                <p>Cuisine</p>
                <div class="slider ">
                    <div class="images ">
                        <img src="/LocalProduct/public/images/slide2.jpg " alt="Cuisine 1 ">
                    </div>
                </div>
                <button class="explore-btn "><a href="# ">Explore now</a></button>
            </div>
            <div class="page ">
                <p>Other Products</p>
                <div class="slider ">
                    <div class="images ">
                        <img src="/LocalProduct/public/images/slide2.jpg " alt="Other 1 ">
                    </div>
                </div>
                <button class="explore-btn "><a href="# ">Explore now</a></button>
            </div>
        </div>
        <div class="introduce ">
            <div class="vk ">
                <img src="/LocalProduct/public/images/Chị Huyền.jpg " alt="Vân Kiều People " class="vkimg ">
                <div class="gach "></div>
                <div class="vk-text ">
                    <h3>Vân Kiều People</h3>
                    <p>Traditional Costume: The traditional attire of the Vân Kiều people is usually made from handwoven fabric with intricate patterns. Men typically wear loincloths and short shirts, while women wear long skirts and tight-fitting tops with elaborate embroidery. The dominant colors of their attire are red, black, and white, symbolizing strength and their connection with nature. Cuisine: Popular dishes include rice cooked in bamboo, grilled meat, and “rượu cần” (a traditional wine), typically made from natural ingredients such as sticky rice and wild meat.</p>
                </div>
            </div>
            <div class="pc ">
                <div class="pc-text ">
                    <h3>Pa Cô People</h3>
                    <p>Traditional Costume: The attire of the Pa Cô people is also unique, often handwoven with geometric patterns that reflect their connection with nature and daily life. Pa Cô women wear a lot of jewelry, such as necklaces and bracelets, creating a traditional beauty. Cuisine: The Pa Cô people enjoy grilled dishes, combined with wild vegetables and fruits gathered from nature. “Rượu cần” is also an essential drink during festive occasions.</p>
                </div>
                <div class="gach "></div>
                <img src="/LocalProduct/public/images/khánh Huyền.jpg " alt="Pa Cô People " class="pcimg ">
            </div>
        </div>

    </div>
    <script src="/LocalProduct/public/js/home.js"></script>
</body>

</html>