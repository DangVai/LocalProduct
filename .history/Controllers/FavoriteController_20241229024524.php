<?php

class FavoriteController extends BaseController
{
    private $favoriteModel;

    public function __construct()
    {
        $this->loadModel('FavoriteModel'); // Load FavoriteModel
        $this->favoriteModel = new FavoriteModel();
    }

    // Thêm sản phẩm vào yêu thích
    public function addToFavorite()
    {
        session_start();

        // Kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm sản phẩm yêu thích.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;

        // Kiểm tra sản phẩm
        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ.']);
            return;
        }

        // Gọi model để thêm sản phẩm vào yêu thích
        $isAdded = $this->favoriteModel->addFavorite($userId, $productId);

        if ($isAdded) {
            echo json_encode(['success' => true, 'message' => 'Thêm vào mục yêu thích thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm vào mục yêu thích.']);
        }
    }

    // Hiển thị danh sách yêu thích
    public function viewFavorite()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header("Location: login.php");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $products = $this->favoriteModel->getFavorites($userId);

        // Hiển thị giao diện danh sách yêu thích
        $this->viewWithoutLayout('frontend.products.favorite', ['products' => $products]);
    }

    // Xóa sản phẩm khỏi yêu thích
    public function removeFavorite()
    {
        session_start();

        // Kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để xóa sản phẩm yêu thích.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $favoriteId = $data['favorite_id'] ?? null;

        // Kiểm tra ID yêu thích
        if (!$favoriteId) {
            echo json_encode(['success' => false, 'message' => 'ID yêu thích không hợp lệ.']);
            return;
        }

        // Gọi model để xóa sản phẩm
        $isRemoved = $this->favoriteModel->removeFavorite($favoriteId, $userId);

        if ($isRemoved) {
            echo json_encode(['success' => true, 'message' => 'Xóa thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm.']);
        }
    }
}
