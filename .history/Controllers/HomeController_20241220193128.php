<?php

require_once 'models/Product.php';

class HomeController
{
    private $productModel;

    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    // Hiển thị trang chủ với sản phẩm nổi bật
    public function index()
    {
        $featuredProducts = $this->productModel->getFeaturedProductsByQuantity();
        require_once 'views/home.php'; // Gọi View để hiển thị
    }

    // Xử lý thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id)
    {
        // Giả sử ta thêm vào session
        $this->productModel->addToCart($product_id, 1); // Ví dụ thêm 1 sản phẩm vào giỏ hàng
        header("Location: /cart"); // Chuyển hướng đến trang giỏ hàng
    }

    // Xử lý thay đổi trạng thái yêu thích của sản phẩm
    public function toggleFavorite($product_id)
    {
        $this->productModel->toggleFavorite($product_id);
        header("Location: /"); // Quay lại trang chủ
    }
}
