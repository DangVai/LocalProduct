<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/orderTracking.css">
</head>
<body>
    <div class="header">
    <h1>Order List</h1>
  </div>
  
  <!-- Bảng danh sách đơn hàng -->
  <table>
    <thead>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>User ID</th>
            <th>Product ID</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php if (isset($orders) && !empty($orders)): ?>
            <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['user_id']) ?></td> 
                    <td><?= htmlspecialchars($order['product_id']) ?></td>
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                    <td><?= htmlspecialchars($order['address']) ?></td>
                    <td><?= number_format($order['total_price'], 0, ',', '.') ?> $</td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td>
                        <form method="POST" action="index.php?controller=admin&action=updateOrderStatus">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                            <select name="status" onchange="this.form.submit()" class="status-dropdown">
                                <option value="Chờ duyệt" <?= $order['status'] == "Chờ duyệt" ? "selected" : "" ?>>Pending Approval</option>
                                <option value="Đang chuẩn bị" <?= $order['status'] == "Đang chuẩn bị" ? "selected" : "" ?>>Preparing</option>
                                <option value="Đang giao" <?= $order['status'] == "Đang giao" ? "selected" : "" ?>>In Transit</option>
                                <option value="Đã giao" <?= $order['status'] == "Đã giao" ? "selected" : "" ?>>Delivered</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="index.php?controller=product&action=detail&id=<?= $order['product_id']; ?>" class="btn-edit">Product detail</a>
                        <a href="index.php?controller=user&action=profile&id=<?= $product['product_id']; ?>" class="btn-delete">User detail</a>
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