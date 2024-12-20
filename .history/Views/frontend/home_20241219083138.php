<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link ref="stylesheet" href="/public/css/home.css">
    <link ref="stylesheet" href="/public/css/header.css">
    <link ref="stylesheet" href="/public/css/footer.css">
    <style>
        .container-Home {
            background-color: white;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner {
            background-color: white;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-run {
            width: 100%;
            overflow: hidden;
            background: rgb(113, 74, 74);
            /* Màu nền */
            white-space: nowrap;
            /* Ngăn chữ xuống dòng */
            box-sizing: border-box;
        }

        .text-run span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 10s linear infinite;
            /* Animation chạy ngang */
            font-size: 15px;
            font-weight: bold;
            color: white;
            /* Màu chữ */
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
                /* Bắt đầu từ đầu */
            }

            100% {
                transform: translateX(-100%);
                /* Chạy hết màn hình */
            }
        }

        .banner .intro {
            position: relative;
            width: 100%;
            height: 100;
            /* Chiều cao banner */
            overflow: hidden;
        }

        .banner .intro .bia img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Hiển thị hình ảnh không bị méo */
        }

        .sliders {
            width: 650px;
            height: 500px;
            overflow: hidden;
            border-radius: 10px;
            position: relative;
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            width: 650px;
            height: 500px;
            object-fit: cover;
            flex-shrink: 0;
        }


        /* Products: */


        /* Phần Sản Phẩm */

        .featured {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .featured h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }


        /* Lưới sản phẩm */

        .selectproduct {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .product-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-title {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .product-price {
            color: #28a745;
            font-weight: bold;
        }

        .product-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-cart,
        .btn-buy {
            background: #f0f0f0;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-cart:hover {
            background: #ffc107;
            color: white;
        }

        .btn-buy:hover {
            background: #28a745;
            color: white;
        }


        /*END product*/
    </style>
</head>

<body>
    <div class="container-Home">
        <?php include 'header.php'; ?> <!-- Nhúng Header -->
        <div class="banner">
            <div class="text-run">
                <span>Chào mừng bạn đến với cửa hàng thời trang Vân Kiều và Pa Cô! Khám phá các sản phẩm đặc sắc ngay hôm nay!</span>
            </div>

            <div class="intro">
                <img src="/public/images/Vân Kiều - Pa Cô.png" alt="Banner" class="bia">
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
                <h3>Người Vân Kiều: thời trang và đồ ăn</h3>
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
    <?php include 'footer.php'; ?> <!-- Nhúng Footer -->
    </div>
    <script src="/public/js/home.js"></script>
</body>

</html>