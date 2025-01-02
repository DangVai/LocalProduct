<?php
class FavoriteController extends BaseController
{
    public function addFavorite()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để thêm yêu thích.']);
            return;
        }

        $productId = $_POST['product_id'];
        $userId = $_SESSION['user_id'];

        $model = $this->loadModel('FavoriteModel');
        $isAdded = $model->toggleFavorite($productId, $userId);

        echo json_encode([
            'status' => 'success',
            'message' => $isAdded ? 'Đã thêm vào yêu thích.' : 'Đã xóa khỏi yêu thích.',
            'is_favorite' => $isAdded
        ]);
    }

    public function showFavorites()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $model = $this->loadModel('FavoriteModel');
        $favorites = $model->getFavoritesByUser($userId);

        $this->view('favorites.index', ['favorites' => $favorites]);
    }
}
