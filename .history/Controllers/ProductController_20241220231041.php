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


    public function show($id)
    {
        // echo "Chi tiết sản phẩm id: $description ";
        $products = $this->productModel->find($id);
        $this->view('frontend.products.index', ['products' => $products]);
    }
    public function search($extractProperties)
    {

    }
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

        // Truyền dữ liệu vào view 'frontend.products.detail'
        $this->view('frontend.products.detail', ['product' => $product]);
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



    // Phương thức xử lý việc lưu đơn hàng
    public function storeOrder()
    {
        // Lấy dữ liệu từ form hoặc session
        $orderData = [
            "size" => $_POST['size'],
            "quantity" => $_POST['quantity'],
            "product_name" => $_POST['product_name'],
            "product_id" => $_POST['product_id'],
            "product_price" => $_POST['product_price'],
            "full_name" => $_POST['full_name'],
            "phone" => $_POST['phone'],
            "location" => $_POST['location'],
            "specific_address" => $_POST['specific_address'],
            "payment_method" => $_POST['payment_method'],
            "user_id" => $_SESSION['user_id'],  // Lấy từ session
            "name" => $_SESSION['user_name'],   // Lấy từ session
            "total_price" => $_POST['total_price']
        ];

        // Gọi phương thức createOrder để lưu đơn hàng
        if ($this->productModel->createOrder($orderData)) {
            // Điều hướng thành công
            header("Location: index.php?controller=product&action=success");
            exit();
        } else {
            // Điều hướng lỗi
            header("Location: index.php?controller=product&action=error");
            exit();
        }
    }
}
