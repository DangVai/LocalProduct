  const slidesContainer = document.querySelector('.slides-container');
  const slideWidth = 650; // Chiều rộng mỗi ảnh
  const totalSlides = document.querySelectorAll('.slide').length;
  let currentSlide = 1; // Bắt đầu từ ảnh đầu tiên

  slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;

  function nextSlide() {
      currentSlide++;
      slidesContainer.style.transition = 'transform 0.5s ease-in-out';
      slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;

      // Reset về ảnh gốc đầu khi đến clone đầu
      if (currentSlide === totalSlides - 1) {
          setTimeout(() => {
              slidesContainer.style.transition = 'none';
              currentSlide = 1;
              slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
          }, 500);
      }
  }

  setInterval(nextSlide, 2000);