<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/createProduct.css">
</head>
<body>
    <h1>Edit Product</h1>
    <form action="index.php?controller=admin&action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <!-- Name -->
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>

        <!-- Category -->
        <label>Category:</label>
        <select name="category" required>
            <option value="Dress" <?php echo $product['category'] === 'Dress' ? 'selected' : ''; ?>>Dress</option>
            <option value="Shirt" <?php echo $product['category'] === 'Shirt' ? 'selected' : ''; ?>>Shirt</option>
            <option value="Accessories" <?php echo $product['category'] === 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
            <option value="Food" <?php echo $product['category'] === 'Food' ? 'selected' : ''; ?>>Food</option>
            <option value="Musical Instruments" <?php echo $product['category'] === 'Musical Instruments' ? 'selected' : ''; ?>>Musical Instruments</option>
            <option value="Household Items" <?php echo $product['category'] === 'Household Items' ? 'selected' : ''; ?>>Household Items</option>
            <option value="fashion" <?php echo $product['category'] === 'fashion' ? 'selected' : ''; ?>>Fashion</option>
             <option value="another" <?php echo $product['category'] === 'another' ? 'selected' : ''; ?>>Other</option>
        </select><br>

         <!-- Input để thêm nhiều ảnh -->
        <label for="new_images">Add new image(s):</label>
        <input type="file" name="new_images[]" id="new_images" multiple>

        <!-- Existing Images -->
        <label>Existing Images:</label><br>
        <?php 
        if (!empty($product['images'])) {
            $imagePaths = explode(',', $product['images']); // Chuyển thành mảng
            foreach ($imagePaths as $key => $imgPath) {
                echo "
                    <div style='margin-bottom: 10px;'>
                        <img src='$imgPath' alt='Product Image' style='width: 100px; height: auto;'><br>
                        <label>Replace this image:</label>
                        <input type='file' name='replace_images[$key]' accept='image/*'>
                        <input type='hidden' name='existing_images[$key]' value='$imgPath'> <!-- Truyền đường dẫn ảnh cũ để xác định -->
                    </div>
                ";
            }
        } else {
            echo "No images found for this product.";
        }
        ?>


         <!-- Types -->
        <label>Type:</label>
        <select name="type" required>
            <option value="Vân Kiều" <?php echo $product['type'] === 'Vân Kiều' ? 'selected' : ''; ?>>Vân Kiều</option>
            <option value="Pa Cô" <?php echo $product['type'] === 'Pa Cô' ? 'selected' : ''; ?>>Pa Cô</option>
        </select><br>


        <!-- Quantity -->
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required><br>

        <!-- Price -->
        <label>Price:</label>
        <input type="number"  name="price" value="<?php echo $product['price']; ?>" required><br>

        <!-- Size -->
        <label>Size:</label><br>
        <?php
        $sizes = ['S', 'M', 'L', 'XL']; // Các kích thước khả dụng
        $selectedSizes = explode(',', $product['sizes'] ?? ''); // Tách kích thước từ chuỗi
        foreach ($sizes as $size) {
            $checked = in_array($size, $selectedSizes) ? 'checked' : '';
            echo "<input type='checkbox' name='sizes[]' value='$size' $checked> $size<br>";
        }
        ?>

        <!-- Description -->
        <label>Description:</label>
        <textarea name="description" rows="5" required><?php echo $product['description']; ?></textarea><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
