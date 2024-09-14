// Thêm hình
function chooseFile(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("hinhanh");
        preview.src = src;
        preview.style.display = "inline-block";
    }
}

// ẩn hiện con mắt chỗ input mật khẩu
document.addEventListener("DOMContentLoaded", function() {

    function toggleShowPassword(element) {
        var passwordInput = document.querySelector('input[name="pass"]');
        var isPasswordVisible = passwordInput.type === 'text';

        passwordInput.type = isPasswordVisible ? 'password' : 'text';

        var eyeIcon = element.querySelector('.icon-eye');
        var eyeSlashIcon = element.querySelector('.icon-eye-slash');

        if (isPasswordVisible) {
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'block';
        } else {
            eyeIcon.style.display = 'block';
            eyeSlashIcon.style.display = 'none';
        }
    }

    var toggleLink = document.querySelector('.input-inline-button');
    toggleLink.addEventListener('click', function() {
        toggleShowPassword(this);
    });
});

// ràng buộc chỉ được nhập số thôi
function validateNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

// lưu lại trang đang active(đổi màu nó)
document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các button có class 'btn-page'
    var buttons = document.querySelectorAll('.btn-page');

    // Khôi phục trạng thái active từ sessionStorage 
    var activeButtonIndex = sessionStorage.getItem('activeButtonIndex');
    if (activeButtonIndex !== null) {
        buttons[activeButtonIndex].classList.add('btn-page-active');
    } else {
        // Nếu không có trạng thái active nào được lưu, áp dụng trạng thái active cho button đầu tiên
        buttons[0].classList.add('btn-page-active');
    }

    // Lặp qua từng button và thêm sự kiện click
    buttons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            // Loại bỏ class 'btn-page-active' từ tất cả các button
            buttons.forEach(function (btn) {
                btn.classList.remove('btn-page-active');
            });

            // Thêm class 'btn-page-active' cho button được click
            this.classList.add('btn-page-active');

            // Lưu trạng thái active vào sessionStorage
            sessionStorage.setItem('activeButtonIndex', index);

            // Lấy href từ thẻ a và chuyển hướng trang
            var href = this.querySelector('a').getAttribute('href');
            window.location.href = href;
        });
    });
});