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