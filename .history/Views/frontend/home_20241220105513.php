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
            height: 600px;
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
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            position: relative;
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            width: 300px;
            height: 250px;
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

        .gach {
            width: 3px;
            border-radius: 5px;
            background-color: #060606;
            height: 200px;
            margin-bottom: 20px
        }

        /* products */
        h1 {
            text-align: center;
            color: #333;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 250px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s ease-in-out;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-item h2 {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
            text-align: center;
        }

        .product-item p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .product-item .price {
            font-size: 16px;
            font-weight: bold;
            color: #e63946;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }

        .actions button,
        .actions a {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .actions button:hover,
        .actions a:hover {
            background-color: #0056b3;
        }

        .favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #e63946;
            cursor: pointer;
        }

        /*END product*/
    </style>
</head>

<body>
    <div class="container-Home">
        <?php include 'header.php'; ?> <!-- Nhúng Header -->
        <!-- Chữ chạy -->
        <div class=" text-run ">
            <span>Chào mừng bạn đến với cửa hàng thời trang Vân Kiều và Pa Cô! Khám phá các sản phẩm đặc sắc ngay hôm nay!</span>
        </div>

        <!-- Banner -->
        <div class="banner ">
            <img src="/public/images/Vân Kiều - Pa Cô.png " alt="Banner ">
        </div>

        <!-- Các mục hình ảnh -->
        <div class="img-sliders ">
            <!-- Slider 1 -->
            <div class="slider-container ">
                <div class="slides " id="slider1 ">
                    <img src="/public/images/R.jpg " class="slide " alt="Slide 1 ">
                    <img src="/public/images/slide2.jpg " class="slide " alt="Slide 2 ">
                    <img src="/public/images/slide3.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>

            <!-- Slider 2 -->
            <div class="slider-container ">
                <div class="slides " id="slider2 ">
                    <img src="/public/images/slide3.jpg " class="slide " alt="Slide 1 ">
                    <img src="/public/images/R.jpg " class="slide " alt="Slide 2 ">
                    <img src="/public/images/slide2.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>

            <!-- Slider 3 -->
            <div class="slider-container ">
                <div class="slides " id="slider3 ">
                    <img src="/public/images/slide2.jpg " class="slide " alt="Slide 1 ">
                    <img src="/public/images/slide3.jpg " class="slide " alt="Slide 2 ">
                    <img src="/public/images/R.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>
        </div>
        <!-- Phần Featured Products -->
        <div class="product-list">
            <?php if (!empty($featuredProducts)) : ?>
                <h1>Sản phẩm nổi bật</h1>
                <?php foreach ($featuredProducts as $product) : ?>
                    <div class="product-item">
                        <!-- Biểu tượng yêu thích -->
                        <a href="/toggleFavorite/<?= $product['product_id'] ?>" class="favorite">
                            <?= $product['is_favorite'] ? '♥' : '♡' ?>
                        </a>

                        <!-- Hình ảnh sản phẩm -->
                        <?php if (!empty($product['image_url'])) : ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else : ?>
                            <img src="default-image.jpg"
                                alt="Hình ảnh mặc định">
                        <?php endif; ?>

                        <!-- Tên sản phẩm -->
                        <h2><?= htmlspecialchars($product['name']) ?></h2>

                        <!-- Danh mục -->
                        <p>Danh mục: <?= htmlspecialchars($product['category']) ?></p>

                        <!-- Số lượng -->
                        <p>Số lượng: <?= htmlspecialchars($product['quantity']) ?></p>

                        <!-- Giá sản phẩm -->
                        <p class="price"><?= number_format($product['price'], 0) ?> VNĐ</p>

                        <!-- Nút hành động -->
                        <div class="actions">
                            <a href="/addToCart/<?= $product['product_id'] ?>" class="button">Thêm Giỏ Hàng</a>
                            <a href="/product/<?= $product['product_id'] ?>" class="button">Chi Tiết</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
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