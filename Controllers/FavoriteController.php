<?php

class FavoriteController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    public function addFavorite()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please log in to add favorites.',
                header('Location: login.php')
            ]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            error_log("Invalid JSON: " . file_get_contents('php://input'));
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid data!'
            ]);
            exit();
        }

        if (!isset($data['product_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid product ID.'
            ]);
            exit();
        }

        $productId = $data['product_id'];
        $userId = $_SESSION['user_id'];
        if ($this->productModel->isFavorite($userId, $productId)) {
            $this->productModel->removeFromFavorites($userId, $productId);
            echo json_encode([
                'status' => 'success',
                'message' => 'Removed from favorites.',
                'is_favorite' => false
            ]);
        } else {
            $this->productModel->addToFavorites($userId, $productId);
            echo json_encode([
                'status' => 'success',
                'message' => 'Added to favorites.',
                'is_favorite' => true
            ]);
        }
    }

    public function showFavorites()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $favorites = $this->productModel->getFavorites($userId);

        $this->viewWithoutLayout('frontend.products.favorite', ['favorites' => $favorites]);
    }
}
