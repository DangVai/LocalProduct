<?php
class CheckoutController extends BaseController
{
        private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

public function onlinePayment()
{
    
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    
    
    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = "Thanh toán qua MoMo";
    $amount = "10000";
    $orderId = time() . "";
    $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    $extraData = "";
    
    
    
        $partnerCode = $partnerCode;
        $accessKey = $accessKey;
        $serectkey = $secretKey;
        $orderId = $orderId; // Mã đơn hàng
        $orderInfo = $orderInfo;
        $amount = $amount;
        $ipnUrl = $ipnUrl;
        $redirectUrl = $redirectUrl;
        $extraData = $extraData;
    
        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
    
        //Just a example, please check more in there
    
        header('Location: ' . $jsonResult['payUrl']);
}
// NGUYEN VAN A	9704 0000 0000 0018	03/07

    public function storeOrder()
    {
        // Kiểm tra yêu cầu từ form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy thông tin người dùng từ form
            $userInfo = [
                'full_name' => $_POST['full_name'],
                'phone' => $_POST['phone'],
                'location' => $_POST['location'],
                'specific_address' => $_POST['specific_address'],
                'user_id' => isset($_POST['user_id']) ? $_POST['user_id'] : null,
                
            ];

            // Lấy thông tin sản phẩm từ form
            $products = [
                [
                    'product_id' => $_POST['product_id'],
                    'product_name' => $_POST['product_name'],
                    'price' => $_POST['product_price'] * $_POST['quantity'], // Sửa ở đây để lấy quantity từ POST
                    'quantity' => $_POST['quantity'],
                    'size' => $_POST['size'] // Kiểm tra xem người dùng có chọn size hay không
                ]
            ];

            // Thêm status mặc định cho đơn hàng
            $status = 'pending'; // Trạng thái mặc định là "pending"

            // Tạo đối tượng model và gọi phương thức để lưu dữ liệu
            $orderModel = new ProductModel();
            $result = $orderModel->saveOrder($userInfo, $products, $status);

            if ($result) {
                $_SESSION['order_success'] = 'Đơn hàng của bạn đã được đặt thành công!';
                // Nếu thành công, trả về thông báo thành công
                header("Location: index.php?controller=product&action=detail&id=" . $_POST['product_id']);
                exit();
            } else {
                $_SESSION['order_error'] = 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại!';
                header("Location: index.php?controller=product&action=detail&id=" . $_POST['product_id']);
                exit();
            }
        } else {
            // Nếu không phải POST request, trả về lỗi
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        }
    }





    public function storeOrders()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = json_decode(file_get_contents('php://input'), true);
            if (isset($inputData['userInfo']) && isset($inputData['products'])) {
                $userInfo = $inputData['userInfo'];
                $products = $inputData['products'];

                try {
                    $orderModel = new ProductModel();
                    $result = $orderModel->saveOrder($userInfo, $products);
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
                    } else {
                        echo json_encode(['error' => false, 'message' => 'Failed to place the order!']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => false, 'message' => 'An error occurred while placing the order!']);
                }
            } else {
                echo json_encode(['error' => false, 'message' => 'Invalid data!']);
            }
        } else {
            echo json_encode(['error' => false, 'message' => 'Invalid request method!']);
        }
    }

}