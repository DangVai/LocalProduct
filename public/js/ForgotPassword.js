
    // Show additional form fields
  function showAdditionalFields() {
    const additionalFields = document.getElementById('additional-fields');
    additionalFields.classList.remove('hidden');
  }

    let currentIndex = 0;

    // Show slide based on the index
    function showSlide(index) {
      const items = document.querySelectorAll('.carousel-item');
      items.forEach((item, i) => {
        item.style.transform = `translateX(${(i - index) * 100}%)`;
    item.style.display = (i === index) ? 'block' : 'none';
      });
    }

    // Move to the previous slide
    function prevSlide() {
      const items = document.querySelectorAll('.carousel-item');
      currentIndex = (currentIndex + 1 + items.length) % items.length;
      showSlide(currentIndex);
    }

    // Move to the next slide
    function nextSlide() {
      const items = document.querySelectorAll('.carousel-item');
      currentIndex = (currentIndex + 1) % items.length;
      showSlide(currentIndex);
    }

    // Auto-slide every 3 seconds
    function autoSlide() {
      nextSlide();
      setTimeout(autoSlide, 4000);
    }

    // Initialize slider
    document.addEventListener('DOMContentLoaded', () => {
      showSlide(currentIndex);
      setTimeout(autoSlide, 4000);
    });


function validatePasswords(event) {
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  // Kiểm tra độ dài mật khẩu
  if (newPassword.length < 6) {
    alert("Mật khẩu phải có ít nhất 6 ký tự.");
    event.preventDefault(); // Ngăn gửi form
    return false;
  }

  // Kiểm tra mật khẩu có giống nhau không
  if (newPassword !== confirmPassword) {
    alert("Hai mật khẩu không khớp.");
    event.preventDefault(); // Ngăn gửi form
    return false;
  }

  return true; // Cho phép gửi form nếu hợp lệ
}

function togglePasswordsVisibility() {
  const newPassword = document.getElementById('newPassword');
  const confirmPassword = document.getElementById('confirmPassword');
  const toggleCheckbox = document.getElementById('togglePasswords');

  // Nếu checkbox được chọn, đổi type sang text
  const type = toggleCheckbox.checked ? 'text' : 'password';
  newPassword.type = type;
  confirmPassword.type = type;
}