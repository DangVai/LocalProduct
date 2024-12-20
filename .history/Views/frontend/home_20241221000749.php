<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/home.css">
</head>

<body>
    <div class="container-Home">

        <!-- Chữ chạy -->
        <div class=" text-run ">
            <span>Chào mừng bạn đến với cửa hàng thời trang Vân Kiều và Pa Cô! Khám phá các sản phẩm đặc sắc ngay hôm nay!</span>
        </div>

        <!-- Banner -->
        <div class="banner ">
            <img src="/LocalProduct/public/images/Vân Kiều - Pa Cô.png " alt="Banner ">
        </div>

        <!-- Các mục hình ảnh -->
        <div class="img-sliders ">
            <!-- Slider 1 -->
            <div class="slider-container ">
                <div class="slides " id="slider1 ">
                    <img src="/LocalProduct/public/images/R.jpg " class="slide " alt="Slide 1 ">
                    <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 2 ">
                    <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>

            <!-- Slider 2 -->
            <div class="slider-container ">
                <div class="slides " id="slider2 ">
                    <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 1 ">
                    <img src="/LocalProduct/public/images/R.jpg " class="slide " alt="Slide 2 ">
                    <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>

            <!-- Slider 3 -->
            <div class="slider-container ">
                <div class="slides " id="slider3 ">
                    <img src="/LocalProduct/public/images/slide2.jpg " class="slide " alt="Slide 1 ">
                    <img src="/LocalProduct/public/images/slide3.jpg " class="slide " alt="Slide 2 ">
                    <img src="/LocalProduct/public/images/R.jpg " class="slide " alt="Slide 3 ">
                </div>
            </div>
        </div>
        <!-- Phần Featured Products -->
        <div class="product-list">
            <?php if (!empty($featuredProducts)) : ?>
                <h1>Sản phẩm nổi bật</h1>
                <?php foreach ($featuredProducts as $product) : ?>
                    <div class="product-item">
                        <h2><?= htmlspecialchars($product['name']) ?></h2>
                        <p class="price"><?= number_format($product['price'], 0) ?> VNĐ</p>
                        <img src="<?= htmlspecialchars($product['image_url']) ?: 'default-image.jpg' ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
        </div>

        <!-- end featured -->
    </div>
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
            <img src="/LocalProduct/public/images/Chị Huyền.jpg " alt="Người Vân Kiều " class="vkimg ">
            <div class="gach "></div>
            <div class="vk-text ">
                <h3>Người Vân Kiều</h3>
                <p>Trang phục truyền thống: Trang phục của người Vân Kiều thường được làm từ vải dệt thủ công với hoa văn tinh tế. Đàn ông thường mặc khố và áo cộc, còn phụ nữ mặc váy dài và áo bó sát người, thêu hoa văn cầu kỳ. Màu sắc chủ đạo của trang
                    phục thường là đỏ, đen, và trắng, tượng trưng cho sức mạnh và sự gắn kết với thiên nhiên. Ẩm thực: Các món ăn phổ biến bao gồm cơm lam, thịt nướng và rượu cần, thường được làm từ nguyên liệu tự nhiên như gạo nếp, thịt rừng..
                </p>
            </div>
        </div>
        <div class="pc ">
            <div class="pc-text ">
                <h3>Người Pa Cô</h3>
                <p>Trang phục truyền thống: Trang phục của người Pa Cô cũng rất độc đáo, thường được dệt tay với các hoa văn hình học, thể hiện sự kết nối với thiên nhiên và đời sống sinh hoạt hàng ngày. Phụ nữ Pa Cô đeo nhiều trang sức như vòng cổ,
                    vòng tay, tạo nên vẻ đẹp truyền thống. Ẩm thực: Người Pa Cô yêu thích các món nướng, kết hợp cùng rau rừng và các loại củ, quả hái lượm. Rượu cần cũng là một thức uống không thể thiếu trong các dịp lễ hội.</p>
            </div>
            <div class="gach "></div>
            <img src="/LocalProduct/public/images/khánh Huyền.jpg " alt="Người Pa Cô " class="pcimg ">
        </div>
    </div>
    </div>
    <script src="/LocalProduct">

    </script>
</body>

</html>