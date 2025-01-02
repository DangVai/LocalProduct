<?php

class FavoriteController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    // Thêm sản phẩm vào yêu thích
    public function addToFavorite()
    {
        if (isset($_SESSION['user_id'])) {
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];

            $result = $this->productModel->addToFavorite($product_id, $user_id);

            // Trả về kết quả cho client (thông qua AJAX)
            echo json_encode($result ? 'success' : 'error');
        } else {
            echo json_encode('login_required');
        }
    }

    // Xóa sản phẩm khỏi yêu thích
    public function removeFromFavorite()
    {
        if (isset($_SESSION['user_id'])) {
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];

            $result = $this->productModel->removeFromFavorite($product_id, $user_id);

            // Trả về kết quả cho client (thông qua AJAX)
            echo json_encode($result ? 'success' : 'error');
        } else {
            echo json_encode('login_required');
        }
    }

    // Hiển thị danh sách yêu thích
    public function showFavorites()
    {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $products = $this->productModel->getFavorites($user_id);
            $this->view('favorite.show', ['products' => $products]);
        } else {
            $this->view('favorite.', []);
        }
    }
}
