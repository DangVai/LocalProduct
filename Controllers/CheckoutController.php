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
        // Lấy dữ liệu từ form hoặc session
        $orderData = [
            "size" => $_POST['size'],
            "quantity" => $_POST['quantity'],
            "product_name" => $_POST['product_name'],
            "product_id" => $_POST['product_id'],
            "product_price" => $_POST['product_price'],
            "full_name" => $_POST['full_name'],
            "phone" => $_POST['phone'],
            "location" => $_POST['location'],
            "specific_address" => $_POST['specific_address'],
            "payment_method" => $_POST['payment_method'],
            "user_id" => $_SESSION['user_id'],  // Lấy từ session
            "name" => $_SESSION['user_name'],   // Lấy từ session
            "total_price" => $_POST['total_price']
        ];

        // Gọi phương thức createOrder để lưu đơn hàng
        if ($this->productModel->createOrder($orderData)) {
            // Lưu thông báo thành công vào session
            $_SESSION['order_success'] = 'Đơn hàng của bạn đã được đặt thành công!';
            // Điều hướng đến trang chi tiết sản phẩm
            header("Location: index.php?controller=product&action=detail&id=" . $_POST['product_id']);
            exit();
        } else {
            // Lưu thông báo lỗi vào session
            $_SESSION['order_error'] = 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại!';
            // Điều hướng đến trang lỗi
            header("Location: index.php?controller=product&action=detail&id=" . $_POST['product_id']);
            exit();
        }
    }


}