<?php
class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        $this->view('frontend.products.index', ['products' => $products]);
    }


    public function show($id)
    {
        // echo "Chi tiết sản phẩm id: $description ";
        $products = $this->productModel->find($id);
        $this->view('frontend.products.index', ['products' => $products]);
    }
    public function search($extractProperties)
    {

    }
}
