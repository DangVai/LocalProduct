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
    public function home()
    {
        $featuredProducts = $this->productModel->getTopProductsByQuantity();
        if (empty($featuredProducts)) {
            // Nếu không có sản phẩm, hiển thị thông báo
            echo "Không có sản phẩm nào trong cơ sở dữ liệu.";
            return;
        }

        // Không cần exit tại đây, hãy trả dữ liệu về view
        $this->view('frontend.home', ['featuredProducts' => $featuredProducts]);
    }

    public function aboutus(){
        $this->view('frontend.aboutus');
    }

    
}
