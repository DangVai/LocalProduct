<?phpclass ProductController {
    public function getFeaturedProducts() {
        require_once 'models/Product.php';
        $productModel = new Product();
        return $productModel->getFeaturedProducts(10);
    }
}