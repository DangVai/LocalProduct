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





     public function index()
     {
         $products = $this->AdminModel->getAll();
         $this->view('frontend.products.index', ['products' => $products]);
     }
     // Hiển thị form thêm sản phẩm
     public function create()
     {
         require_once 'Views/products/create.php';
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
             $size = implode(',', $_POST['size']);
             $description = $_POST['description'];

             // Xử lý ảnh tải lên
             $images = $_FILES['images'];
             $image_paths = [];
             $target_dir = "uploads/"; // Thư mục chứa ảnh
 
             foreach ($images['name'] as $key => $image_name) {
                 $image_tmp_name = $images['tmp_name'][$key];
                 $image_path = $target_dir . basename($image_name);

                 if (move_uploaded_file($image_tmp_name, $image_path)) {
                     $image_paths[] = $image_path;
                 } else {
                     echo "Error uploading file: " . $image_name;
                 }
             }

             $images_json = json_encode($image_paths); // Lưu dưới dạng JSON
 
             // Chuẩn bị dữ liệu để truyền sang Model
             $data = [
                 'name' => $name,
                 'category' => $category,
                 'image_id' => $images_json,
                 'quantity' => $quantity,
                 'type' => $type,
                 'price' => $price,
                 'description' => $description,
                 'size' => $size
             ];

             // Gọi model để lưu vào database
             if ($this->AdminModel->create($data)) {
                 header("Location: index.php?controller=product&action=index");
                 exit();
             } else {
                 echo "Có lỗi xảy ra khi thêm sản phẩm!";
             }
         }
     }
 }
?>