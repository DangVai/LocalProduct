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

 document.addEventListener("DOMContentLoaded", function() {
     // Giả sử biến isLoggedIn được trả về từ backend và nhúng vào HTML
     const isLoggedIn = <?= json_encode(isset($_SESSION['user'])); ?>;

     // Thêm sự kiện click cho tất cả các nút thêm vào yêu thích
     const favoriteButtons = document.querySelectorAll('.favourite-btn');

     favoriteButtons.forEach(button => {
         button.addEventListener('click', function() {
             if (!isLoggedIn) {
                 alert("Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm vào mục yêu thích.");
             } else {
                 alert("Bạn đã thêm sản phẩm yêu thích thành công!");
             }
         });
     });
 });