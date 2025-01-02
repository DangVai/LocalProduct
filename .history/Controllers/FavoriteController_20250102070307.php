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

        // Sử dụng ProductModel thay vì FavoriteModel
        $model = $this->loadModel('ProductModel');

        // Kiểm tra xem sản phẩm đã có trong yêu thích chưa
        if ($model->isFavorite($userId, $productId)) {
            // Nếu đã có, xóa khỏi danh sách yêu thích
            $model->removeFromFavorites($userId, $productId);
            echo json_encode([
                'status' => 'success',
                'message' => 'Đã xóa khỏi yêu thích.',
                'is_favorite' => false
            ]);
        } else {
            // Nếu chưa có, thêm vào danh sách yêu thích
            $model->addToFavorites($userId, $productId);
            echo json_encode([
                'status' => 'success',
                'message' => 'Đã thêm vào yêu thích.',
                'is_favorite' => true
            ]);
        }
    }

    public function showFavorites()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        // Sử dụng ProductModel thay vì FavoriteModel
        $model = $this->loadModel('ProductModel');
        $favorites = $model->getFavorites($userId);

        $this->view('favorites.index', ['favorites' => $favorites]);
    }
}
