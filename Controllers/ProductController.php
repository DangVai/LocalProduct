<?php
class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }



    public function index()
    {
        $products = $this->productModel->getAll();
        $this->view('frontend.products.index', ['products' => $products]);
    }
    public function detail($id)
    {
        // Kiểm tra xem id có hợp lệ không
        if (empty($id) || !is_numeric($id)) {
            $_SESSION['success'] = "Mật khẩu đã được thay đổi thành công.";
            header("Location: index.php?controller=user&action=profile");
            exit(); 
        }

        // Lấy sản phẩm theo ID từ mô hình
        $product = $this->productModel->getById($id);

        // Nếu không tìm thấy sản phẩm
        if (!$product) {
            die('Sản phẩm không tồn tại');
        }

        // Lấy các sản phẩm cùng category với sản phẩm hiện tại
        $relatedProducts = $this->productModel->getByCategory($product['category'], $id);

        // Lấy preview của sản phẩm
        $previews = $this->productModel->getProductPreview($id);

        // Truyền dữ liệu vào view 'frontend.products.detail'
        $this->viewWithoutLayout('frontend.products.detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'previews' => $previews  // Truyền dữ liệu preview vào view
        ]);
    }

    // Xử lý việc gửi đánh giá
    public function submitReview()
    {
        if (isset($_POST['stars'], $_POST['content'], $_POST['product_id'])) {
            $stars = $_POST['stars'];
            $content = $_POST['content'];
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];

            // Kiểm tra xem người dùng đã mua và đơn hàng đã giao thành công chưa
            if (!$this->productModel->hasPurchasedProduct($user_id, $product_id)) {
                $_SESSION['error'] = "You can only review products that have been delivered successfully.";
                header("Location: index.php?controller=product&action=detail&id=$product_id");
                exit();
            }

            // Lưu bình luận nếu điều kiện thỏa mãn
            $this->productModel->saveReview($user_id, $product_id, $content, $stars);
            $_SESSION['success'] = "Review sent.";
            header("Location: index.php?controller=product&action=detail&id=$product_id");
            exit();
        }
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

    //CÁC TRANG SAN PHAM
    public function fashion()
    {
        $priceFilter = isset($_GET['price']) ? $_GET['price'] : '';
        $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
        $keywordFilter = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $fa = $this->productModel->getFashionProducts($priceFilter, $typeFilter, $keywordFilter);
        error_log(print_r($fa, true));

        $this->viewWithoutLayout('frontend.products.fashion', ['products' => $fa]);
    }
    public function food()
    {
        $fo = $this->productModel->getFoodProducts();

        $this->viewWithoutLayout('frontend.products.food', ['products' => $fo]);
    }
    public function another()
    {
        $an = $this->productModel->getAnotherProducts();
        $this->viewWithoutLayout('frontend.products.another', ['products' => $an]);
    }
    //LỌC SẢN PHẨM
    //search home
    public function search()
    {
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $products = $this->productModel->searchProducts($keyword);
            // Truyền dữ liệu sang view
            $this->viewWithoutLayout('frontend.products.search_results', ['products' => $products]);
   
        } else {
            // Nếu không có từ khóa, quay lại trang home
            header('Location: home.php');
            exit;
        }
    }

    // Phương thức xử lý việc lưu đơn hàng
}
