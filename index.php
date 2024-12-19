<?php
require './Config/db.php';
require './Models/BaseModel.php';
require './Controllers/BaseController.php';

// Lấy tên controller từ tham số 'controller' trong URL
$controllersName = ucfirst(strtolower($_REQUEST['controller'] ?? 'index')) . 'Controller'; // Default to 'IndexController'

// Lấy tên action từ tham số 'action' trong URL
$actionName = $_REQUEST['action'] ?? 'introduction'; // Default to 'introduction'

// Đường dẫn đến tệp Controller tương ứng
$controllerPath = './Controllers/' . $controllersName . '.php';

// Kiểm tra xem tệp Controller có tồn tại không
if (!file_exists($controllerPath)) {
    // error_log("Controller file '{$controllersName}.php' not found.");
    // Nếu không tìm thấy controller hoặc action, hiển thị trang 404
    header('Location: /LocalProduct/Views/frontend/404.php');
    // include '/LocalProduct/Views/frontend/404.php';
    exit;

}

require $controllerPath; // Nhúng file Controller

// Kiểm tra xem lớp Controller có tồn tại không
if (!class_exists($controllersName)) {
    header('Location: /LocalProduct/Views/frontend/404.php');
    // include '/LocalProduct/Views/frontend/404.php';
    exit;
}

// Tạo đối tượng từ lớp Controller đã nhập
$controllerObject = new $controllersName();

// Kiểm tra nếu phương thức (action) có tồn tại không
if (!method_exists($controllerObject, $actionName)) {
    header('Location: /LocalProduct/Views/frontend/404.php');
    // include '/LocalProduct/Views/frontend/404.php';
    exit;
}

// Lấy danh sách tham số của phương thức
$actionNameArgs = get_func_argNames($controllerObject, $actionName);

// Lọc tham số từ $_REQUEST và truyền vào phương thức
$params = [];
foreach ($actionNameArgs as $argName) {
    $params[] = $_REQUEST[$argName] ?? null; // Nếu không có tham số, truyền giá trị null
}

// Gọi phương thức với các tham số đã xử lý
$controllerObject->$actionName(...$params);

/**
 * Hàm lấy danh sách tham số của một phương thức
 * @param object $object - Đối tượng chứa phương thức
 * @param string $methodName - Tên phương thức
 * @return array - Danh sách tên các tham số
 */
function get_func_argNames($object, $methodName)
{
    $reflection = new ReflectionMethod($object, $methodName);
    $params = $reflection->getParameters();
    return array_map(fn($param) => $param->getName(), $params);
}
