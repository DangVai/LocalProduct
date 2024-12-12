<?php
class BaseController extends db
{
    
    const VERSION = 'Views';  // This is assumed to be the folder name containing your view files
    public function loadModel($model)
    {
        session_start();
        require_once './Models/' . $model . '.php';
    }
    /**
     * Description: 
     * + part name: folderName.fileName
     * + chỉ cần lấy từ sau thư mục views
     * + tất cả các file mà muốn gọi đến views đều phải extends BaseController kế thừa phương thức của lớp cha
     * + file con dùng return $this->view()để trỏ đến function ViewPath() trong lớp BaseController
     */
    public function view($viewPath, array $data = [])
    {
        // Truyền trực tiếp mảng data vào view
        extract($data);  // Biến mảng $data thành các biến động

        // Gọi file view từ thư mục Views/frontend
        $file = self::VERSION . '/'. str_replace('.', '/', $viewPath) . '.php';

        // Kiểm tra file tồn tại trước khi require
        if (!file_exists($file)) {
            die("File view '{$file}' không tồn tại.");
        }

        // require($file);
        require("Views/layouts/defaultlayouts.php");

    }
    public function viewWithoutLayout($viewPath, array $data = [])
    {
        extract($data);  // Biến mảng $data thành các biến động

        // Gọi file view từ thư mục Views/frontend
        $file = self::VERSION . '/' . str_replace('.', '/', $viewPath) . '.php';

        // Kiểm tra file tồn tại trước khi require
        if (!file_exists($file)) {
            die("File view '{$file}' không tồn tại.");
        }

        // require file view mà không có layout
        require($file);
    }


    /**
     * Lấy danh sách các tham số của phương thức.
     *
     * @param string $funcName Tên phương thức cần lấy tham số.
     * @return array Danh sách tên các tham số của phương thức.
     */
    public function get_func_argNames($funcName)
    {
        $f = new ReflectionMethod($this, $funcName);
        $result = [];
        foreach ($f->getParameters() as $param) {
            $result[] = $param->name;
        }
        return $result;
    }

}

