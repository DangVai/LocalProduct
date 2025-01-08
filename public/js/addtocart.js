// Lấy tất cả các ảnh thumbnail
const thumbnails = document.querySelectorAll('.preview-thumbnail li a img');
// Lấy ảnh chính
const mainImage = document.querySelector('.preview-pic .tab-pane img');

// Lặp qua từng thumbnail và thêm sự kiện click
thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener('click', (event) => {
        event.preventDefault(); // Ngăn chặn hành động mặc định (nếu cần)

        // Thay đổi src của ảnh chính thành src của thumbnail
        mainImage.src = thumbnail.src;
    });
});


function addToCart() {

    if (!userId || userId === 'null') {
        const userChoice = confirm('You need to log in to add products to the cart. Do you want to log in now?');
        if (userChoice) {
            // Người dùng chọn "OK" -> chuyển hướng đến trang đăng nhập
            window.location.href = 'index.php?controller=user&action=login';
        } else {
            // Người dùng chọn "Cancel" -> không làm gì
            console.log('User chose not to log in.');
        }
        return;
    }

    fetch('index.php?controller=product&action=addtocart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId, product_id: productId }),
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