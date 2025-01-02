class FavoriteController extends BaseController
{
private $productModel;

public function __construct()
{
$this->loadModel('ProductModel');
$this->productModel = new ProductModel();
}

// Thêm sản phẩm vào danh sách yêu thích
public function add()
{
if (!isset($_SESSION['user_id'])) {
echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để sử dụng tính năng này!']);
return;
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];

$result = $this->productModel->addToFavorite($userId, $productId);

if ($result) {
echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào danh sách yêu thích!']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Sản phẩm đã có trong danh sách yêu thích!']);
}
}

// Xóa sản phẩm khỏi danh sách yêu thích
public function remove()
{
if (!isset($_SESSION['user_id'])) {
echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để sử dụng tính năng này!']);
return;
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];

$result = $this->productModel->removeFromFavorite($userId, $productId);

if ($result) {
echo json_encode(['status' => 'success', 'message' => 'Đã xóa khỏi danh sách yêu thích!']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Không thể xóa sản phẩm!']);
}
}

// Hiển thị danh sách yêu thích
public function index()
{
if (!isset($_SESSION['user_id'])) {
$this->view('frontend.favorite', ['products' => []]);
return;
}

$userId = $_SESSION['user_id'];
$favorites = $this->productModel->getFavoritesByUser($userId);
$this->view('frontend.favorite', ['products' => $favorites]);
}
}