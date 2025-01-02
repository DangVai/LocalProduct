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
        <!-- Phần Featured Products -->
        <div class="product-list">
            <?php if (isset($featuredProducts) && !empty($featuredProducts)) : ?>
                <h1>Sản phẩm nổi bật</h1>
                <?php foreach ($featuredProducts as $product) : ?>
                    <div class="product-item">
                        <!-- Nút yêu thích -->
                        <button class="favourite-btn" type="button" onclick="addToFavorite(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-heart"></i>
                        </button>

                        <!-- Ảnh sản phẩm -->
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>"
                                alt="Hình sản phẩm" class="product-image" width="150">
                        </a>
                        <div class="detail">
                            <!-- Tên sản phẩm -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>

                            <!-- Giá sản phẩm -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            </a>

                            <!-- Giỏ hàng -->
                            <a href="#" class="cart-home">
                                <i class="bi bi-cart-plus"></i> <!-- Icon giỏ hàng Bootstrap -->
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
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
    <script src="/LocalProduct/public/js/home.js"></script>
</body>

</html>