<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/orderTracking.css">
    <script src="/LocalProduct/public/js/orderTracking.js"></script>
</head>
<body>
    <p>Order List</p>

    <div class="filter-container">
        <!-- Nút "Tất cả" -->
        <button onclick="filterOrders('all')">Tất cả</button>
        
        <!-- Dropdown để chọn trạng thái cần lọc -->
        <select id="filter-status" onchange="filterOrders(this.value)">
            <option value="Chờ duyệt">Pending Approval</option>
            <option value="Đang chuẩn bị">Preparing</option>
            <option value="Đang giao">In Transit</option>
            <option value="Đã giao">Delivered</option>
        </select>
    </div>

  
  <!-- Bảng danh sách đơn hàng -->
  <table>
    <thead>
        <tr>
            <th>STT</th>
            <th>order_id</th>
            <th>User ID</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php if (isset($orders) && !empty($orders)): ?>
            <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['user_id']) ?></td> 
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                    <td><?= htmlspecialchars($order['specific_address']) ?></td>
                    <td>
                        <form method="POST" action="index.php?controller=admin&action=updateOrderStatus">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                            <select name="status" onchange="this.form.submit()" class="status-dropdown">
                                <option value="Chờ duyệt" <?= $order['status'] == "Chờ duyệt" ? "selected" : "" ?>>Pending Approval</option>
                                <option value="Đang chuẩn bị" <?= $order['status'] == "Đang chuẩn bị" ? "selected" : "" ?>>Preparing</option>
                                <option value="Đang giao" <?= $order['status'] == "Đang giao" ? "selected" : "" ?>>In Transit</option>
                                <option value="Đã giao" <?= $order['status'] == "Đã giao" ? "selected" : "" ?>>Delivered</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <button class="detail"><a href="index.php?controller=admin&action=orderDetail&order_id=<?= htmlspecialchars($order['order_id']); ?>" class="btn-detail">Order Detail</a></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">No orders found!</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


    
</body>
</html>