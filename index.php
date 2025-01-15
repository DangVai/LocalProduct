<?php
require './Config/db.php';
require './Models/BaseModel.php';
require './Controllers/BaseController.php';
$controllersName = ucfirst(strtolower($_REQUEST['controller'] ?? 'index')) . 'Controller'; // Default to 'IndexController'
$actionName = $_REQUEST['action'] ?? 'introduction'; // Default to 'introduction'

$controllerPath = './Controllers/' . $controllersName . '.php';
if (!file_exists($controllerPath)) {
    header('Location: /LocalProduct/Views/frontend/404.php');
    exit;

}

require $controllerPath;
if (!class_exists($controllersName)) {
    header('Location: /LocalProduct/Views/frontend/404.php');
    exit;
}

$controllerObject = new $controllersName();

if (!method_exists($controllerObject, $actionName)) {
    header('Location: /LocalProduct/Views/frontend/404.php');
    exit;
}

$actionNameArgs = get_func_argNames($controllerObject, $actionName);

$params = [];
foreach ($actionNameArgs as $argName) {
    $params[] = $_REQUEST[$argName] ?? null; // Nếu không có tham số, truyền giá trị null
}
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
