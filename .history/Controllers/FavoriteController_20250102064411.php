class FavoriteController extends BaseController {
public function addFavorite() {
session_start();
if (!isset($_SESSION['user_id'])) {
echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để thêm vào yêu thích.']);
return;
}

$productId = $_POST['product_id'];
$userId = $_SESSION['user_id'];

$model = $this->loadModel('FavoriteModel');
$isAdded = $model->toggleFavorite($productId, $userId);

if ($isAdded) {
echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào yêu thích.']);
} else {
echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã bị xóa khỏi yêu thích.']);
}
}

public function showFavorites() {
session_start();
if (!isset($_SESSION['user_id'])) {
header('Location: login.php');
exit();
}

$userId = $_SESSION['user_id'];
$model = $this->loadModel('FavoriteModel');
$favorites = $model->getFavorites($userId);

$this->view('favorites.index', ['favorites' => $favorites]);
}
}