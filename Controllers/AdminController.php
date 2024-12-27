 <?php
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 class AdminController extends BaseController
 {
     private $AdminModel;

     public function __construct()
     {
         parent::__construct(); // Gọi constructor của BaseController nếu cần
         $this->loadModel('AdminModel'); // Kiểm tra tên chính xác của model
         $this->AdminModel = new AdminModel(); // Tạo đối tượng model
     }

     //=====================================================Product Management===========================================
     public function index()
     {
         $products = $this->AdminModel->getAllProducts();
         $this->viewWithoutLayout('frontend.Admin.products.index', ['products' => $products]);
        //  require_once('frontend.Admin.products.index', ['products' => $products]);
     }


     // Hiển thị form thêm sản phẩm
     public function create()
     {
         $this->viewWithoutLayout("frontend.Admin.products.create");

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
                     $image_path = "/LocalProduct/public/images/Product_image/" . basename($image_name);
                     move_uploaded_file($image_tmp_name, $image_path);  // Di chuyển ảnh vào thư mục uploads
 
                     // Lưu vào bảng image
                     $image_data = [
                         'product_id' => $product_id,  // Lưu product_id từ bảng sản phẩm
                         'img' => $image_path,
                     ];
                     $this->AdminModel->insertImage($image_data); // Giả sử `insertImage` thêm ảnh vào bảng image
                 }
             }

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
             header("Location: index.php?controller=admin&action=home#");
             exit();
         }
     }



     // Lấy dữ liệu sản phẩm để edit
     public function edit($id)
     {
         $id = $_GET['id'] ?? null;
         if ($id) {
             $product = $this->AdminModel->getProductById($id);
             $this->viewWithoutLayout("frontend.Admin.products.edit", ["product" => $product]);
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
                         $uploadDir = '/LocalProduct/public/images/Product_image/';
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
                         $uploadDir = '/LocalProduct/public/images/Product_image/';
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
                 header("Location: index.php?controller=admin&action=home#");
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
             header("Location: index.php?controller=admin&action=home#");
             exit();
         } else {
             // Xử lý nếu có lỗi trong quá trình xóa sản phẩm
             echo "Có lỗi xảy ra khi xóa sản phẩm!";
         }
     }

     //=====================================================End Product Management===========================================
 
     //===================================================Oder tracking==========================================================

    public function showOrders() {
    // Kiểm tra nếu có danh sách đã lọc trong session
    if (isset($_SESSION['filteredOrders'])) {
        $orders = $_SESSION['filteredOrders'];
        unset($_SESSION['filteredOrders']); // Xóa sau khi sử dụng để tránh dữ liệu cũ
    } else {
        // Lấy toàn bộ danh sách nếu không có bộ lọc
        $orders = $this->AdminModel->getOrders();
    }

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
        header("Location: index.php?controller=admin&action=home#");
    }
}


public function listOrders() {
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;

    // Gọi model để lấy danh sách đơn hàng dựa trên bộ lọc
    if ($statusFilter && $statusFilter !== 'all') {
        $orders = $this->AdminModel->getOrdersByStatus($statusFilter);
    } else {
        $orders = $this->AdminModel->getOrders();
    }

    // Lưu danh sách đã lọc vào session
    $_SESSION['filteredOrders'] = $orders;

    // Chuyển hướng về trang home#
    header("Location: index.php?controller=admin&action=home#");
    exit();
}



public function orderDetail() {
    if (!isset($_GET['order_id'])) {
        // Nếu không có `order_id`, quay lại danh sách
        header("Location: index.php?controller=admin&action=listOrders");
        exit();
    }

    $orderId = $_GET['order_id'];

    // Gọi model để lấy thông tin từ bảng `order_items`
    $orderDetails = $this->AdminModel->getOrderDetails($orderId);

    // Kiểm tra nếu không tìm thấy order
    if (!$orderDetails) {
        header("Location: index.php?controller=admin&action=listOrders&error=Order not found");
        exit();
    }

    // Truyền dữ liệu vào view
    $this->viewWithoutLayout("frontend.Admin.orderItem", ['orderDetails' => $orderDetails]);
}



//===================================================End Oder tracking==========================================================



//===================================================Admin login==========================================================
    
// Hiển thị trang đăng nhập admin
    public function login() {
        $this->viewWithoutLayout("frontend.Admin.login");
    }

    // Xử lý gửi OTP qua email
    public function sendOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Kiểm tra email có hợp lệ hay không
            if (!$this->AdminModel->isValidAdminEmail($email)) {
                header("Location: index.php?controller=admin&action=login&error=email_invalid");
                exit();
            }

            // Tạo mã OTP và gửi qua email
            $otp = $this->AdminModel->generateOTP($email);
            $this->sendEmail($email, $otp);

            // Chuyển tới form nhập OTP kèm email
            header("Location: index.php?controller=admin&action=login&success=success&email=" . urlencode($email));
            exit();
        }
    }

    // Xử lý xác thực mã OTP
    public function processOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $otp = $_POST['otp'];

            // Xác minh OTP
            if ($this->AdminModel->verifyOTP($email, $otp)) {
                // Đăng nhập thành công
                $_SESSION['admin_logged_in'] = true; 
                session_regenerate_id(true); 
                header("Location: index.php?controller=admin&action=home");
                exit();
            } else {
                die("Mã OTP không hợp lệ hoặc đã hết hạn!");
            }
        }
    }

    // Hiển thị trang Dashboard
    public function home() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        $this->viewWithoutLayout("frontend.Admin.home");
    }


    public function sendEmail($email, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'on.ho26@student.passerellesnumeriques.org'; // Email của bạn
            $mail->Password = 'jriaycnpewjpslnu'; // Mật khẩu ứng dụng
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('on.ho26@student.passerellesnumeriques.org', 'Your Website');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP verification code';
            $mail->Body = "Your OTP code:<b>$otp</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
//===================================================End Admin login==========================================================

//===================================================User Management==========================================================
   // Phương thức hiển thị danh sách người dùng
    public function listUsers() {
        $users = $this->AdminModel->getAllUsers();  
        $this->viewWithoutLayout("frontend.Admin.userManagement", ['users' => $users]);
    }


    // Cập nhật thông tin người dùng
 public function updateUser() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_POST['user_id'];
        // Xử lý file upload
        $avatarFileName = null;
        // Kiểm tra nếu người dùng chọn ảnh để tải lên
        if (!empty($_FILES['avatar']['name'])) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/LocalProduct/public/images/User_Avata/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }

            $avatarFileName = time() . "_" . basename($_FILES['avatar']['name']);
            $targetFile = $targetDir . $avatarFileName;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile);

            // Lưu tên tệp avatar vào CSDL:
            $avatarToDB = $avatarFileName;


            // Kiểm tra loại file (chỉ chấp nhận các định dạng ảnh phổ biến)
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                // Nếu file hợp lệ, tiến hành upload
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    $avatarFileName = basename($targetFile); // Lưu tên file vào CSDL
                } else {
                    header("Location: index.php?controller=admin&action=updateUser&id=$userId&error=" . urlencode("Failed to upload avatar."));
                    exit();
                }
            } else {
                header("Location: index.php?controller=admin&action=updateUser&id=$userId&error=" . urlencode("Invalid avatar file type."));
                exit();
            }
        }

        // Dữ liệu từ form
        $userData = [
            'Name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            // Kiểm tra nếu người dùng chưa upload ảnh mới, giữ ảnh cũ
            'avatar' => $avatarFileName ?: ($_POST['avatar'] ?? $this->AdminModel->getUserById($userId)['avata']),
            'status' => $_POST['status'] ?? 'active'
        ];

        // Kiểm tra ràng buộc cơ bản
        if (empty($userData['Name']) || empty($userData['email']) || empty($userId)) {
            header("Location: index.php?controller=admin&action=updateUser&id=$userId&error=" . urlencode("Please fill in all required fields!"));
            exit();
        }

        // Cập nhật thông tin người dùng
        $this->AdminModel->updateUserById($userId, $userData);

        // Sau khi cập nhật thành công, chuyển hướng về danh sách người dùng
        header("Location: index.php?controller=admin&action=home#");
        exit();
    } else {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            header("Location: index.php?controller=admin&action=listUsers&error=" . urlencode("Invalid user ID."));
            exit();
        }

        $user = $this->AdminModel->getUserById($userId);
        if (!$user) {
            header("Location: index.php?controller=admin&action=listUsers&error=" . urlencode("User not found."));
            exit();
        }

        // Hiển thị form với thông tin người dùng hiện tại
        $this->viewWithoutLayout("frontend.Admin.updateUser", ['user' => $user]);
    }
}




    // Phương thức khóa tài khoản người dùng
    public function lockUser() {
        if (isset($_POST['confirm_lock']) && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];

            // Dùng đối tượng đã khởi tạo từ __construct()
            $this->AdminModel->lockUserById($userId);

            // Sau khi khóa thành công, chuyển hướng về danh sách người dùng kèm thông báo thành công
            header("Location: index.php?controller=admin&action=home#");
            exit();
        }
    }

//===========================Logout==================================
public function logout() {
    // Hủy session
    session_start();
    session_unset(); // Xóa tất cả biến session
    session_destroy(); // Hủy session

    // Chuyển hướng về trang đăng nhập hoặc trang chủ
    header("Location: index.php?controller=admin&action=login"); 
    exit();
}



 }
?>