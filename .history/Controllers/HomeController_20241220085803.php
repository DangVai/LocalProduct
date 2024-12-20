<?php

require_once 'models/Product.php';

class HomeController
{
    public function index()
    {
        $featuredProducts = $this->productModel->getFeaturedProductsByQuantity();
        require_once "views/home.php"; // Gọi View để hiển thị
    } ire_once 'views/home.php'; // Đưa dữ liệu sang View
    
    }
