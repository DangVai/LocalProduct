class FavoriteModel extends BaseModel {
const TABLE_NAME = 'favorites';

public function __construct() {
parent::__construct(self::TABLE_NAME);
}

public function toggleFavorite($productId, $userId) {
// Kiểm tra sản phẩm đã yêu thích chưa
$stmt = $this->connect->prepare("SELECT * FROM favorites WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $productId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
// Nếu đã yêu thích, xóa khỏi danh sách
$stmt = $this->connect->prepare("DELETE FROM favorites WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $productId, $userId);
$stmt->execute();
return false;
} else {
// Nếu chưa yêu thích, thêm vào danh sách
$stmt = $this->connect->prepare("INSERT INTO favorites (product_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $productId, $userId);
$stmt->execute();
return true;
}
}

public function getFavorites($userId) {
$stmt = $this->connect->prepare("
SELECT p.*, i.img FROM products p
INNER JOIN favorites f ON p.product_id = f.product_id
LEFT JOIN images i ON p.product_id = i.product_id
WHERE f.user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
return $result->fetch_all(MYSQLI_ASSOC);
}
}