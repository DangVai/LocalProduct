<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/footer.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container-Home {
            background-color: white;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .text-run {
            width: 100%;
            height: 50px;
            overflow: hidden;
            background: rgb(113, 74, 74);
            white-space: nowrap;
            box-sizing: border-box;
            margin-bottom: 0px;
            margin-top: 200px;
            text-align: center;
        }

        .text-run span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 10s linear infinite;
            font-size: 15px;
            padding-top: 18px;
            font-weight: bold;
            color: white;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .banner {
            position: relative;
            margin-top: 0px;
            width: 100%;
            height: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.5);
        }

        .img-sliders {
            width: 100%;
            height: 250px;
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .slider-container {
            flex: 1;
            overflow: hidden;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            object-fit: cover;
        }

        .header {
            top: 0;
            left: 0;
            display: flex;
            width: 100%;
            height: 200px;
            align-items: center;
            position: fixed;
            z-index: 4;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .box_logo {
            width: 15%;
            display: flex;
            align-items: center;
        }

        .box_logo img {
            position: absolute;
            top: 10px;
            left: 30px;
            width: 170px;
            height: 160px;
            z-index: 10;
        }

        .nav {
            width: 550px;
            height: 30%;
            display: flex;
            margin-right: 150px;
            justify-content: center;
            align-items: center;
            justify-content: space-evenly;
            border-radius: 10px;
            font-size: 20px;
            color: black;
            margin-left: 20px;
            border: 2px solid black;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(252, 245, 245, 0.667);
        }

        .nav a {
            text-decoration: none;
            color: rgb(1, 1, 1);
            font-weight: bold;
        }

        .nav a:hover {
            font-size: 22px;
        }

        /* Search */

        .searchHome {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: 2px black solid;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 20px;
            width: 300px;
        }

        .searchInput {
            flex: 1;
            border: none;
            padding: 5px 10px;
            font-size: 20px;
            outline: none;
        }

        .searchButton {
            border: none;
            background-color: white;
            cursor: pointer;
            height: 40px;
            width: 40px;
        }

        /* Giỏ hàng */

        .cart {
            width: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-left: 20px;
        }

        .box-cart {
            border: 2px solid rgb(6, 6, 6);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
        }

        .box-cart i {
            font-size: 25px;
            color: black;
        }

        .cart-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            font-size: 14px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
        }

        .account {
            width: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box-account {
            border: 2px solid rgb(6, 6, 6);
            width: 55px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .box-account i {
            font-size: 25px;
            color: black;
            cursor: pointer;
        }

        .name-user p {
            margin: 0px 20px 10px 10px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: rgb(234, 216, 216);
            border: 1px solid #070707;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-right: 30px;
            z-index: 5;
        }

        .name-user:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            text-decoration: none;
            color: black;
            display: block;
            padding: 5px 10px;
        }

        .dropdown-menu a:hover {
            background-color: #f0f0f0;
        }

        .categories {
            width: 100%;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 20px;
            background-color: #2b2b2b;
            padding: 20px;
            border-radius: 10px;
        }

        .page {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 30px 10px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .page p {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #6b5925;
        }

        .slider {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .images {
            display: flex;
            overflow: hidden;
            width: 100%;
            gap: 25px;
        }

        .images img {
            width: 100%;
            height: 250px;
            /* margin-left: 0px; */
            object-fit: cover;
            border-radius: 5px;
        }

        button.explore-btn {
            background-color: #6b5925;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button.explore-btn a {
            text-decoration: none;
            color: white;
        }

        button.explore-btn:hover {
            background-color: #52451d;
        }

        button.prev:hover,
        button.next:hover {
            background-color: #52451d;
        }

        /* Giới thiệu : */
        /* Bố cục chính */
        /* Tổng thể bố cục */

        .introduce {
            margin-top: 50px;
            width: 100%;
            display: flex;
            flex-direction: column;
            /* Chia theo chiều dọc */
            gap: 50px;
            /* Khoảng cách giữa các phần */
            padding: 20px;
            margin-bottom: 50px;
        }

        /* Phần chung cho vk và pc */

        .vk,
        .pc {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            width: 100%;
        }

        /* Hình ảnh */

        .pc img {
            width: 500px;
            height: 400px;
            border-radius: 10px;
            border: 2px solid #3e3f40;
            object-fit: cover;
            /* Đảm bảo hình ảnh không bị méo */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 50px
        }

        .vk img {
            width: 400px;
            height: 300px;
            border-radius: 10px;
            border: 2px solid #3e3f40;
            object-fit: cover;
            /* Đảm bảo hình ảnh không bị méo */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 50px;
        }

        /* Gạch dọc */

        .vk .gach,
        .pc .gach {
            width: 3px;
            height: 300px;
            background-color: #070707;
        }

        .vk-text {
            flex: 1;
            padding: 0 10px;
            text-align: left;
            margin-right: 30px
        }

        .pc-text {
            flex: 1;
            padding: 0 10px;
            text-align: right;
            margin-left: 30px;
        }

        .vk-text h3,
        .pc-text h3 {
            font-size: 20px;
            color: #2c3e50;
            margin: 0 0 10px;
        }

        .vk-text p,
        .pc-text p {
            font-size: 20px;
            color: #555;
            line-height: 1.8;
        }

        /* Đảm bảo phần giới thiệu không bị lỗi chiều cao */

        .vk,
        .pc {
            min-height: 400px;
        }

        .top-footer {
            height: 5px;
            width: 100%;
            background-color: rgb(253, 253, 252);
        }

        .footer {
            width: 100%;
            height: 400px;
            background-color: rgb(60, 45, 45);
            color: #fffcfc;
            padding: 20px 0;
            display: flex;
            justify-content: space-around;
        }

        .footer-follow {
            flex: 1;
            margin: 0 15px;
            margin-left: 100px;
        }

        .box_logo {
            width: 20%;
            display: flex;
            align-items: center;
        }

        .box_logo img {
            position: absolute;
            top: 10px;
            left: 30px;
            width: 170px;
            height: 160px;
            z-index: 10;
            margin-right: 100px;
        }

        .footer-aboutus {
            flex: 1;
            width: 100px;
            margin: 0 15px;
        }

        .footer-contact {
            flex: 1;
            margin: 0 100px;
        }

        .footer h3 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .footer p {
            font-size: 25px;
            line-height: 1.6;
        }

        .follow-icons div {
            margin-bottom: 10px;
        }

        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .contact-details div {
            display: flex;
            align-items: center;
        }

        .contact-details i {
            margin-right: 10px;
        }

        .contact-details p {
            margin: 0;
        }

        /* products */

        .product-list {
            width: 100%;
            height: auto;
            margin-top: 100px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 50px
        }

        .product-list h1 {
            margin: 0px 0px 30px 30px;
            text-align: left;
        }

        .product-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 250px;
            height: 350px;
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
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Căn chỉnh phần nội dung sản phẩm */

        .product-item .detail {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }

        .product-name {
            text-align: left;
        }

        .product-price {
            text-align: left;
            margin-top: 5px;
        }

        /* Ẩn gạch dưới của liên kết */

        a {
            text-decoration: none;
        }

        /* Căn chỉnh giỏ hàng nằm phía phải */

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .actions .button {
            background-color: #ccd2d8;
            color: rgb(8, 8, 8);
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .actions .button:hover {
            background-color: #654747;
        }

        .favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #e63946;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-Home">
        <div class="header">
            <!-- Logo -->
            <div class="box_logo">
                <img src="LocalProduct/public/images/logo.jpg" alt="logo">
            </div>

            <!-- Navigation Menu -->
            <div class="nav">
                <a href="?page=home"><b>Home</b></a>
                <a href="?page=fashion"><b>Thời Trang</b></a>
                <a href="?page=food"><b>Ẩm thực</b></a>
                <a href="?page=others"><b>Khác</b></a>
            </div>

            <!-- Search -->
            <div class="searchHome">
                <input type="text" placeholder="Tìm kiếm..." class="searchInput">
                <button class="searchButton">🔍</button>
            </div>
            <div class="cart">
                <div class="box-cart">
                    <i class="fas fa-shopping-cart"></i>

                </div>
            </div>
            <!-- User Account -->
            <div class="account">
                <div class="box-account">
                    <i class="fa-regular fa-user"></i>
                </div>


                <!-- User Name and Dropdown Menu -->
                <div class="name-user">
                    <p>John Doe</p>
                    <div class="dropdown-menu" id="account-menu">
                        <a href="#"><i class="fas fa-user fa-sm"></i> Profile</a>
                        <a href="#"><i class="fas fa-cogs fa-sm"></i> Settings</a>
                        <a href="#"><i class="fas fa-sign-in-alt fa-sm"></i> Log in</a>
                        <a href="#"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a>
                    </div>
                </div>
            </div>
        </div>

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
    <div class=" footer ">
        <!-- Follow Us -->

        <div class="footer-follow ">
            <!-- Logo -->
            <!-- <div class="box_logo ">
                <img src="/public/images/logo.jpg " alt="logo ">
            </div> -->
            <h3>Follow Us</h3>
            <div class="follow-icons ">
                <div><i class="fa-brands fa-facebook "></i> Facebook</div>
                <div><i class="fa-brands fa-tiktok "></i> TikTok</div>
                <div><i class="fa-brands fa-zalo "></i> Zalo</div>
            </div>
        </div>

        <!-- About Us -->
        <div class="footer-aboutus ">
            <h3>About Us</h3>
            <p>The website selling traditional products of the Bru - Vân Kiều and Pa Cô people offers unique items, from clothing to handicrafts. Each product reflects distinct cultural traits and contributes to the preservation of cultural heritage.</p>
        </div>

        <!-- Contact -->
        <div class="footer-contact ">
            <h3>Contact</h3>
            <div class="contact-details ">
                <div>
                    <i class="fa-solid fa-location-dot "></i>
                    <p>123 Cultural Street, Heritage City</p>
                </div>
                <div>
                    <i class="fa-solid fa-phone "></i>
                    <p>+84 123 456 789</p>
                </div>
                <div>
                    <i class="fa-solid fa-envelope "></i>
                    <p>vai.xom26@student.passerellesnumeriques.org</p>
                </div>
                <div>
                    <i class="fa-solid fa-envelope "></i>
                    <p>dieu.ho26@student.passerellesnumeriques.org</p>
                </div>
                <div>
                    <i class="fa-solid fa-envelope "></i>
                    <p>on.ho26@student.passerellesnumeriques.org</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function autoSlide(sliderId) {
            const slides = document.querySelector(`#${sliderId}`);
            const totalSlides = slides.children.length;
            let currentSlide = 0;

            setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                const offset = -currentSlide * 100;
                slides.style.transform = `translateX(${offset}%)`;
            }, 3000); // Thay đổi ảnh sau mỗi 3 giây
        }

        autoSlide('slider1');
        autoSlide('slider2');
        autoSlide('slider3');
    </script>
</body>

</html>