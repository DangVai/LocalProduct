 const buttons = document.querySelectorAll('.favourite-btn');
 buttons.forEach(btn => {
     btn.addEventListener('click', async function() {
         const productId = this.dataset.productId;
         console.log("Product ID:", productId);

         try {
             const response = await fetch('index.php?controller=favorite&action=addFavorite', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json'
                 },
                 body: JSON.stringify({
                     product_id: productId
                 }),
             });
             if (response.ok) {
                 const responseText = await response.text(); // Convert response to text
                 console.log("Response Text:", responseText); // Log response content
                 let data;
                 try {
                     data = JSON.parse(responseText);
                     console.log("Response Data:", data);
                 } catch (error) {
                     console.error("Error parsing JSON:", error);
                     Swal.fire({
                         icon: 'error',
                         title: 'An error occurred, please try again!',
                     });
                     return;
                 }
                 const heartIcon = this.querySelector('i');
                 if (data.is_favorite) {
                     heartIcon.classList.add('text-danger');
                 } else {
                     heartIcon.classList.remove('text-danger');
                 }
                 Swal.fire({
                     icon: 'success',
                     title: data.message,
                     showConfirmButton: false,
                     timer: 1500
                 });

             } else {
                 throw new Error('Error: ' + response.status);
             }

         } catch (error) {
             console.error("Fetch error:", error);
             Swal.fire({
                 icon: 'error',
                 title: 'An error occurred, please try again!',
             });
         }
     });
 });


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