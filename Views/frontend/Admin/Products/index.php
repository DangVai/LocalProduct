<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/indexProduct.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Product List</h1>

        <div class="top-bar">
            <a href="index.php?controller=admin&action=create" class="btn-add">Insert Product</a>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($products) && is_array($products) && count($products) > 0) {
                    foreach ($products as $product) { ?>
                        <tr>
                            <td><?= htmlspecialchars($product['product_id']) ?></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td>
                                <?php if (!empty($product['image_id'])) { ?>
                                    <img src="<?= htmlspecialchars($product['image_id']) ?>" alt="Product Image" class="product-img">
                                <?php } else { echo "No Image"; } ?>
                            </td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td><?= $product['type'] == 1 ? 'Vân Kiều' : 'Pa Cô' ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?> $</td>
                            <td><?= !empty($product['sizes']) ? htmlspecialchars($product['sizes']) : "No Size" ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td>
                                <a href="index.php?controller=admin&action=edit&id=<?= $product['product_id']; ?>" class="btn-edit">Edit</a>
                                <a href="index.php?controller=admin&action=delete&id=<?= $product['product_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php 
                    }
                } else {
                    echo "<tr><td colspan='10' style='text-align:center;'>Không có sản phẩm nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
