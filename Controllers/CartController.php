<?php
class CartController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    public function addToCart()
    {
        // Lấy dữ liệu từ request
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['user_id'] ?? null;
        $productId = $data['product_id'] ?? null;
        $size = $data['size'] ?? null;
        $quantity = $data['quantity'] ?? null;

        // Kiểm tra người dùng đã đăng nhập
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'You must log in to add products to the cart.']);
            return;
        }

        // Kiểm tra sản phẩm
        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
            return;
        }

        // Gọi phương thức addToCart trong model để thêm sản phẩm vào giỏ hàng
        $isAdded = $this->productModel->addToCart($userId, $productId, $size, $quantity);

        if ($isAdded) {
            echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
        }
    }
} 

