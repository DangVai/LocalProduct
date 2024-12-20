<?php

require_once 'models/Product.php';

class HomeController {
    public function displayHomePage() {
        $productModel = new Product();
        $featuredProducts = $productModel->getFeaturedProducts(10); // Lấy 10 sản phẩm nổi bật
        require_once 'views/home.php'; // Đưa dữ liệu sang View
    }
}
?>
