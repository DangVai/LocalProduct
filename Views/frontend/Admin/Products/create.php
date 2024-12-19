<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/createProduct.css">
</head>
<body>
    <h1>Insert product</h1>
        <form action="index.php?controller=admin&action=store" method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" required><br>

            <!-- Dropdown cho Category -->
            <label>Category:</label>
            <select name="category" required>
                <option value="Dress">Dress</option>
                <option value="Shirt">Shirt</option>
                <option value="Accessories">Accessories</option>
                <option value="Food">Food</option>
                <option value="Musical Instruments">Musical Instruments</option>
                <option value="Household Items">Household Items</option>
            </select><br>

            <label>Image(s):</label>
            <!-- Chọn nhiều file ảnh từ máy tính -->
            <input type="file" name="images[]" accept="image/*" multiple required><br>
                <label>Quantity:</label>
                <input type="number" name="quantity" required><br>

            <!-- Dropdown cho Type -->
            <label>Type:</label>
            <select name="type" required>
                <option value="Vân Kiều">Vân Kiều</option>
                <option value="Pa Cô">Pa Cô</option>
            </select><br>

            <label>Price:</label>
            <input type="number" name="price" required><br>

            <label>Size:</label><br>
                <input type="checkbox" name="size[]" value="S"> s<br>
                <input type="checkbox" name="size[]" value="M"> m<br>
                <input type="checkbox" name="size[]" value="L"> l<br>
                <input type="checkbox" name="size[]" value="XL"> xl<br>

            <label>Descriptions:</label>
            <textarea name="description" rows="5" required></textarea><br>

            <button type="submit">Insert</button>
        </form>

        
</body>
</html>