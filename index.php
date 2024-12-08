<?php
require './Config/db.php';
require './Models/BaseModel.php';
// Import tệp chứa lớp cơ bản cho các Controllers
require './Controllers/BaseController.php';

// Lấy tên controller từ tham số 'controller' trong URL (ví dụ: index.php?controller=Home)
$controllersName = ucfirst(strtolower($_REQUEST['controller'] ?? 'index')) . 'Controller'; // Default to 'HelloController' if not provided

// Lấy tên action từ tham số 'action' trong URL (ví dụ: index.php?action=view)
$actionName = $_REQUEST['action'] ?? 'index'; // Default to 'index' if not provided

// Đường dẫn đến tệp Controller tương ứng
$controllerPath = './Controllers/' . $controllersName . '.php';

// Kiểm tra xem tệp Controller có tồn tại không
if (!file_exists($controllerPath)) {
    die("Controller file '{$controllersName}.php' not found.");
}

require $controllerPath; // Nhúng file Controller

// Kiểm tra xem lớp Controller có tồn tại không
if (!class_exists($controllersName)) {
    die("Controller class '{$controllersName}' not found.");
}

// Tạo đối tượng từ lớp Controller đã nhập
$controllerObject = new $controllersName();

// Assuming a simple routing in index.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['controller'] == 'user' && $_GET['action'] == 'handleLogin') {
    $userController = new UserController();
    $userController->handleLogin();
}

// Kiểm tra xem phương thức (action) có tồn tại không
if (!method_exists($controllerObject, $actionName)) {
    die("Action '{$actionName}' not found in '{$controllersName}' controller.");
}

// Gọi phương thức (action) trên đối tượng Controller
$actionNameargs = get_func_argNames($controllersName, $actionName);


$intersect_keys = extractProperties($_REQUEST, $actionNameargs);

$controllerObject->$actionName(...array_values(array: $intersect_keys));

function get_func_argNames($className, $funcName)
{
    $f = new ReflectionMethod($className, $funcName);
    $result = array();
    foreach ($f->getParameters() as $param) {
        $result[] = $param->name;
    }
    return $result;
}
function extractProperties(array $array, array $keys): array
{
    return array_intersect_key($array, array_flip($keys));
}