<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link ref="stylesheet" href="/public/css/home.css">
<link ref="stylesheet" href="/public/css/header.css"> 
<link ref="stylesheet" href="/public/css/footer.css">  </head>

<body>
    <div class="container-Home">
        <iframe src="header.php" style="width:100%; height:100px; border:none;"></iframe>
        <div class="banner">
            <div class="text-runrun">
                <span>Chào mừng bạn đến với cửa hàng thời trang Vân Kiều và Pa Cô! Khám phá các sản phẩm đặc sắc ngay hôm nay!</span>
            </div>

            <div class="intro">
                <img src="/LocalProduct/public/images/Vân Kiều-Pa Cô.png" alt="Banner" class="bia">
            </div>
            <div class="sliders">
                <img src="/LocalProduct/public/images/R.jpg" class="slide" alt="Slide Clone Last">
                <img src="/LocalProduct/public/images/slide2.jpg" class="slide" alt="Slide 1">
                <img src="/LocalProduct/public/images/slide3.jpg" class="slide" alt="Slide 2">
                <img src="/LocalProduct/public/images/R.jpg" class="slide" alt="Slide Clone First">
            </div>

        </div>
        <!-- Phần Featured Products -->
        <div class="featured">
            <h2>Featured Products</h2>
            <div class="selectproduct">
                <?php
            foreach ($featuredProducts as $index => $product) {
                // Bắt đầu một hàng mới nếu là sản phẩm đầu tiên hoặc sản phẩm thứ 6
                if ($index % 5 == 0) {
                    echo '<div class="product-row">';
                }
                ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="product-image">
                        <h3 class="product-title">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>
                        <p class="product-price">
                            <?php echo number_format($product['price']); ?> VND</p>
                        <div class="product-actions">
                            <button class="btn-cart">&#128722;</button>
                            <button class="btn-buy">&#128717;</button>
                        </div>
                    </div>
                    <?php
                // Kết thúc hàng sau 5 sản phẩm
                if ($index % 5 == 4 || $index == count($featuredProducts) - 1) {
                    echo '</div>'; // Đóng product-row
                }
            }
            ?>
            </div>
        </div>
    </div>
    <div class="introduce">
        <div class="vk">
            <img href="" class="vkimg">
            <div class="gach"></div>
            <div class="vk-text">
                <h3>Người Vân Kiều: thời trang và đồ ănăn</h3>
            </div>
        </div>
        <div class="pc">
            <img href="" class="pcpcimg">
            <div class="gach"></div>
            <div class="pc-text">
                <h3>Người Pa Cô: thời trang và đồ ăn</h3>
            </div>
        </div>
    </div>
    nhúng footer
    <iframe src="footer.php" style="width:100%; height:100px; border:none;"></iframe>
    </div>
    <script src="/public/js/home.js"></script>
</body>

</html>