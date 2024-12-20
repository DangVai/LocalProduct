let currentSlide = 0;

function autoSlide() {
    const slides = document.querySelector('.sliders');
    const totalSlides = document.querySelectorAll('.slide').length;

    // Chuyển sang slide tiếp theo
    currentSlide++;

    // Kiểm tra nếu đến slide cuối cùng
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
}

// Tự động chuyển slide mỗi 3 giây
setInterval(autoSlide, 2000);