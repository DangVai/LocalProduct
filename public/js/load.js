
document.addEventListener('DOMContentLoaded', function () {
    // Ẩn phần loading khi trang đã tải xong
    const loadingOverlay = document.getElementById('loading');
    loadingOverlay.style.display = 'none';
});
document.addEventListener('DOMContentLoaded', function () {
    // Ẩn phần loading khi trang đã tải xong
    const loadingOverlay = document.getElementById('loading');
    loadingOverlay.style.display = 'none'; // Ẩn phần loading
});

window.addEventListener('beforeunload', function () {
    // Hiển thị phần loading khi người dùng chuyển trang
    const loadingOverlay = document.getElementById('loading');
    loadingOverlay.style.display = 'flex'; // Hiển thị loading overlay
});