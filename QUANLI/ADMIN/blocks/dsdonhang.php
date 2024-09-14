<div id="filterOrder-container">
    <label for="ngaydathang">Ngày đặt hàng:</label>
    <input type="date" id="ngaydathang" name="ngaydathang">

    <label for="trangthai">Trạng thái đơn:</label>
    <select id="trangthai" name="trangthai">
        <option value="">Tất cả</option>
        <option value="Chờ xác nhận">Chờ xác nhận</option>
        <option value="Đã xác nhận">Đã xác nhận</option>
        <option value="Đang giao hàng">Đang giao hàng</option>
        <option value="Đã giao hàng">Đã giao hàng</option>
    </select>

    <button onclick="filterOrders()">Lọc</button>
</div>

<table class="main-table">
    <thead>
        <tr>
            <td>STT</td>
            <td>Mã Đơn Hàng</td>
            <td>Mã Khách Hàng</td>
            <td>Ngày Đặt Hàng</td>
            <td>Tổng Giá</td>
            <td>Phương Thức Thanh Toán</td>
            <td>Tổng Sản Phẩm</td>
            <td>Trạng Thái</td>
            <td>Chi Tiết Đơn</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "banphimco");

    // Số lượng đơn hàng mỗi trang
    $items_per_page = 3;

    // Lấy số trang hiện tại, mặc định là 1
    $npage = isset($_GET['npage']) && $_GET['npage'] > 0 ? (int)$_GET['npage'] : 1;

    $offset = max(0, ($npage - 1) * $items_per_page);

    //SQL gốc
    $sql = "SELECT * FROM donhang";

    // lọc
    $conditions = [];
    if (isset($_GET['ngaydathang']) && !empty($_GET['ngaydathang'])) {
        $selectedDate = $_GET['ngaydathang'];
        $conditions[] = "DATE(ngaydathang) = '$selectedDate'";
    }

    if (isset($_GET['trangthai']) && !empty($_GET['trangthai'])) {
        $selectedStatus = $_GET['trangthai'];
        $conditions[] = "trangthai = '$selectedStatus'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // đếm tổng đơn hàng
    $count_sql = "SELECT COUNT(*) as total FROM donhang" . (count($conditions) > 0 ? " WHERE " . implode(" AND ", $conditions) : "");
    $total_result = mysqli_query($conn, $count_sql);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_orders = $total_row['total'];

    // Thêm thứ tự và phân trang vào SQL
    $sql .= " ORDER BY ngaydathang DESC LIMIT $items_per_page OFFSET $offset";
    $result = mysqli_query($conn, $sql);

    $i = $offset + 1;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$i}</td>
                <td>{$row['madonhang']}</td>
                <td>{$row['makhachhang']}</td>
                <td>" . date('d/m/Y', strtotime($row['ngaydathang'])) . "</td>
                <td>" . number_format($row['tonggia']) . "</td>
                <td>{$row['phuongthucthanhtoan']}</td>
                <td>{$row['tongsanpham']}</td>
                <td>
                    <form method='post' action='capNhatTrangThai.php'>
                        <select name='trangthai' id='trangthaiSelect'>
                            <option value='Chờ xác nhận' " . ($row['trangthai'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>
                            <option value='Đã xác nhận' " . ($row['trangthai'] == 'Đã xác nhận' ? 'selected' : '') . ">Đã xác nhận</option>
                            <option value='Đang giao hàng' " . ($row['trangthai'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                            <option value='Đã giao hàng' " . ($row['trangthai'] == 'Đã giao hàng' ? 'selected' : '') . ">Đã giao hàng</option>
                        </select>
                        <input type='hidden' name='madonhang' value='{$row['madonhang']}'>
                        <button type='submit'>Sửa</button>
                    </form>
                </td>
                <td><a class='fa-solid fa-list' href='?page=dschitietdonhang&madonhang={$row['madonhang']}'></a></td>
              </tr>";
        $i++;
    }
    ?>
    </tbody>
</table>

<div class="btn-pagination">
    <?php if ($npage > 1): ?>
        <a href="?page=dsdonhang&npage=1<?php echo isset($selectedDate) ? '&ngaydathang=' . $selectedDate : ''; ?><?php echo isset($selectedStatus) ? '&trangthai=' . $selectedStatus : ''; ?>"><i class="fa-solid fa-angles-left"></i></a>
        <a href="?page=dsdonhang&npage=<?php echo $npage - 1; ?><?php echo isset($selectedDate) ? '&ngaydathang=' . $selectedDate : ''; ?><?php echo isset($selectedStatus) ? '&trangthai=' . $selectedStatus : ''; ?>"><i class="fa-solid fa-angle-left"></i></a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= ceil($total_orders / $items_per_page); $p++): ?>
        <a href="?page=dsdonhang&npage=<?php echo $p; ?><?php echo isset($selectedDate) ? '&ngaydathang=' . $selectedDate : ''; ?><?php echo isset($selectedStatus) ? '&trangthai=' . $selectedStatus : ''; ?>" class="<?php if ($p == $npage) echo 'active'; ?>"><?php echo $p; ?></a>
    <?php endfor; ?>

    <?php if ($npage < ceil($total_orders / $items_per_page)): ?>
        <a href="?page=dsdonhang&npage=<?php echo $npage + 1; ?><?php echo isset($selectedDate) ? '&ngaydathang=' . $selectedDate : ''; ?><?php echo isset($selectedStatus) ? '&trangthai=' . $selectedStatus : ''; ?>"><i class="fa-solid fa-angle-right"></i></a>
        <a href="?page=dsdonhang&npage=<?php echo ceil($total_orders / $items_per_page); ?><?php echo isset($selectedDate) ? '&ngaydathang=' . $selectedDate : ''; ?><?php echo isset($selectedStatus) ? '&trangthai=' . $selectedStatus : ''; ?>"><i class="fa-solid fa-angles-right"></i></a>
    <?php endif; ?>
</div>

<style>
    a {
        text-decoration: none;
        color: #000;
    }

    a:hover {
        color: #ee6457;
    }

    .btn-pagination {
        margin-top: 10px;
    }

    .btn-pagination a {
        display: inline-block;
        padding: 8px 12px;
        background-color: #f2f2f2;
        color: #333;
        text-decoration: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 5px;
    }

    .btn-pagination a.active {
        background-color: var(--main_color);
        color: white;
    }

    #filterOrder-container {
        float: right;
        padding: 0 50px 10px 0;
    }

    #filterOrder-container input[type='date'] {
        margin: 0 4px;
        height: 24px;
        line-height: 24px;
    }

    #filterOrder-container button {
        padding: 2px 5px;
        color: #fff;
        background-color: #254753;
        border: thin solid #254753;
        cursor: pointer;
        min-height: 24px;
    }

    #filterOrder-container button:hover {
        color: #254753;
        background-color: #fff;
        border: thin solid #254753;
    }

    #filterOrder-container select {
        height: 24px;
        width: 120px;
        padding: 0 10px;
    }

    #trangthaiSelect {
        width: 150px;
        min-height: 32px;
        padding: 0px 12px;
        margin-right: 10px;
        outline: none;
    }

    #submitButton {
        background-color: #254753;
        color: white;
        min-height: 32px;
        padding: 0 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    #submitButton:hover {
        background-color: #667E86;
    }
</style>

<script>
    function filterOrders() {
        var selectedDate = document.getElementById("ngaydathang").value;
        var selectedStatus = document.getElementById("trangthai").value;

        // Chuyển hướng đến trang với tham số ngaydathang và trangthai được chọn
        var url = 'index.php?page=dsdonhang';

        if (selectedDate) {
            url += '&ngaydathang=' + selectedDate;
        }

        if (selectedStatus) {
            url += '&trangthai=' + selectedStatus;
        }

        window.location.href = url;
    }
</script>
