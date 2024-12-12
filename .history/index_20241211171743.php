<?php
require './Config/db.php';
require './Models/BaseModel.php';
// Import tệp chứa lớp cơ bản cho các Controllers
require './Controllers/BaseController.php';

// Lấy tên controller từ tham số 'controller' trong URL (ví dụ: index.php?controller=Home)
$controllersName = ucfirst(strtolower($_REQUEST['controller'] ?? 'home')) . 'Controller'; // Default to 'IndexController' if not provided

// Lấy tên action từ tham số 'action' trong URL (ví dụ: index.php?action=view)
$actionName = $_REQUEST['action'] ?? 'index'; // Default to 'index' if not provided

// Đường dẫn đến tệp Controller tương ứng
$controllerPath = './Controllers/' . $controllersName . '.php';

// Kiểm tra xem tệp Controller có tồn tại không
if (!file_exists($controllerPath)) {
    error_log("Controller file '{$controllersName}.php' not found.");
    exit("Controller not found");
}

require $controllerPath; // Nhúng file Controller

// Kiểm tra xem lớp Controller có tồn tại không
if (!class_exists($controllersName)) {
    error_log("Controller class '{$controllersName}' not found.");
    exit("Controller class not found");
}

// Tạo đối tượng từ lớp Controller đã nhập
$controllerObject = new $controllersName();

// Kiểm tra xem có yêu cầu 'handleLogin' từ controller 'user'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['controller'] === 'user' && $_GET['action'] === 'handleLogin') {
    $controllerObject->handleLogin();  // Gọi phương thức handleLogin từ đối tượng hiện tại
}
//thêm 5:17 11/12

require_once 'Controllers/UserController.php';
require_once 'Models/UserModel.php';

$controller = $_GET['controller'] ?? 'user';  // Controller mặc định là 'user'
$action = $_GET['action'] ?? 'login';  // Action mặc định là 'login'

$controllerName = ucfirst($controller) . 'Controller';  // Ví dụ: 'UserController'

if (class_exists($controllerName)) {
    $controllerObject = new $controllerName();
    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();  // Gọi action trong controller
    } else {
        die('Action không tồn tại');
    }
} else {
    die('Controller không tồn tại');
}

// Kiểm tra xem phương thức (action) có tồn tại không
if (!method_exists($controllerObject, $actionName)) {
    error_log("Action '{$actionName}' not found in '{$controllersName}' controller.");
    exit("Action not found");
}

// Lấy danh sách tham số của phương thức
$actionNameArgs = $controllerObject->get_func_argNames($actionName);

// Kiểm tra nếu phương thức có tham số và extract chúng từ $_REQUEST
$intersectKeys = extractProperties($_REQUEST, $actionNameArgs);

$controllerObject->$actionName(...array_values($intersectKeys));

// Hàm lấy tên các tham số của phương thức
function extractProperties(array $array, array $keys): array
{
    return array_intersect_key($array, array_flip($keys));
}
