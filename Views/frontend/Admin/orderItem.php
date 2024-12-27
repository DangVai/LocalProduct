<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/orderItem.css">
</head>
<body>
    <h1>Order Detail</h1>
     <a href="index.php?controller=admin&action=listOrders">Back to Order List</a>

    <!-- Hiển thị thông tin chi tiết đơn hàng -->
    <table>
        <thead>
            <tr>
                <th>Order Item ID</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Product Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orderDetails)): ?>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['order_item_id']) ?></td>
                        <td><?= htmlspecialchars($item['product_id']) ?></td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['size']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> $</td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td><a href="index.php?controller=product&action=detail&id=<?= htmlspecialchars($item['product_id']); ?>">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No order details found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
