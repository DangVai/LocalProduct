<?php


require_once 'models/ProductModel.php';

class HomeController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // Hiển thị trang chủ với sản phẩm nổi bật
    public function index()
    {
        $featuredProducts = $this->productModel->getFeaturedProductsByQuantity();
        $this->view('home', ['featuredProducts' => $featuredProducts]);
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
