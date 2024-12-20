<?php
class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }
<<<<<<< HEAD

    public function index()
    {
        $products = $this->productModel->getAll();
        $this->view('frontend.products.index', ['products' => $products]);
    }


    public function show($id)
    {
        // echo "Chi tiết sản phẩm id: $description ";
        $products = $this->productModel->find($id);
        $this->view('frontend.products.index', ['products' => $products]);
    }
    public function search($extractProperties) {}

    public function detail($id)
    {
        // Kiểm tra xem id có hợp lệ không trước khi gọi getById
        if (empty($id) || !is_numeric($id)) {
            die('ID không hợp lệ');
        }

        // Lấy sản phẩm theo ID từ mô hình
        $product = $this->productModel->getById($id);

        // Nếu không tìm thấy sản phẩm, có thể thông báo lỗi
        if (!$product) {
            die('Sản phẩm không tồn tại');
        }

        // Lấy các sản phẩm cùng category với sản phẩm hiện tại
        $relatedProducts = $this->productModel->getByCategory($product['category'], $id);
        // Truyền dữ liệu vào view 'frontend.products.detail'
        $this->view('frontend.products.detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }


    public function checkout()
    {
        $this->view('frontend.products.checkout');
    }

    public function finishcheckout()
    {
        $this->view('frontend.products.finishcheckout');
    }
    public function showProduct()
    {
        // Lấy toàn bộ dữ liệu sản phẩm và hình ảnh
        $productData = $this->productModel->getAllProductsWithImages();

        if (empty($productData)) {
            // Nếu không có sản phẩm, hiển thị thông báo
            echo "Không có sản phẩm nào trong cơ sở dữ liệu.";
            return;
        }

        // Gửi dữ liệu sản phẩm tới view
        $this->view('frontend.products.listProduct', ['productData' => $productData]);
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



    // Phương thức xử lý việc lưu đơn hàng
}
