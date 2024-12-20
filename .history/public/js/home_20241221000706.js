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
            }

            // Gọi hàm để áp dụng hiệu ứng slide cho tất cả slider
            autoSlideAll();