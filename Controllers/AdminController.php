 <?php
 class AdminController extends BaseController
 {
     private $AdminModel;

     public function __construct()
     {
         parent::__construct(); // Gọi constructor của BaseController nếu cần
         $this->loadModel('AdminModel'); // Kiểm tra tên chính xác của model
         $this->AdminModel = new AdminModel(); // Tạo đối tượng model
     }

     // Các phương thức khác của AdminController có thể được thêm ở đây
 



     //=====================================================Product Management===========================================
     public function index()
     {
         $products = $this->AdminModel->getAllProducts();
         $this->view('frontend.Admin.products.index', ['products' => $products]);
     }


     // Hiển thị form thêm sản phẩm
     public function create()
     {
         $this->view("frontend.Admin.products.create");

     }


     // Xử lý thêm sản phẩm
     public function store()
     {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Lấy thông tin từ form
             $name = $_POST['name'];
             $category = $_POST['category'];
             $quantity = $_POST['quantity'];
             $type = $_POST['type'];
             $price = $_POST['price'];
             $description = $_POST['description'];

             // Lưu vào bảng products
             $data = [
                 'name' => $name,
                 'category' => $category,
                 'quantity' => $quantity,
                 'type' => $type,
                 'price' => $price,
                 'description' => $description,
                 'product_view_at' => date('Y-m-d H:i:s'), // ví dụ, bạn có thể tự động thêm thời gian
             ];

             // Gọi model để lưu vào bảng products
             $product_id = $this->AdminModel->create($data); // Giả sử `createProduct` trả về `product_id`
 
             // Lưu nhiều ảnh vào bảng image
             if (isset($_FILES['images'])) {
                 $images = $_FILES['images'];
                 $image_paths = [];

                 foreach ($images['name'] as $key => $image_name) {
                     $image_tmp_name = $images['tmp_name'][$key];
                     $image_path = "public/images/Product_image/" . basename($image_name);
                     move_uploaded_file($image_tmp_name, $image_path);  // Di chuyển ảnh vào thư mục uploads
 
                     // Lưu vào bảng image
                     $image_data = [
                         'product_id' => $product_id,  // Lưu product_id từ bảng sản phẩm
                         'img' => $image_path,
                     ];
                     $this->AdminModel->insertImage($image_data); // Giả sử `insertImage` thêm ảnh vào bảng image
                 }
             }

             // Lưu nhiều kích thước vào bảng product_sizes
             // Lưu kích thước vào bảng product_sizes (chỉ nếu có size đã chọn)
             if (!empty($_POST['size'])) {
                 foreach ($_POST['size'] as $size) {
                     // Lưu giá trị kích thước vào bảng `product_sizes`
                     $this->AdminModel->insertSize([
                         'product_id' => $product_id,
                         'size' => $size,  // Gửi giá trị kích thước (ví dụ 's', 'm', v.v.)
                     ]);
                 }
             }

             // Chuyển hướng sau khi thành công
             header("Location: index.php?controller=admin&action=index");
             exit();
         }
     }



     // Lấy dữ liệu sản phẩm để edit
     public function edit($id)
     {
         $id = $_GET['id'] ?? null;
         if ($id) {
             $product = $this->AdminModel->getProductById($id);
             $this->view("frontend.Admin.products.edit", ["product" => $product]);
         } else {
             echo "Invalid product ID.";
         }
     }


     // Xử lý cập nhật sản phẩm
     public function update()
     {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $id = $_POST['product_id'];

             // Chuẩn bị dữ liệu cho update
             $data = [
                 'name' => $_POST['name'],
                 'category' => $_POST['category'],
                 'quantity' => $_POST['quantity'],
                 'price' => $_POST['price'],
                 'type' => $_POST['type'],
                 'sizes' => implode(',', $_POST['sizes'] ?? []), // Convert sizes array to string
                 'description' => $_POST['description'],
                 'images' => [] // Mảng chứa đường dẫn ảnh mới
             ];

             // **Xử lý ảnh thay thế**
             if (!empty($_FILES['replace_images']['name'])) {
                 foreach ($_FILES['replace_images']['name'] as $key => $filename) {
                     if (!empty($filename)) {
                         $uploadDir = 'public/images/Product_image/';
                         $newFileName = uniqid() . "_" . $filename; // Tạo tên file mới
                         $newFilePath = $uploadDir . $newFileName;

                         // Di chuyển file vào thư mục
                         if (move_uploaded_file($_FILES['replace_images']['tmp_name'][$key], $newFilePath)) {
                             $data['images'][$key] = $newFilePath; // Thay ảnh
                         }
                     }
                 }
             }

             // **Xử lý thêm ảnh mới**
             if (!empty($_FILES['new_images']['name'][0])) {
                 foreach ($_FILES['new_images']['name'] as $key => $filename) {
                     if (!empty($filename)) {
                         $uploadDir = 'public/images/Product_image/';
                         $newFileName = uniqid() . "_" . $filename; // Tạo tên file mới
                         $newFilePath = $uploadDir . $newFileName;

                         if (move_uploaded_file($_FILES['new_images']['tmp_name'][$key], $newFilePath)) {
                             $data['images'][] = $newFilePath; // Thêm ảnh mới
                         }
                     }
                 }
             }

             // Gọi model để cập nhật sản phẩm
             $result = $this->AdminModel->updateProduct($id, $data);

             if ($result) {
                 // Chuyển hướng nếu thành công
                 header("Location: index.php?controller=admin&action=index");
             } else {
                 // Thông báo lỗi nếu thất bại
                 echo "Cập nhật không thành công. Vui lòng thử lại.";
             }
         }
     }


     // Xóa sản phẩm
     public function delete()
     {
         $id = (int) $_GET['id']; // Lấy id từ URL và ép kiểu về integer
 
         if ($this->AdminModel->delete($id)) {  // Gọi phương thức delete trong model
             $_SESSION['flash_message'] = "Xóa sản phẩm thành công!";
             // Chuyển hướng về trang danh sách sau khi xóa thành công
             header("Location: index.php?controller=admin&action=index");
             exit();
         } else {
             // Xử lý nếu có lỗi trong quá trình xóa sản phẩm
             echo "Có lỗi xảy ra khi xóa sản phẩm!";
         }
     }

     //=====================================================End Product Management===========================================
 
     //===================================================Oder tracking==========================================================
     public function showOrders()
     {
         $orders = $this->AdminModel->getOrders();

         // Xử lý giá trị NULL và thay thế bằng "N/A"
         foreach ($orders as &$order) {
             foreach ($order as $key => &$value) {
                 if (is_null($value)) {
                     $value = "N/A";
                 }
             }
         }

         // Trả về View với dữ liệu
         $this->viewWithoutLayout("frontend.Admin.oderTracking", ["orders" => $orders]);

     }

     public function updateOrderStatus()
{
    if (isset($_POST['order_id'], $_POST['status'])) {
        $orderId = $_POST['order_id'];
        $status = $_POST['status'];

        // Gọi model để cập nhật trạng thái đơn hàng
        $this->AdminModel->updateOrderStatus($orderId, $status);

        // Chuyển hướng về trang orderTracking
        header("Location: index.php?controller=admin&action=showOrders");
    }
}

 }
?>