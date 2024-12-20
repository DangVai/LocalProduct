let currentSlide = 0;

function autoSlide(sliderId) {
    const slides = document.querySelector(`#${sliderId}`);
    const totalSlides = slides.children.length;
    let currentSlide = 0;

    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        const offset = -currentSlide * 100;
        slides.style.transform = `translateX(${offset}%)`;
    }, 3000); // Thay đổi ảnh sau mỗi 3 giây
}

autoSlide('slider1');
autoSlide('slider2');
autoSlide('slider3');

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