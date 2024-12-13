let currentSlide = 0;

function autoSlide() {
    const slides = document.querySelector('.slides');
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



//Ràng buộc theo tiêu chuẩn quốc tế
function validatePhone() {
    const phone = document.getElementById("phone").value;
    const phonePattern = /^\+?[1-9]\d{1,14}$/;
    const phoneError = document.getElementById("phone-error");

    if (!phonePattern.test(phone)) {
        phoneError.textContent = "Số điện thoại không hợp lệ. Vui lòng nhập số theo định dạng quốc tế.";
        phoneError.style.display = "block";
    } else {
        phoneError.style.display = "none";
    }
}

function validatePasswords(event) {
    const password = document.getElementById('password').value;
    const confirmpassword = document.getElementById('confirm-password').value;

    // Kiểm tra độ dài mật khẩu
    if (password.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự.");
        event.preventDefault(); // Ngăn gửi form
        return false;
    }

    // Kiểm tra mật khẩu có giống nhau không
    if (password !== confirmpassword) {
        alert("Hai mật khẩu không khớp.");
        event.preventDefault(); // Ngăn gửi form
        return false;
    }

    return true; // Cho phép gửi form nếu hợp lệ
}


document.getElementById("registration-form").addEventListener("submit", function (event) {
    validateEmail();
    validatePhone();
    validatePassword();

    if (document.getElementById("email-error").style.display === "block" ||
        document.getElementById("phone-error").style.display === "block" ||
        document.getElementById("password-error").style.display === "block") {
        event.preventDefault();
    }
});


function sendOTP(event) {
    event.preventDefault(); // Ngăn form gửi đi

    const formData = new FormData(document.getElementById('registration-form'));

    // Gửi request đến server để xử lý gửi OTP
    fetch('index.php?controller=user&action=storeRegister', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ẩn form đăng ký và hiển thị form OTP
                document.getElementById('registration-form-container').style.display = 'none';
                document.getElementById('otp-form-container').style.display = 'block';
            } else {
                alert(data.message || 'Failed to send OTP. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}