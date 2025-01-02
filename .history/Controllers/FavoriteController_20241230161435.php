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

        // Kiểm tra xem người dùng có đăng nhập không
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào mục yêu thích.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra lỗi dữ liệu JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Lỗi JSON: " . json_last_error_msg());
            echo json_encode(['success' => false, 'message' => 'Dữ liệu JSON không hợp lệ.']);
            return;
        }

        $productId = $data['product_id'] ?? null;

        // Kiểm tra xem ID sản phẩm có hợp lệ không
        if (!is_numeric($productId)) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu sản phẩm không hợp lệ.']);
            return;
        }

        // Gọi model để thêm sản phẩm vào yêu thích
        $isAdded = $this->productModel->addFavorite($userId, $productId);

        if ($isAdded) {
            echo json_encode(['success' => true, 'message' => 'Thêm vào mục yêu thích thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm vào mục yêu thích.']);
        }
    }

    // Hiển thị danh sách yêu thích
    public function viewFavorite()
    {


        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=user&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $products = $this->productModel->getFavoriteItems($userId);

        $this->viewWithoutLayout('frontend.products.favorite', ['products' => $products]);
    }


    // Xóa sản phẩm khỏi yêu thích
    public function removeFavorite()
    {


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
        $isRemoved = $this->productModel->removeFavorite($favoriteId, $userId);

        if ($isRemoved) {
            echo json_encode(['success' => true, 'message' => 'Xóa thành công.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm.']);
        }
    }
}
