<?php
class CartController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    public function addToFavorite()
    {
        // Lấy dữ liệu từ request
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['user_id'] ?? null;
        $productId = $data['product_id'] ?? null;

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
        $isAdded = $this->productModel->addToFavorite($userId, $productId);

        if ($isAdded) {
            echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
        }
    }

    public function viewFavorite()
    {
        $userId = $_SESSION['user_id']; // Lấy user_id từ session

        if (!$userId) {
            // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header("Location: login.php");
            exit();
        }

        // Lấy các sản phẩm trong giỏ hàng của người dùng
        $cartItems = $this->productModel->getCartItems($userId);

        // Hien thi giao dien cart.php
        $this->viewWithoutLayout('frontend.products.cart', ['cartItems' => $cartItems]);
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
            $productIdToDelete = intval($_POST['delete_item']);  // Convert to integer for safety

            if ($productIdToDelete <= 0) {
                // Nếu product_id không hợp lệ
                echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
                exit; // Dừng lại sau khi trả về kết quả JSON
            }

            // Gọi phương thức trong model để xóa sản phẩm
            $isDeleted = $this->productModel->deleteItem($productIdToDelete);

            // Kiểm tra kết quả và trả về phản hồi dạng JSON
            if ($isDeleted) {
                echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
            }
            exit;  // Dừng lại sau khi trả về kết quả JSON
        }

        // Trường hợp yêu cầu không hợp lệ
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }
}
