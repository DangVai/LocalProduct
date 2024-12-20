<?php

require_once 'models/Product.php';

class HomeController
{
    private $productModel;

    public function index()
    {
        $featuredProducts = $this->productModel->getFeaturedProductsByQuantity();
        require_once "views/home.php"; // Gọi View để hiển thị
    }
}
