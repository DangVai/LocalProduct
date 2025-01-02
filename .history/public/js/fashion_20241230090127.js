 document.addEventListener("DOMContentLoaded", () => {
     const filterForm = document.getElementById("filter-form");
     const productItems = document.querySelectorAll(".product-item");

     const applyFilter = () => {
         const priceFilter = document.getElementById("price").value;
         const typeFilter = document.getElementById("type").value.toLowerCase();
         const keywordFilter = document.getElementById("keyword").value.toLowerCase();

         // Lấy khoảng giá
         let [minPrice, maxPrice] = priceFilter
             ?
             priceFilter.split("-").map((value) => parseInt(value)) : [0, Infinity];

         productItems.forEach((item) => {
             const itemPrice = parseInt(item.getAttribute("data-price"));
             const itemType = item.getAttribute("data-type").toLowerCase();
             const itemName = item.getAttribute("data-name").toLowerCase();

             // Điều kiện lọc
             const matchPrice = itemPrice >= minPrice && itemPrice <= maxPrice;
             const matchType = !typeFilter || itemType.includes(typeFilter);
             const matchKeyword = !keywordFilter || itemName.includes(keywordFilter);

             // Hiển thị hoặc ẩn sản phẩm dựa trên bộ lọc
             if (matchPrice && matchType && matchKeyword) {
                 item.style.display = "block";
             } else {
                 item.style.display = "none";
             }
         });
     };

     // Gắn sự kiện khi nhấn nút "Lọc"
     document.getElementById("apply-filter").addEventListener("click", applyFilter);
 });

 function addToFavorite() {

     if (!userId || userId === 'null') {
         const userChoice = confirm('You need to log in to add products to the cart. Do you want to log in now?');
         if (userChoice) {
             // Người dùng chọn "OK" -> chuyển hướng đến trang đăng nhập
             window.location.href = 'index.php?controller=user&action=login';
         } else {
             // Người dùng chọn "Cancel" -> không làm gì
             console.log('User chose not to log in.');
         }
         return; // Dừng hàm nếu chưa đăng nhập
     }

     fetch('index.php?controller=product&action=addtocart', {
             method: 'POST',
             headers: { 'Content-Type': 'application/json' },
             body: JSON.stringify({ user_id: userId, product_id: productId, size, quantity }),
         })
         .then(res => res.json())
         .then(({ success, message }) => {
             if (success) {
                 alert('Product added to cart successfully!');
             } else {
                 alert(message);
             }
         })
         .catch(err => console.error('Error:', err));
 }