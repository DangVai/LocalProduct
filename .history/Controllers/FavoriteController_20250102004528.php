<?php
class FavoriteController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    // Thêm sản phẩm vào danh sách yêu thích
    public function toggleFavorite()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $data['user_id'];
        $productId = $data['product_id'];

        // Kiểm tra nếu sản phẩm chưa yêu thích thì thêm vào
        if ($this->productModel->isProductFavorite($userId, $productId)) {
            // Nếu sản phẩm đã có trong yêu thích thì xóa
            if ($this->productModel->removeFavorite($userId, $productId)) {
                echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm khỏi yêu thích!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Đã có lỗi xảy ra khi xóa sản phẩm yêu thích!']);
            }
        } else {
            // Nếu sản phẩm chưa có trong yêu thích thì thêm vào
            if ($this->productModel->addFavorite($userId, $productId)) {
                echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào yêu thích!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Đã có lỗi xảy ra khi thêm sản phẩm yêu thích!']);
            }
        }
    }

    // Hiển thị danh sách yêu thích của người dùng
    public function showFavorites()
    {
        $userId = $_SESSION['user_id'];
        $favorites = $this->productModel->getFavoritesByUser($userId);
        $this->view('favorite.index', ['products' => $favorites]);
    }
}
