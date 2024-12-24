<?php
class AdminModel extends BaseModel
{
    protected $table_name = "products";


    public function __construct()
    {
        parent::__construct('products');
    }

//=====================================================Product Management===========================================
public function getAllProducts() {
    $query = "
        SELECT p.*, 
               GROUP_CONCAT(DISTINCT ps.size ORDER BY ps.size ASC) AS sizes,
               (SELECT img 
                FROM image 
                WHERE image.product_id = p.product_id 
                ORDER BY image.image_id ASC LIMIT 1) AS image_id
        FROM products p
        LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
        GROUP BY p.product_id
    ";

    $result = $this->connect->query($query);

    if (!$result) {
        die("Error in SQL query: " . $this->connect->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}




    // Thêm sản phẩm vào cơ sở dữ liệu
    // Thêm sản phẩm vào bảng products
    public function create($data)
    {
        $query = "INSERT INTO products (name, category, quantity, type, price, description, product_view_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('ssisiss', 
            $data['name'],
            $data['category'],
            $data['quantity'],
            $data['type'],
            $data['price'],
            $data['description'],
            $data['product_view_at']
        );

        // Thực thi câu lệnh và trả về ID của sản phẩm vừa được thêm vào
        if ($stmt->execute()) {
            return $this->connect->insert_id;  // Trả về ID của sản phẩm vừa được tạo
        }
        return false;
    }

    // Thêm ảnh vào bảng image
    public function insertImage($image_data)
    {
        $query = "INSERT INTO image (product_id, img) VALUES (?, ?)";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('is', $image_data['product_id'], $image_data['img']);
        
        // Thực thi và kiểm tra việc lưu ảnh
        return $stmt->execute();
    }

    // Phương thức này sẽ lưu size vào bảng `product_sizes`
    public function insertSize($data)
    {
        $query = "INSERT INTO product_sizes (product_id, size) VALUES (?, ?)";
        $stmt = $this->connect->prepare($query);

        if (!$stmt) {
            die("Lỗi SQL: " . $this->connect->error);
        }

        // Bind dữ liệu vào câu lệnh SQL
        $stmt->bind_param('is', $data['product_id'], $data['size']);
        return $stmt->execute();
    }



    // Lấy sản phẩm để edit
public function getProductById($productId) {
    $query = "
        SELECT p.*, 
               GROUP_CONCAT(DISTINCT ps.size ORDER BY ps.size ASC) AS sizes,
               GROUP_CONCAT(DISTINCT i.img ORDER BY i.image_id ASC) AS images
        FROM products p
        LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
        LEFT JOIN image i ON p.product_id = i.product_id
        WHERE p.product_id = ?
        GROUP BY p.product_id
    ";

    $stmt = $this->connect->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
        

public function updateProduct($id, $data) {
    try {
        $this->connect->autocommit(false);

        // Update thông tin sản phẩm
        $stmt = $this->connect->prepare("
            UPDATE products 
            SET name = ?, category = ?, quantity = ?, price = ?, type = ?, description = ?
            WHERE product_id = ?
        ");
        if (!$stmt) {
            error_log("SQL Error (Update products): " . $this->connect->error);
            throw new Exception("Prepare statement failed for updating products.");
        }
        $stmt->bind_param(
            "ssiissi",
            $data['name'],
            $data['category'],
            $data['quantity'],
            $data['price'],
            $data['type'],
            $data['description'],
            $id
        );
        $stmt->execute();

         // Cập nhật kích thước
        if (!empty($data['sizes'])) {
            // Nếu $data['sizes'] là chuỗi, chuyển nó thành mảng
            if (is_string($data['sizes'])) {
                $data['sizes'] = explode(',', $data['sizes']); // Chuyển chuỗi thành mảng
            }

            // Lấy các kích thước hiện tại của sản phẩm
            $query = $this->connect->prepare("SELECT size FROM product_sizes WHERE product_id = ?");
            $query->bind_param("i", $id);
            $query->execute();
            $result = $query->get_result();
            $currentSizes = [];
            while ($row = $result->fetch_assoc()) {
                $currentSizes[] = $row['size'];
            }

            // Nếu currentSizes là chuỗi, chuyển thành mảng
            if (is_string($currentSizes)) {
                $currentSizes = explode(',', $currentSizes); // Chuyển chuỗi thành mảng
            }

            // Tìm ra các kích thước cần xóa (có trong currentSizes nhưng không có trong data['sizes'])
            $sizesToDelete = array_diff($currentSizes, $data['sizes']);

            // Xóa các kích thước cũ không có trong dữ liệu mới
            if (!empty($sizesToDelete)) {
                $deleteSizes = $this->connect->prepare("DELETE FROM product_sizes WHERE product_id = ? AND size = ?");
                foreach ($sizesToDelete as $size) {
                    $deleteSizes->bind_param("is", $id, $size);
                    $deleteSizes->execute();
                }
            }

            // Thêm kích thước mới vào bảng (cập nhật kích thước mới chưa có)
            $insertSizes = $this->connect->prepare("INSERT INTO product_sizes (product_id, size) VALUES (?, ?)");
            foreach ($data['sizes'] as $size) {
                if (!in_array($size, $currentSizes)) { // Kiểm tra nếu kích thước mới chưa có trong cơ sở dữ liệu
                    $insertSizes->bind_param("is", $id, $size);
                    $insertSizes->execute();
                }
            }
        }

        
// Update ảnh sản phẩm
if (!empty($data['images'])) {
    // Lấy danh sách ảnh hiện tại từ cơ sở dữ liệu
    $query = $this->connect->prepare("
        SELECT image_id, img 
        FROM image 
        WHERE product_id = ?
    ");
    if (!$query) {
        error_log("SQL Error (Select image): " . $this->connect->error);
        throw new Exception("Prepare statement failed for selecting images.");
    }
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    // Tạo danh sách ảnh hiện tại
    $currentImages = [];
    while ($row = $result->fetch_assoc()) {
        $currentImages[$row['image_id']] = $row['img'];
    }

    // Duyệt qua danh sách ảnh mới (bao gồm các ảnh cũ giữ lại và các ảnh chỉnh sửa)
    $updatedImages = $data['images'];

    // Danh sách ảnh mới xử lý
    foreach ($updatedImages as $index => $newImagePath) {
        $isEdited = false;

        foreach ($currentImages as $imageId => $currentImagePath) {
            if ($newImagePath === $currentImagePath) {
                // Ảnh không chỉnh sửa, giữ nguyên
                unset($currentImages[$imageId]);
                $isEdited = true;
                break;
            }
        }

        if (!$isEdited) {
            // Ảnh được chỉnh sửa, thay thế ảnh cũ
            if (!empty(array_keys($currentImages))) {
                // Lấy ảnh cũ để xóa
                $deleteImageId = array_keys($currentImages)[0];
                $currentImagePath = $currentImages[$deleteImageId];

                // Xóa ảnh cũ trong database
                $deleteStmt = $this->connect->prepare("DELETE FROM image WHERE image_id = ?");
                if (!$deleteStmt) {
                    error_log("SQL Error (Delete image): " . $this->connect->error);
                    throw new Exception("Prepare statement failed for deleting image.");
                }
                $deleteStmt->bind_param("i", $deleteImageId);
                $deleteStmt->execute();

                // Xóa file vật lý (tùy chọn)
                if (file_exists($currentImagePath)) {
                    unlink($currentImagePath);
                }

                unset($currentImages[$deleteImageId]);
            }

            // Thêm ảnh mới thay thế
            $insertStmt = $this->connect->prepare("
                INSERT INTO image (product_id, img) 
                VALUES (?, ?)
            ");
            if (!$insertStmt) {
                error_log("SQL Error (Insert image): " . $this->connect->error);
                throw new Exception("Prepare statement failed for inserting image.");
            }
            $insertStmt->bind_param("is", $id, $newImagePath);
            $insertStmt->execute();
        }
    }
}



        $this->connect->commit();
        $this->connect->autocommit(true);
        return true;

    } catch (Exception $e) {
        $this->connect->rollback();
        $this->connect->autocommit(true);
        error_log("Update failed: " . $e->getMessage());
        return false;
    }

    // Cập nhật kích thước

}




// Xóa sản phẩm
public function delete($id)
{
    // Xóa tất cả dữ liệu liên quan đến sản phẩm trong các bảng khác nếu cần
    $this->connect->begin_transaction(); // Bắt đầu một transaction (nếu cần)

    try {
        // Xóa dữ liệu liên quan trong bảng product_sizes
        $query = "DELETE FROM product_sizes WHERE product_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Xóa dữ liệu liên quan trong bảng image
        $query = "DELETE FROM image WHERE product_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Cuối cùng, xóa sản phẩm trong bảng products
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Commit transaction nếu mọi thao tác xóa thành công
        $this->connect->commit();
        return true;
    } catch (Exception $e) {
        $this->connect->rollback(); // Rollback nếu có lỗi
        return false;
    }
}
//=====================================================End Product Management===========================================

//===================================================Oder tracking==========================================================
public function getOrders() {
    $query = "SELECT id, user_id, product_id, phone, 
                     CONCAT( specific_address, ', ', location) AS address,
                     total_price, payment_method, status
              FROM orders";

    $result = $this->connect->query($query);

    if (!$result) {
        die("SQL Error: " . $this->connect->error); 
    }
    $orders = $result->fetch_all(MYSQLI_ASSOC);

    return $orders;
}

public function updateOrderStatus($orderId, $status)
{
    $stmt = $this->connect->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);

    if (!$stmt->execute()) {
        die("SQL Error: " . $this->connect->error);
    }

    $stmt->close();
}

//=====================================================End Order Tracking==============================================

//=====================================================Admin Login==============================================
// Danh sách email admin hợp lệ
    private $validEmails = [
        "hothion010100@gmail.com",
        "xomdangvaisf@gmail.com",
        "thidieu100625@gmail.com"
    ];

    // Kiểm tra email có hợp lệ không
    public function isValidAdminEmail($email) {
        return in_array($email, $this->validEmails);
    }

    // Tạo mã OTP và lưu vào database
    public function generateOTP($email) {
        $otp = rand(100000, 999999);

        $stmt = $this->connect->prepare("INSERT INTO admin_otp (email, otp_code, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $stmt->close();

        return $otp;
    }

    // Kiểm tra mã OTP
    public function verifyOTP($email, $otp) {
        $stmt = $this->connect->prepare("SELECT otp_code, created_at FROM admin_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($stored_otp, $created_at);
        $stmt->fetch();
        $stmt->close();

        // Kiểm tra mã OTP có trùng và còn hạn không (5 phút)
        if ($stored_otp === $otp && (time() - strtotime($created_at) <= 300)) {
            // Xóa OTP sau khi xác minh
            $delete_stmt = $this->connect->prepare("DELETE FROM admin_otp WHERE email = ?");
            $delete_stmt->bind_param("s", $email);
            $delete_stmt->execute();
            $delete_stmt->close();

            return true;
        }

        return false;
    }
}
?>