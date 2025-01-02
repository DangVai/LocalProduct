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

 function addToFavorite(productId) {
     // Kiểm tra xem người dùng đã đăng nhập chưa
     const userId = document.querySelector('meta[name="user-id"]').content; // Gán từ meta tag (hoặc backend gửi xuống)

     if (!userId || userId === 'null') {
         const userChoice = confirm('Bạn cần đăng nhập để thêm sản phẩm vào mục yêu thích. Bạn có muốn đăng nhập ngay bây giờ không?');
         if (userChoice) {
             // Chuyển hướng đến trang đăng nhập
             window.location.href = 'index.php?controller=user&action=login';
         }
         return; // Dừng hàm nếu chưa đăng nhập
     }

     // Gửi yêu cầu thêm vào mục yêu thích
     fetch('index.php?controller=favorite&action=addToFavorite', {
             method: 'POST',
             headers: { 'Content-Type': 'application/json' },
             body: JSON.stringify({ product_id: productId }),
         })
         .then((res) => res.json())
         .then(({ success, message }) => {
             if (success) {
                 alert('Thêm vào mục yêu thích thành công!');
             } else {
                 alert(message);
             }
         })
         .catch((err) => console.error('Lỗi:', err));
 }