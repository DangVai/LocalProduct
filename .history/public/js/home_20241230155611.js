function autoSlideAll() {
    const sliders = document.querySelectorAll('.slider-container');

    sliders.forEach(sliderContainer => {
        const slides = sliderContainer.querySelector('.slides');
        const slideImages = slides.querySelectorAll('.slide');
        const totalSlides = slideImages.length;
        let currentSlide = 0;

        // Tự động chạy slide
        setInterval(() => {
            currentSlide++;

            if (currentSlide === totalSlides) {
                slides.style.transition = 'none'; // Loại bỏ hiệu ứng chuyển động
                currentSlide = 0; // Reset về slide đầu tiên
                slides.style.transform = `translateX(0%)`;

                // Bật lại hiệu ứng chuyển động sau khi reset
                setTimeout(() => {
                    slides.style.transition = 'transform 0.5s ease-in-out';
                }, 50);
            } else {
                // Chuyển động bình thường giữa các slide
                const offset = -currentSlide * 100;
                slides.style.transform = `translateX(${offset}%)`;
            }
        }, 3000);
    });
}

// Gọi hàm để áp dụng hiệu ứng slide cho tất cả slider
autoSlideAll();

function addToFavorite() {
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!userId || userId === 'null') {
        const userChoice = confirm('You need to log in to add products to the favorite list. Do you want to log in now?');
        if (userChoice) {
            // Người dùng chọn "OK" -> chuyển hướng đến trang đăng nhập
            window.location.href = 'index.php?controller=user&action=login';
        } else {
            // Người dùng chọn "Cancel" -> không làm gì
            console.log('User chose not to log in.');
        }
        return; // Dừng hàm nếu chưa đăng nhập
    }

    // Lấy ID sản phẩm từ DOM (bạn cần phải thay đổi phần này cho phù hợp với cấu trúc HTML của bạn)
    const productId = document.getElementById('product-id').value; // Giả sử bạn có một input chứa product_id

    // Kiểm tra nếu không có thông tin sản phẩm
    if (!productId) {
        alert('Product information is missing.');
        return;
    }

    // Gửi yêu cầu API để thêm sản phẩm vào mục yêu thích
    fetch('index.php?controller=favorite&action=addtofavorite', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId, product_id: productId }),
        })
        .then(res => res.json())
        .then(({ success, message }) => {
            if (success) {
                alert('Product added to your favorite list successfully!');
            } else {
                alert(message);
            }
        })
        .catch(err => console.error('Error:', err));
}