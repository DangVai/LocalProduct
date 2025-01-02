<?php
class FavoriteController extends BaseController
{
    private $favoriteModel;

    public function __construct()
    {
        $this->loadModel('FavoriteModel');
        $this->favoriteModel = new FavoriteModel();
    }

    // Thêm sản phẩm vào danh sách yêu thích
    public function addFavorite()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào yêu thích.']);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];

        $exists = $this->favoriteModel->checkFavorite($user_id, $product_id);
        if ($exists) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm đã có trong danh sách yêu thích.']);
            return;
        }

        $result = $this->favoriteModel->addFavorite($user_id, $product_id);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Thêm vào yêu thích thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
        }
    }

    // Xóa sản phẩm khỏi danh sách yêu thích
    public function removeFavorite()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thao tác.']);
            return;
        }

        $user_id = $_SESSION['user_id'];
        $favorite_id = $_POST['favorite_id'];

        $result = $this->favoriteModel->removeFavorite($user_id, $favorite_id);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Xóa khỏi yêu thích thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
        }
    }
}
