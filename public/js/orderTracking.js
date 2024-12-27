
    function filterOrders(status) {
        // Xây dựng URL để gửi yêu cầu lọc
        let url = "index.php?controller=admin&action=listOrders";
    if (status !== 'all') {
        url += "&status=" + encodeURIComponent(status);
        }
    // Chuyển hướng đến URL tương ứng
    window.location.href = url;
    }
