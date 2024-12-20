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
        $this->view('frontend.home', ['featuredProducts' => $featuredProducts]);
    }

    public function home()
    {
        $this->view('frontend.home');
    }
}
